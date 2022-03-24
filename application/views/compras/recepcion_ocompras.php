<?php $this->load->view('administrador/dashboard/header'); ?>
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
                        Listado Ordenes de Compra
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <?php
            //print_r($_GET);
            $ocompra = $_GET['ocompra'];
            $nombre_proveedor = $_GET['nombre'];
            $items = $_GET['items'];
            $sucursal = $_GET['sucursal'];
            $fecha = $_GET['fecha'];
            $total = $_GET['total'];
            ?>
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget purple">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i>Detalle Orden de Compra</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                    </div>
                    <div class="widget-body">

                        <div class="portlet-body">
                            <div class="row-fluid">
                                <div class="span6 billing-form">

                                    <div class="space10"></div>
                                    <form action="#">
                                        <div class="control-group ">
                                            <label class="control-label">OC Nro:</label>
                                            <span><?php echo $ocompra; ?></span>
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">Proveedor</label>
                                            <span><?php echo $nombre_proveedor; ?></span>
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">Fecha</label>
                                            <span><?php echo $fecha; ?></span>
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">Sucursal</label>
                                            <span><?php echo $sucursal; ?></span>
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">Total</label>
                                            <span><?php echo $total; ?></span>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <div>

                            <div class="space15"></div>
                            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                <thead>
                                    <tr>
                                        <th>Articulo</th>
                                        <th>Interno</th>
                                        <th>Fecha</th>
                                        <th>Costo</th>
                                        <th>Dto1</th>
                                        <th>Dto2</th>
                                        <th>Dto3</th>
                                        <th>Rec1</th>
                                        <th>Cantidad Ped</th>
                                        <th>Cantidad Rec</th>
                                        <th>Cantidad Pend</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_ocompra = "SELECT codigo_fenix, interno_proveedor,fecha,
                                        descripcion, costo, dto1, dto2, dto3,
                                        rec1, cantidadped, cantidadrec
                                    FROM ocompras
                                    WHERE ocompra = $ocompra";
                                    $res_ocompra = mysql_query($link, $sql_ocompra);
                                    $cont = 0;
                                    while ($row_ocompra = mysql_fetch_array($res_ocompra)) {
                                        $cont++;
                                        ?>
                                        <tr>
                                            <td><?php echo $row_ocompra['codigo_fenix']; ?></td>
                                            <td><?php echo $row_ocompra['interno_proveedor']; ?></td>
                                            <td><?php echo $row_ocompra['fecha']; ?></td>
                                            <td><?php echo $row_ocompra['costo']; ?></td>
                                            <td><?php echo $row_ocompra['dto1']; ?></td>
                                            <td><?php echo $row_ocompra['dto2']; ?></td>
                                            <td><?php echo $row_ocompra['dto3']; ?></td>
                                            <td><?php echo $row_ocompra['rec1']; ?></td>
                                            <td><?php echo $row_ocompra['cantidadped']; ?></td>
                                            <td>
                                                <?php
                                                if ($row_ocompra['cantidadped'] != $row_ocompra['cantidadrec']) {
                                                    echo '<input type="number" value="' . $row_ocompra['cantidadrec'] . '" id="cant-rec-' . $cont . '">';
                                                } else {
                                                    echo $row_ocompra['cantidadrec'];
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo ($row_ocompra['cantidadped'] - $row_ocompra['cantidadrec']); ?></td>
                                            <td>
                                                <button class="btn btn-primary"  onclick="guardarCantidadRec('<?php echo $row_ocompra['codigo_fenix']; ?>',<?php echo $row_ocompra['cantidadped']; ?>,<?php echo $ocompra; ?>,<?php echo $sucursal; ?>, '<?php echo 'cant-rec-' . $cont ?>')">Guardar</button>
                                                <?php
                                            }
                                            ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="row-fluid text-center">

                            <a class="btn btn-inverse btn-medium hidden-print" onclick="javascript:window.print();">Imprimir <i class="icon-print icon-big"></i></a>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE widget-->
            </div>
            <br/>
        </div>
    </div>
</div>
<!-- END PAGE -->
<!-- Modal - Orden Guardada -->
<div class="modal hide fade" id="recepcion-guardada-modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Recepcion de Mercaderia</h3>
    </div>
    <div class="modal-body">
        <span id="msj-recepcion"></span>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Aceptar</button>
        <!--<button id="btn-guardar-precio" class="btn btn-primary">Guardar</button>-->
    </div>
</div>
<?php $this->load->view('administrador/dashboard/footer_compra'); ?>

<script>
jQuery(document).ready(function() {
    EditableTable.init();

});

function guardarCantidadRec(_art, _cantPed, _ocompra, _sucursal, _cantRec) {

    var cantRec = $('#' + _cantRec).val() * 1;
    _cantPed = _cantPed * 1;
    
    if (cantRec > _cantPed) {
        $('#msj-recepcion').html('ANTENCIÓN: La cantidad recibida no puede superar la cantidad pedida');
        $('#recepcion-guardada-modal').modal();
    } else {

        var uri = '/fenix/sistema/compra_controller/recibirStock';
        if (window.location.host !== 'localhost') {
            uri = '/sistema/compra_controller/recibirStock';
        }
        //
        $.ajax({
            url: uri,
            data: {ocompra: _ocompra, art: _art, cantped: _cantPed, cantrec: cantRec, sucursal: _sucursal},
            type: 'POST',
            success: function(data) {
                var datosJson = JSON.parse(data);
                var err = datosJson.err;
                var msjErr = datosJson.mensaje;
                
                if (err != 0) {
                    $('#msj-recepcion').html(msjErr);
                    $('#recepcion-guardada-modal').modal();
                } else {
                    $('#msj-recepcion').html('Articulo agregado al stock');
                    $('#recepcion-guardada-modal').modal();
                }                
            },
            error: function() {

            }
        });
    }
}
</script>