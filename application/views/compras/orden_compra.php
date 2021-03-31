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
                        Orden de Compra
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <?php
            $query_prov = "SELECT proveedor_id,p.codigo_proveedor, p.`nombre_proveedor` , l.`nombre_archivo`, l.`id`
                    FROM listas l
                    INNER JOIN proveedores p ON p.`id` =  l.`proveedor_id`
                    WHERE proveedor_id NOT IN (1,5,7)";
            $result_prov = mysql_query($query_prov);

            $query_sucursal_h = "SELECT id, nombre
                    FROM sucursales";
            $result_sucursal_h = mysql_query($query_sucursal_h);
            ?>
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget purple">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Orden de Compra</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                    </div>
                    <div class="widget-body">

                        <div class="portlet-body">
                            <div class="row-fluid">
                                <div class="span6 billing-form">
                                    <h4>Datos del Proveedor</h4>
                                    <div class="space10"></div>
                                    <form action="#">
                                        <div class="control-group ">
                                            <label class="control-label">Proveedor</label>
                                            <select id="proveedor" class="chzn-select-deselect span6" data-placeholder="Seleccione proveedor">
                                                <option value=""></option>
                                                <?php
                                                while ($row_prov = mysql_fetch_array($result_prov)) {
                                                    echo '<option value="' . $row_prov['proveedor_id'] . '">' . $row_prov['nombre_proveedor'] . ' [' . $row_prov['codigo_proveedor'] . ']</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="control-group ">
                                            <label class="control-label">Sucursal</label>
                                            <select id="sucursal" class="chzn-select-deselect span6" data-placeholder="Seleccione sucursal">

                                                <?php
                                                while ($row_suc_h = mysql_fetch_array($result_sucursal_h)) {
                                                    echo '<option value="' . $row_suc_h['id'] . '">' . $row_suc_h['nombre'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="control-group ">
                                            <label class="control-label">Fecha</label>
                                            <input type="text" value="<?php echo date('d/m/Y'); ?>" size="16" id="fecha-oc" class=" span5">
                                        </div>
                                    </form>
                                </div>
                                <div class="span6 billing-form">
                                    <h4>.</h4>
                                    <div class="space10"></div>
                                    <div class="control-group ">
                                        <label class="control-label">Moneda</label>
                                        <select id="moneda" class="chzn-select-deselect span6" data-placeholder="Seleccione moneda">
                                            <option valuee="PES">PES</option>
                                            <option valuee="USD">USD</option>
                                        </select>
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Importe Total</label>
                                        <input type="text" id="total-orden" readonly="readonly">
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Items</label>
                                        <input type="text" id="items-orden" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="clearfix">
                                <div class="btn-group">
                                    <button id="editable-sample_new" class="btn green">
                                        Agregar Articulo <i class="icon-plus"></i>
                                    </button>                                     
                                </div>
                                <div id="info-consulta" class="label label-success">*</div>
                                <input type="hidden" id="descripcion-lista" >
                                <input type="hidden" id="marca-lista" >
                                <input type="hidden" id="costo-lista" >
                                <div class="btn-group pull-right">
                                    <span id="mensajes-error"></span>
                                </div>
                            </div>
                            <div class="space15"></div>
                            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                <thead>
                                    <tr>
                                        <th>Codigo Fenix</th>
                                        <th>Interno</th>
                                        <th>Testigo</th>
                                        <th>Cant</th>
                                        <th>Costo</th>
                                        <th>Dto1</th>
                                        <th>Dto2</th>
                                        <th>Dto3</th>
                                        <th>Rec1</th>
                                        <th>Importe</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                        <div class="row-fluid text-center">
                            <button class="btn btn-success btn-medium hidden-print" id="guardar-orden"> Guardar <i class="icon-check"></i></button>
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
<!-- Modal - Orden Guardada -->
<div class="modal hide fade" id="orden-guardada-modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Orden de Compra</h3>
    </div>
    <div class="modal-body">
        <span id="msj-ocompra"></span>
    </div>
    <div class="modal-footer">
        <a class="btn" href="<?php echo site_url('compra_controller/nueva_orden_compra') ?>">Aceptar</a>
        <!--<button id="btn-guardar-precio" class="btn btn-primary">Guardar</button>-->
    </div>
</div>
<!-- END PAGE -->
<?php $this->load->view('administrador/dashboard/footer_compra'); ?>

<script>
    jQuery(document).ready(function() {
        EditableTable.init();
        
        $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});
        
        $('#fecha-oc').datepicker({
            format: 'dd/mm/yyyy'
        });
    });
</script>