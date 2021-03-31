<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class venta_controller extends CI_Controller {

    private $_guestProfile;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            //user is already logged in
            redirect('ingresar');
        } else {
            $this->load->library('grocery_CRUD');
            $this->_guestProfile = $this->session->userdata('logged_in');
        }
    }
   
    public function output($view, $output = null) {
        $this->load->view($view, $output);
    }

    public function nueva_factura() {
        $this->load->view('ventas/nueva_factura.php');
    }
    
    public function presupuesto() {
        
        $user = $this->session->userdata('logged_in');
        $user_id = $user['guestData']['tbl_users_id'];
        
        $articulo = $this->input->post('articulo');
        $oem = $this->input->post('oem');
        $descripcion = $this->input->post('descripcion');
        $oem_vw = $this->input->get('oem_vw');
        
        if($oem_vw != ''){
            $oem = $oem_vw;
        }

        $this->load->model('articulo_model');
        $this->load->model('presupuesto_model');
        $this->load->model('condicion_venta_model');
        $this->load->model('banco_model');

        //Condiciones de Vena
        $condiciones_venta = $this->condicion_venta_model->get_all_condiciones_venta();

        //Bancos
        $bancos = $this->banco_model->get_all_bancos();

        $sucursal = $this->_guestProfile['sucursal'];

        //$codigo = $this->input->post('codigo'); 
        if($articulo != '') {
            $articulos = $this->articulo_model->get_articulo_by_codigo_fenix($articulo);    
            $oem = "";
            $descripcion = "";
        } else if($oem != '') {
            $articulos = $this->articulo_model->get_articulo_by_codigo_oem($oem);    
            $articulo = "";
            $descripcion = "";
        }  else if($descripcion != '') {
            $articulos = $this->articulo_model->get_all_articulo_by_descripcion($descripcion);    
            $articulo = "";
            $oem = '';
        } else {
            $articulos = $this->articulo_model->get_all_articulo_by_descripcion($descripcion);    
        }

        $data['articulo'] = $articulos;
        $data['sucursal'] = $sucursal;
        $data['condiciones_venta'] = $condiciones_venta;
        $data['bancos'] = $bancos;

        $this->presupuesto_model->limpiarPresupuesto(0, $user_id);
        
        $this->load->view('ventas/presupuesto.php', $data);
    }

    public function buscarArticulo() {
        $this->load->model('articulo_model');
        
        $codfenix = $this->input->post('codfenix');
        $sucursal = $this->input->post('sucursal');

        $items = array();
        //Errores
        $items['err'] = "0";
        $items['msg_err'] = "";
        //Datos
        $items['codigofenix'] = '';
        $items['oem'] = '';
        $items['descripcion'] = '';
        $items['precio_lista'] = '';
        
        $row_art = $this->articulo_model->get_articulo_by_codigo_fenix($codfenix, false);
        
        if (count($row_art) > 0) {
            $codigofenix = $row_art['codigo_fenix'];
            $oem = $row_art['codigo_oem'];
            $descripcion = $row_art['descripcion'];
            $precio_lista = $row_art['precio_lista'];
            
            //Verifica si hay stock del articulo
            $stock = $this->articulo_model
                    ->get_stock_articulo($codfenix, $sucursal);
            
            $stock = 1; ///ojo - despues hacer control de stock
            if ($stock === 0) {
                $items['stock'] = 0;
                $items['err'] = "1";
                $items['msg_err'] = "Articulo sin stock en sucursal $sucursal";
            } else {
                $items['codigofenix'] = $codigofenix;
                $items['oem'] = $oem;
                $items['descripcion'] = $descripcion;
                $items['precio_lista'] = $precio_lista;
                $items['stock'] = $stock;
            }            
            
        } else {
            $items['err'] = "1";
            $items['msg_err'] = "Articulo inexistente";
        }
        echo json_encode($items);
    }

    public function getArticulosCarrito() {
        $this->load->model('presupuesto_model');
        
        $user = $this->session->userdata('logged_in');
        $user_id = $user['guestData']['tbl_users_id'];

        $articulos = $this->presupuesto_model->get_detalle_presupuesto_by_user(0, $user_id);
        
        $totales = $this->presupuesto_model->get_totales_presupuesto(0, $user_id);
                
        $importe_total = $totales['importe'];
        $items_presupuesto = $totales['items'];

        $items['articulos'] = $articulos;
        $items['importe_total'] = $importe_total;
        $items['items_presupuesto'] = $items_presupuesto;
        
        echo json_encode($items);
    }

    /** 
     * Guarda el Articulo en el presupuesto desde la consulta de Articulos
     */
    public function guardarArtPresupuestoConsulta() {
        //Datos de usuario
        $user = $this->session->userdata('logged_in');
        
        $user_id = $user['guestData']['tbl_users_id'];
        $username = $user['username'];
        $sucursal = $user['sucursal'];

        $this->load->model('articulo_model');
        $this->load->model('presupuesto_model');
                
        $fecha = date('d/m/Y');
        $concepto = 1;
        $codfenix = $this->input->post('codfenix');
        $oem = $this->input->post('oem');
        $precio = $this->input->post('precio');
        $cantidadped = $this->input->post('cantidadped');
        $sucursal = $sucursal;
        $cliente = 0;
        $compania = 0;
        $perito = 0;
        $vehiculo = 0;
        $chasis = '';
        $motor = '';
        $siniestro = '';
        $observaciones = '';

        $importe_flete = 0;
        $destino_flete = '';
        $modelo_ano = 0;
        $patente = 0;

        //Dtos / Rec
        $dto1 = 0;
        $dto2 = 0;
        $dto3 = 0;
        $rec1 = 0;
        
        $arrayFecha = explode('/', $fecha);
        $fecha = $arrayFecha[2] . '-' . $arrayFecha[1] . '-' . $arrayFecha[0] . ' ' . date('h:i:s');
        
        $items = array();

        $total_items = 0;
        $importe_total = 0;

        //Verifica si exite el articulo
        $count_art = count($this->presupuesto_model->get_articulo_presupuesto(0, $codfenix));
        
        $art = array (
            'presupuesto_nro' => 0,
            'codfenix' => $codfenix,
            'oem' => $oem,
            'precio' => $precio,
            'cantidad' => $cantidadped,
            'sucursal' => $sucursal,
            'fecha' => $fecha,
            'concepto' => $concepto,
            'cliente_id' => $cliente,
            'compania_id' => $compania,
            'perito_id' => $perito,
            'modelo_id' => $vehiculo,
            'chasis' => $chasis,
            'motor' => $motor,
            'siniestro' => $siniestro,
            'observaciones' => $observaciones,
            'dto1' => $dto1,
            'dto2' => $dto2,
            'dto3' => $dto3,
            'rec1' => $rec1,
            'patente' => $patente,
            'flete' => $importe_flete,
            'flete_destino' => $destino_flete,
            'modelo_ano' => $modelo_ano,
            'user_id' => $user_id
        );
        
        $importe_total = 0;
        $items_presupuesto = 0;
        $err = 0; 

        if ($count_art == 0) {
            $result = $this->presupuesto_model->guardar_art_presupuesto($art);  
            $strMensaje = '';
            if ($result) {
                $strMensaje = 'Articulo guardado en el presupuesto';
                $totales = $this->presupuesto_model->get_totales_presupuesto(0, $user_id);
                
                $importe_total = $totales['importe'];
                $items_presupuesto = $totales['items'];
                
            } else {
                $err = 1;
                $strMensaje = 'Error al guardar artículo en el presupuesto';
            }
        } else {
            $err = 2;
            $strMensaje = 'Articulo ' . $codfenix . ' ya existe en el presupuesto. Desea acumular a la cantidad pedida?';
        }
        
        $items['mensaje'] = $strMensaje;
        $items['mensaje'] = $strMensaje;
        $items['importe'] = $importe_total;
        $items['err'] = $err;

        echo json_encode($items);
    }



    /**
     * Guarda el Articulo en el presupuesto
     */
    public function guardarArtPresupuesto() {
        
        $this->load->model('articulo_model');
        $this->load->model('presupuesto_model');
                
        //Datos de usuario
        $user = $this->session->userdata('logged_in');
        $user_id = $user['guestData']['tbl_users_id'];
        $fecha = $this->input->post('fecha');
        $concepto = $this->input->post('concepto');
        $codfenix = $this->input->post('codfenix');
        $oem = $this->input->post('oem');
        $precio = $this->input->post('precio');
        $cantidadped = $this->input->post('cantidadped');
        $sucursal = $this->input->post('sucursal');
        $cliente = $this->input->post('cliente');
        $compania = $this->input->post('compania');
        $perito = $this->input->post('perito');
        $vehiculo = $this->input->post('vehiculo');
        $chasis = $this->input->post('chasis');
        $motor = $this->input->post('motor');
        $siniestro = $this->input->post('siniestro');
        $observaciones = $this->input->post('observaciones');

        $importe_flete = $this->input->post('importe_flete');
        $destino_flete = $this->input->post('destino_flete');
        $modelo_ano = $this->input->post('modelo_ano');
        $patente = $this->input->post('patente');

        //Dtos / Rec
        $dto1 = $this->input->post('dto1');
        $dto2 = $this->input->post('dto2');
        $dto3 = $this->input->post('dto3');
        $rec1 = $this->input->post('rec1');
        
        $arrayFecha = explode('/', $fecha);
        $fecha = $arrayFecha[2] . '-' . $arrayFecha[1] . '-' . $arrayFecha[0] . ' ' . date('h:i:s');
        
        $items = array();

        $total_items = 0;
        $importe_total = 0;
        
        //Verifica si exite el articulo
        $count_art = count($this->presupuesto_model->get_articulo_presupuesto(0, $codfenix));

        $art = array (
            'presupuesto_nro' => 0,
            'codfenix' => $codfenix,
            'oem' => $oem,
            'precio' => $precio,
            'cantidad' => $cantidadped,
            'sucursal' => $sucursal,
            'fecha' => $fecha,
            'concepto' => $concepto,
            'cliente_id' => $cliente,
            'compania_id' => $compania,
            'perito_id' => $perito,
            'modelo_id' => $vehiculo,
            'chasis' => $chasis,
            'motor' => $motor,
            'siniestro' => $siniestro,
            'observaciones' => $observaciones,
            'dto1' => $dto1,
            'dto2' => $dto2,
            'dto3' => $dto3,
            'rec1' => $rec1,
            'patente' => $patente,
            'flete' => $importe_flete,
            'flete_destino' => $destino_flete,
            'modelo_ano' => $modelo_ano,
            'user_id' => $user_id
        );
        
        $actualiza_articulo = false;

        if ($count_art == 0) {
            $result = $this->presupuesto_model->guardar_art_presupuesto($art);
            $importe_total = 0;
            $items_presupuesto = 0;
            $strMensaje = '';
            if ($result) {
                $strMensaje = 'Articulo guardado en el presupuesto';
                $totales = $this->presupuesto_model->get_totales_presupuesto(0, $user_id);
                
                $importe_total = $totales['importe'];
                $items_presupuesto = $totales['items'];
                
            } else {
                $strMensaje = 'Error al guardar artículo en el presupuesto';
            }
        } else {
             $result = $this->presupuesto_model->updateArtPresupuesto($codfenix, $cantidadped);
             
             if (!$result) {
                $strMensaje = "Error al actualizar articulo";
             } else {
                $actualiza_articulo = true;
                $strMensaje = "Articulo actualizado correctamente";
             }
        }
        
        $items['mensaje'] = $strMensaje;
        $items['importe'] = $importe_total;
        $items['items'] = $items_presupuesto;
        $items['actualiza'] = $actualiza_articulo;

        echo json_encode($items);
        
    }
	
	public function borrarArticuloPresupuesto(){
        $this->load->model('presupuesto_model');
                
        $user = $this->session->userdata('logged_in');
        $user_id = $user['guestData']['tbl_users_id'];
        $cliente = $this->input->post('cliente');
        $articulo = $this->input->post('articulo');

        $res = $this->presupuesto_model->deleteArtPresupuesto(0, $user_id, $articulo);
        
        $totales = $this->presupuesto_model->get_totales_presupuesto(0, $user_id);
            
        $importe_total = $totales['importe'];
        $items_presupuesto = $totales['items'];

        $items['importe'] = $importe_total;
        $items['items'] = $items_presupuesto;
        $items['res'] = $res;

        echo json_encode($items);
    }

    public function updateArticuloPresupuesto(){
        $this->load->model('presupuesto_model');
                
        $articulo = $this->input->post('articulo');
        $cantidad = $this->input->post('cantidad');

        $res = $this->presupuesto_model->updateArtPresupuesto($articulo, $cantidad);
        $err = 0;
        $mensaje = "";
        if (!$res) {
            $err = 1;
            $mensaje = "Error al actualizar cantidad";
        } else {
            $err = 0;
            $mensaje = "Cantidad actualizada correctamente";
        }
        
        /*
        $totales = $this->presupuesto_model->get_totales_presupuesto(0, $cliente);
            
        $importe_total = $totales['importe'];
        $items_presupuesto = $totales['items'];

        $items['importe'] = $importe_total;
        $items['items'] = $items_presupuesto;
        */

        $items['err'] = $err;
        $items['mensaje'] = $mensaje;
        $items['res'] = $res;

        echo json_encode($items);
    }

    function anular_presupuesto($cliente) {

        $this->load->model('presupuesto_model');
                
        $this->presupuesto_model->anular_presupuesto($cliente);

        redirect(site_url('administrador/listado_presupuesto'));
        
    }

    /**
     * Guarda presupuesto
     */
    public function guardarPresupuesto($factura_directa = false) {
        //Datos de usuario
        $user = $this->session->userdata('logged_in');
        $user_id = $user['guestData']['tbl_users_id'];

        $this->load->model('presupuesto_model');
        
        $var = $this->input->post();
         
        //Datos de usuario
        $user = $this->session->userdata('logged_in');
        $user_id = $user['guestData']['tbl_users_id'];
        //Datos del Presupuesto
        $cliente = $var['cliente'];
        $sucursal = $var['sucursal'];
        $condventa = $var['cond_venta'];
        //
        $fecha = $var['fecha'];
        $concepto = $var['concepto'];
        $perito = $var['perito'];
        $vehiculo = $var['vehiculo'];
        $chasis = $var['chasis'];
        $motor = $var['motor'];
        $siniestro = $var['siniestro'];
        $observaciones = $var['observaciones'];

        $importe_flete = $var['importe_flete'];
        $destino_flete = $var['destino_flete'];
        $modelo_ano = $var['modelo_ano'];
        $patente = $var['patente'];
		
		if ($factura_directa == false) {
			$arrayFecha = explode('/', $fecha);
			$fecha = $arrayFecha[2] . '-' . $arrayFecha[1] . '-' . $arrayFecha[0] . ' ' . date('h:i:s');
		}

        //Dtos / Rec
        $dto1 = $this->input->post('dto1');
        $dto2 = $this->input->post('dto2');
        $dto3 = $this->input->post('dto3');
        $rec1 = $this->input->post('rec1');

        $detalle_presupuesto = $this->presupuesto_model->get_detalle_presupuesto_by_user(0, $user_id);

        $data_presupuesto = array(
            'sucursal' => $sucursal,
            'fecha' => $fecha,
            'concepto' => $concepto,
            'cliente_id' => $cliente,
            'perito_id' => $perito,
            'modelo_id' => $vehiculo,
            'chasis' => $chasis,
            'motor' => $motor,
            'siniestro' => $siniestro,
            'observaciones' => $observaciones,
            'dto1' => $dto1,
            'dto2' => $dto2,
            'dto3' => $dto3,
            'rec1' => $rec1,
            'patente' => $patente,
            'flete' => $importe_flete,
            'flete_destino' => $destino_flete,
            'modelo_ano' => $modelo_ano,
			'condicion_venta_id' => $condventa
        );

                
        $cantidad_arts = count($detalle_presupuesto);
        if ($cantidad_arts > 0 ) {
            $presupuesto_nro = $this->presupuesto_model
                ->guardar_presupuesto($sucursal, $user_id, $data_presupuesto);
        } else {
            $presupuesto_nro = -1;
        }

        $items = array();
        $strMensaje = '';
        $err = false;
        $importe_total = 0;
        $total_items = 0;
        if ($cantidad_arts > 0 ) {
            if ($presupuesto_nro != -1) {
                $strMensaje = "*** Presupuesto generado con éxito ***<br/>Presupuesto Nro: $presupuesto_nro<br/>";
                $totales = $this
                        ->presupuesto_model
                        ->get_totales_presupuesto($presupuesto_nro, $user_id);
                $importe_total = $totales['importe'];
                $total_items = $totales['items'];
            } else {
                $strMensaje = "ERROR AL GUARDAR PRESUPUESTO NRO $presupuesto_nro<br/>";
                $err = true;
            }
        } else {
            $strMensaje = "El presupuesto no contiene articulos";
            $err = true;
        }

        $items['err'] = $err;
        $items['presupuesto_nro'] = $presupuesto_nro;
        $items['mensaje'] = $strMensaje;
        $items['importe_total'] = $importe_total;
        $items['items'] = $total_items;
        
        if ($factura_directa) {
            if ($err) {
                return -1;
            } else {
                return $presupuesto_nro;
            }
        } else {
            echo json_encode($items);
        }
        
    }
    
    public function getTotalesPresupuesto()
    {
        $user = $this->session->userdata('logged_in');
        $user_id = $user['guestData']['tbl_users_id'];
        $totales = $this->presupuesto_model->get_totales_presupuesto(0, $user_id);
        $importe_total = $totales['importe'];
        $total_items = $totales['items'];
        echo json_encode($items);
    }

    public function listado_presupuesto() {
        $data = array();
        $cliente_id = $this->input->get('cliente');
        $this->load->model('cliente_model');
        $this->load->model('presupuesto_model');
        $clientes = $this->cliente_model->get_all_cliente();
        if ($cliente_id != '') {
            $presupuestos = $this->presupuesto_model->get_listado_presupuesto_by_cliente($cliente_id);
        } else {
            $presupuestos = $this->presupuesto_model->get_listado_presupuesto();
        }
        $data['clientes'] = $clientes;
        $data['presupuestos'] = $presupuestos;
        $this->load->view('ventas/listado_presupuesto.php', $data);
    }
    
    public function listado_facturas() {
        $data = array();
        $cliente_id = $this->input->get('cliente');
        $this->load->model('cliente_model');
        $this->load->model('factura_model');
        $clientes = $this->cliente_model->get_all_cliente();
        if ($cliente_id != '') {
            $facturas = $this->factura_model->get_listado_facturas_by_cliente($cliente_id);
        } else {
            $facturas = $this->factura_model->get_listado_facturas();
        }
        $data['clientes'] = $clientes;
        $data['facturas'] = $facturas;
        $this->load->view('facturacion/listado_facturacion.php', $data);
    }
    
    public function facturar_presupuesto($presupuesto_nro) {
        $data = array();
        
        $this->load->model('presupuesto_model');
        $presupuesto = $this->presupuesto_model->get_presupuesto_by_nro($presupuesto_nro);
        $detalle_presupuesto = $this->presupuesto_model->get_detalle_presupuesto_sin_facturar($presupuesto_nro);
        
        $data['presupuesto_nro'] = $presupuesto_nro;
        $data['presupuesto'] = $presupuesto;
        $data['detalle_presupuesto'] = $detalle_presupuesto;
        
        $this->load->view('ventas/facturar_presupuesto.php', $data);
    }

    public function generar_remito($presupuesto_nro) {
        $data = array();
        
        $this->load->model('presupuesto_model');
        $presupuesto = $this->presupuesto_model->get_presupuesto_by_nro($presupuesto_nro);
        $detalle_presupuesto = $this->presupuesto_model->get_detalle_presupuesto_sin_facturar($presupuesto_nro);
        
        $data['presupuesto_nro'] = $presupuesto_nro;
        $data['presupuesto'] = $presupuesto;
        $data['detalle_presupuesto'] = $detalle_presupuesto;
        
        $this->load->view('ventas/generar_remito.php', $data);
    }

    public function nota_credito() {
        $data = array();
        
        $params = $_GET;
        //print_r($params);
        //die;
        $comprobante_nro = $params['cbte_nro'];
        $tipo_cbte = $params['tipo_cbte'];
        $punto_vta = $params['punto_vta'];

        $this->load->model('comprobante_model');
        $comprobante = $this->comprobante_model->get_comprobante_cabecera($comprobante_nro, $tipo_cbte, $punto_vta);
        $comprobante_detalle = $this->comprobante_model->get_comprobante_detalle($comprobante_nro, $tipo_cbte, $punto_vta);
        
        $data['comprobante_nro'] = $comprobante_nro;
        $data['comprobante'] = $comprobante;
        $data['comprobante_detalle'] = $comprobante_detalle;
        
        $this->load->view('ventas/nota_credito.php', $data);
    }
    
    public function facturarPresupuesto($factura_directa=false, $_presupuesto_nro = 0, $_articulos = array(),
        $cobranza = array()) {
        
        $this->load->model('factura_model');
        $this->load->model('presupuesto_model');
        $this->load->model('sucursal_model');
        $this->load->model('stock_model');
        $this->load->model('cobranza_model');
        
        $items = array();
        
        if ($factura_directa) {
            $presupuesto_nro = $_presupuesto_nro;    
            //Articulos seleccionados para facturar
            $articulos = $_articulos;
        } else {
            $presupuesto_nro = $this->input->post('presupuesto_nro');    
            //Articulos seleccionados para facturar
            $articulos = $this->input->post('articulos');
        }
        
        $presupuesto = $this->presupuesto_model->get_presupuesto_by_nro($presupuesto_nro);
        
        $fecha_actual = date('Y-m-d h:i:s');
        $user = $this->session->userdata('logged_in');
        $username = $user['username'];

        $punto_vta = $this->sucursal_model->get_punto_vta($presupuesto[0]->sucursal);

        $importe_total = 0;
        $importe_neto = 0;
        $importe_iva = 0;

        foreach ($articulos as $clave => $valor) {
           $importe_total += ($valor['cantidad'] * $valor['precio']) * 1;
        }

        $importe_neto = ($importe_total / 1.21);
        $importe_iva = $importe_total - $importe_neto;

        //DocTipo
        $doc_tipo = $presupuesto[0]->doc_tipo;

        //Tipo Cbte
        $tipo_cbte = $presupuesto[0]->codigo_cbte;
        
               
        $factura = array (
            'sucursal' => $presupuesto[0]->sucursal,
            'comprobante_nro' => '',
            'fecha' => $fecha_actual,//Fecha Sin ningún tipo de formato
            'cliente_id' => $presupuesto[0]->cliente_id,
            'doc_tipo' => $doc_tipo,
            'doc_nro' => $presupuesto[0]->doc_nro,
            'user_factura' => $username,
            'tipo_cbte' => $tipo_cbte,
            'concepto' => $presupuesto[0]->concepto,
            'importe_total' => $importe_total,
            'importe_iva' => $importe_iva,
            'importe_neto' => $importe_neto,
            'punto_vta' => $punto_vta,
            'condicion_venta_id' => $presupuesto[0]->condicion_venta_id
            );
        
        $error = false;
        
        $factura_nro = $this->factura_model->guardar_factura($factura);
        if ($factura_nro !== -1) {
            
            foreach ($articulos as $k => $v) {
                  $factura_detalle = array (
                        'comprobante_id' => '0',
                        'codigo_articulo' => $v['articulo'],
                        'oem' => $v['oem'],
                        'precio' => $v['precio'],
                        'cantidad' => $v['cantidad'],
                        'sucursal_id' => $presupuesto[0]->sucursal,
                        'comprobante_nro' => $factura_nro,
                        'fecha' => $fecha_actual,
                        'tipo_cbte' => $tipo_cbte,
                        'punto_vta' => $punto_vta
                        );

                $result_factura_detalle = $this->factura_model
                        ->guardar_factura_detalle($factura_detalle, $presupuesto_nro);
                
                if (!$result_factura_detalle) {
                    $error = true;
                } else {

                    //cargar_cobranza
                    $cobranza['fecha_cobranza'] = date('Y-m-d h:i:s');
                    $cobranza['fecha'] = date('Y-m-d h:i:s');
                    $cobranza['comprobante_nro'] = $factura_nro;
                    $cobranza['cbte_tipo'] = $tipo_cbte;
                    $cobranza['importe'] = $importe_total;
                    $cobranza['punto_vta'] = $punto_vta;
                    $cobranza['cliente_id'] = $presupuesto[0]->cliente_id;

                    $this->cobranza_model->cargar_cobranza($cobranza);
                }
            }
            
        } else {
            $error = true;
        }
        
        $items['factura_nro'] = $factura_nro;
        $items['error'] = $error;

        if ($factura_directa) {
            if ($error) {
                return -1;
            } else {
                return $factura_nro;
            }
        } else {
            echo json_encode($items);
        }
    }

    public function generarRemito($factura_directa=false, $_presupuesto_nro = 0, $_articulos = array(),
        $cobranza = array()) {
        
        $this->load->model('factura_model');
        $this->load->model('presupuesto_model');
        $this->load->model('sucursal_model');
        $this->load->model('stock_model');
        $this->load->model('cobranza_model');
        
        $items = array();
        
        if ($factura_directa) {
            $presupuesto_nro = $_presupuesto_nro;    
            //Articulos seleccionados para facturar
            $articulos = $_articulos;
        } else {
            $presupuesto_nro = $this->input->post('presupuesto_nro');    
            //Articulos seleccionados para facturar
            $articulos = $this->input->post('articulos');
        }
        
        $presupuesto = $this->presupuesto_model->get_presupuesto_by_nro($presupuesto_nro);
        
        $fecha_actual = date('Y-m-d h:i:s');
        $user = $this->session->userdata('logged_in');
        $username = $user['username'];

        $punto_vta = $this->sucursal_model->get_punto_vta($presupuesto[0]->sucursal);

        $importe_total = 0;
        $importe_neto = 0;
        $importe_iva = 0;

        foreach ($articulos as $clave => $valor) {
           $importe_total += ($valor['cantidad'] * $valor['precio']) * 1;
        }

        $importe_neto = ($importe_total / 1.21);
        $importe_iva = $importe_total - $importe_neto;

        //DocTipo
        $doc_tipo = $presupuesto[0]->doc_tipo;

        //Tipo Cbte
        $tipo_cbte = $presupuesto[0]->codigo_cbte;
        
               
        $factura = array (
            'sucursal' => $presupuesto[0]->sucursal,
            'comprobante_nro' => '',
            'fecha' => $fecha_actual,//Fecha Sin ningún tipo de formato
            'cliente_id' => $presupuesto[0]->cliente_id,
            'doc_tipo' => $doc_tipo,
            'doc_nro' => $presupuesto[0]->doc_nro,
            'user_factura' => $username,
            'tipo_cbte' => $tipo_cbte,
            'concepto' => $presupuesto[0]->concepto,
            'importe_total' => $importe_total,
            'importe_iva' => $importe_iva,
            'importe_neto' => $importe_neto,
            'punto_vta' => $punto_vta,
            'condicion_venta_id' => $presupuesto[0]->condicion_venta_id
            );
        
        $error = false;
        
        $factura_nro = $this->factura_model->guardar_factura($factura);
        if ($factura_nro !== -1) {
            
            foreach ($articulos as $k => $v) {
                  $factura_detalle = array (
                        'comprobante_id' => '0',
                        'codigo_articulo' => $v['articulo'],
                        'oem' => $v['oem'],
                        'precio' => $v['precio'],
                        'cantidad' => $v['cantidad'],
                        'sucursal_id' => $presupuesto[0]->sucursal,
                        'comprobante_nro' => $factura_nro,
                        'fecha' => $fecha_actual,
                        'tipo_cbte' => $tipo_cbte,
                        'punto_vta' => $punto_vta
                        );

                $result_factura_detalle = $this->factura_model
                        ->guardar_factura_detalle($factura_detalle, $presupuesto_nro);
                
                if (!$result_factura_detalle) {
                    $error = true;
                } else {

                    //cargar_cobranza
                    $cobranza['fecha_cobranza'] = date('Y-m-d h:i:s');
                    $cobranza['fecha'] = date('Y-m-d h:i:s');
                    $cobranza['comprobante_nro'] = $factura_nro;
                    $cobranza['cbte_tipo'] = $tipo_cbte;
                    $cobranza['importe'] = $importe_total;
                    $cobranza['punto_vta'] = $punto_vta;
                    $cobranza['cliente_id'] = $presupuesto[0]->cliente_id;

                    $this->cobranza_model->cargar_cobranza($cobranza);
                }
            }
            
        } else {
            $error = true;
        }
        
        $items['factura_nro'] = $factura_nro;
        $items['error'] = $error;

        if ($factura_directa) {
            if ($error) {
                return -1;
            } else {
                return $factura_nro;
            }
        } else {
            echo json_encode($items);
        }
    }

    public function notaCredito() {
        
        $this->load->model('factura_model');
        //$this->load->model('presupuesto_model');
        $this->load->model('sucursal_model');
        $this->load->model('stock_model');
        $this->load->model('cobranza_model');
        
        $items = array();
        
        $presupuesto_nro = 0;
        
        //Articulos seleccionados para NOTA DE CREDITO
        $articulos = $this->input->post('articulos');
        
        $fecha_actual = date('Y-m-d h:i:s');
        $user = $this->session->userdata('logged_in');
        $username = $user['username'];

        //$punto_vta = $this->sucursal_model->get_punto_vta($presupuesto[0]->sucursal);

        $importe_total = 0;
        $importe_neto = 0;
        $importe_iva = 0;

        foreach ($articulos as $clave => $valor) {
           $importe_total += ($valor['cantidad'] * $valor['precio']) * 1;
        }

        $importe_neto = ($importe_total / 1.21);
        $importe_iva = $importe_total - $importe_neto;

        //DocTipo
        $doc_tipo = $this->input->post('doc_tipo');
        //Tipo Cbte
        $tipo_cbte = $this->input->post('tipo_cbte');

        $sucursal = $this->input->post('sucursal');
        $punto_vta = $this->input->post('punto_vta');
        $cliente_id = $this->input->post('cliente_id');
        $doc_nro = $this->input->post('doc_nro');
        $concepto = $this->input->post('concepto');
        $condicion_venta_id = $this->input->post('condicion_venta_id');
        
               
        $factura = array (
            'sucursal' => $sucursal,
            'comprobante_nro' => '',
            'fecha' => $fecha_actual,//Fecha Sin ningún tipo de formato
            'cliente_id' => $cliente_id,
            'doc_tipo' => $doc_tipo,
            'doc_nro' => $doc_nro,
            'user_factura' => $username,
            'tipo_cbte' => $tipo_cbte,
            'concepto' => $concepto,
            'importe_total' => $importe_total,
            'importe_iva' => $importe_iva,
            'importe_neto' => $importe_neto,
            'punto_vta' => $punto_vta,
            'condicion_venta_id' => $condicion_venta_id
            );
        
        $error = false;
        
        $factura_nro = $this->factura_model->guardar_factura($factura);
        if ($factura_nro !== -1) {
            
            foreach ($articulos as $k => $v) {
                  $factura_detalle = array (
                        'comprobante_id' => '0',
                        'codigo_articulo' => $v['articulo'],
                        'oem' => $v['oem'],
                        'precio' => $v['precio'],
                        'cantidad' => $v['cantidad'],
                        'sucursal_id' => $sucursal,
                        'comprobante_nro' => $factura_nro,
                        'fecha' => $fecha_actual,
                        'tipo_cbte' => $tipo_cbte,
                        'punto_vta' => $punto_vta
                        );

                $result_factura_detalle = $this->factura_model
                        ->guardar_factura_detalle($factura_detalle, $presupuesto_nro);
                
                if (!$result_factura_detalle) {
                    $error = true;
                } else {
                    /*
                    //cargar_cobranza
                    $cobranza['fecha_cobranza'] = date('Y-m-d h:i:s');
                    $cobranza['fecha'] = date('Y-m-d h:i:s');
                    $cobranza['comprobante_nro'] = $factura_nro;
                    $cobranza['cbte_tipo'] = $tipo_cbte;
                    $cobranza['importe'] = $importe_total;
                    $cobranza['punto_vta'] = $punto_vta;
                    $cobranza['cliente_id'] = $presupuesto[0]->cliente_id;

                    $this->cobranza_model->cargar_cobranza($cobranza);
                    */
                }
            }
            
        } else {
            $error = true;
        }
        
        $items['factura_nro'] = $factura_nro;
        $items['error'] = $error;

        $factura_directa = false;

        if ($factura_directa) {
            if ($error) {
                return -1;
            } else {
                return $factura_nro;
            }
        } else {
            echo json_encode($items);
        }
    }

    public function facturaDirecta() {
        
        $cobranza_form = $this->input->post('cobranza');
        $cobranza = $cobranza_form[0];

        $presupuesto_nro = 0;
        
        $this->load->model('presupuesto_model');
        $presupuesto_nro = $this->guardarPresupuesto(true);
        
        if ($presupuesto_nro == -1) {
            $presupuesto_nro = 0;
        }        
        
        $detalle_presupuesto = $this->presupuesto_model->get_detalle_presupuesto($presupuesto_nro);

        $items = array();
        $strMensaje = '';        
        
        $articulos = array();
        
        $error = false;
        $factura_nro = 0;
        

        $c = 0;
        foreach ($detalle_presupuesto as $art) {
            $articulos[$c]['articulo'] = $art->codfenix;
            $articulos[$c]['oem'] = $art->oem;
            $articulos[$c]['precio'] = $art->precio;
            $articulos[$c]['cantidad'] = $art->cantidad;
            $c++;
        }

        if ($c > 0) {
            if ($presupuesto_nro != -1) {
                $factura_nro = $this->facturarPresupuesto(true, $presupuesto_nro, $articulos, $cobranza);
                 if ($factura_nro != -1) {
                    $strMensaje = 'Factura nro '. $factura_nro.' generada con exito. Nro de presupuesto asociado: ' . $presupuesto_nro;
                } else {
                    $error = true;
                    $strMensaje = 'Error al generar factura';
                }
                
            } else {
                $error = true;
                $strMensaje = 'Error al generar presupuesto';
            }
        } else {
            $error = true;
            $strMensaje = 'La factura no contiene articulos';
        }

        $items['error'] = $error;
        $items['presupuesto_nro'] = $presupuesto_nro;
        $items['factura_nro'] = $factura_nro;
        $items['mensaje'] = $strMensaje;
        
        echo json_encode($items);

    }
    
    public function anular_comprobante() {
        
        $this->load->model('comprobante_model');

        $cbte_nro = $this->input->post('cbte_nro');
        $tipo_cbte = $this->input->post('cbte_tipo');
        $punto_vta = $this->input->post('punto_vta');

        $items = array();
        $items['cbte_nro'] = $cbte_nro;
        $items['tipo_cbte'] = $tipo_cbte;
        $items['punto_vta'] = $punto_vta;

        $dbdata = array();
        $dbdata['fecha_anulado']  = date('Y-m-d h:i:s');

        $items['resultado'] = $this->comprobante_model->anular_comprobante($cbte_nro, $tipo_cbte, $punto_vta, $dbdata);

        echo json_encode($items);

    }

    public function presupuesto_pdf($presupuesto_nro) {
        //Carga Libreria FPDF
        $this->load->library('pdf');
        $this->load->model('presupuesto_model');
        $presupuesto = $this->presupuesto_model->get_presupuesto_by_nro($presupuesto_nro);
        $detalle_presupuesto = $this->presupuesto_model->get_detalle_presupuesto($presupuesto_nro);
        
        $this->pdf = new Pdf();
        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle("Presupuesto ". $presupuesto_nro);
        $this->pdf->SetLeftMargin(15);
        $this->pdf->SetRightMargin(15);
        $this->pdf->SetFillColor(200,200,200);
 
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(180, 5,'Presupuesto Nro.: ' . $presupuesto_nro, 0, 1, 'R',0);
        $this->pdf->Cell(180, 5,'Fecha: ' . $presupuesto[0]->fecha, 0, 1, 'R',0);
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->Cell(180, 5,'Siniestro: ' . $presupuesto[0]->siniestro, 0, 1, 'L',0);
        $this->pdf->SetFont('Arial', 'B', 11);
        $this->pdf->Cell(180, 5,'Cliente: ' . $presupuesto[0]->razon_social, 0, 1, 'L',0);
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(180, 5,'Domicilio: ' . $presupuesto[0]->domicilio, 0, 1, 'L',0);
        $this->pdf->Cell(180, 5,'Cia de Seguro: ' . $presupuesto[0]->compania, 0, 1, 'L',0);
        $this->pdf->Cell(180, 5,'Perito: ' . $presupuesto[0]->perito, 0, 1, 'L',0);
        $this->pdf->Cell(180, 5,'Modelo: ' . $presupuesto[0]->modelo, 0, 1, 'L',0);
        $this->pdf->Cell(180, 5,'Chasis: ' . $presupuesto[0]->chasis, 0, 1, 'L',0);
        $this->pdf->Cell(180, 5,'Motor: ' . $presupuesto[0]->motor, 0, 1, 'L',0);
        $this->pdf->Ln(7);
        
        $this->pdf->SetFont('Arial', '', 9);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
 
        $this->pdf->Cell(30,7,'Articulo','TBL',0,'C','1');
        $this->pdf->Cell(30,7,'OEM','TBL',0,'C','1');
        $this->pdf->Cell(60,7,'Descripcion','TBL',0,'C','1');
        $this->pdf->Cell(20,7,'Precio','TBL',0,'C','1');
        $this->pdf->Cell(20,7,'Cantidad','TBL',0,'C','1');
        $this->pdf->Cell(20,7,'Importe','TBLR',1,'C','1');
        //$this->pdf->Ln(7);
        
        foreach ($detalle_presupuesto as $art) {
            
            $this->pdf->Cell(30,5,$art->codfenix,'',0,'L',0);
            $this->pdf->Cell(30,5,$art->oem,'',0,'L',0);
            $this->pdf->Cell(60,5,  substr($art->descripcion,0,25),'',0,'L',0);
            $this->pdf->Cell(20,5,$art->precio,'',0,'R',0);
            $this->pdf->Cell(20,5,$art->cantidad,'',0,'R',0);
            $this->pdf->Cell(20,5,$art->importe,'',1,'R',0);
        }
        
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(180, 5,'Items: ' . $presupuesto[0]->items, 0, 1, 'R',0);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->Cell(180, 5,'Importe Total: $' . $presupuesto[0]->importe, 0, 1, 'R',0);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 10);

        if ($presupuesto[0]->observaciones != '') {
            $this->pdf->Cell(180, 5,'Observaciones: ' . $presupuesto[0]->observaciones, 1, 1, 'L',0);    
        }
        
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("FENIX_PRESUPUESTO_" .$presupuesto_nro . ".pdf", 'I');
    }
    
    public function factura_pdf() {
        
        //Carga Libreria FPDF
        $this->load->library('pdf');
        $this->load->model('factura_model');
        $this->load->model('numeracion_model'); 
        
        $cbte_nro = $this->input->get('cbte_nro');
        $tipo_cbte = $this->input->get('tipo_cbte');
        $punto_vta = $this->input->get('punto_vta');
 
        $factura = $this->factura_model->get_factura_by_nro($cbte_nro, $tipo_cbte, $punto_vta);
        $detalle_factura = $this->factura_model->get_detalle_factura($cbte_nro, $tipo_cbte, $punto_vta);

        $cbte_tipo = $factura[0]->tipo_cbte;
        $pto_vta = $factura[0]->punto_vta;

        $numeracion = $this->numeracion_model->get_cbte_nombre($cbte_tipo, $pto_vta);
        
        $this->pdf = new FacturaPdf();
        $this->pdf->cbte_tipo =  $numeracion['cbte_clase'];
        $this->pdf->cbte_tipo_nombre =  $numeracion['cbte_nombre'];
        $this->pdf->cbte_tipo_codigo = str_pad($cbte_tipo, 2, "0", STR_PAD_LEFT);;
        $this->pdf->punto_vta = str_pad($pto_vta, 4, "0", STR_PAD_LEFT);
        $this->pdf->comprobante_nro = str_pad($cbte_nro, 8, "0", STR_PAD_LEFT);
        $this->pdf->cae =  $factura[0]->cae_afip;
        $fecha_vto_cae = substr($factura[0]->fecha_vto_cae,6,2) . '/' . substr($factura[0]->fecha_vto_cae,4,2) . '/' . substr($factura[0]->fecha_vto_cae,0,4);
        $this->pdf->cae_fecha_vto =  $fecha_vto_cae;
        $this->pdf->cliente_id = $factura[0]->cliente_id;
        $this->pdf->fecha_cbte = $factura[0]->fecha;
        $this->pdf->condicion_venta = $factura[0]->condicion_venta;

        // Agregamos una página
        $this->pdf->AddPage();
        // Define el alias para el número de página que se imprimirá en el pie
        $this->pdf->AliasNbPages();
 
        /* Se define el titulo, márgenes izquierdo, derecho y
         * el color de relleno predeterminado
         */
        $this->pdf->SetTitle($numeracion['cbte_nombre'].'-'.$numeracion['cbte_clase'].'-'.$cbte_nro);
        //$this->pdf->SetLeftMargin(15);
        //$this->pdf->SetRightMargin(15);
        $this->pdf->SetFillColor(200,200,200);
 
        $this->pdf->SetFont('Arial', '', 9);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
 
        //$this->pdf->Cell(30,7,'Articulo','TBL',0,'C','1');
        //$this->pdf->Cell(30,7,'OEM','TBL',0,'C','1');
        $this->pdf->Cell(130,7,'Descripcion','TBL',0,'C','1');
        $this->pdf->Cell(20,7,'Precio Unit.','TBL',0,'C','1');
        $this->pdf->Cell(20,7,'Cantidad','TBL',0,'C','1');
        $this->pdf->Cell(20,7,'Subtotal c/IVA','TBLR',1,'C','1');
        //$this->pdf->Ln(7);
        //$importe = 0;
        foreach ($detalle_factura as $art) {
            
            //$this->pdf->Cell(30,5,$art->codigo_articulo,'',0,'L',0);
            //$this->pdf->Cell(30,5,$art->oem,'',0,'L',0);
            $this->pdf->Cell(130,5,  substr($art->descripcion,0,25),'',0,'L',0);
            $this->pdf->Cell(20,5,$art->precio,'',0,'R',0);
            $this->pdf->Cell(20,5,$art->cantidad,'',0,'R',0);
            $this->pdf->Cell(20,5,$art->importe,'',1,'R',0);
            //$importe +=  ($art->precio * $art->cantidad);
        }
        
        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->Cell(190, 5,'Items: ' . $factura[0]->items, 0, 1, 'R',0);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 12);
        
        //Comprobantes A
        if($cbte_tipo == 1 || $cbte_tipo == 2 ||$cbte_tipo == 3) {
            $this->pdf->Cell(190, 5,'Importe Neto: $' . $factura[0]->importe_neto, 0, 1, 'R',0);
            $this->pdf->Cell(190, 5,'Importe Iva: $' . $factura[0]->importe_iva, 0, 1, 'R',0);
        }

        //Comprobantes B
        if($cbte_tipo == 6 || $cbte_tipo == 7 ||$cbte_tipo == 8) {
            $this->pdf->Cell(190, 5,'Importe Neto: $' . $factura[0]->importe_total, 0, 1, 'R',0);
        }

        $this->pdf->Cell(190, 5,'Importe Otros Tributos: $ 0.00', 0, 1, 'R',0);
        $this->pdf->SetFont('Arial', 'B', 12);
        $this->pdf->Cell(190, 5,'Importe Total: $' . $factura[0]->importe_total, 0, 1, 'R',0);
        $this->pdf->Ln(5);
        $this->pdf->SetFont('Arial', '', 10);
        if ($factura[0]->observaciones != '') {
            $this->pdf->Cell(190, 5,'Observaciones: ' . $factura[0]->observaciones, 1, 1, 'L',0);    
        }    
        

        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output($numeracion['cbte_nombre'].'-'.$numeracion['cbte_clase'].'-'.$cbte_nro . ".pdf", 'I');
    }

}
