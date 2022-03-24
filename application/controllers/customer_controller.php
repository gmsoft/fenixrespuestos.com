<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class customer_controller extends CI_Controller {

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
    

    public function get_cliente() {
        $this->load->model('cliente_model');
        
        $cliente_id = $this->input->post('cliente');
        
        $cliente = $this->cliente_model->get_cliente_by_id($cliente_id);
        
        echo json_encode($cliente);
    
    }

    /**
     * Handle de usuarios 
     */
    public function manager_clientes() 
    {
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('clientes');
            $crud->set_subject('Clientes');           
           
            /**/            
            
            //$crud->fields('razon_soci', 'Last_Name', 'email' , 'Address', 'Num_Int', 'Num_Ext', 'twitter_account', 'facebook_account', 'City_idCity', 'CP', 'phone' , 'mobile_phone');
            //$crud->columns('Name', 'Last_Name', 'email' , 'Address');
            //$crud->required_fields('Name', 'Last_Name', 'email' , 'Address', 'Num_Int', 'Num_Ext', 'twitter_account', 'facebook_account', 'City_idCity', 'CP', 'phone' , 'mobile_phone');
            //Razon social

            $crud->columns('razon_social', 'domicilio','tipo_iva','cuit','dni','telefono','email','fecha_alta','activo');
            $crud->display_as('iva_id', 'Tipo IVA');
            $crud->set_relation('iva_id', 'tipos_iva', 'descripcion');
            $crud->set_rules('email', 'Email', 'valid_email|required');

            //Agrega la agenda de contactos
            $crud->callback_field('telefono',array($this, 'field_callback_telefono'));

            /*
            $crud->display_as('Name', 'Nombre');
            $crud->display_as('Last_Name', 'Apellido');
            $crud->display_as('email', 'Email');
            $crud->display_as('Address', 'Direccion');
            $crud->display_as('Num_Int', 'Numero Interno');
            $crud->display_as('Num_Ext', 'Numero Externo');
            $crud->display_as('twitter_account', 'Twitter');
            $crud->display_as('facebook_account', 'Facebook');
            $crud->display_as('City_idCity', 'Ciudad');
            $crud->display_as('CP', 'Codigo Postal');
            $crud->display_as('phone', 'Telefono');
            $crud->display_as('mobile_phone', 'Celular');
            $crud->unset_add();*/

            
            $output = $crud->render();
            $this->output('administrador/default_layout/abm.php', $output);
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }

     /*Agrega la agenda de contactos*/
    public function field_callback_telefono($value = '', $primary_key = null)
    {
        /*
      return '<input id="field-telefono" name="telefono1" type="text" value="' . $value . '" maxlength="50">
      <button data-entidad="clientes_contactos" data-campo="cliente_id" data-id="' . $primary_key . '" class="btn btn-primary" type="button" id="btn-agenda-contactos">Agenda de Contactos</button>';
      */
      return '<input id="field-telefono" name="telefono1" type="text" value="' . $value . '" maxlength="50">
      ';
      
    }


    public function getContactos() {
        $entidad = $_POST['entidad'];
        $campo = $_POST['campo'];
        $valor_id = $_POST['valor_id'];

        $sql = "SELECT nombre, telefono, email, direccion FROM contactos WHERE id IN ( SELECT contacto_id FROM $entidad WHERE $campo = '$valor_id')";
        $res = mysqli_query($link, $sql);
        $tabla = '<table class="table table-striped table-bordered">
        <thead><tr><th>Nombre</th><th>Telefono</th><th>Email</th><th>Direccion</th></tr></thead><tbody>';
        while ($row = mysql_fetch_array($res)) {
            $tabla .= '<tr>'; 
            $tabla .= '<td>' . $row['nombre'] . '</td>';
            $tabla .= '<td>' . $row['telefono'] . '</td>';
            $tabla .= '<td>' . $row['email'] . '</td>';
            $tabla .= '<td>' . $row['direccion'] . '</td>';
            $tabla .= '</tr>'; 
        }

        $tabla .= '</tbody></table>';
        echo $tabla;

    }

    public function addContacto() {
        $entidad = $_POST['entidad'];
        $campo = $_POST['campo'];
        $valor_id = $_POST['valor_id'];

        //@todo: agregar contacto
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $direccion = $_POST['direccion'];
        
        $err = 1;

        $sql_contactos = "INSERT INTO contactos (nombre, telefono, email, direccion) VALUES ('$nombre','$telefono','$email','$direccion')";
        $res_contactos = mysqli_query($link, $sql_contactos);
        if ($res_contactos) {
            $sql_contacto = "SELECT id FROM contactos WHERE nombre='$nombre' AND telefono= '$telefono'";// AND email = '$email'";
            //die($sql_contacto);
            $res_contacto = mysqli_query($link, $sql_contacto);
            $contacto_id = 0;
            while($row = mysql_fetch_array($res_contacto)) {
                $contacto_id = $row['id'];
            }

            $valor_id = $valor_id * 1;
            
            $sql_entidad = "INSERT INTO $entidad ($campo, contacto_id) VALUES ($valor_id, '$contacto_id')";
            //die($sql_entidad );
            $res_entidad = mysqli_query($link, $sql_entidad);
            if ($res_entidad) {
                $err = 0;
            }
        }
        echo $err;
    }

    function cta_cte() {
        $this->load->model('cliente_model');
        $this->load->model('ctacte_model');
        
        $cliente_id = $this->input->get('cliente');
        
        $clientes = $this->cliente_model->get_all_cliente();
        
        if ($cliente_id != '') {
            $cta_cte = $this->ctacte_model->get_ctacte_cliente($cliente_id);
        } else {
            $cta_cte = array();
        }
        $data['clientes'] = $clientes;
        $data['cta_cte'] = $cta_cte;
        $data['cliente_id'] = $cliente_id;

        $this->load->view('ventas/cta_cte_clientes.php', $data);
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