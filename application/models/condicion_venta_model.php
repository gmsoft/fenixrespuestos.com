<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class condicion_venta_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }
    
   function get_condicion_by_id($id)
   {
        $this->db->select('*');
        $this->db->where('id = "'.$id.'"');
        $query=$this->db->get('condiciones_venta');
        return $query->row_array();
   }

   function get_all_condiciones_venta()
   {
        $this->db->select('*');
        $query=$this->db->get('condiciones_venta');
        return $query->result_array();
   }

}
