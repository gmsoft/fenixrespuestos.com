<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class comprobante_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }
        
    function get_comprobante_by_id($id)
    {
        $this->db->select('*');
        $this->db->where('id = "'.$id.'"');
        $query=$this->db->get('clientes');
        return $query->row_array();
    }
    
    function anular_comprobante($cbte_nro, $cbte_tipo, $punto_vta, $dbdata)
    {
        $this->db->where('comprobante_nro = ' . $cbte_nro . ' AND tipo_cbte = ' . $cbte_tipo . ' AND punto_vta = ' 
            . $punto_vta );
        return $this->db->update('comprobantes', $dbdata);
    }

    function get_comprobante_cabecera($comprobante_nro, $tipo_cbte, $punto_vta)
    {
        $query = $this->db->query("SELECT a.id, 
                                    sucursal, 
                                    s.nombre as nombre_sucursal,
                                    comprobante_nro,
                                    c.razon_social,
                                    DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,
                                    cliente_id,
                                    doc_tipo,
                                    doc_nro,
                                    observaciones,
                                    user_factura,
                                    tipo_cbte,
                                    t.descripcion as tipo_cbte_descripcion,
                                    concepto,
                                    importe_total,
                                    importe_neto,
                                    importe_iva,
                                    importe_excento,
                                    a.punto_vta,
                                    a.condicion_venta_id
                                    FROM comprobantes a
                                    INNER JOIN clientes c ON c.id = a.`cliente_id`
                                    INNER JOIN tipos_comprobantes t ON t.codigo = a.`tipo_cbte`
                                    INNER JOIN sucursales s ON s.id = a.`sucursal`
                                    WHERE comprobante_nro = $comprobante_nro
                                    AND tipo_cbte = $tipo_cbte
                                    AND a.punto_vta = $punto_vta");
        return $query->result();

    }

    function get_comprobante_detalle($comprobante_nro, $tipo_cbte, $punto_vta)
    {
        $query = $this->db->query("SELECT codigo_articulo,
                    oem,
                    a.`descripcion`,
                    precio,
                    cantidad,
                    (precio * cantidad) as importe
                    FROM comprobantes_detalle
                    LEFT JOIN articulos a ON a.`codigo_fenix` = codigo_articulo
                    WHERE comprobante_nro = $comprobante_nro
                    AND tipo_cbte = $tipo_cbte
                    AND punto_vta = $punto_vta");
        return $query->result();
    }


}
?>