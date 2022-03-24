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
            $query_prov = "SELECT proveedor_id,p.codigo_proveedor, p.`nombre_proveedor` , l.`nombre_archivo`, l.`id`
                    FROM listas l
                    INNER JOIN proveedores p ON p.`id` =  l.`proveedor_id`
                    WHERE proveedor_id NOT IN (1,5,7)";
            $result_prov = mysqli_query($link, $query_prov);

            $query_sucursal_h = "SELECT id, nombre
                    FROM sucursales";
            $result_sucursal_h = mysqli_query($link, $query_sucursal_h);
            ?>
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget purple">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Ordenes de Compra</h4>
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
                                            <label class="control-label">Proveedor</label>
                                            <select id="proveedor">

                                                <?php
                                                while ($row_prov = mysqli_fetch_array($result_prov)) {
                                                    echo '<option value="' . $row_prov['proveedor_id'] . '">' . $row_prov['nombre_proveedor'] . ' [' . $row_prov['codigo_proveedor'] . ']</option>';
                                                }
                                                ?>
                                            </select>
                                             <button id="search-ocompras" class="btn green">
                                                Buscar <i class="icon-search"></i>
                                            </button>   
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
                                        <th>Proveedor</th>
                                        <th>Nro OC</th>
                                        <th>Fecha</th>
                                        <th>Sucursal</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql_ocompra = "SELECT   
                                    proveedor_id,
                                    p.`nombre_proveedor`,
                                    ocompra, 
                                    DATE_FORMAT(fecha,'%d/%m/%Y') as fecha,
                                    sucursal,
                                    COUNT(*) AS items,
                                    SUM(costo * (1-dto1/100) * (1-dto2/100) * (1-dto3/100) * cantidadped) AS importe
                                    FROM ocompras oc
                                    INNER JOIN proveedores p ON p.`id`  = oc.`proveedor_id`
                                    WHERE ocompra <> 0
                                    GROUP BY ocompra
                                    ORDER BY fecha desc, ocompra desc";
                                    $res_ocompra = mysqli_query($link, $sql_ocompra);
                                    while ($row_ocompra = mysqli_fetch_array($res_ocompra)) {
                                        $importe_total = number_format($row_ocompra['importe'], 2, '.', ',');
                                        ?>
                                        <tr>
                                            <td><?php echo $row_ocompra['nombre_proveedor']; ?></td>
                                            <td><?php echo $row_ocompra['ocompra']; ?></td>
                                            <td><?php echo $row_ocompra['fecha']; ?></td>
                                            <td><?php echo $row_ocompra['sucursal']; ?></td>
                                            <td><?php echo $row_ocompra['items']; ?></td>
                                            <td><?php echo $importe_total; ?></td>
                                            <td><a class="btn btn-primary" href="recepcion?ocompra=<?php echo $row_ocompra['ocompra']; ?>&nombre=<?php echo $row_ocompra['nombre_proveedor']; ?>&fecha=<?php echo $row_ocompra['fecha']; ?>&sucursal=<?php echo $row_ocompra['sucursal']; ?>&items=<?php echo $row_ocompra['items']; ?>&total=<?php echo $importe_total; ?>" >Recepcion</a></td>
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
<?php $this->load->view('administrador/dashboard/footer_compra'); ?>

<script>
                                jQuery(document).ready(function() {
                                    EditableTable.init();

                                });
                                //$(".chosen-select").chosen();
                                //$(".chosen-select-deselect").chosen({allow_single_deselect: true});
</script>