<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class presupuesto_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    /*
    GET
    */
    function get_presupuesto_by_id($id)
    {
        $this->db->select('*');
        $this->db->where('id = "'.$id.'"');
        $query=$this->db->get('presupuestos');
        return $query->row_array();
    }
    
    /*
    Guardar articulo de un presupuesto
    */
    function guardar_art_presupuesto($dbdata)
    {
        return $this->db->insert('presupuestos', $dbdata);
    }
    
    function get_articulo_presupuesto($presupuesto_nro, $codfenix)
    {
        $this->db->select('*');
        $this->db->where('presupuesto_nro = "' . $presupuesto_nro . '" AND codfenix = "'. $codfenix .'"' );
        $query=$this->db->get('presupuestos');
        return $query->row_array();
    }

    function updateArtPresupuesto($art , $cantidad) {
        $sql = "UPDATE presupuestos SET cantidad = cantidad + $cantidad WHERE presupuesto_nro = 0 AND codfenix = '$art'";
        if (mysql_query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /*
        Guardar el presupuesto asignando numeración
    */
    function guardar_presupuesto($sucursal, $user_id, $data_presupuesto)
    {
        $this->load->model('numeracion_model');
        $this->load->model('sucursal_model');
        
        $punto_vta = $this->sucursal_model->get_punto_vta($sucursal);
        $numeracion = $this->numeracion_model->get_secuencia(99, $punto_vta);
        $presupuesto_nro = $numeracion['secuencia'];
        /*
        $this->db->where("cliente_id = $cliente "
                . "AND sucursal = $sucursal "
                . "AND presupuesto_nro = 0");
        */
        $this->db->where("presupuesto_nro = 0 AND user_id = $user_id");
        $data_presupuesto['presupuesto_nro'] = $presupuesto_nro;
        $update = $this->db->update('presupuestos', $data_presupuesto);
        /*
        $update = $this->db->update('presupuestos',
                    array(
                        'presupuesto_nro' => $presupuesto_nro,
                        'condicion_venta_id' => $cond_venta,
                        'cliente_id' => $cliente,
                        'sucursal' => $sucursal
                    )
                );
        */
        if ($update) {
            $this->numeracion_model->set_secuencia(99, $punto_vta, ($presupuesto_nro + 1));
            return $presupuesto_nro;
        } else {
            return -1;
        }
    }
    
    function get_totales_presupuesto($presupuesto_nro, $user_id) {
        
        $sql = "SELECT SUM(precio * cantidad) AS importe_total,"
                . " COUNT(*) AS items "
                . "FROM presupuestos "
                . "WHERE presupuesto_nro = $presupuesto_nro "
                //. "AND cliente_id = $cliente";
                . "AND user_id = $user_id";
        $res = mysqli_query($link, $sql);
        $importe_total = 0;
        $items = 0;
        $totales = array();
        while($row = mysql_fetch_array($res)) {
           $importe_total = $row['importe_total'];
           $items = $row['items'];
        }
        $totales['importe'] = $importe_total;
        $totales['items'] = $items;
        
        return $totales;
    }

    function limpiarPresupuesto($presupuesto_nro, $user_id) {
        $sql = "DELETE FROM presupuestos WHERE presupuesto_nro = $presupuesto_nro AND user_id = $user_id";
        if(mysql_query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteArtPresupuesto($presupuesto_nro, $user_id, $art) {
        $sql = "DELETE FROM presupuestos 
        WHERE presupuesto_nro = $presupuesto_nro
        AND user_id = $user_id 
        AND codfenix = '$art'";
        if(mysql_query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    
    function get_listado_presupuesto() {
        $query = $this->db->query("SELECT   
                    cliente_id,
                    c.`razon_social`,
                    presupuesto_nro, 
                    DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,
                    sucursal,
                    COUNT(*) AS items,
                    SUM(precio * cantidad) AS importe,
                     motor,
                    chasis,
                    s.nombre AS compania,
                    pt.nombre AS  perito,
                    m.`nombre` AS modelo,
                    p.patente,
                    siniestro,
                    observaciones,
                    fechafac
                FROM presupuestos p
                LEFT JOIN clientes c ON c.`id`  = p.`cliente_id`
                LEFT JOIN companias s ON s.`id`  = p.`compania_id`
                LEFT JOIN peritos pt ON pt.`id`  = p.`perito_id`
                LEFT JOIN modelos m ON m.`id`  = p.`modelo_id`
                WHERE presupuesto_nro <> 0 

                GROUP BY presupuesto_nro
                ORDER BY presupuesto_nro DESC");
        return $query->result();
    }
    
    function get_listado_presupuesto_by_cliente($cliente_id) {
        $query = $this->db->query("SELECT   
                    cliente_id,
                    c.`razon_social`,
                    presupuesto_nro, 
                    DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,
                    sucursal,
                    s.nombre AS compania,
                    pt.nombre AS  perito,
                    m.`nombre` AS modelo,
                    p.patente,
                    siniestro,
                    p.`compania_id` as compania_id,
                    p.`perito_id` as perito_id,
                    p.`modelo_id` as modelo_id,
                    COUNT(*) AS items,
                    SUM(precio * cantidad) AS importe,
                    fechafac
                FROM presupuestos p
                LEFT JOIN clientes c ON c.`id`  = p.`cliente_id`
                LEFT JOIN companias s ON s.`id`  = p.`compania_id`
                LEFT JOIN peritos pt ON pt.`id`  = p.`perito_id`
                LEFT JOIN modelos m ON m.`id`  = p.`modelo_id`
                WHERE presupuesto_nro <> 0 AND cliente_id = $cliente_id
                GROUP BY presupuesto_nro
                ORDER BY presupuesto_nro DESC");
        return $query->result();
    }
    
    function get_presupuesto_by_nro($presupuesto_nro) {
        $query = $this->db->query("SELECT   
                    cliente_id,
                    c.`razon_social`,
                    c.`domicilio`,
                    c.`cuit` as doc_nro,
                    presupuesto_nro, 
                    DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,
                    fecha as fecha_presupuesto,
                    concepto,
                    sucursal,
                    condicion_venta_id,
                    COUNT(*) AS items,
                    SUM(precio * cantidad) AS importe,
                    motor,
                    chasis,
                    s.nombre AS compania,
                    pt.nombre AS  perito,
                    m.`nombre` AS modelo,
                    siniestro,
                    p.`compania_id` as compania_id,
                    p.`perito_id` as perito_id,
                    p.`modelo_id` as modelo_id,
                    observaciones,
                    i.`doc_tipo` as doc_tipo,
                    tc.`descripcion` as tipo_cbte,
                    tc.`codigo` as codigo_cbte
                FROM presupuestos p
                LEFT JOIN clientes c ON c.`id`  = p.`cliente_id`
                LEFT JOIN companias s ON s.`id`  = p.`compania_id`
                LEFT JOIN peritos pt ON pt.`id`  = p.`perito_id`
                LEFT JOIN modelos m ON m.`id`  = p.`modelo_id`
                LEFT JOIN tipos_iva i ON i.`id`  = c.`iva_id`
                LEFT JOIN tipos_comprobantes tc ON tc.`codigo`  = i.`tipo_cbte_id`
                WHERE presupuesto_nro = $presupuesto_nro
                GROUP BY presupuesto_nro
                ORDER BY presupuesto_nro DESC");
        return $query->result();
    }
    
    function get_detalle_presupuesto($presupuesto_nro) {
        $query = $this->db->query("SELECT codfenix,
                    oem,
                    a.`descripcion`,
                    precio,
                    cantidad,
                    (precio * cantidad) as importe
                    FROM presupuestos
                    LEFT JOIN articulos a ON a.`codigo_fenix` = codfenix
                    WHERE presupuesto_nro = $presupuesto_nro");   
        return $query->result();
    }

    function get_detalle_presupuesto_by_user($presupuesto_nro, $user_id) {
        $query = $this->db->query("SELECT codfenix,
                    oem,
                    a.`descripcion`,
                    precio,
                    cantidad,
                    (precio * cantidad) as importe
                    FROM presupuestos
                    LEFT JOIN articulos a ON a.`codigo_fenix` = codfenix
                    WHERE presupuesto_nro = $presupuesto_nro
                    AND user_id = $user_id");   
        return $query->result();
    }
    
    function get_detalle_presupuesto_sin_facturar($presupuesto_nro) {
        $query = $this->db->query("SELECT codfenix,
                    oem,
                    a.`descripcion`,
                    precio,
                    cantidad,
                    (precio * cantidad) as importe
                    FROM presupuestos
                    LEFT JOIN articulos a ON a.`codigo_fenix` = codfenix
                    WHERE presupuesto_nro = $presupuesto_nro
                    AND fechafac IS NULL");   
        return $query->result();
    }
}
