<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class banco_model extends CI_Model {
    
   function __construct() {
        parent::__construct();
   }
    
   function get_banco_by_id($id) {
        $this->db->select('*');
        $this->db->where('id = "'.$id.'"');
        $query=$this->db->get('bancos');
        return $query->row_array();
   }

   function get_all_bancos() {
        $this->db->select('*');
        $query=$this->db->get('bancos');
        return $query->result_array();
   }
}
