<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class proveedor_controller extends CI_Controller {

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
     * Abm Articulos
     */
    public function abm_proveedores() 
    {
        $accion = $this->uri->segment(3);
        
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('proveedores');
            $crud->set_subject('Proveedores');
            
            $crud->set_relation('iva_id', 'tipos_iva', 'descripcion');
            $crud->set_relation('provincia_id', 'provincias', 'nombre');
            $crud->set_relation('departamento_id', 'departamentos', 'nombre');
            $crud->set_relation('localidad_id', 'localidades', 'nombre');
            
            $crud->display_as('provincia_id', 'Provincia');
            $crud->display_as('departamento_id', 'Departamento');
            $crud->display_as('localidad_id', 'Localidad');

            $crud->columns('codigo_proveedor', 'nombre_proveedor', 'cuit',
                    'telefono1', 'email1','viajante_nombre', 'provincia_id', 'departamento_id', 'localidad_id');
            
            $crud->fields('codigo_proveedor', 'nombre_proveedor', 'nro_cliente','iva_id',
                    'cuit', 'domicilio', 'provincia_id', 'departamento_id', 'localidad_id', 
                    'codigo_postal','telefono1', 'email1', 'ibrutos',
                    'viajante_nombre', 'viajante_telefono',
                    'comentarios');

            $crud->display_as('iva_id', 'Tipo IVA');            
            
            
            if ($accion == 'edit') {
                //$crud->field_type('codigo_proveedor', 'readonly', 'readonly');
                $crud->callback_field('codigo_proveedor',array($this, 'field_callback_codigo_prov_ro'));
                $crud->callback_field('cuit',array($this, 'field_callback_cuit_ro'));
            }
            
            if ($accion == 'add') {
                $crud->callback_field('codigo_proveedor',array($this, 'field_callback_codigo_prov'));
                $crud->callback_field('cuit',array($this, 'field_callback_cuit'));
            }

            //Agrega la agenda de contactos
            $crud->callback_field('telefono1',array($this, 'field_callback_telefono'));
            
            
            $crud->required_fields('codigo_proveedor','nombre_proveedor',
                    'iva_id', 'telefono1');

            $crud->display_as('telefono1', 'Telefono');
            $crud->display_as('email1', 'E-mail');
            $crud->display_as('viajante_nombre', 'Viajante');

            $crud->order_by('codigo_proveedor','asc');

            $this->load->library('gc_dependent_select');

            $fields = array(
                // first field:
                'provincia_id' => array( // first dropdown name
                'table_name' => 'provincias', // table of country
                'title' => 'nombre', // country title
                'relate' => null,
                'order_by'=>"nombre", 
                ),
                // second field
                'departamento_id' => array( // second dropdown name
                'table_name' => 'departamentos', // table of state
                'title' => 'nombre', // state title
                'id_field' => 'id', // table of state: primary key
                'relate' => 'provincia_id', // table of state:
                'data-placeholder' => 'Seleccione Departamento', //dropdown's data-placeholder:
                'order_by'=>"nombre", 

                ),
                // second field
                'localidad_id' => array( // second dropdown name
                'table_name' => 'localidades', // table of state
                'title' => 'nombre', // state title
                'id_field' => 'id', // table of state: primary key
                'relate' => 'departamento_id', // table of state:
                'data-placeholder' => 'Seleccione Localidad', //dropdown's data-placeholder:
                'order_by'=>"nombre", 
            ));

            $config = array(
            'main_table' => 'proveedores',
            'main_table_primary' => 'id',
            "url" => base_url() . __CLASS__ . '/' . __FUNCTION__ . '/', //path to method
            //'ajax_loader' => base_url() . 'ajax-loader.gif' // path to ajax-loader image. It's an optional parameter
            //'segment_name' =>'Your_segment_name' // It's an optional parameter. by default "get_items"
            );
            
            $categories = new gc_dependent_select($crud, $fields, $config);

            //$crud->set_rules('codigo_proveedor', 'Codigo Proveedor', 'callback_codigo_proveedor_check');

            // first method:
            //$output = $categories->render();

            // the second method:
            $js = $categories->get_js();
            $output = $crud->render();
            $output->output.= $js;


            //$output = $crud->render();

            $this->output('administrador/default_layout/abm.php', $output);
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    /*Agrega la agenda de contactos*/
    public function field_callback_telefono($value = '', $primary_key = null)
    {
      /*return '<input id="field-telefono1" name="telefono1" type="text" value="' . $value . '" maxlength="50">
      <button data-entidad="proveedores_contactos" data-campo="proveedor_id" data-id="' . $primary_key . '" class="btn btn-primary" type="button" id="btn-agenda-contactos">Agenda de Contactos</button>';
      */
      return '<input id="field-telefono1" name="telefono1" type="text" value="' . $value . '" maxlength="50">';
    }

    function field_callback_cuit($value = '', $primary_key = null)
    {
        return '<input type="text" value="'.$value.'" onkeypress="return event.charCode > 31 && (event.charCode >= 48 && event.charCode <= 57)" name="cuit" id="field-cuit" maxlength="11"><span id="msg-error-cuit" style="color:red"> * </span>';
    }
    
    //Campo CUIT Solo Lectura
    function field_callback_cuit_ro($value = '', $primary_key = null)
    {
        return '<input type="text" maxlength="50" value="'.$value.'" name="cuit" id="field-cuit" readonly="readonly">';
    }
    
    function field_callback_codigo_prov($value = '', $primary_key = null)
    {
        $nuevo_numero = '0';
        $sql = "SELECT (MAX((codigo_proveedor * 1)) + 1) AS codigo FROM proveedores ORDER BY codigo";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        
        $nuevo_numero = $row['codigo'];
        $nuevo_numero = str_pad($nuevo_numero, 3, "0", STR_PAD_LEFT);
        return '<input type="text" maxlength="50" value="'.$nuevo_numero.'" name="codigo_proveedor" id="field-codigo_proveedor">';
    }
    //Codigo de Proveedor Solo Lectura
    function field_callback_codigo_prov_ro($value = '', $primary_key = null)
    {        
        return '<input type="text" maxlength="50" value="'.$value.'" name="codigo_proveedor" id="field-codigo_proveedor" readonly="readonly">';
    }

    //FUNCION VALIDA CUIT
    function validarCUIT($cuit) {
            
            $cuit = str_replace('-', '', $cuit);

            $cadena = str_split($cuit);

            $result = $cadena[0]*5;
            $result += $cadena[1]*4;
            $result += $cadena[2]*3;
            $result += $cadena[3]*2;
            $result += $cadena[4]*7;
            $result += $cadena[5]*6;
            $result += $cadena[6]*5;
            $result += $cadena[7]*4;
            $result += $cadena[8]*3;
            $result += $cadena[9]*2;

            $div = intval($result/11);
            $resto = $result - ($div*11);

            if($resto==0){
                if($resto==$cadena[10]){
                    return true;
                }else{
                    return false;
                }
            }elseif($resto==1){
                if($cadena[10]==9 AND $cadena[0]==2 AND $cadena[1]==3){
                    return true;
                }elseif($cadena[10]==4 AND $cadena[0]==2 AND $cadena[1]==3){
                    return true;
                }
            }elseif($cadena[10]==(11-$resto)){
                return true;
            }else{
                return false;
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