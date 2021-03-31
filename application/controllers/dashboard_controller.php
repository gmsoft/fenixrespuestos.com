<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class dashboard_controller extends CI_Controller {

    private $_guestProfile;

    public function __construct() {
        parent::__construct();
        $this->_guestProfile = $this->session->userdata('logged_in');		
    }

    public function index() {
        /*
         //Datos de usuario
        $user = $this->session->userdata('logged_in');
        $user_id = $user['guestData']['tbl_users_id'];
        $username = $user['username'];
        */
        
        /*
        $this->load->model('menu_model');
        $menu = $this->menu_model->get_full_menu();
        
        $data['sidebar'] = $menu;*/
        
        $this->load->view('administrador/dashboard/dashboard');
    }
}

?>