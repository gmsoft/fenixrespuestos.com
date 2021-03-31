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
                        Cuenta Corriente
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <div class="span12" style="margin-left: 0px;">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget red">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Cuenta Corriente</h4>
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
                                                    if ($v['id']==$cliente_id) {
                                                        echo '<option value="' . $v['id'] . '" SELECTED>' . $v['razon_social'] .'</option>';
                                                    } else {
                                                        echo '<option value="' . $v['id'] . '" >' . $v['razon_social'] .'</option>';
                                                    }                                                    
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
                                        <th>Concepto</th>
                                        <th>Comprobante.Nro</th>
                                        <th>Debito</th>
                                        <th>Credito</th>
                                        <th>Saldo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $saldo_cta_cte = 0;
                                    foreach($cta_cte as $k=>$v) {
                                        $importe_comprobantes = 0;
                                        $importe_cobranzas = 0;
                                        $saldo_comprobante = 0;
                                        
                                        ?>
                                        <tr>
                                            <td style="text-align: center"><?php echo $v['tipo_cbte_descripcion']; ?></td>
                                            <td style="text-align: center"><?php echo $v['comprobante_nro']; ?></td>
                                            <td style="text-align: center"><?php echo $v['condicion_venta']; ?></td>
                                            <td style="text-align: center"><?php echo $v['fecha']; ?></td>
                                            <td style="text-align: right"><?php echo $v['importe_total']; ?></td>
                                            <td>
                                                <a target="_blank" 
                                                class="btn btn-primary"
                                                 href="/venta_controller/factura_pdf/?cbte_nro=<?php echo $v['cbte_nro']; ?>&tipo_cbte=<?php echo $v['tipo_cbte']; ?>&punto_vta=<?php echo $v['punto_vta']; ?>" 
                                                 title="Imprimir a PDF"><i class="icon-print"></i></a></td>                                           
                                        </tr>
                                        <?php
                                        
                                        $importe_comprobantes = $v['importe_total'] * 1;

                                        if (count($v['cobranzas']) > 0) {
                                            foreach($v['cobranzas'] as $kc=>$vc) {    
                                            ?>
                                                <tr>
                                                    <td style="text-align: center"><?php echo $vc['tipo_cbte_descripcion']; ?></td>
                                                    <td style="text-align: center"><?php echo $vc['comprobante_nro']; ?></td>
                                                    <td style="text-align: center"></td>                                                    
                                                    <td style="text-align: center"><?php echo $vc['fecha']; ?></td>
                                                    <td style="text-align: right"><?php echo $vc['importe']; ?></td>
                                                    <td></td>
                                                </tr>
                                            <?php
                                                $importe_cobranzas += $vc['importe'] * 1;
                                           }
                                           
                                        }
                                        //Saldo
                                        $saldo_comprobante = $importe_cobranzas - $importe_comprobantes;
                                        $saldo_cta_cte += $saldo_comprobante;
                                        ?>
                                            <tr>
                                                <td style="text-align: right" colspan="4">Saldo del comprobante</td>
                                                <td style="text-align: right"><?php echo number_format($saldo_comprobante,2,'.',',');?></td>
                                                <td></td>
                                            </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="row-fluid text-right">
                            <strong>SALDO CTA CTE $ <?php echo number_format($saldo_cta_cte,2,'.',',');?></strong>
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