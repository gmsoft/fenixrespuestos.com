<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ctacte_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    function get_ctacte_cliente($cliente_id)
    {
        $query = $this->db->query("SELECT   
                    cliente_id,
                    DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_movimiento,
                    tipo_cbte,
                    comprobante_nro,
                    punto_vta,
                    tc.descripcion as tipo_cbte_descripcion,
                    debito,
                    credito,
                    saldo,
                    concepto
                FROM cuentas_corrientes p
                LEFT JOIN tipos_comprobantes tc ON tc.`codigo`  = p.`tipo_cbte`
                WHERE comprobante_nro <> 0 AND cliente_id = $cliente_id
                ORDER BY fecha ASC");
        return $query->result_array();

    } 

    function get_ctacte_cliente_old($cliente_id)
    {
        
        $query = $this->db->query("SELECT   
                    cliente_id,
                    c.`razon_social`,
                    c.`email`,
                    comprobante_nro, 
                    DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_cbte,
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
                    punto_vta,
                    condicion_venta_id,
                    cv.`nombre` as condicion_venta
                FROM comprobantes p
                LEFT JOIN clientes c ON c.`id`  = p.`cliente_id`
                LEFT JOIN tipos_comprobantes tc ON tc.`codigo`  = p.`tipo_cbte`
                LEFT JOIN condiciones_venta cv ON cv.`id`  = p.`condicion_venta_id`
                WHERE comprobante_nro <> 0 AND cliente_id = $cliente_id
                GROUP BY comprobante_nro, tipo_cbte
                ORDER BY fecha DESC, comprobante_nro DESC");
        $comprobates = $query->result_array();

        $cta_cte = array();

        $c = 0;
        foreach ($comprobates as $key => $value) {
            
            $comprobante_nro = str_pad($value['punto_vta'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($value['comprobante_nro'], 8, "0", STR_PAD_LEFT);

            $cta_cte[$c]['tipo_cbte_descripcion'] = $value['tipo_cbte_descripcion'];
            $cta_cte[$c]['condicion_venta'] = $value['condicion_venta'];
            $cta_cte[$c]['comprobante_nro'] = $comprobante_nro;
            $cta_cte[$c]['cbte_nro'] = $value['comprobante_nro'];
            $cta_cte[$c]['fecha'] = $value['fecha_cbte'];
            $cta_cte[$c]['importe_total'] = $value['importe_total'];
            $cta_cte[$c]['punto_vta'] = $value['punto_vta'];
            $cta_cte[$c]['tipo_cbte'] = $value['tipo_cbte'];
            
            //Cobranzas
            $query_cobranzas = $this->db->query("SELECT id,
                    DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha,
                    comprobante_nro,
                    cbte_tipo,
                    importe 
                    FROM cobranzas
                    WHERE comprobante_nro  =" . $value["comprobante_nro"] 
                    . " AND cbte_tipo =" . $value["tipo_cbte"]
                    . " AND punto_vta =" . $value["punto_vta"]
                    . " AND cond_venta_id <> 2" );//Que no sean cta/cta
            $cobranzas = $query_cobranzas->result_array();
            $j = 0;
            $cobranza_detalle = array();
            foreach ($cobranzas as $keyCobranza => $valueCobranza) {
                
                $cobranza_detalle[$j]['tipo_cbte_descripcion'] = 'Recibo';
                $cobranza_detalle[$j]['comprobante_nro'] = str_pad($valueCobranza['id'], 8, "0", STR_PAD_LEFT);;
                $cobranza_detalle[$j]['fecha'] = $valueCobranza['fecha'];
                $cobranza_detalle[$j]['importe'] = $valueCobranza['importe'];
                $j++;
            }

            $cta_cte[$c]['cobranzas'] = $cobranza_detalle;

            $c++;
        }
        
        return $cta_cte;
    }
}
?>