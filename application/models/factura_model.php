<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class factura_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    
    /*
    Guardar factura de un presupuesto
    */
    function guardar_factura($dbdata)
    {
        $this->load->model('numeracion_model');

        //Obtiene la numeracion
        $tipo_cbte = $dbdata['tipo_cbte'];
        $punto_vta = $dbdata['punto_vta'];
        
        $numeracion = $this->numeracion_model->get_secuencia($tipo_cbte, $punto_vta);
        $factura_nro = $numeracion['secuencia'];
        $dbdata['comprobante_nro'] = $factura_nro;
        
        //Crea la cabecera de la factura
        if ($this->db->insert('comprobantes', $dbdata)) {
            //Actualiza la secuencia de numeracion
            $this->numeracion_model->set_secuencia($tipo_cbte, $punto_vta, ($factura_nro + 1));
            
            //Generar archivo para el WSFE
            //$this->generarArchivoWSFE($tipo_cbte, $factura_nro);
            
            return $factura_nro;
        } else {
            return -1; //Error
        }        
    }

    function generarArchivoWSFE($tipo_cbte, $factura_nro) {
        $file = fopen("./comprobantes/factura_" . $tipo_cbte . "_" . $factura_nro . ".txt", "w");
        fwrite($file, "@CABECERA" . PHP_EOL);
        fwrite($file, "@DETALLE" . PHP_EOL);
        fwrite($file, "@IVA" . PHP_EOL);
        fclose($file);
    }
    
    function guardar_factura_detalle($dbdata, $presupuesto)
    {
        $res = $this->db->insert('comprobantes_detalle', $dbdata);
        if ($res) {
             //Guadar fecha de facturacion indicando que el articulo esta facturado
            if ($presupuesto != null && $presupuesto != '' && $presupuesto != 0) {
                 $this->db->where("codfenix = '" . $dbdata['codigo_articulo']. "'"
                    . " AND presupuesto_nro = " . $presupuesto );
                $update = $this->db->update('presupuestos',
                    array('fecha'=>date('Y-m-d h:i:s'), 'fechafac'=>date('Y-m-d h:i:s')));
            }
        }
        return $res;
    }
    /*
        Guardar el presupuesto asignando numeración
    */
    function guardar_presupuesto($cliente, $sucursal)
    {
        $this->load->model('numeracion_model');
        
        $numeracion = $this->numeracion_model->get_secuencia('presupuestos');
        $presupuesto_nro = $numeracion['secuencia'];
        $this->db->where("cliente_id = $cliente "
                . "AND sucursal = $sucursal "
                . "AND presupuesto_nro = 0");
        $update = $this->db->update('presupuestos',
                array('presupuesto_nro'=>$presupuesto_nro));
        if ($update) {
            $this->numeracion_model->set_secuencia('presupuestos', ($presupuesto_nro + 1));
            return $presupuesto_nro;
        } else {
            return -1;
        }
    }
    
    function get_totales_presupuesto($presupuesto_nro, $cliente) {
        
        $sql = "SELECT SUM(precio * cantidad) AS importe_total,"
                . " COUNT(*) AS items "
                . "FROM presupuestos "
                . "WHERE presupuesto_nro = $presupuesto_nro "
                . "AND cliente_id = $cliente";
        $res = mysqli_query($link, $sql);
        $importe_total = 0;
        $items = 0;
        $totales = array();
        while($row = mysqli_fetch_array($res)) {
           $importe_total = $row['importe_total'];
           $items = $row['items'];
        }
        $totales['importe'] = $importe_total;
        $totales['items'] = $items;
        
        return $totales;
    }
    
    function get_listado_facturas() {
        $query = $this->db->query("SELECT   
                    cliente_id,
                    c.`razon_social`,
                    c.`email`,
					c.`cuit`,
                    comprobante_nro, 
                    DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,
                    sucursal,
                    COUNT(*) AS items,
                    observaciones,
                    tipo_cbte,
                    tc.descripcion as tipo_cbte_descripcion,
                    importe_total,
                    importe_neto,
                    importe_iva,
                    cae_afip,
                    fecha_vto_cae,
                    punto_vta
                FROM comprobantes p
                LEFT JOIN clientes c ON c.`id`  = p.`cliente_id`
                LEFT JOIN tipos_comprobantes tc ON tc.`codigo`  = p.`tipo_cbte`
                WHERE comprobante_nro <> 0 AND fecha_anulado IS NULL
                GROUP BY p.`fecha`
                ORDER BY p.`fecha` DESC");
        return $query->result();
    }

    function get_facturas_sin_autorizar() {
        $query = $this->db->query("SELECT   
                    cliente_id,
                    c.`razon_social`,
                    factura_nro, 
                    DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,
                    sucursal,
                    COUNT(*) AS items,
                    motor,
                    chasis,
                    s.nombre AS compania,
                    pt.nombre AS  perito,
                    m.`nombre` AS modelo,
                    siniestro,
                    cae_afip,
                    token_afip,
                    fecha_vto_cae,
                    observaciones
                FROM facturas p
                LEFT JOIN clientes c ON c.`id`  = p.`cliente_id`
                LEFT JOIN companias s ON s.`id`  = p.`compania_id`
                LEFT JOIN peritos pt ON pt.`id`  = p.`perito_id`
                LEFT JOIN modelos m ON m.`id`  = p.`modelo_id`
                WHERE factura_nro <> 0 
                AND cae_afip IS NULL
                GROUP BY factura_nro
                ORDER BY factura_nro ASC");
        return $query->result();
    }
    
    function get_listado_facturas_by_cliente($cliente_id) {
        $query = $this->db->query("SELECT   
                    cliente_id,
                    c.`razon_social`,
                    c.`email`,
					c.`cuit`,
                    comprobante_nro, 
                    DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,
                    sucursal,
                    COUNT(*) AS items,
                    tipo_cbte,
                    tc.descripcion as tipo_cbte_descripcion,
                    importe_total,
                    importe_neto,
                    importe_iva,
                    cae_afip,
                    fecha_vto_cae,
                    punto_vta,
                    observaciones                    
                FROM comprobantes p
                LEFT JOIN clientes c ON c.`id`  = p.`cliente_id`
                LEFT JOIN tipos_comprobantes tc ON tc.`codigo`  = p.`tipo_cbte`
                WHERE comprobante_nro <> 0 AND cliente_id = $cliente_id AND fecha_anulado IS NULL
                GROUP BY p.`fecha`
                ORDER BY p.`fecha` DESC");
        return $query->result();
    }
    
    function get_factura_by_nro($comprobante_nro, $cbte_tipo, $punto_vta) {
        $query = $this->db->query("SELECT   
                    cliente_id,
                    c.`razon_social`,
                    c.`cuit`,
                    comprobante_nro, 
                    DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,
                    sucursal,
                    COUNT(*) AS items,
                    observaciones,
                    tipo_cbte,
                    concepto,
                    importe_total,
                    importe_neto,
                    importe_iva,
                    cae_afip,
                    fecha_vto_cae,
                    punto_vta,
                    ti.`doc_tipo`,
                    moneda,
                    cotizacion,
                    cv.nombre as condicion_venta
                FROM comprobantes p
                LEFT JOIN clientes c ON c.`id`  = p.`cliente_id`
                LEFT JOIN tipos_iva ti ON ti.`id`  = c.`iva_id`
                LEFT JOIN condiciones_venta cv ON cv.`id`  = p.`condicion_venta_id`
                WHERE comprobante_nro = $comprobante_nro
                AND tipo_cbte = $cbte_tipo
                AND punto_vta = $punto_vta
                GROUP BY comprobante_nro
                ORDER BY comprobante_nro DESC");
        return $query->result();
    }

    /*
        obtiene los datos de un comprobante para autorizar en AFIP con el WSFE
    */
    function get_comprobante_wsfe($comprobante_nro, $cbte_tipo, $punto_vta) {
        $query = $this->db->query("SELECT   
                    cliente_id,
                    c.`razon_social`,
                    c.`cuit`,
                    comprobante_nro, 
                    DATE_FORMAT(fecha,'%Y%m%d') AS fecha,
                    sucursal,
                    COUNT(*) AS items,
                    observaciones,
                    tipo_cbte,
                    concepto,
                    importe_total,
                    importe_neto,
                    importe_iva,
                    cae_afip,
                    fecha_vto_cae,
                    punto_vta,
                    ti.`doc_tipo`,
                    moneda,
                    cotizacion
                FROM comprobantes p
                LEFT JOIN clientes c ON c.`id`  = p.`cliente_id`
                LEFT JOIN tipos_iva ti ON ti.`id`  = c.`iva_id`
                WHERE comprobante_nro = $comprobante_nro
                AND tipo_cbte = $cbte_tipo
                AND punto_vta = $punto_vta
                GROUP BY comprobante_nro
                ORDER BY comprobante_nro DESC");
        return $query->result();
    }

    function guardarCAE($comprobante_nro, $cbte_tipo, $punto_vta, $cae, $fecha_vto_cae) {
        $this->db->where("comprobante_nro = $comprobante_nro "
                . "AND tipo_cbte = $cbte_tipo "
                . "AND punto_vta = $punto_vta");
        $update = $this->db->update('comprobantes',
                array('cae_afip'=>$cae, 'fecha_vto_cae'=>$fecha_vto_cae));

        if ($update) {
            return true;
        } else {
            return false;
        }
    }
    
    function get_detalle_factura($comprobante_nro, $cbte_tipo, $punto_vta) {
        $query = $this->db->query("SELECT
                    codigo_articulo,
                    oem,
                    a.`descripcion`,
                    precio,
                    cantidad,
                    (precio * cantidad) as importe
                    FROM comprobantes_detalle
                    LEFT JOIN articulos a ON a.`codigo_fenix` = codigo_articulo
                    WHERE comprobante_nro = $comprobante_nro
                    AND tipo_cbte = $cbte_tipo
                    AND punto_vta = $punto_vta");   
        return $query->result();
    }
}
