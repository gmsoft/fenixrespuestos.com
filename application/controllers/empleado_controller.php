<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class empleado_controller extends CI_Controller {

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
     * Handle de usuarios 
     */
    public function manager_empleados() 
    {
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('rrhh_empleados');
            $crud->set_subject('Empleados');           
           
            /*            
            $crud->fields('Name', 'Last_Name', 'email' , 'Address', 'Num_Int', 'Num_Ext', 'twitter_account', 'facebook_account', 'City_idCity', 'CP', 'phone' , 'mobile_phone');
            $crud->columns('Name', 'Last_Name', 'email' , 'Address');
            $crud->required_fields('Name', 'Last_Name', 'email' , 'Address', 'Num_Int', 'Num_Ext', 'twitter_account', 'facebook_account', 'City_idCity', 'CP', 'phone' , 'mobile_phone');

            $crud->set_rules('email', 'Email', 'valid_email|required');
            
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
            $crud->unset_add();

            */
            $output = $crud->render();
            $this->output('administrador/default_layout/abm.php', $output);
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
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