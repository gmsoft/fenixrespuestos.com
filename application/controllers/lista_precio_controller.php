<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lista_precio_controller extends CI_Controller {

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
    public function abm_articulos() 
    {
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('articulos');
            $crud->set_subject('Articulos');    
            
            $output = $crud->render();
            $this->output('administrador/default_layout/abm.php', $output);
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    public function abm_listas() 
    {
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('listas');
            $crud->set_subject('ABM Listas');    
            
            $crud->set_relation('proveedor_id', 'proveedores', '{codigo_proveedor}, {nombre_proveedor} ');
            $crud->columns('proveedor_id', 'nombre_tabla', 'nombre_archivo', 'fecha_actualizacion');
           
            //$crud->callback_before_upload(array($this,'example_callback_before_upload'));

            //$crud->set_field_upload('nombre_archivo','assets/uploads/files/listas');
            //$crud->callback_before_upload(array($this,'_callback_before_upload'));
            //$crud->callback_add_field('nombre_archivo',array($this,'_callback_nombre_archivo'));
            //$crud->callback_edit_field('nombre_archivo',array($this,'_callback_nombre_archivo'));
            
			$crud->display_as('dto1','Dto(-)/Rec(+) 1');
            $crud->display_as('dto2','Dto(-)/Rec(+) 2');
            $crud->display_as('dto3','Dto(-)/Rec(+) 3');

			//$crud->callback_upload(array($this,'_callback_upload'));
            $crud->unset_texteditor('script');
            $crud->unset_texteditor('post_script');
            $crud->unset_texteditor('observaciones');

            $output = $crud->render();
            $this->output('administrador/default_layout/abm.php', $output);
            
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function abm_lista_vw() 
    {
        try {

            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('lista_vw');
            $crud->set_subject('Lista VW');    
            
            $crud->columns('original', 'precio_publico', 'ue');
            $crud->fields('original', 'precio_publico', 'ue');
            
            
            $output = $crud->render();
            $this->output('administrador/default_layout/abm.php', $output);
            
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

     public function tabla_dto() 
    {
        try {

            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('proveedor_dto_vw');
            $crud->set_subject('Tabla de Descuento Proveedor');

            $crud->set_relation('proveedor_id', 'proveedores', '{codigo_proveedor}, {nombre_proveedor}');    
            
            $output = $crud->render();
            $this->output('administrador/default_layout/abm.php', $output);
            
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    public function lista_vw()
    {
        $oem = $this->input->post('original');
        $descripcion = $this->input->post('descripcion');

        $this->load->model('lista_precio_model');

        //$codigo = $this->input->post('codigo'); 
        if($oem != '') {
            $articulos = $this->lista_precio_model->get_articulo_by_original($oem);    
            $articulo = "";
            $descripcion = "";
            //die('oem:'.$oem);
        }  else if($descripcion != '') {
            $articulos = $this->lista_precio_model->get_all_articulo_by_descripcion($descripcion);    
            $articulo = "";
            $oem = '';
        } else {
            $articulos = $this->lista_precio_model->get_all_articulo_by_descripcion($descripcion);    
        }        


        

        $data['articulo'] = $articulos;        
        $data['oem'] = $oem;
        $data['descripcion'] = $descripcion;
        
        $this->load->view('consulta_articulo/consulta_vw.php', $data);
    }

    public function lista_ford()
    {
        $original = trim($this->input->post('original'));
        $descripcion = $this->input->post('descripcion');

        $this->load->model('lista_precio_model');

        //$codigo = $this->input->post('codigo'); 
        if ($original != '') {
            $articulos = $this->lista_precio_model->get_articulo_by_interno('original', $original, 'lista_ford');    
            $articulo = "";
            $descripcion = "";
        }  else if($descripcion != '') {
            $articulos = $this->lista_precio_model->get_all_articulo_by_descripcion($descripcion, 'lista_ford');    
            $articulo = "";
            $original = '';
        } else {
            $articulos = $this->lista_precio_model->get_all_articulo_by_descripcion($descripcion, 'lista_ford');    
        }      

        $data['articulo'] = $articulos;        
        $data['original'] = $original;
        $data['descripcion'] = $descripcion;
        
        $this->load->view('consulta_articulo/consulta_ford.php', $data);
    }


    public function lista_chevrolet()
    {
        $interno = trim($this->input->post('interno'));
        $descripcion = $this->input->post('descripcion');

        $this->load->model('lista_precio_model');

        //$codigo = $this->input->post('codigo'); 
        if ($interno != '') {
            $articulos = $this->lista_precio_model->get_articulo_by_interno('cod_chevrolet', $interno, 'lista_chevrolet');    
            $articulo = "";
            $descripcion = "";
        }  else if($descripcion != '') {
            $articulos = $this->lista_precio_model->get_all_articulo_by_descripcion($descripcion, 'lista_chevrolet');    
            $articulo = "";
            $oem = '';
        } else {
            $articulos = $this->lista_precio_model->get_all_articulo_by_descripcion($descripcion, 'lista_chevrolet');    
        }        

        $data['articulo'] = $articulos;        
        $data['interno'] = $interno;
        $data['descripcion'] = $descripcion;
        
        $this->load->view('consulta_articulo/consulta_chevrolet.php', $data);
    }

    public function lista_renault()
    {
        $original = trim($this->input->post('original'));
        $descripcion = $this->input->post('descripcion');

        $this->load->model('lista_precio_model');

        //$codigo = $this->input->post('codigo'); 
        if ($original != '') {
            $articulos = $this->lista_precio_model->get_articulo_by_interno('original', $original, 'lista_renault');    
            $articulo = "";
            $descripcion = "";
        }  else if($descripcion != '') {
            $articulos = $this->lista_precio_model->get_all_articulo_by_descripcion($descripcion, 'lista_renault');    
            $articulo = "";
            $oem = '';
        } else {
            $articulos = $this->lista_precio_model->get_all_articulo_by_descripcion($descripcion, 'lista_renault');    
        }        

        $data['articulo'] = $articulos;        
        $data['original'] = $original;
        $data['descripcion'] = $descripcion;
        
        $this->load->view('consulta_articulo/consulta_renault.php', $data);
    }
    
    public function edit_precio()
    {
         $art = $this->input->post('art');
         $precio = $this->input->post('precio');
         
         $sql_update = "UPDATE articulos SET precio_lista = '$precio' WHERE id = '$art'";
         $res_update = mysql_query($link, $sql_update);
         echo $res_update;
    }
    
    public function edit_stock()
    {
         $art = $this->input->post('art');
         $cantidad = $this->input->post('cantidad');
         
         $sql_update = "UPDATE stock SET cantidad = '$cantidad' WHERE articulo_fenix = '$art' and sucursal_id = 1";
         $res_update = mysql_query($link, $sql_update);
         echo $res_update;
    }
    
    public function importar_listas() 
    {
        try {            
            $this->load->view('lista_precios/importar_lista.php');
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

    function _callback_upload($obj)
    {
        return true;
    }

    function _callback_nombre_archivo($value, $primary_key)
    {
        return '<input type="text" value="'.$value.'" name="nombre_archivo" id="field-nombre_archivo" >
                <input type="file" id="file-import" value="'.$value.'" name="_nombre_archivo" id="_field-nombre_archivo" class="default">';
                
    }
    
    function _callback_before_upload($files_to_upload,$field_info)
    {
        /*
         * Examples of what the $files_to_upload and $field_info will be:    
        $files_to_upload = Array
        (
                [sd1e6fec1] => Array
                (
                        [name] => 86.jpg
                        [type] => image/jpeg
                        [tmp_name] => C:\wamp\tmp\phpFC42.tmp
                        [error] => 0
                        [size] => 258177
                )

        )

        $field_info = stdClass Object
        (
                [field_name] => file_url
                [upload_path] => assets/uploads/files
                [encrypted_field_name] => sd1e6fec1
        )

        */

        if(is_dir($field_info->upload_path))
        {
            return true;
        }
        else
        {
            return 'I am sorry but it seems that the folder that you are trying to upload doesn\'t exist.';    
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