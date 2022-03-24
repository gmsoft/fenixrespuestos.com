<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class compra_controller extends CI_Controller {

    private $_guestProfile;

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            //user is already logged in
            redirect('ingresar');
        } else {
            $this->load->library('grocery_CRUD');
            $this->_guestProfile = $this->session->userdata('logged_in');
        }
    }

    public function orden_compra() {
        //$this->load->view('compras/orden_compra.php');
        $this->load->view('compras/menu_ocompra.php');
    }

    public function nueva_orden_compra() {
        $this->load->view('compras/orden_compra.php');
    }

    public function listado_orden_compra() {
        $this->load->view('compras/listado_ocompras.php');
    }

    public function recepcion() {
        $this->load->view('compras/recepcion_ocompras.php');
    }

    public function output($view, $output = null) {
        $this->load->view($view, $output);
    }

    public function facturas_compra() {
        $this->load->view('compras/facturas_compras.php');
    }

    public function listado_facturas_compra() {
        $this->load->view('compras/listado_facturas_compras.php');
    }

    public function buscarCosto() {

        $var = $_POST;
        $proveedor = $var['proveedor'];
        $codfenix = $var['codfenix'];
        $interno = $var['interno'];

        $items = array();
        $items['err'] = "0";
        $items['msg_err'] = "";
        $items['costo'] = 0;
        $items['dto1'] = 0;
        $items['dto2'] = 0;
        $items['dto3'] = 0;
        $items['rec1'] = 0;
        $items['codigofenix'] = 0;
        $items['utilidad'] = 0;
        $items['testigo'] = '';
        //Precio Lista
        $items['descripcion_lista'] = '';
        $items['precio_lista'] = 0;

        //TODO: Falta filtro por moneda
        $sql_costo = "SELECT codigo_fenix, costo, moneda, dto1, dto2, dto3, rec1, testigo, utilidad "
                . "FROM costos_proveedor "
                . "WHERE proveedor_id = $proveedor "
                . "AND codigo_fenix = '$codfenix' "
                . "AND interno_proveedor = '$interno'";
        $res_costo = mysql_query($link, $sql_costo);
        $contador_costo = 0;
        while ($row_costo = mysql_fetch_array($res_costo)) {
            $codigofenix = $row_costo['codigo_fenix'];
            $costo = $row_costo['costo'];
            $dto1 = $row_costo['dto1'];
            $dto2 = $row_costo['dto2'];
            $dto3 = $row_costo['dto3'];
            $rec1 = $row_costo['rec1'];
            $utilidad = $row_costo['utilidad'];
            $testigo = $row_costo['testigo'];

            $items['codigofenix'] = $codigofenix;
            $items['costo'] = $costo * 1;
            $items['dto1'] = $dto1 * 1;
            $items['dto2'] = $dto2 * 1;
            $items['dto3'] = $dto3 * 1;
            $items['rec1'] = $rec1 * 1;
            $items['testigo'] = $testigo;
            $items['utilidad'] = $utilidad * 1;
            $contador_costo ++;
        }

        if ($contador_costo == 0) {
            $items['err'] = "1";
            $items['msg_err'] = "No existen costos para este proveedor";
        }

        //Lee la lista del proveedor 
        $sql_lista = "SELECT nombre_tabla , columna_cod_interno FROM listas WHERE proveedor_id = $proveedor";
        $res_lista = mysql_query($link, $sql_lista);
        while ($row_lista = mysql_fetch_array($res_lista)) {
            $nombre_tabla = $row_lista['nombre_tabla'];
            $columna_cod_interno = $row_lista['columna_cod_interno'];

            //La tabla existe
            if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $nombre_tabla . "'")) == 1) {
                $sql_lista_prov = "SELECT descripcion, precio_lista, marca "
                        . "FROM $nombre_tabla "
                        . "WHERE $columna_cod_interno = '$interno'";
                $res_lista_prov = mysql_query($link, $sql_lista_prov);
                while ($row_lista_prov = mysql_fetch_array($res_lista_prov)) {
                    $descripcion_lista = $row_lista_prov['descripcion'];
                    $precio_lista = $row_lista_prov['precio_lista'];
                    $marca_lista = $row_lista_prov['marca'];

                    $items['descripcion_lista'] = $descripcion_lista;
                    $items['marca_lista'] = $marca_lista;
                    $items['precio_lista'] = $precio_lista * 1;
                }
            } else {
                //La tabla NO existe
                $items['descripcion_lista'] = 'ARTICULO NO CARGADO EN LISTA';
                $items['marca_lista'] = '';
                $items['precio_lista'] = '0';
            }
        }

        echo json_encode($items);
    }

    public function buscarArticuloCosto() {

        $var = $_POST;

        $codfenix = $var['codfenix'];
        $proveedor = $var['proveedor'];
        $sucursal = $var['sucursal'];

        //TODO: Falta filtro por moneda
        $sql_costo = "SELECT descripcion "
                . "FROM articulos "
                . "WHERE codigo_fenix = '$codfenix' ";

        $res_costo = mysql_query($link, $sql_costo);

        $items = array();
        $items['descripcion'] = "";
        $items['err'] = "0";
        $descripcion = '';
        while ($row_costo = mysql_fetch_array($res_costo)) {

            $descripcion = $row_costo['descripcion'];

            $items['descripcion'] = $descripcion;
        }

        if ($descripcion == '' || $codfenix == '') {
            $items['descripcion'] = 'Articulo Inexistente!';
            $items['err'] = "1";
        }

        //Busca en Costo Particular
        $sql_interno_costo = "SELECT codigo_fenix, interno_proveedor, costo, dto1,dto2,dto3,rec1,testigo, utilidad "
                . "FROM costos_proveedor "
                . "WHERE codigo_fenix = '$codfenix' AND proveedor_id = $proveedor";
        $res_interno_costo = mysql_query($link, $sql_interno_costo);

        while ($row_interno_costo = mysql_fetch_array($res_interno_costo)) {

            $codigo_fenix = $row_interno_costo['codigo_fenix'];
            $interno_proveedor = $row_interno_costo['interno_proveedor'];
            $dto1 = $row_interno_costo['dto1'];
            $dto2 = $row_interno_costo['dto2'];
            $dto3 = $row_interno_costo['dto3'];
            $rec1 = $row_interno_costo['rec1'];
            $costo = $row_interno_costo['costo'];
            $testigo = $row_interno_costo['testigo'];
            $utilidad = $row_interno_costo['utilidad'];

            $items['codigofenix'] = $codigo_fenix;
            $items['interno_proveedor'] = $interno_proveedor;
            $items['costo'] = $costo * 1;
            $items['dto1'] = $dto1 * 1;
            $items['dto2'] = $dto2 * 1;
            $items['dto3'] = $dto3 * 1;
            $items['rec1'] = $rec1 * 1;
            $items['testigo'] = $testigo;
            $items['utilidad'] = $utilidad;
        }

        //Busca cantidad pendiente de Orden de Compra
        $sql_ocompra = "select ocompra,costo,dto1,dto2,dto3,rec1,cantidadped, cantidadrec,DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha 
            FROM ocompras 
            WHERE proveedor_id = $proveedor
            AND codigo_fenix = '$codfenix' 
            AND cantidadped <> cantidadrec
            AND sucursal = $sucursal";
        $res_ocompra = mysql_query($link, $sql_ocompra);
        while ($row_ocompra = mysql_fetch_array($res_ocompra)) {
            $items['ocompra'] = $row_ocompra['ocompra'];
            $items['fecha_ocompra'] = $row_ocompra['fecha'];
            $items['costo'] = $row_ocompra['costo'];
            $items['cantidadped'] = $row_ocompra['cantidadped'];
            $items['cantidadrec'] = $row_ocompra['cantidadrec'];
        }

        echo json_encode($items);
    }

    /**
     * Guarda el Articulo de la orden de compra
     */
    public function guardarArtOCompra() {
        $var = $_POST;
        $proveedor = $var['proveedor'];
        $fecha = $var['fecha'];
        $arrayFecha = explode('/', $fecha);
        $fecha = $arrayFecha[2] . '-' . $arrayFecha[1] . '-' . $arrayFecha[0];
        $codfenix = $var['codfenix'];
        $interno = $var['interno'];
        $costo = $var['costo'];
        $cantidadped = $var['cantidadped'];
        $dto1 = $var['dto1'];
        $dto2 = $var['dto2'];
        $dto3 = $var['dto3'];
        $rec1 = $var['rec1'];
        $sucursal = $var['sucursal'];

        $descripcion_lista = $var['descripcion_lista'];
        //$marca_lista = $var['marca_lista'];
        //Si existe borra el articulo
        //Verifica que no tenga una orden de compra asignada
        $sql_delete = "DELETE FROM ocompras "
                . " WHERE ocompra = 0 "
                . "AND codigo_fenix = '$codfenix' "
                . "AND interno_proveedor = '$interno' "
                . "AND proveedor_id = $proveedor";
        $res_delete = mysql_query($link, $sql_delete);

        $items = array();

        $total_items = 0;
        $importe_total = 0;

        $sql = "INSERT INTO ocompras "
                . "("
                . " ocompra,"
                . " proveedor_id,"
                . " codigo_fenix,"
                . " interno_proveedor,"
                . " fecha,"
                . " costo,"
                . " cantidadped,"
                . " moneda,"
                . " dto1,"
                . " dto2,"
                . " dto3,"
                . " rec1,"
                . " descripcion,"
                . " sucursal"
                . " )VALUES("
                . "0,"
                . " '$proveedor',"
                . " '$codfenix',"
                . " '$interno',"
                . " '$fecha',"
                . " '$costo',"
                . " '$cantidadped',"
                . " 'PES' , "
                . " '$dto1',"
                . " '$dto2',"
                . " '$dto3',"
                . " '$rec1',"
                . " '$descripcion_lista',"
                . " '$sucursal'"
                . " )";
        $res = mysql_query($link, $sql);
        //die($sql);
        $strMensaje = '';
        if ($res) {
            //Cuenta cantidad de items e importe total
            $sql_totales = "select SUM((costo * (1-dto1/100) * (1-dto2/100) * (1-dto3/100)) * cantidadped) as importe_total
                        , COUNT(*) AS items
                        from ocompras 
                        where proveedor_id = $proveedor 
                        and ocompra = 0";
            $res_totales = mysql_query($link, $sql_totales);
            $row_totales = mysql_fetch_array($res_totales);

            $importe_total = number_format($row_totales['importe_total'], 2, '.', ',');
            $total_items = number_format($row_totales['items'], 0, '.', ',');

            $strMensaje .= "*** Nuevo articulo agregado a la orden ***";

            $items['importe_total'] = $importe_total;
            $items['items'] = $total_items;
            $items['mensaje'] = $strMensaje;

            echo json_encode($items);
        } else {
            $strMensaje .= 'ERROR: ' . $sql;

            $items['importe_total'] = $importe_total;
            $items['items'] = $total_items;
            $items['mensaje'] = $strMensaje;

            echo json_encode($items);
        }
    }

    /**
     * Genera la nueva orden de compra
     */
    public function guardarOCompra() {
        $var = $_POST;
        $proveedor = $var['proveedor'];
        $sucursal = $var['sucursal'];

        $items = array();
        $strMensaje = '';
        $err = 0;
        $importe_total = 0;
        $total_items = 0;
        $nueva_orden = 0;

        $sql = "SELECT MAX(ocompra) + 1 AS nueva_orden FROM ocompras";
        $res = mysql_query($link, $sql);
        $row = mysql_fetch_array($res);
        $nueva_orden = $row['nueva_orden'];

        if ($res) {

            //Genera la orden de Compra
            $sql_nuevaorden = "UPDATE ocompras SET ocompra = $nueva_orden "
                    . "WHERE proveedor_id = $proveedor AND sucursal = $sucursal AND ocompra = 0";
            $res_nuevaorden = mysql_query($link, $sql_nuevaorden);

            if ($res_nuevaorden) {
                $err = 0;
                $strMensaje .= "*** Orden de Compra Nro: $nueva_orden generada con exito ***";

                //Cuenta cantidad de items e importe total
                $sql_totales = "select SUM((costo * (1-dto1/100) * (1-dto2/100) * (1-dto3/100)) * cantidadped) as importe_total
                            , COUNT(*) AS items
                            from ocompras 
                            where proveedor_id = $proveedor 
                            and ocompra = $nueva_orden";
                $res_totales = mysql_query($link, $sql_totales);
                $row_totales = mysql_fetch_array($res_totales);

                $importe_total = number_format($row_totales['importe_total'], 2, '.', ',');
                $total_items = number_format($row_totales['items'], 0, '.', ',');
            } else {
                $err = 1;
                $strMensaje .= "*** ERROR al generar Orden de Compra Nro: $nueva_orden";
            }

            $items['err'] = $err;
            $items['nueva_orden'] = $nueva_orden;
            $items['mensaje'] = $strMensaje;
            $items['importe_total'] = $importe_total;
            $items['items'] = $total_items;

            echo json_encode($items);
        } else {
            $strMensaje .= 'ERROR al obtener numeración: ' . $sql;
            $err = 1;

            $items['err'] = $err;
            $items['nueva_orden'] = $nueva_orden;
            $items['mensaje'] = $strMensaje;
            $items['importe_total'] = $importe_total;
            $items['items'] = $total_items;

            echo json_encode($items);
        }
    }

    /**
     * Recepciona la cantidad e incorpora al Stock
     */
    public function recibirStock() {

        $var = $_POST;

        $items = array();
        $strMensaje = '';
        $err = 0;

        //ocompra:_ocompra, art: _art, cantped: _cantPed, cantrec: _cantRec, sucursal: _sucursal},
        $ocompra = $var['ocompra'];
        $art = $var['art'];
        $cantped = $var['cantped'] * 1;
        $cantrec = $var['cantrec'] * 1;
        $cantrec_oc = 0;
        $sucursal = $var['sucursal'];

        //Obtiene los datos de la orden de compra
        $sql_ocompra = "SELECT cantidadrec FROM"
                . " ocompras WHER codigo_fenix = '$art'"
                . " AND ocompra = $ocompra";
        $res_ocompra = mysql_query($link, $sql_ocompra);
        while ($row_ocompra = mysql_fetch_array($res_ocompra)) {
            $cantrec_oc = $row_ocompra['cantidadrec'] * 1;
        }

        $cantrec = $cantrec + $cantrec_oc;

        if ($cantrec > $cantped) {
            $strMensaje = 'La cantidad recibida no puede superar la cantidad pedida.<br>Cantidad Pedida:' . $cantped . ' Cantidad Recibida:' . $cantrec;
            $err = 1;
            $items['err'] = $err;
            $items['mensaje'] = $strMensaje;
            echo json_encode($items);
        } else {

            $sql_compras = "UPDATE ocompras "
                    . "SET cantidadrec = $cantrec, fecharec = NOW()"
                    . " WHERE ocompra = $ocompra"
                    . " AND codigo_fenix = '$art'"
                    . " AND sucursal = $sucursal";
            $res_compras = mysql_query($link, $sql_compras);
            if ($res_compras) {
                //Verifica Stock
                $sql_stk = "SELECT cantidad FROM stock WHERE articulo_fenix = '$art' AND sucursal_id = $sucursal";
                $res_stk = mysql_query($link, $sql_stk);
                $cantidad_stk = 0;
                $cantidad_stk_nueva = 0;
                $cont_stk = 0;
                while ($row_stk = mysql_fetch_array($res_stk)) {
                    $cantidad_stk = $row_stk['cantidad'];
                    $cont_stk++;
                }

                $cantidad_stk_nueva = $cantidad_stk + $cantrec;

                if ($cont_stk > 0) {
                    //El ariculo esta en stock, hay que actualizar la cantidad
                    $sql_update_stk = "UPDATE stock SET cantidad = $cantidad_stk_nueva"
                            . " WHERE articulo_fenix = '$art' AND sucursal_id = $sucursal";
                    $res_update_stk = mysql_query($link, $sql_update_stk);
                    if (!$res_update_stk) {
                        $strMensaje = 'Error al actualizar cantidad en stock';
                        $err = 1;
                    }
                } else {
                    //El articulo se carga por primera vez
                    $sql_insert_stk = "INSERT INTO stock (articulo_fenix, cantidad, sucursal_id)"
                            . "VALUES ('$art', $cantidad_stk_nueva, $sucursal)";
                    $res_insert_stk = mysql_query($link, $sql_insert_stk);
                    if (!$res_insert_stk) {
                        $strMensaje = 'Error al ingresar articulo al stock';
                        $err = 1;
                    }
                }
            } else {
                $strMensaje = 'Error al actualizar cantidad recibida en la orden de compra';
                $err = 1;
            }

            $items['err'] = $err;
            $items['mensaje'] = $strMensaje;
            echo json_encode($items);
        }
    }

    //
    ///FACTURA DE COMPRA

    //
    
    /**
     * Guarda el Articulo de la orden de compra
     */
    public function guardarArtFacCompra() {
        $var = $_POST;
        $proveedor = $var['proveedor'];
        $factura = strtoupper($var['factura']);
        $fecha = $var['fecha'];
        $arrayFecha = explode('/', $fecha);
        $fecha = $arrayFecha[2] . '-' . $arrayFecha[1] . '-' . $arrayFecha[0];
        $codfenix = $var['codfenix'];
        $interno = $var['interno'];
        $costo = $var['costo'];
        $cantidadped = $var['cantidadped'];
        $dto1 = $var['dto1'];
        $dto2 = $var['dto2'];
        $dto3 = $var['dto3'];
        $rec1 = $var['rec1'];

        $descripcion_lista = $var['descripcion_lista'];

        $items = array();

        $total_items = 0;
        $importe_total = 0;

        //Si existe borra el articulo
        //Verifica que no tenga una orden de compra asignada
        $sql_delete = "DELETE FROM facturas_compras "
                . " WHERE factura = '$factura' "
                . "AND codigo_fenix = '$codfenix' "
                . "AND interno_proveedor = '$interno' "
                . "AND proveedor_id = $proveedor";
        $res_delete = mysql_query($link, $sql_delete);

        $sql = "INSERT INTO facturas_compras "
                . "("
                . " factura,"
                . " ocompra,"
                . " proveedor_id,"
                . " codigo_fenix,"
                . " interno_proveedor,"
                . " fecha,"
                . " costo,"
                . " cantidad,"
                . " moneda,"
                . " dto1,"
                . " dto2,"
                . " dto3,"
                . " rec1,"
                . " descripcion"
                . " )VALUES("
                . " '$factura',"
                . "0,"
                . " '$proveedor',"
                . " '$codfenix',"
                . " '$interno',"
                . " '$fecha',"
                . " '$costo',"
                . " '$cantidadped',"
                . " 'PES' , "
                . " '$dto1',"
                . " '$dto2',"
                . " '$dto3',"
                . " '$rec1',"
                . " '$descripcion_lista'"
                . " )";
        $res = mysql_query($link, $sql);

        $strMensaje = '';
        if ($res) {
            //Cuenta cantidad de items e importe total
            $sql_totales = "select SUM((costo * (1-dto1/100) * (1-dto2/100) * (1-dto3/100)) * cantidad) as importe_total
                        , COUNT(*) AS items
                        from facturas_compras 
                        where proveedor_id = $proveedor 
                        and ocompra = 0";
            $res_totales = mysql_query($link, $sql_totales);
            $row_totales = mysql_fetch_array($res_totales);

            $importe_total = number_format($row_totales['importe_total'], 2, '.', ',');
            $total_items = number_format($row_totales['items'], 0, '.', ',');

            $strMensaje .= "*** Nuevo articulo agregado a la factura ***";

            $items['importe_total'] = $importe_total;
            $items['items'] = $total_items;
            $items['mensaje'] = $strMensaje;

            echo json_encode($items);
        } else {
            $strMensaje .= 'ERROR: ' . $sql;

            $items['importe_total'] = $importe_total;
            $items['items'] = $total_items;
            $items['mensaje'] = $strMensaje;

            echo json_encode($items);
        }
    }

    /**
     * Genera la nueva orden de compra
     */
    public function guardarFacCompra() {
        $var = $_POST;
        $proveedor = $var['proveedor'];
        $factura = $var['factura'];
        $sucursal = $var['sucursal'];

        //Datos del proveedor 
        $sql_prov = "SELECT codigo_proveedor, nombre_proveedor FROM PROVEEDORES WHERE ID = $proveedor";
        $res_prov = mysql_query($link, $sql_prov);
        $row_prov = mysql_fetch_array($res_prov);
        $prov_nombre = $row_prov['nombre_proveedor'];
        $codigo_proveedor = $row_prov['codigo_proveedor'];

        $items = array();
        $strMensaje = '';
        $err = 0;
        $importe_total = 0;
        $total_items = 0;

        $strMensaje .= "*** Factura de Compra generada con éxito ***<br/>Factura Nro: $factura<br/>Proveedor:$codigo_proveedor - $prov_nombre";

        //Cuenta cantidad de items e importe total
        $sql_totales = "select SUM((costo * (1-dto1/100) * (1-dto2/100) * (1-dto3/100)) * cantidad) as importe_total
                    , COUNT(*) AS items
                    from facturas_compras 
                    where proveedor_id = $proveedor 
                    and factura = '$factura'";
        $res_totales = mysql_query($link, $sql_totales);
        $row_totales = mysql_fetch_array($res_totales);

        $importe_total = number_format($row_totales['importe_total'], 2, '.', ',');
        $total_items = number_format($row_totales['items'], 0, '.', ',');

        //Baja los articulos de la orden de compra
        $sql_arts = "SELECT codigo_fenix, cantidad FROM facturas_compras WHERE factura = '$factura'";
        $res_arts = mysql_query($link, $sql_arts);
        while ($row_arts = mysql_fetch_array($res_arts)) {

            $art_oc = $row_arts['codigo_fenix'];
            $cant_ocompra = $row_arts['cantidad'];

            //1 - Busca orden de compra pendientes
            $sql_ocompra = "SELECT ocompra, costo, cantidadped, cantidadrec
                FROM ocompras 
                WHERE proveedor_id = $proveedor 
                AND codigo_fenix = '$art_oc' 
                AND cantidadped > cantidadrec
                AND sucursal = $sucursal
                ORDER BY fecha DESC LIMIT 1";
            $res_ocompra = mysql_query($link, $sql_ocompra);
            while ($row_arts = mysql_fetch_array($res_ocompra)) {
                $ocompra = $row_arts['ocompra'];
                $cantidadped = $row_arts['cantidadped'];
                $cantidadrec = $row_arts['cantidadrec'];
                $costo = $row_arts['costo'];

                //2 - Recepcion de mercaderia
                $sql_compras = "UPDATE ocompras "
                        . "SET cantidadrec = $cant_ocompra, fecharec = NOW()"
                        . " WHERE ocompra = $ocompra"
                        . " AND codigo_fenix = '$art_oc'"
                        . " AND sucursal = $sucursal";
                $res_compras = mysql_query($link, $sql_compras);
                
                    //VINCULA LA FACTURA DE COMPRA CON LA ORDEN DE COMPRA
                
                    $sql_fac_oc = "UPDATE facturas_compras "
                        . "SET ocompra = $ocompra"
                        . " WHERE ocompra = 0"
                        . " AND codigo_fenix = '$art_oc'"
                        . " AND factura = '$factura'";
                    $res_fac_oc = mysql_query($link, $sql_fac_oc);
                    
                    //3 - Actualiza el Stock
                    //Verifica Stock
                    $sql_stk = "SELECT cantidad FROM stock "
                            . "WHERE articulo_fenix = '$art_oc'"
                            . " AND sucursal_id = $sucursal";
                    $res_stk = mysql_query($link, $sql_stk);
                    $cantidad_stk = 0;
                    $cantidad_stk_nueva = 0;
                    $cont_stk = 0;
                    while ($row_stk = mysql_fetch_array($res_stk)) {
                        $cantidad_stk = $row_stk['cantidad'];
                        $cont_stk++;
                    }

                    $cantidad_stk_nueva = $cantidad_stk + $cant_ocompra;

                    if ($cont_stk > 0) {
                        //El ariculo esta en stock, hay que actualizar la cantidad
                        $sql_update_stk = "UPDATE stock SET cantidad = $cantidad_stk_nueva"
                                . " WHERE articulo_fenix = '$art_oc' "
                                . "AND sucursal_id = $sucursal";
                        $res_update_stk = mysql_query($link, $sql_update_stk);
                        if (!$res_update_stk) {
                            $strMensaje = 'Error al actualizar cantidad en stock';
                            $err = 1;
                        }
                    } else {
                        //El articulo se carga por primera vez
                        $sql_insert_stk = "INSERT INTO stock (articulo_fenix, cantidad, sucursal_id)"
                                . "VALUES ('$art_oc', $cantidad_stk_nueva, $sucursal)";
                        $res_insert_stk = mysql_query($link, $sql_insert_stk);
                        if (!$res_insert_stk) {
                            $strMensaje = 'Error al ingresar articulo al stock';
                            $err = 1;
                        }
                    }
                
            }
        }

        $items['err'] = $err;
        $items['factura'] = $factura;
        $items['mensaje'] = $strMensaje;
        $items['importe_total'] = $importe_total;
        $items['items'] = $total_items;

        echo json_encode($items);
    }

}
