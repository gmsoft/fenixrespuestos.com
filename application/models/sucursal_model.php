<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sucursal_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    function get_punto_vta($sucursal) {
        $this->db->select('punto_vta');
        $this->db->where("id = $sucursal");
        $query=$this->db->get('sucursales');
        $row =  $query->row_array();
        return $row['punto_vta'];
    }
    
}
