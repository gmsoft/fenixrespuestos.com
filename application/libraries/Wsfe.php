<?php

class Wsfe {
	
	public $token = ''; 
	public $sign = ''; 
	public $cuit = 0;

  public $cae = ''; 
  public $fecha_vto_cae = 0;

  public function __construct() {
    $this->cae = '';
    $this->fecha_vto_cae = 0;     
  }


	function CreateTRA($SERVICE)
	{
	  $TRA = new SimpleXMLElement(
	    '<?xml version="1.0" encoding="UTF-8"?>' .
	    '<loginTicketRequest version="1.0">'.
	    '</loginTicketRequest>');
	  $TRA->addChild('header');
	  $TRA->header->addChild('uniqueId',date('U'));
	  $TRA->header->addChild('generationTime',date('c',date('U')-60));
	  $TRA->header->addChild('expirationTime',date('c',date('U')+60));
	  $TRA->addChild('service',$SERVICE);
	  $TRA->asXML('TRA.xml');
	}

	#==============================================================================
	# This functions makes the PKCS#7 signature using TRA as input file, CERT and
	# PRIVATEKEY to sign. Generates an intermediate file and finally trims the 
	# MIME heading leaving the final CMS required by WSAA.
	function SignTRA()
	{
	   $STATUS = openssl_pkcs7_sign(realpath("TRA.xml"), realpath('.').'/'."TRA.tmp", "file://" . realpath(CERT), array("file://". realpath(PRIVATEKEY), PASSPHRASE), array(), !PKCS7_DETACHED);
	   if (!$STATUS) {exit("ERROR generating PKCS#7 signature\n");}
	  
	  $inf = fopen("TRA.tmp", "r");
	  $i = 0;
	  $CMS = "";
	  while (!feof($inf)) { 
	      $buffer = fgets($inf);
	      if ( $i++ >= 4 ) {$CMS.=$buffer;}
	    }
	  fclose($inf);
	 #  unlink("TRA.xml");
	  unlink("TRA.tmp");
	  return $CMS;
	  
	}

	function CallWSAA($CMS)
	{
	  $client=new SoapClient(WSDL, array(
	          #'proxy_host'     => PROXY_HOST,
	          #'proxy_port'     => PROXY_PORT,
	          'soap_version'   => SOAP_1_2,
	          'location'       => URL,
	          'trace'          => 1,
	          'exceptions'     => 0
	          )); 
	  $results=$client->loginCms(array('in0'=>$CMS));
	  file_put_contents("request-loginCms.xml",$client->__getLastRequest());
	  file_put_contents("response-loginCms.xml",$client->__getLastResponse());
	  if (is_soap_fault($results)) {
	  	exit("SOAP Fault: ".$results->faultcode."\n".$results->faultstring."\n");
	  }
	  return $results->loginCmsReturn;
	}

	function CallWSFE()
	{
		$client_wsfe = new SoapClient(WSDL_WSFE , array( 
                                'trace' => true,
                                'encoding' => 'UTF-8',
                                //'cache_wsdl' => WSDL_CACHE_BOTH,
                                //'ssl_method' => SOAP_SSL_METHOD_SSLv3,
                                //'stream_context' => stream_context_create($opts),
                                "exceptions" => false
                          ) );
		
    return $client_wsfe;

	}

	function GetUltimoCbte($client_wsfe, $punto_vta, $tipo_cbte) {
		$items = array();
    $items['MsgErr'] = '';
    $items['Errores'] = 0;
    $items['Errores_Code'] = 0;
    $items['Errores_Msg'] = '';
    $items['CbteNro'] = 0;

    $results = $client_wsfe->FECompUltimoAutorizado(
                    array('Auth' =>  array('Token'    => $this->token,
                                           'Sign'     => $this->sign,
                                           'Cuit'     => $this->cuit),
                          'PtoVta'   => $punto_vta,
                          'CbteTipo' => $tipo_cbte));
        
        if (isset($results->FECompUltimoAutorizadoResult->Errors)) {
        	foreach($results->FECompUltimoAutorizadoResult->Errors as $k) {
        		$items['Errores_Code'] = $k->Code;
            $items['Errores_Msg'] = $k->Msg;
        	}
        } else {
        	$items['CbteNro'] = $results->FECompUltimoAutorizadoResult->CbteNro;
        }

      echo(json_encode($items));         
	}

	function ConsultarCbte($client_wsfe, $tipo_cbte, $cbte_nro, $punto_vta) {
		
    $items = array();
    $items['MsgErr'] = '';
    $items['Errores'] = 0;
    $items['Errores_Code'] = 0;
    $items['Errores_Msg'] = '';
    $items['CbteNro'] = 0;
    
		$results = $client_wsfe->FECompConsultar(
                    array('Auth' =>  array('Token'    => $this->token,
                                           'Sign'     => $this->sign,
                                           'Cuit'     => $this->cuit),
                          'FeCompConsReq'   => array('CbteTipo' => $tipo_cbte,
                          							 'CbteNro' => $cbte_nro,
                          							 'PtoVta' => $punto_vta, )
                          ));
        
        if (isset($results->FECompConsultarResult->Errors)) {
        	$items['Errores'] = 1;
          foreach($results->FECompConsultarResult->Errors as $k) {
        		$items['Errores_Code'] = $k->Code;
            $items['Errores_Msg'] = $k->Msg;
        	}
        } else {
        	print_r($results->FECompConsultarResult);
        }        
	}

	function ConsultarPuntosVta($client_wsfe) {
		echo '<pre>';
		$results = $client_wsfe->FEParamGetPtosVenta(
                    array('Auth' =>  array('Token'    => $this->token,
                                           'Sign'     => $this->sign,
                                           'Cuit'     => $this->cuit)
                          ));
        
        if (isset($results->FEParamGetPtosVentaResult->Errors)) {
        	foreach($results->FEParamGetPtosVentaResult->Errors as $k) {
        		echo $k->Code. ' - ' . $k->Msg ;
        	}
        } else {
        	print_r($results->FEParamGetPtosVentaResult);
        }        
	}

	function ConsultarCotizacion($client_wsfe, $moneda) {
		echo '<pre>';
		$results = $client_wsfe->FEParamGetCotizacion(
                    array('Auth' =>  array('Token'    => $this->token,
                                           'Sign'     => $this->sign,
                                           'Cuit'     => $this->cuit),
                    		'MonId' => $moneda
                          ));
        
        if (isset($results->FEParamGetCotizacionResult->Errors)) {
        	foreach($results->FEParamGetCotizacionResult->Errors as $k) {
        		echo $k->Code. ' - ' . $k->Msg ;
        	}
        } else {
        	print_r($results->FEParamGetCotizacionResult);
        }        
	}

	function ConsultarTiposIVA($client_wsfe) {
		
		$results = $client_wsfe->FEParamGetTiposIva(
                    array('Auth' =>  array('Token'    => $this->token,
                                           'Sign'     => $this->sign,
                                           'Cuit'     => $this->cuit)
                          ));
        
     if (isset($results->FEParamGetTiposIvaResult->Errors)) {
        	foreach($results->FEParamGetTiposIvaResult->Errors as $k) {
        		echo $k->Code. ' - ' . $k->Msg ;
        	}
     } else {
        	print_r($results->FEParamGetTiposIvaResult);
     }        
	}


	function AutorizarCbte($client, $cant_reg, $punto_vta, $cbte_tipo, $comprobante) {
		
    
    $Auth = array('Token' => $this->token,
                     	'Sign'  => $this->sign,
                     	'Cuit'  => $this->cuit); 

		$FeCabReq = array('CantReg' => $cant_reg, 
                        	'PtoVta' => $punto_vta, 
                        	'CbteTipo' => $cbte_tipo);

		$FEDetalleRequest = array('Concepto' => $comprobante->Concepto,
	                           'DocTipo' => $comprobante->DocTipo,
	                           'DocNro' =>  $comprobante->DocNro * 1,
	                           'CbteDesde' => $comprobante->CbteDesde,
	                           'CbteHasta' => $comprobante->CbteHasta,
	                           'CbteFch' => $comprobante->CbteFch,
	                           'ImpTotal' => $comprobante->ImpTotal,
	                           'ImpTotConc' => $comprobante->ImpTotConc,
	                           'ImpNeto' => $comprobante->ImpNeto,
	                           'ImpOpEx' => $comprobante->ImpOpEx,
	                           'ImpTrib' => $comprobante->ImpTrib,
	                           'ImpIVA' => $comprobante->ImpIVA,
	                           'MonId' => $comprobante->MonId,
	                           'MonCotiz' => $comprobante->MonCotiz,
	                           'Iva' => $comprobante->Iva
	                          );

		$results = $client->FECAESolicitar(
            array('Auth' => $Auth,
                  'FeCAEReq' => array(
                     'FeCabReq' => $FeCabReq,
                     'FeDetReq' => array('FECAEDetRequest' => $FEDetalleRequest) 
					)
				)
		);
  	
    $items = array();
    $items['Resultado'] = '';
    $items['MsgRta'] = '';
    $items['CAE'] = '';
    $items['CAEFchVto'] = '';
    $items['Errores'] = 0;
    $items['Errores_Code'] = 0;
    $items['Errores_Msg'] = '';
    $items['Observaciones'] = 0;
    $items['Observaciones_Code'] = 0;
    $items['Observaciones_Msg'] = '';

    $items['Resultado'] = $results->FECAESolicitarResult->FeCabResp->Resultado;

  	if ($results->FECAESolicitarResult->FeCabResp->Resultado == 'R') {
  		  $items['MsgRta'] = '** COMPROBANTE RECHAZADO***';
  	} else {
  			$items['MsgRta'] = '** COMPROBANTE APROBADO***';
  			
      	$items['CAE'] = $results->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAE .'<br>';
      	$items['CAEFchVto'] = $results->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAEFchVto .'<br>';
        
        $this->cae = $results->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAE;
        $this->fecha_vto_cae = $results->FECAESolicitarResult->FeDetResp->FECAEDetResponse->CAEFchVto;
  	}

		//Errores
		if (isset($results->FECAESolicitarResult->Errors)) {
      	$items['Errores'] = 1;
      	foreach($results->FECAESolicitarResult->Errors as $k) {
      	   $items['Errores_Code'] = $k->Code;
           $items['Errores_Msg'] = $k->Msg;
      	}
    }
        
    //Observaciones
    if (isset($results->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones)) {
      	
        $items['Observaciones'] = 1;
      	
        if (count($results->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones->Obs) > 1) {
          foreach($results->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones->Obs as $k => $v) {
            $items['Observaciones_Code'] = $v->Code;
            $items['Observaciones_Code'] = $v->Msg;
          }  
        } else {
          foreach($results->FECAESolicitarResult->FeDetResp->FECAEDetResponse->Observaciones as $k) {
            $items['Observaciones_Code'] = $k->Code;
            $items['Observaciones_Code'] = $k->Msg;
          }
        }          
    }

    return json_encode($items);
          
	}

	function Dummy ($client) {
          $results = $client->FEDummy();
          printf("appserver status: %s\ndbserver status: %s\nauthserver status: %s\n",
                 $results->FEDummyResult->AppServer, 
                 $results->FEDummyResult->DbServer, 
                 $results->FEDummyResult->AuthServer);
          if (is_soap_fault($results)) 
           { 
             echo $results->faultcode. ' - ' . $results->faultstring; 
           }
          return;
        }
}

class Comprobante {
	  
    public $Concepto = 1;
	  public $DocTipo = 80;
	  public $DocNro = 20312202515;
    public $CbteDesde = 23;
    public $CbteHasta = 23;
    public $CbteFch = 20150821;
    public $ImpTotal = 121;
    public $ImpTotConc = 0;
    public $ImpNeto = 100;
    public $ImpOpEx = 0;
    public $ImpTrib = 0;
    public $ImpIVA = 21;
    public $MonId = 'PES';
    public $MonCotiz = 1;
    public $Iva = array(
   			'AlicIva' => array(
   				'Id' => 5,
   				'BaseImp' => 100,
   				'Importe' => 21,
   			)
   		);

}