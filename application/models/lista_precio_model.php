<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lista_precio_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
        
    function get_articulo_by_id($id, $lista = 'lista_vw')
    {
        $this->db->select('*');
        $this->db->where('id = "'.$id.'"');
        $query=$this->db->get($lista);
        return $query->row_array();
    }
    
    function get_articulo_by_interno($campo_interno, $interno, $lista = 'lista_vw')
    {
        $interno = str_replace('*', '%', $interno);
        $this->db->select('*');
        $this->db->where($campo_interno . ' LIKE "%' . $interno . '%"');
        $query = $this->db->get($lista);
        return $query->result_array();
    }

    function get_articulo_by_original($codigo_oem, $lista = 'lista_vw')
    {
        $codigo_oem = str_replace('*', '%', $codigo_oem);
        $codigo_oem = str_replace('-  -', '-%-', $codigo_oem);
        $codigo_oem = str_replace('  -', '%-', $codigo_oem);
        $codigo_oem = str_replace(' -', '%-', $codigo_oem);
        //die($codigo_oem);
        $this->db->select('*');
        $this->db->where('original LIKE "%' . $codigo_oem . '%"');
        $query=$this->db->get($lista);
        return $query->result_array();
    }
    
    function get_articulo_by_descripcion($descripcion, $lista = 'lista_vw')
    {
        $descripcion = str_replace('*', '%', $descripcion);
        $this->db->select('*');
        $this->db->where('descripcion LIKE "%' . $descripcion . '%"');
        $query=$this->db->get($lista);
        return $query->row_array();
    }
    
    function get_all_articulo_by_descripcion($descripcion, $lista = 'lista_vw')
    {
        $descripcion = str_replace('*', '%', $descripcion);
        $this->db->select('*');
        $this->db->where('descripcion LIKE "%' . $descripcion . '%"');
        if($descripcion=='')
            $query=$this->db->get($lista,100);
        else
            $query=$this->db->get($lista);
        return $query->result_array();
    }    
  	
}
?>