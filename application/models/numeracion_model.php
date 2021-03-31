<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class numeracion_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }
    
    function get_secuencia($cbte_tipo, $pto_vta) {
        $this->db->select('secuencia');
        $this->db->where("cbte_tipo = '$cbte_tipo' AND pto_vta = '$pto_vta'");
        $query=$this->db->get('numeracion');
        return $query->row_array();
    }
    
    public function set_secuencia($cbte_tipo, $pto_vta, $secuencia)
    {
        $this->db->where("cbte_tipo = '$cbte_tipo' AND pto_vta = '$pto_vta'");
        return $this->db->update('numeracion', array('secuencia'=>$secuencia));
    }

    function get_cbte_nombre($cbte_tipo, $pto_vta) {
        $this->db->select('cbte_nombre,cbte_clase');
        $this->db->where("cbte_tipo = '$cbte_tipo' AND pto_vta = '$pto_vta'");
        $query=$this->db->get('numeracion');
        return $query->row_array();
    }

}
