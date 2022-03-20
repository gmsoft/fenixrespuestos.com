<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    function get_menu_by_id($id)
    {
        $this->db->select('*');
        $this->db->where("id = '" . $id . "'");
        $query=$this->db->get('menues');
        return $query->row_array();
    }
    /*
     * Obtiene todos los menues activos de un modulo
     */
    function get_menues_by_modulo($modulo_id)
    {
        $this->db->select('*');
        $this->db->order_by('orden');
        $this->db->where('modulo_id = "' . $modulo_id . '" AND activo = 1');
        $query=$this->db->get('menues');
        return $query->result_array();
    }
    
    function get_all_menues()
    {
        $this->db->select('*');
        $query = $this->db->get('menues');
        return $query->result_array();
    }
    
    function tienePermiso($user_id, $menu_id) {
        $this->db->select('*');
        $this->db->where("user_id = '" . $user_id . "' AND menu_id = '" . $menu_id);
        $query = $this->db->get('permisos');
        if(count($query->result_array()) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function get_full_menu($user_id)
    {
        $menuHTML = '';
        $this->db->select('*');
        $this->db->order_by('orden');
        $query_modulos = $this->db->get('modulos');
        foreach($query_modulos->result_array() as $e) {
            $icono = $e['icono'];
            $nombre_modulo = $e['nombre'];
            
            $menuHTML .= '<li class="sub-menu">';
            $menuHTML .= '<a href="javascript:;" class="">';
            $menuHTML .= '<i class="' . $icono . '"></i>';
            $menuHTML .= '<span>' . $nombre_modulo .'</span>';
            $menuHTML .= '<span class="arrow"></span>';
            $menuHTML .= '</a>';
            //SubMenues
            $query_menues = $this->get_menues_by_modulo($e['id']);
            $menuHTML .= '<ul class="sub">';
            foreach($query_menues as $ee) {
                $titulo = $ee['titulo'];
                $action = $ee['action'];
                $controller = $ee['controller'];
                $menu_id = $ee['id'];
                //Verifica si tiene permiso
                // Si es el administrador pasa el control
                if (!$this->tienePermiso($user_id, $menu_id) && $user_id != 1) {
                    continue;
                }
            
                $menuHTML .= '<li>';
                $menuHTML .= '<a class="" href="' . site_url($action . '/' . $controller) . '">' . $titulo . '</a>';
                $menuHTML .= '</li>';
            }
            $menuHTML .= '</ul>';
            $menuHTML .= '</li>';
        }
        
        return $menuHTML;
    }
}
?>
