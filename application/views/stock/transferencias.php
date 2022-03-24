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
                        Transferencias de Stock
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <?php
            $query_sucursal = "SELECT id, nombre
                    FROM sucursales";
            $result_sucursal = mysqli_query($link, $query_sucursal);
            
            $query_sucursal_h = "SELECT id, nombre
                    FROM sucursales";
            $result_sucursal_h = mysqli_query($link, $query_sucursal_h);
            
            ?>
            <div class="span12">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget purple">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Transferencia de Stock</h4>
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
                                                 <label class="control-label">Sucursal Origen</label>
                                                  <select id="desde-sucursal">
                                                    
                                                    <?php
                                                    while($row_suc = mysqli_fetch_array($result_sucursal)){
                                                        echo '<option value="' . $row_suc['id'] . '">' . $row_suc['nombre'] .'</option>';
                                                    }
                                                    ?>
                                                </select>
                                             </div>
                                             
                                             <div class="control-group ">
                                                 <label class="control-label">Sucursal Destino</label>
                                                  <select id="hasta-sucursal">
                                                    
                                                    <?php
                                                    while($row_suc_h = mysqli_fetch_array($result_sucursal_h)){
                                                        echo '<option value="' . $row_suc_h['id'] . '">' . $row_suc_h['nombre'] .'</option>';
                                                    }
                                                    ?>
                                                </select>
                                             </div>
                                             
                                         </form>

                                     </div>
                                     
                                     <div class="span6 billing-form">
                                         <h4>.</h4>
                                         <div class="space10"></div>
                                         <form action="#">
                                             <div class="control-group ">
                                                 <label class="control-label">Fecha</label>
                                                 <input type="text" value="<?php echo date('d/m/Y'); ?>" size="16" id="fecha-transferencia" class=" span5" readonly="readonly">
                                             </div>

                                         </form>

                                     </div>
                                 </div>
                             </div>
                         
                        
                        
                        <div>
                            <div class="clearfix">
                                <div class="btn-group">
                                    <button id="editable-transferencia_new" class="btn green">
                                        Agregar Articulo <i class="icon-plus"></i>
                                    </button>                                     
                                </div>
                                <div id="info-consulta" class="label label-success">*</div>
                                
                                <input type="hidden" id="descripcion-lista" >
                                <input type="hidden" id="marca-lista" >
                                
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
                            <table class="table table-striped table-hover table-bordered" id="editable-transferencia">
                                <thead>
                                    <tr>
                                        <th>Codigo Fenix</th>
                                        <th>Cantidad</th>
                                        
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
<?php $this->load->view('administrador/dashboard/footer'); ?>

<script>
                            jQuery(document).ready(function() {
                                EditableTable.init();
                               
                            });
                            
                             
                            //$(".chosen-select").chosen();
                            //$(".chosen-select-deselect").chosen({allow_single_deselect: true});

</script>
