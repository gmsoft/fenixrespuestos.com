<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rol_controller extends CI_Controller {

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
         *   ABM categorias
	*/
	public function manager_rol()
	{
            if (!$this->session->userdata('logged_in')) {
                    //user is already logged in
                    redirect('ingresar');
            } else {
                try{
                    $crud = new grocery_CRUD();
                    $crud->set_theme('twitter-bootstrap');
                    $crud->set_table('role');
                    $crud->set_subject('Roles');
                    
                    /**/                   
                    $crud->fields('User_idUser', 'Role_Type');
                    $crud->columns('User_idUser', 'Role_Type');
                    $crud->required_fields('User_idUser', 'Role_Type');
                    
                    $crud->set_relation(
                        'User_idUser',
                        'users',
                        'username'
                    );
                    $crud->display_as('User_idUser', 'Usuario');
                    $crud->display_as('Role_Type', 'Rol');
                   
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