<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cobranza_model extends CI_Model {
    
  function __construct(){
        parent::__construct();
  }  
   
  function cargar_cobranza($dbdata)
  {
      if ($this->db->insert('cobranzas', $dbdata)) {
          
          return true;
      } else {
          return false;
      }
  }

}
