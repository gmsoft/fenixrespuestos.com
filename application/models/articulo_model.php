<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class articulo_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    /*
    GET
    */
    
    function get_articulo_by_id($id)
    {
        $this->db->select('*');
        $this->db->where("id = '" . $id . "'");
        $query=$this->db->get('articulos');
        return $query->row_array();
    }

    function get_articulo_individual_by_codigo_oem($codigo_oem)
    {
        $this->db->select('*');
        $this->db->where('codigo_oem = "' . $codigo_oem . '"');
        $query=$this->db->get('articulos');
        return $query->row_array();
    }
    
    function get_articulo_by_codigo_fenix($codigo_fenix, $like = true)
    {
        $codigo_fenix = str_replace('*', '%', $codigo_fenix);
        //$this->db->select('*');

        $sql  = "SELECT * FROM articulos WHERE ";
        
        $where = '';
        if ($like) {
            //$this->db->where('codigo_fenix LIKE "%' . $codigo_fenix . '%"');
            $where = "codigo_fenix LIKE '%$codigo_fenix%'";
        } else {
            $where = "codigo_fenix = '$codigo_fenix'";
            //$this->db->where($where);
        }  

        $sql = $sql . $where;

        //die($sql);

        $query = $this->db->query($sql);
        
        if ($like) {
            return $query->result_array();
        } else {
            return $query->row_array();
        }
        
        
    }
    
    function get_articulo_by_codigo_oem($codigo_oem)
    {
        $codigo_oem = str_replace('*', '%', $codigo_oem);
        $this->db->select('*');
        $this->db->where('codigo_oem LIKE "%' . $codigo_oem . '%"');
        $query=$this->db->get('articulos');
        return $query->result_array();
    }
    
    function get_articulo_by_descripcion($descripcion)
    {
        $descripcion = str_replace('*', '%', $descripcion);
        $this->db->select('*');
        $this->db->where('descripcion LIKE "%' . $descripcion . '%"');
        $query=$this->db->get('articulos');
        return $query->row_array();
    }
    
    function get_all_articulo_by_descripcion($descripcion)
    {
        $descripcion = str_replace('*', '%', $descripcion);
        $this->db->select('*');
        $this->db->where("descripcion LIKE '%" . $descripcion . "%'");
        if ($descripcion == '')
            $query = $this->db->get('articulos',100);
        else
            $query = $this->db->get('articulos');
        return $query->result_array();
    }

    function get_all_articulo_by_proveedor($proveedor)
    {
        //$descripcion = str_replace('*', '%', $descripcion);
        $this->db->select('*');
        $this->db->where("proveedor_testigo = '" . $proveedor . "'");
        
        $query = $this->db->get('articulos');
            
        return $query->result_array();
    }
    
    function get_stock_articulo($codigo_fenix, $sucursal)
    {
        $this->db->select('*');
        $this->db->where("articulo_fenix = '$codigo_fenix' AND sucursal_id = $sucursal");
        $query = $this->db->get('stock');
        $row_stock = $query->row_array();
        
        if (count($row_stock) === 0) {
            return 0;
        } else {
         return ($row_stock['cantidad'] * 1);
        }
    }
    
    

    

}
?>
