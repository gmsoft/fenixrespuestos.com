<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class marca_controller extends CI_Controller {

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
     * Abm Marcas
     */
    public function abm_marcas() 
    {
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('marcas');
            $crud->set_subject('Marcas');    
            
            $output = $crud->render();
            $this->output('administrador/default_layout/abm.php', $output);
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }
    }
    
    public function abm_modelos() 
    {
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('modelos');
            $crud->set_subject('Modelos');

            $crud->set_relation('marca_id', 'marcas', 'nombre');
            $crud->display_as('marca_id', 'Marca');


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