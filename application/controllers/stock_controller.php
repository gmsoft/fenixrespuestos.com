<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class stock_controller extends CI_Controller {

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

    public function index()
    {       
        $this->load->view('administrador/dashboard/dashboard.php');
    }
    
    /**
     * Abm Stock
     */
    public function abm_stock() 
    {
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('stock');
            $crud->set_subject('Stock');    

            //$crud->set_relation('articulo_id', 'articulos', '{codigo_fenix}');
            $crud->columns('articulo_fenix',  'sucursal_id', 'cantidad', 'ubicacion', 'ajuste');
            $crud->fields('articulo_fenix',  'sucursal_id', 'cantidad', 'ubicacion', 'ajuste');

            $crud->set_relation('sucursal_id', 'sucursales', 'nombre');
            $crud->set_relation('ubicacion', 'ubicaciones', 'ubicacion');
            
            $crud->callback_add_field('articulo_fenix', function () {
                return '<input type="text" maxlength="50"  id="field-articulo_fenix" name="articulo_fenix" ><span id="descripcion-art"> *<span>';
            });

            $crud->display_as('articulo_fenix', 'Articulo');
            $crud->display_as('sucursal_id', 'Sucursal');
            
            $crud->unset_delete();
            
            $output = $crud->render();
            $this->output('administrador/default_layout/abm.php', $output);
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    function _callback_codigo_fenix($value, $primary_key)
    {
        return '<input type="text" maxlength="50" value="'.$value.'" name="codigo_fenix" id="field-codigo_fenix" readonly>';
    }

    /**
     * Abm Ubicaciones
     */
    public function abm_ubicacion() 
    {
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('ubicaciones');
            $crud->set_subject('Ubicaciones');    

            $crud->unset_delete();
            
            $output = $crud->render();
            $this->output('administrador/default_layout/abm.php', $output);
        } catch(Exception $e) {
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function transferencias() 
    {
       $this->load->view('stock/transferencias.php');
    }
    
    public function cargarArticuloTransferencia() 
    {
       $var = $_POST;
       $codigo_fenix = $var['codfenix'];
       $cantidad = $var['cantidad'];
       $desdeSucursal = $var['desdeSucursal'];
       $hastaSucursal = $var['hastaSucursal'];
       $fecha = $var['fecha'];
       
       $sql_insert = "INSERT INTO transferencias_stock (codigo_fenix, cantidad, sucursal_desde, sucursal_hasta, fecha)"
               . " VALUES ('$codigo_fenix', '$cantidad', '$desdeSucursal', '$hastaSucursal','$fecha')";
       $res_insert = mysql_query($sql_insert);
       if (!$res_insert) {
           echo 'Error al crear transferencia';
       } else {
           echo 'Transferencia realizada con éxito';
       }
    }
    
    /**
     * Muestra las vistas
     * @param string $output 
     */
    public function output($view, $output = null)
    {
        $this->load->view($view, $output);
    }
}

?>