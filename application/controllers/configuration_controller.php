<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class configuration_controller extends CI_Controller {

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
	public function manager_configuration()
	{
            if (!$this->session->userdata('logged_in')) {
                    //user is already logged in
                    redirect('ingresar');
            } else {
                try{
                    $crud = new grocery_CRUD();
                    $crud->set_theme('twitter-bootstrap');
                    $crud->set_table('settings');
                    $crud->set_subject('Configuración');
                    $crud->unset_add();
                    $crud->unset_delete();
                    $output = $crud->render();
                    $this->output($output);
		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}               
            }
        }
        
        public function modulos()
	{
            try{
                $crud = new grocery_CRUD();
                $crud->set_theme('twitter-bootstrap');
                $crud->set_table('modulos');
                $crud->set_subject('Módulos del sistema');
                //$crud->unset_add();
                $crud->unset_delete();
                $output = $crud->render();
                $this->output('administrador/default_layout/abm.php', $output);
            }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }               
        }
        
        public function menues()
	{
            try{
                $crud = new grocery_CRUD();
                $crud->set_theme('twitter-bootstrap');
                $crud->set_table('menues');
                $crud->set_subject('Menues del sistema');
                $crud->set_relation('modulo_id', 'modulos', 'nombre');                
                $crud->display_as('modulo_id', 'Módulo');                

                $crud->unset_delete();
                
                $output = $crud->render();
                $this->output('administrador/default_layout/abm.php', $output);
            }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }               
        }
        
        public function permisos()
	{
            try{
                $crud = new grocery_CRUD();
                $crud->set_theme('twitter-bootstrap');
                $crud->set_table('permisos');
                $crud->set_subject('Permisos');
                
                $crud->set_relation('user_id', 'users', 'username');
                $crud->set_relation('menu_id', 'menues', 'titulo');
                
                $crud->display_as('user_id', 'Usuario');
                $crud->display_as('menu_id', 'Menu');
                
                $crud->unset_edit();
                
                $output = $crud->render();
                $this->output('administrador/default_layout/abm.php', $output);
            }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }               
        }
        
       public function numeracion()
       {
            try{
                $crud = new grocery_CRUD();
                $crud->set_theme('twitter-bootstrap');
                $crud->set_table('numeracion');
                $crud->set_subject('Numeración');
                
             

                $crud->unset_delete();
                //$crud->unset_edit();
                
                $output = $crud->render();
                $this->output('administrador/default_layout/abm.php', $output);
            }catch(Exception $e){
                    show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }               
        }

        public function backup_database() {
            
            //$this->do_backup_database();
            $this->load->view('config/backup.php');
        }

        public function do_backup_database() {
            $host = "localhost";
            $port = "3307";
            $user = 'root';
            $data_base = "fenix_base";
            $bkupfilename = 'D:\mysql_daily_backups\\' . $data_base .'_'. date('Y-m-d_his') . '.sql';
            $bkupfilename_zip = 'D:\mysql_daily_backups\\' . $data_base .'_'. date('Y-m-d_his') . '.zip';


            exec('D:\xampp\mysql\bin\mysqldump  --routines --host ' . $host . ' --port ' . $port . ' -u ' . $user . '  ' . $data_base  .' > '. $bkupfilename);

            $zip = new ZipArchive();

            
/*
            if(file_exists($_SERVER['DOCUMENT_ROOT']."/TEST/".$DelFilePath)) {

                    unlink ($_SERVER['DOCUMENT_ROOT']."/TEST/".$DelFilePath); 

            }*/
            if ($zip->open($bkupfilename_zip, ZIPARCHIVE::CREATE) != TRUE) {
                    die ("Could not open archive");
            }
            $zip->addFile($bkupfilename,"file_name");

            // close and save archive
            $zip->close(); 
            unlink($bkupfilename);
            //die;
            //echo shell_exec('mysqldump  --routines --host ' . $host . ' --port ' . $port . ' -u ' . $user . '  ' . $data_base . ' > D:\mysql_daily_backups\\' . $bkupfilename );
            //redirect('/', 'refresh');
            echo "Backup de la base de datos OK";
        }

         
        public function output($view, $output = null) {
            $this->load->view($view, $output);
        }
}