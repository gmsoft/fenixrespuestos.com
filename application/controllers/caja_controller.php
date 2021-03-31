<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class caja_controller extends CI_Controller {

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
    public function abm_caja() 
    {
        /*
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('companias');
            $crud->set_subject('Companias');           
           
            $output = $crud->render();
            $this->output('administrador/default_layout/abm.php', $output);
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }*/
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