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
                        Costos Proveedor
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <?php
            $query_prov = "SELECT id, codigo_proveedor, nombre_proveedor
                    FROM proveedores ORDER BY nombre_proveedor";
            $result_prov = mysqli_query($link, $query_prov);
            ?>
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget purple">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Carga de Costos</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                    </div>
                    <div class="widget-body">
                         
                             <div class="portlet-body">
                                 <!--
                                 <div class="invoice-date-range span12 form">
                                     <h4>Datos</h4>
                                     <form action="#" class="form-horizontal form-row-seperated">
                                         <div class="control-group ">
                                             <label class="control-label">Fecha Costo</label>
                                             <input id="dp1" type="text" value="<?=date('d/m/Y')?>" size="16" class="m-ctrl-medium">
                                             
                                             <label class="control-label">Proveedor</label>
                                             <select>
                                                 <option>Tipo 1</option>
                                                 <option>Tipo 2</option>
                                             </select>
                                         </div>
                                     </form>
                                 </div>
                                 -->
                                 
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
                                                    while($row_prov = mysqli_fetch_array($result_prov)){
                                                        echo '<option value="' . $row_prov['id'] . '">' . $row_prov['nombre_proveedor'] . ' [' . $row_prov['codigo_proveedor'] . ']</option>';
                                                        
                                                    }
                                                    ?>
                                                </select>
                                             </div>
                                             
                                             <div class="control-group ">
                                                 <label class="control-label">Fecha</label>
                                                 <input type="text" value="<?php echo date('d/m/Y'); ?>" size="16" id="fecha-costo" class=" span5">
                                             </div>
                                            

                                         </form>

                                     </div>
                                     
                                     <div class="span6 billing-form">
                                         <h4>.</h4>
                                         <div class="space10"></div>
                                         <form action="#">
                                             <div class="control-group ">
                                                 <label class="control-label">Moneda</label>
                                                 <select id="moneda" class="chzn-select-deselect span6" data-placeholder="Seleccione moneda">
                                                     <option valuee="PES">PES</option>
                                                     <option valuee="USD">USD</option>
                                                 </select>
                                             </div>

                                         </form>

                                     </div>
                                 </div>
                             </div>
                         
                        
                        
                        <div>
                            <div class="clearfix">
                                <div class="btn-group">
                                    <button id="editable-sample_new" class="btn green">
                                        Agregar Costo <i class="icon-plus"></i>
                                    </button>                                     
                                </div>
                                <div id="info-consulta" class="label label-success">*</div>
                                
                                <input type="hidden" id="descripcion-lista" >
                                <input type="hidden" id="marca-lista" >
                                <input type="hidden" id="costo-lista" >
                                
                                <div class="btn-group pull-right">
                                    <span id="mensajes-error"></span>

                                    <!--
                                    <button class="btn dropdown-toggle" data-toggle="dropdown">Herramientas <i class="icon-angle-down"></i>
                                    </button>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="#">Imprimir</a></li>
                                        <li><a href="#">Guardar PDF</a></li>
                                        <li><a href="#">Guardar Excel</a></li>
                                    </ul>
                                    -->
                                </div>
                            </div>
                            <div class="space15"></div>
                            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                <thead>
                                    <tr>
                                        <th>Codigo Fenix</th>
                                        <th>Interno</th>
                                        <th>Testigo</th>
                                        <th>Util</th>
                                        <th>Costo</th>
                                        <th>Dto1</th>
                                        <th>Dto2</th>
                                        <th>Dto3</th>
                                        <th>Rec1</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--
                                    <tr class="">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="center"></td>
                                        <td class="center"></td>
                                        <td><a class="edit" href="javascript:;">Editar</a></td>
                                    </tr>
                                    -->

                                </tbody>
                            </table>
                        </div>
                        
                         <div class="row-fluid text-center">
                                 <!--<a class="btn btn-success btn-medium hidden-print"> Guardar <i class="icon-check"></i></a>-->
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
<?php $this->load->view('administrador/dashboard/footer_costo'); ?>

<script>
    jQuery(document).ready(function() {
        EditableTable.init();
        
        $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});
        
        $('#fecha-costo').datepicker({
            format: 'dd/mm/yyyy'
        });
    });
</script>