<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class state_controller extends CI_Controller {

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

	/**
         *   ABM Country
	*/
	public function manager_state()
	{
            if (!$this->session->userdata('logged_in')) {
                    //user is already logged in
                    redirect('ingresar');
            } else {
                try{
                    $crud = new grocery_CRUD();
                    $crud->set_theme('twitter-bootstrap');
                    $crud->set_table('state');
                    $crud->set_subject('State');
                   
                    /**/                   
                    $crud->fields('State_name', 'Country_idCountry');
                    $crud->columns('State_name', 'Country_idCountry');
                    $crud->required_fields('State_name', 'Country_idCountry');
                    
                    $crud->display_as('State_name', 'Estados');
                    $crud->display_as('Country_idCountry', 'País');
                    
                    $crud->set_relation(
                        'Country_idCountry',
                        'country',
                        'Country_name'
                    );
                    
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