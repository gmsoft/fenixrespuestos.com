<?php 

$this->load->view('administrador/dashboard/header'); 
?>
<!-- BEGIN PAGE -->
<div id="container" class="row-fluid">
    <!-- BEGIN SIDEBAR -->
    <?php $this->load->view('administrador/dashboard/sidebar'); ?>
    <!-- END SIDEBAR -->
    <!-- BEGIN PAGE -->  
    <div id="main-content">
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                        <button class="btn btn-danger" onclick="window.history.back()"><i class="icon-arrow-left"></i></button>
                        Consulta de Articulos <span id="lbl-info" class="label label-info"></span>
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>

            <div class="row-fluid">
                <?php $this->load->view('consulta_articulo/detalle_art'); ?>

                <?php
                if (isset($articulo)) {
                    if (count($articulo) > 0) {
                        ?>

                        <div class="span2"  id="foto-articulo">
                            <div class="widget red">
                                <div class="widget-title">
                                    <h4><i class="icon-reorder"></i> Foto</h4>
                                    <span class="tools">
                                        <a href="javascript:;" class="icon-chevron-down"></a>
                                        <a href="javascript:;" class="icon-remove"></a>
                                    </span>
                                </div>
                                <div class="widget-body">
                                    <img src="<?php echo base_url() . 'assets/uploads/files/fotos_articulos/' . ($articulo['imagen']==''?'artsinfoto.jpg':$articulo['imagen']);?>" >
                                </div>

                            </div>
                        </div>
                        
                        <div class="span10"  id="detalles-articulo" style="margin-left: 0px;">
                            <div class="widget red">
                                <div class="widget-title">
                                    <h4><i class="icon-reorder"></i> Detalles del Articulo</h4>
                                    <span class="tools">
                                        <a href="javascript:;" class="icon-chevron-down"></a>
                                        <a href="javascript:;" class="icon-remove"></a>
                                    </span>
                                </div>

                                <div class="widget-body">
                                    <div class="bs-docs-example">
                                        <ul class="nav nav-tabs" id="myTab">
                                            <li class="active"><a data-toggle="tab" href="#comparativo">Comparativo</a></li>
                                            <li class=""><a data-toggle="tab" href="#compras">Pendientes</a></li>
                                            <li class=""><a data-toggle="tab" href="#stock">Stock</a></li>
                                            <li class=""><a data-toggle="tab" href="#ucompra">Ultima Compra</a></li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div id="comparativo" class="tab-pane fade active in">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>PROVEEDOR</th>
                                                            <th>COD.PROV.</th>
                                                            <th>DESCRIPCION</th>                                                            
                                                            <th>FECHA</th>
                                                            <th>LISTA S/I</th>
                                                            <th>COD</th>
                                                            <th>DTO</th>
                                                            <th>COSTO S/I</th>
                                                            <th>Util%</th>
                                                            <th>MARCA NRO</th>
                                                            <th>MARCA</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                       
                                                        <?php
                                                        
                                                        //Otros proveedores
                                                        $sql = "SELECT rp.`interno_proveedor`,rp.`proveedor_id`,
                                                            rp.`costo`, rp.`costo_lista`, rp.`descripcion`, rp.`marca`,rp.`testigo`, rp.`cod_dto`,
                                                            rp.`dto1`,rp.`dto2`,rp.`dto3`,rp.`rec1`, rp.`utilidad`, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha
                                                              FROM costos_proveedor  rp 
                                                              WHERE codigo_fenix = '" . $articulo['codigo_fenix'] . "' ORDER BY rp.`costo` ASC";
                                                        $res = mysql_query($link, $sql);
                                                        while($row = mysql_fetch_array($res)){
                                                            $testigo = $row['testigo'];
                                                            $utilidad = $row['utilidad'];
                                                            $proveedor_costo = $row['proveedor_id'];
                                                            $cod_dto = $row['cod_dto'];
                                                            $fecha_costo = $row['fecha'];
                                                            //Datos del Proveedor
                                                            $sql_datos_prov = "SELECT codigo_proveedor, nombre_proveedor FROM  proveedores WHERE id = $proveedor_costo";
                                                            $res_datos_prov = mysql_query($link, $sql_datos_prov);
                                                            $nombre_proveedor = '';
                                                            while($row_datos_prov = mysql_fetch_array($res_datos_prov)){
                                                                $nombre_proveedor = '[' . $row_datos_prov['codigo_proveedor'] . '] ' . $row_datos_prov['nombre_proveedor'];
                                                            }
                                                            
                                                            $interno_prov = $row['interno_proveedor'];
                                                            $costo = $row['costo'];
                                                            
                                                            $dto1 = $row['dto1'];
                                                            $dto2 = $row['dto2'];
                                                            $dto3 = $row['dto3'];
                                                            $rec1 = $row['rec1'];
                                                            $costo_neto = $costo * (1 - ($dto1 / 100)) * (1 - ($dto2 / 100)) * (1 - ($dto3 / 100)) * (1 + ($rec1 / 100));
                                                            
                                                            //Busca el codigo de dto (Deprecado, ahora busca de costo proveedor)
                                                            /*
                                                            $sql_cod_dto = "SELECT codigo FROM proveedor_dto_vw WHERE proveedor_id = $proveedor_costo AND porcentaje_dto = $dto1";
                                                            $res_cod_dto = mysql_query($link, $sql_cod_dto);
                                                            $row_cod_dto = mysql_fetch_array($res_cod_dto);
                                                            $cod_dto = $row_cod_dto['codigo'];
                                                            */

                                                            $costo_lista = $row['costo_lista'];
                                                            $descripcion = $row['descripcion'];
                                                            $marca = $row['marca'];
                                                            ?>
                                                            <tr>
                                                               <td <?php if($testigo=='SI'){echo 'style=background-color:yellow';} ?>><?php if($testigo=='SI'){echo '(T) ';} ?><?php echo $nombre_proveedor;?></td>
                                                                <td><?php echo $interno_prov;?></td>
                                                                <td><?php echo $descripcion;?></td>
                                                                <td><?php echo $fecha_costo;?></td>
                                                                <td><?php echo $costo;?></td>
                                                                <td><?php echo $cod_dto;?></td>
                                                                <td><?php echo $dto1.'/'.$dto2.'/'.$dto3.' / '.$rec1;?></td>
                                                                <td><?php echo number_format($costo_neto,2,'.',',');?></td>
                                                                <td><?php echo $utilidad;?>%</td>
                                                                <td><?php echo $marca;?></td>
                                                                <td>-</td>
                                                                </tr>
                                                            <?php   
                                                        
                                                         }
														
														?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="compras" class="tab-pane fade">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>NRO OC</th>
                                                            <th>FECHA</th>
                                                            <th>CODIGO</th>
                                                            <th>PROVEEDOR</th>
                                                            <th>CANT PED</th>
                                                            <th>CANT REC</th>
                                                            <th>COSTO</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $sql_ocompra = "SELECT  ocompra, interno_proveedor,
                                                        DATE_FORMAT(fecha,'%d/%m/%Y') as fecha , costo, dto1, dto2, 
                                                        dto3, rec1, cantidadped,
                                                        cantidadrec, sucursal, p.`nombre_proveedor`
                                                    FROM ocompras oc
                                                    INNER JOIN proveedores p ON p.`id` = oc.`proveedor_id`
                                                    WHERE codigo_fenix = '".$articulo['codigo_fenix']."' ORDER BY fecha desc, ocompra desc";
                                                    $res_ocompra = mysql_query($link, $sql_ocompra);
                                                    while($row_ocompra = mysql_fetch_array($res_ocompra)) {
                                                        ?>
                                                        <tr>
                                                        <td><?php echo $row_ocompra['ocompra']; ?></td>
                                                        <td><?php echo $row_ocompra['fecha']; ?></td>
                                                        <td><?php echo $row_ocompra['interno_proveedor']; ?></td>
                                                        <td><?php echo $row_ocompra['nombre_proveedor']; ?></td>
                                                        <td><?php echo $row_ocompra['cantidadped']; ?></td>
                                                        <td><?php echo $row_ocompra['cantidadrec']; ?></td>
                                                        <td><?php echo $row_ocompra['costo']; ?></td>
                                                        </tr>
                                                    <?php

                                                    }
                                                    ?>    
                                                    

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="stock" class="tab-pane fade">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Sucursal</th>
                                                            <th>Ubicacion</th>
                                                            <th>Stock</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql_stock = "SELECT cantidad, c.`nombre`, u.`ubicacion` FROM stock s INNER JOIN sucursales c ON c.`id` = s.`sucursal_id` INNER JOIN ubicaciones u ON u.`id` = s.`ubicacion` WHERE articulo_fenix = '" . $articulo['codigo_fenix'] . "'";    
                                                        $res = mysql_query($link, $sql_stock);
                                                        @$rows_stock = mysql_num_rows($res);
                                                        if ($rows_stock > 0) {
                                                            while ($row = mysql_fetch_array($res)) {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $row['nombre'];?></td>
                                                                    <td><?php echo $row['ubicacion'];?></td>
                                                                    <td><?php echo $row['cantidad'];?></td>
                                                                </tr>
                                                            <?php    
                                                            }
                                                        }

                                                        ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="ucompra" class="tab-pane fade">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>FAC NRO</th>
                                                            <th>FECHA</th>
                                                            <th>CODIGO</th>
                                                            <th>PROVEEDOR</th>
                                                            <th>CANT</th>
                                                            <th>PRECIO</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                    $sql_ocompra = "SELECT  factura, interno_proveedor,
                                                        DATE_FORMAT(fecha,'%d/%m/%Y') as fecha,fecha as fecha2, costo, dto1, dto2, 
                                                        dto3, rec1, cantidad,
                                                        sucursal, p.`nombre_proveedor`
                                                    FROM facturas_compras fc
                                                    INNER JOIN proveedores p ON p.`id` = fc.`proveedor_id`
                                                    WHERE codigo_fenix = '".$articulo['codigo_fenix']."' 
                                                    order by fecha2 Desc limit 1";
                                                    $res_ocompra = mysql_query($link, $sql_ocompra);
                                                    while($row_ocompra = mysql_fetch_array($res_ocompra)) {
                                                        ?>
                                                        <tr>
                                                        <td><?php echo $row_ocompra['factura']; ?></td>
                                                        <td><?php echo $row_ocompra['fecha']; ?></td>
                                                        <td><?php echo $row_ocompra['interno_proveedor']; ?></td>
                                                        <td><?php echo $row_ocompra['nombre_proveedor']; ?></td>
                                                        <td><?php echo $row_ocompra['cantidad']; ?></td>
                                                        <td><?php echo $row_ocompra['costo']; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    
                        <?php
                    }
                }
                ?>

            </div>

        <!-- END PAGE -->  
    </div>
    <!-- END PAGE -->

    <!-- Modal - Edit Precio -->
        <div class="modal hide fade" id="add-art-modal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Agregar articulo</h3>
            </div>
            <div class="modal-body">
                <span id="msg-add-art"></span>                
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button id="btn-acumular-cantidad" class="btn btn-primary">Acumular</button>
            </div>
        </div>
<?php $this->load->view('administrador/dashboard/footer'); ?>

<script>
function consultarArt() {
    //$('#detalles-articulo').attr('style','display:bock');
    $('#form_consulta').submit();
}

$('input[type=text]').keypress(function(e) {
    if (e.which == 13) {
        $('#form_consulta').submit();
    }
});

$('#btn-add-art').click(function(){
          
     var uri = '<?php echo base_url();?>' + 'venta_controller/guardarArtPresupuestoConsulta';
     var datos = {
        codfenix : $('#codfenix').val(),
        oem : $('#oem').val(),
        precio : $('#precio').val(),
        cantidadped : 1
     };

     $.ajax({
        url: uri,
        data: datos,
        type: 'POST',
        success: function(data) {
            var datosJson = JSON.parse(data);
            var err = datosJson.err * 1;
            var msjErr = datosJson.mensaje;
            
            //Error
            if (err == 1) {
                $('#lbl-info').html(msjErr);
                $('#lbl-info').fadeOut(5000); 
            }

            //OK
            if (err == 0) {
                $('#lbl-info').html(msjErr);
                 $('#lbl-info').fadeOut(5000); 
            }
            
            //Acumular
            if (err == 2) {
                //Articulo existe en el presupuesto
                $('#msg-add-art').html(msjErr);
                $('#add-art-modal').modal();
            }
                                        
        },
        error: function() {

        }
    });
});

$('#btn-acumular-cantidad').click(function() {         
     /**TODO: Acumular cantidad*/
 
     var uri = '<?php echo base_url();?>' + 'venta_controller/updateArticuloPresupuesto';
     var datos = {
        articulo : $('#codfenix').val(),
        cantidad : 1
     };

     $.ajax({
        url: uri,
        data: datos,
        type: 'POST',
        success: function(data) {
            var datosJson = JSON.parse(data);
            var err = datosJson.err * 1;
            var msjErr = datosJson.mensaje;

            $('#add-art-modal').modal('hide');

            //Error
            if (err == 1) {
                $('#lbl-info').html(msjErr);
                $('#lbl-info').fadeOut(5000);
            } else {
                $('#lbl-info').html(msjErr);
                $('#lbl-info').fadeOut(5000);
            }
            
        },
        error: function() {

        }
});

});

</script>