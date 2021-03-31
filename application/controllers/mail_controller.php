<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mail_controller extends CI_Controller {

	 public function __construct() {
        parent::__construct();
     }

	public function sendMail($debug=false)
	{
		//cargamos la libreria email de ci
		$this->load->library("email");

		$para = $this->input->get('para');
		$asunto = $this->input->get('asunto');
		$mensaje = $this->input->get('mensaje');
 
		//configuracion para gmail
		
		$configGmail = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'info.gmsoft',
			'smtp_pass' => '123Gm789',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		);
		
		
		//cargamos la configuración para enviar con gmail
		$this->email->initialize($configGmail);
 
		$this->email->from('postmaster@mail.comprobantes365.com','Fenix SRL');
		$this->email->to($para);
		$this->email->subject('[Fenix SRL]' . $asunto);
		$this->email->message($mensaje);
		
		if ($debug) {
			var_dump($this->email->print_debugger());
		}

		if (!$this->email->send())
		{
			echo "Error al enviar mail";
		} else {
			echo "OK";
		}
		//con esto podemos ver el resultado
		//var_dump($this->email->print_debugger());
		//redirect('administrador/listado_facturas');
	}

}