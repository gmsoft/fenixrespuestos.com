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
                <div class="span12" style="margin-left: 0px;">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                        <button class="btn btn-danger" onclick="window.history.back()"><i class="icon-arrow-left"></i></button>
                        Listado de Presupuestos
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <div class="span12" style="margin-left: 0px;">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget red">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Presupuestos</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                    </div>
                    <div class="widget-body">

                        <div class="portlet-body">
                            <div class="row-fluid">
                                <div class="span6 billing-form">

                                    <div class="space10"></div>
                                    <form action="" role="form">
                                        <div class="form-group ">
                                            <select id="cliente" name="cliente" class="chzn-select-deselect" data-placeholder="Seleccione cliente">
                                                <option value=""></option>
                                                <?php
                                                foreach ($clientes as $k => $v) {
                                                    echo '<option value="' . $v['id'] . '">' . $v['razon_social'] .'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <button id="search-presupuesto" class="btn green">
                                                Buscar <i class="icon-search"></i>
                                        </button> 
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="space15"></div>
                            <table class="table table-striped table-hover table-bordered" id="tabla-listado">
                                <thead>
                                    <tr>
                                        <th>Pres.Nro</th>
                                        <th>Nro Siniestro</th>
                                        <th>Cliente</th>
                                        <th>Patente</th>
                                        <th>Fecha</th>
                                        <th>Sucursal</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($presupuestos as $v) {
                                        ?>
                                        <tr>
                                            <td style="text-align: right"><?php echo $v->presupuesto_nro; ?></td>
                                            <td style="text-align: center"><?php echo $v->siniestro; ?></td>
                                            <td><?php echo $v->razon_social; ?></td>
                                            <td style="text-align: center"><?php echo $v->patente; ?></td>
                                            <td style="text-align: center"><?php echo $v->fecha; ?></td>
                                            <td style="text-align: center"><?php echo $v->sucursal; ?></td>
                                            <td style="text-align: right"><?php echo $v->items; ?></td>
                                            <td style="text-align: right"><?php echo $v->importe; ?></td>
                                            <td>
                                                <a target="_blank" class="btn btn-primary"
                                                   href="<?php echo site_url('venta_controller/presupuesto_pdf/' . $v->presupuesto_nro) ?>" title="Imprimir a PDF" ><i class="icon-print"></i></a>
                                                   <?php 
                                                    if ($v->fechafac == '') {
                                                   ?>
                                                <a href="<?php echo site_url('venta_controller/facturar_presupuesto/' . $v->presupuesto_nro) ?>" class="btn" title="Generar Factura">
                                                    <i class="icon-inbox"></i></a>
                                                    <?php
                                                    }
                                                    ?>
                                                <a class="btn btn-warning"
                                                   href="<?php echo site_url('venta_controller/generar_remito/' . $v->presupuesto_nro) ?>" title="Imprimir Remito" ><i class="icon-list"></i></a>
                                                
                                            </td>
                                        </tr>
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
<?php $this->load->view('administrador/dashboard/footer_listado'); ?>

<script>
jQuery(document).ready(function() {
    EditableTable.init();

});

$(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});

</script>