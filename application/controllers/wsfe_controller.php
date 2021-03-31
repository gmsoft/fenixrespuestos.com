<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class wsfe_controller extends CI_Controller {

    private $_guestProfile;
    
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
                //user is already logged in
                redirect('ingresar');
        } else {
            $this->load->library('grocery_CRUD');
            $this->_guestProfile = $this->session->userdata('logged_in');
        }
    }

    public function solicitar_cae()
    {       
        $this->load->library('Wsfe');
        $this->load->model('factura_model');

        //Parametros
        $cbte_nro = $this->input->get('cbte_nro');
        $cbte_tipo = $this->input->get('cbte_tipo');
        $punto_vta = $this->input->get('punto_vta');

        $cbte = $this->factura_model->get_comprobante_wsfe($cbte_nro, $cbte_tipo, $punto_vta);

        ini_set('soap.wsdl_cache_enabled',0);
        ini_set('soap.wsdl_cache_ttl',0);        
        
        /*
        //HOMOLOGACION - PRUEBA
        define("WSDL", "./certificados-wsfe/wsaa.wsdl");     # The WSDL corresponding to WSAA
        define("WSDL_WSFE", "./certificados-wsfe/wsfe.wsdl");     # The WSDL corresponding to WSFE
        define("CERT", "./certificados-wsfe/fenix.crt");       # The X.509 certificate in PEM format - el del paso 3.. empieza el archivo con -----BEGIN CERTIFICATE-----
        define("PRIVATEKEY", "./certificados-wsfe/fenix.key"); # The private key correspoding to CERT (PEM) .. paso 1, empieza archivo con -----BEGIN RSA PRIVATE KEY-----
        define("PASSPHRASE", "./certificados-wsfe/pedido"); # The passphrase (if any) to sign .. clave que se coloco en paso 1 y 2
        //define("PROXY_HOST", "190.18.237.47"); # Proxy IP, to reach the Internet
        //define("PROXY_PORT", "80");            # Proxy TCP port
        define("URL", "https://wsaahomo.afip.gov.ar/ws/services/LoginCms");  # ambiente de prueba
        */

        //PRODUCCION
        define("WSDL", "./certificados-wsfe-prod/wsaa.wsdl");     # The WSDL corresponding to WSAA
        define("WSDL_WSFE", "./certificados-wsfe-prod/wsfe.wsdl");     # The WSDL corresponding to WSFE
        define("CERT", "./certificados-wsfe-prod/fenix_sha2.crt");       # The X.509 certificate in PEM format - el del paso 3.. empieza el archivo con -----BEGIN CERTIFICATE-----
        define("PRIVATEKEY", "./certificados-wsfe-prod/privada-fenix-sha2"); # The private key correspoding to CERT (PEM) .. paso 1, empieza archivo con -----BEGIN RSA PRIVATE KEY-----
        define("PASSPHRASE", "./certificados-wsfe-prod/fenix-sha-2.csr"); # The passphrase (if any) to sign .. clave que se coloco en paso 1 y 2
        
        //SI LLEVA PROXY
        //define("PROXY_HOST", "190.18.237.47"); # Proxy IP, to reach the Internet
        //define("PROXY_PORT", "80");            # Proxy TCP port
        define("URL", "https://wsaa.afip.gov.ar/ws/services/LoginCms");  # ambiente de prueba
        
        if (!file_exists(CERT)) {exit("Failed to open ".CERT."\n");}
        if (!file_exists(PRIVATEKEY)) {exit("Failed to open ".PRIVATEKEY."\n");}
        if (!file_exists(WSDL)) {exit("Failed to open ".WSDL."\n");}
        
        $SERVICE = "wsfe";

        $wsfe = new Wsfe();
        
        //Wsaa
        $wsfe->CreateTRA($SERVICE);
        $CMS = $wsfe->SignTRA();
        $TA = $wsfe->CallWSAA($CMS);
        
        //Datos del WSAA
        $ta_xml = simplexml_load_string($TA);   
        $token = $ta_xml->credentials->token;
        $sign = $ta_xml->credentials->sign;

        //Datos del Solicitante

        
        //HOMOLOGACION
        //$cuit = 20276708598;
        
        
        //PRODUCCION (OJO, es Distri OG)
        $cuit = 30711225206;
        

        $wsfe->token = $token;
        $wsfe->sign = $sign;
        $wsfe->cuit = $cuit;

        //WSFE Cliente
        $client_wsfe = $wsfe->CallWSFE();

        $cant_reg = 1;
        $comprobante = new Comprobante();
        $comprobante->Concepto = $cbte[0]->concepto;
        $comprobante->DocTipo = $cbte[0]->doc_tipo;
        $comprobante->DocNro = $cbte[0]->cuit;
        $comprobante->CbteDesde = $cbte_nro;
        $comprobante->CbteHasta = $cbte_nro;
        $comprobante->CbteFch = $cbte[0]->fecha;
        $comprobante->ImpTotal = $cbte[0]->importe_total;
        $comprobante->ImpTotConc = 0;
        $comprobante->ImpNeto = $cbte[0]->importe_neto;
        $comprobante->ImpOpEx = 0;
        $comprobante->ImpTrib = 0;
        $comprobante->ImpIVA = $cbte[0]->importe_iva;
        $comprobante->MonId = $cbte[0]->moneda;
        $comprobante->MonCotiz = $cbte[0]->cotizacion;

        $id_iva = 5;

        $comprobante->Iva = array(
                    'AlicIva' => array(
                        'Id' => $id_iva,
                        'BaseImp' => $cbte[0]->importe_neto,
                        'Importe' => $cbte[0]->importe_iva,
                    )
            );
        
        
        //Autorizar Comprobante
        echo $wsfe->AutorizarCbte($client_wsfe, $cant_reg, $punto_vta, $cbte_tipo, $comprobante);

        $cae = $wsfe->cae;
        $fecha_vto_cae = $wsfe->fecha_vto_cae;

        if ($cae != '') {
            $this->factura_model->guardarCAE($cbte_nro, $cbte_tipo, $punto_vta, $cae, $fecha_vto_cae);    
        }
        
        
        //$wsfe->GetUltimoCbte($client_wsfe, 1, 6);
        //echo $wsfe->GetUltimoCbte($client_wsfe, $punto_vta, $tipo_cbte);

        //$wsfe->ConsultarCbte($client_wsfe, $tipo_cbte, 1, $punto_vta);

        //$wsfe->ConsultarPuntosVta($client_wsfe);

        //$wsfe->ConsultarCotizacion($client_wsfe,'PES');

        //$wsfe->ConsultarTiposIva($client_wsfe);

        //$wsfe->Dummy($client_wsfe);
            
    }

     
}


?>