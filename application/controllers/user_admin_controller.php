<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_admin_controller extends CI_Controller {

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
    public function usuarios() 
    {
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('users');
            $crud->set_subject('Usuarios');           
            $crud->columns('username', 'email', 'firstname', 'lastname', 'telefono');
            $crud->fields('username', 'password', 'email','firstname','lastname','telefono');
            //$crud->where('idUser !=', 1);
            
            //$crud->columns('username', 'email', 'firstname' , 'lastname', 'dateofbirth', 'address', 'country', 'accountactive', 'userlvl');
            //$crud->fields('username', 'email', 'firstname' , 'lastname', 'dateofbirth', 'address', 'country', 'phone');
            //$crud->required_fields('username', 'email', 'firstname' , 'lastname', 'dateofbirth', 'address', 'country');
            
            $crud->set_rules('email', 'Email', 'valid_email|required');
            
            /*
            $crud->set_relation(
                'country',
                'country',
                'Country_name'
            );*/
            
            
            $crud->display_as('username', 'Nombre de Usuario');
            $crud->display_as('email', 'Email');
            $crud->display_as('firstname', 'Nombre');
            $crud->display_as('lastname', 'Apellido');
            $crud->display_as('dateofbirth', 'Fecha de Nacimiento');
            $crud->display_as('address', 'Direccion');
            $crud->display_as('accountactive', 'Activo');
            $crud->display_as('phone', 'Telefono');
            
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
    
    /**
     * Cambia el input por defecto por uno limpio
     * @return string 
     */
    public function set_password_input_to_empty() 
    {
        return "<input type='password' name='password' value='' />";
    }
    
    /**
     * Accion de cambio de contraseña del usuario
     * @param int $id 
     */
    public function changePassword()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password', 'Contraseña', 'required');
        $this->form_validation->set_rules('repassword', 'Confirmar contraseña', 'required|matches[password]');
        $this->form_validation->set_message('required', 'El campo %s es requerido');
        $this->form_validation->set_message('matches', 'El campo %s debe ser igual que el valor de la contraseña');
        
        if ($this->input->post()) {
            
            $this->load->model('user');
            $paramPassword = $this->input->post('password');
            $paramUserId = $this->input->post('id');
            
            if ($this->user->changePassword($this->data, $paramUserId, $paramPassword) 
                && $this->form_validation->run()) {
                redirect('admin/usuarios/edit/' . $paramUserId);
            } else {
                $this->doChangePassword($paramUserId, true);
            }
        } else {
            $this->load->view('admin/header.php');
            $this->load->view('admin/dashboard/dashboard.php', $this->data);
            $this->load->view('change-password/index.php', array('id' => $this->uri->segment(3)));
            $this->load->view('admin/footer.php');
        }
    }
    
    /**
     * Cambia el input por un link a cambiar la contraseña
     * @return string 
     */
    public function change_input_to_button() 
    {
        return '<a href="' . site_url("admin/changepassword/" . $this->uri->segment(4)) . '" class="btn" type="button">Cambiar Contraseña</a>';
    }
}

?>