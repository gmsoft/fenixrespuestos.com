<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class iva_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    /*
    GET
    */
    
    function get_tipo_iva($id)
    {
        $this->db->select('*');
        $this->db->where('id = "' . $id . '"');
        $query=$this->db->get('tipos_iva');
        return $query->row_array();
    }

}
?>