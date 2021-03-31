<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class country_controller extends CI_Controller {

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

    /*
    ABM de Provincias
    */
    public function abm_provincias()
    {
        if (!$this->session->userdata('logged_in')) {
                //user is already logged in
                redirect('ingresar');
        } else {
            try{
                $crud = new grocery_CRUD();
                $crud->set_theme('twitter-bootstrap');
                $crud->set_table('provincias');
                $crud->set_subject('Provincias');
                                       
                
                $output = $crud->render();
                $this->output($output);
            }catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }               
        }
    }

    /*
    ABM Departamentos
    */
    public function abm_departamentos()
    {
            if (!$this->session->userdata('logged_in')) {
                //user is already logged in
                redirect('ingresar');
            } else {
                try{
                    $crud = new grocery_CRUD();
                    $crud->set_theme('twitter-bootstrap');
                    $crud->set_table('departamentos');
                    $crud->set_subject('Departamentos');
                    
                    $crud->set_relation('provincia_id', 'provincias', 'nombre');                       
                    $crud->display_as('provincia_id','Provincia');
                    
                    $output = $crud->render();
                    $this->output($output);
                }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
                }               
            }
        }

    /*
    ABM Localidades
    */
    public function abm_localidades()
    {
        if (!$this->session->userdata('logged_in')) {
            //user is already logged in
            redirect('ingresar');
        } else {
            try{
                $crud = new grocery_CRUD();
                $crud->set_theme('twitter-bootstrap');
                $crud->set_table('localidades');
                $crud->set_subject('ABM Localidades');
                
                $crud->set_relation('departamento_id', 'departamentos', 'nombre');                       
                $crud->display_as('departamento_id','Departamento');

                $output = $crud->render();
                $this->output($output);
            }catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }               
        }
    }

    public function output($output = null)
	{
            $this->load->view('administrador/default_layout/abm.php', $output);
	}
}