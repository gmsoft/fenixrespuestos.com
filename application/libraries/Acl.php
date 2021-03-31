<?php
/**
 * Permisos de Usuarios
 */
class Acl
{
	public $user = ''; 
	public $module = '';
	public $ci;

	function __construct ($config=array()) {
		$this->ci = &get_instance();
  		$this->user =  $config['user'];
		$this->module =  $config['module'];
	}

	public function tiene_permiso() 	{
		return true;
	}

	function getRol($user_id) {

        $strSQL = "SELECT role_id FROM `".DB_PREFIX."permissions` WHERE `ID` = " . floatval($permID) . " LIMIT 1";

        $this->ci->db->select('users_permisos');

        $this->ci->db->where('user_id',floatval($permID));

        $sql = $this->ci->db->get('perm_data',1);

        $data = $sql->result();

        return $data[0]->permKey;

    }
}
