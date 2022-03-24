<?php

if (isset($_GET['carrito'])) {

}

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
                        Presupuesto 
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <?php
            //CLIENTES
            $query_clientes = "SELECT id, razon_social FROM clientes";
            $result_clientes = mysql_query($link, $query_clientes);
            
            //SUCURSALES
            $query_sucursal_h = "SELECT id, nombre
                    FROM sucursales";
            $result_sucursal_h = mysql_query($link, $query_sucursal_h);
            
            //COMPANIAS
            $query_compania = "SELECT id, nombre FROM companias";
            $result_compania = mysql_query($link, $query_compania);
            
            //PERITOS
            $query_peritos = "SELECT id, nombre FROM peritos";
            $result_peritos = mysql_query($link, $query_peritos);
            
            //MODELOS
            $query_modelos = "SELECT id, marca_id, nombre FROM modelos";
            $result_modelos = mysql_query($link, $query_modelos);
            ?>
            <div class="span12" style="margin-left: 0px;">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget green">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Cabecera del presupuesto</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div class="portlet-body">
                            <div class="row-fluid">
                                <div class="span4 billing-form">
                                    <div class="space10"></div>
                                    <form action="#">
                                        <div class="control-group ">
                                            <label class="control-label">Sucursal</label>
                                            <input type="hidden" size="16" id="nro-presupuesto" class=" span4">
                                            <!--
                                            <button class="btn btn-mini btn-primary" id="btn-buscar-presupuesto">Buscar <i class="icon-search"></i></button>
                                            -->
                                            <select id="sucursal" class="chzn-select-deselect" data-placeholder="Seleccione sucursal" style="width:100px">
                                                <option value=""></option>
                                                <?php
                                                while ($row_suc_h = mysql_fetch_array($result_sucursal_h)) {
                                                 ?>   
                                                    <option value="<?php echo $row_suc_h['id'];?>" <?php echo($row_suc_h['id'] == $sucursal)? 'selected' : '' ?> > <?php echo $row_suc_h['nombre'] ?></option>  
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">Nro Siniestro</label>
                                            <input type="text" value="" size="16" maxlength="25" id="siniestro" class=" span5">
                                        </div>
                                        <div class="control-group ">
                                            <label class="control-label">Fecha</label>
                                            <input type="text" value="<?php echo date('d/m/Y'); ?>" size="16" id="fecha-presupuesto" class=" span5">
                                        </div>                                       
                                        <div class="control-group ">
                                            <label class="control-label">Cliente</label>
                                            <select id="cliente" class="chzn-select-deselect span6" data-placeholder="Seleccione cliente" style="width:250px">
                                                <option value=""></option>        
                                                <?php
                                                while ($row_clientes = mysql_fetch_array($result_clientes)) {                                                    
                                                    echo '<option value="' . $row_clientes['id'] . '">' . $row_clientes['razon_social'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                         <div class="control-group ">
                                            <label class="control-label">Domicilio</label>
                                            <input type="text" size="16" id="domicilio-cliente" class=" span9" readonly="readonly">
                                        </div>
                                        <div class="control-group ">
                                            <input type="hidden" value="1" id="concepto">
                                        <!--    
                                            <label class="control-label">Concepto</label>
                                            <select id="concepto" class="chzn-select-deselect" data-placeholder="Seleccione concepto">
                                                <option value="1">01 Productos</option>
                                                <option value="2">02 Servicios</option>
                                                <option value="3">03 Productos </option>
                                            </select>
                                        -->

                                        </div>
                                        <!--
                                        <div class="control-group ">
                                            <label class="control-label">Cia de Seguro</label>
                                            <select id="compania" class="chzn-select-deselect span6" data-placeholder="Seleccione la compania">
                                                <option value=""></option>        
                                                <?php
                                                while ($row_companias = mysql_fetch_array($result_compania)) {
                                                    echo '<option value="' . $row_companias['id'] . '">' . $row_companias['nombre'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        -->
                                        <div class="control-group ">
                                            <label class="control-label">Perito</label>
                                            <select id="perito" class="chzn-select-deselect span6" data-placeholder="Seleccione el perito">
                                                <option value=""></option>        
                                                <?php
                                                while ($row_perito = mysql_fetch_array($result_peritos)) {
                                                    echo '<option value="' . $row_perito['id'] . '">' . $row_perito['nombre'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                
                                
                                <div class="span4 billing-form">
                                  <div class="control-group ">
                                        <label class="control-label">Vehiculo</label>
                                        <select id="vehiculo" class="chzn-select-deselect" data-placeholder="Seleccione vehiculo" style="width:150px">
                                            <option value=""></option>
                                            <?php
                                            while ($row_modelos = mysql_fetch_array($result_modelos)) {
                                                echo '<option value="' . $row_modelos['id'] . '">' . $row_modelos['nombre'] . '</option>';
                                            }
                                            ?>
                                         </select>
                                         <select id="modelo-ano" class="chzn-select-deselect" data-placeholder="Seleccione año"  style="width:100px">
                                            <option value=""></option>
                                            <?php
                                            for ($i = 1980; $i <= 2100; $i++) {
                                                echo '<option value="' . $i . '">' . $i. '</option>';
                                            }
                                            ?>
                                         </select>   
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Patente</label>
                                        <input type="text" id="patente">
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Nro Chasis</label>
                                        <input type="text" id="nro-chasis" maxlength="17">
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Nro Motor</label>
                                        <input type="text" id="nro-motor" maxlength="17">
                                    </div>
                                   
                                     <div class="control-group ">
                                        <label class="control-label">Notas</label>
                                        <textarea id="observaciones" ></textarea>
                                    </div>
                                </div>

                                <div class="span4 billing-form">
                                    
                                    <div class="control-group ">
                                        <label class="control-label">Cond Venta</label>
                                        <select id="cond-venta" class="chzn-select-deselect" data-placeholder="">
                                               
                                                <?php
                                                foreach ($condiciones_venta as $key => $value) {
                                                    $selected = '';
                                                    if ($value['id'] == 2) {
                                                        $selected = ' selected';
                                                    } else {
                                                        $selected = '';
                                                    }
                                                    echo '<option value="' . $value['id'] . '" data-codigo="' . $value['codigo'] . '"' . $selected . '>' . $value['nombre'] . '</option>';
                                                }
                                                ?>
                                         </select>
                                    </div>
									<div class="control-group ">
                                        <label class="control-label">%Dtos</label>
                                        <input type="text" id="dto1-base"  class=" span2">
										<input type="text" id="dto2-base"  class=" span2">
										<input type="text" id="dto3-base"  class=" span2">
                                    </div>
									<div class="control-group ">
                                        <label class="control-label">%Recs</label>
                                        <input type="text" id="rec1-base"  class=" span2">
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Flete</label>
                                        <input type="text" id="importe-flete" class="span3" placeholder="($)Importe">
                                        <input type="text" id="destino-flete" class="span5" placeholder="Destino" maxlength="30">
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Importe S/IVA(Flete)</label>
                                        <input type="text" id="total-presupuesto-flete" readonly="readonly">
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Importe IVA</label>
                                        <input type="text" id="total-presupuesto" readonly="readonly">
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Importe Total C/IVA</label>
                                        <input type="text" id="total-presupuesto" readonly="readonly">
                                    </div>

                                    <div class="control-group ">
                                        <label class="control-label">Items</label>
                                        <input type="text" id="items-presupuesto" readonly="readonly">
                                    </div>
<!--
                                    <div class="control-group ">
                                        <label class="control-label">Empresa TC</label>
                                        <select id="empresa-tarjeta" class="chzn-select-deselect" data-placeholder="">
                                                <option value="1">Visa</option>
                                                <option value="2">MasterCard</option>
                                                <option value="3">Naranja</option>
                                         </select>
                                    </div>
                                     
 -->                               </div>


                            </div>
                        </div>

                    </div>
                </div>

                 <div class="span12" style="margin-left: 0px;">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget green">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Detalle del presupuesto</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                    </div>
                    <div class="widget-body">

                        <div class="portlet-body">

                        <div>
                            <div class="clearfix">
                                <div class="btn-group">
                                    <button id="editable-sample_new" class="btn green">
                                        Agregar Articulo <i class="icon-plus"></i>
                                    </button>                                     
                                </div>
                                <div id="info-consulta" class="label label-success" style="width:75%">*</div>
                                <div id="info-ocompra">*</div>
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
                                        <th>Codigo Fenix <button class="btn btn-mini btn-primary" id="btn-buscar">Buscar <i class="icon-search"></i></button></th>
                                        <th>OEM</th>
                                        <th>Descripcion</th>
                                        <th>Testigo</th>
                                        <th>Cant</th>
                                        <th>Precio</th>
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
                            <button class="btn btn-primary btn-medium hidden-print" id="guardar-presupuesto">Guardar Presupuesto <i class="icon-check"></i></button>
                            <button class="btn btn-success btn-medium hidden-print" id="guardar-factura">Guardar Factura <i class="icon-save"></i></button>
                            <!--<a class="btn btn-inverse btn-medium hidden-print" onclick="javascript:window.print();">Imprimir <i class="icon-print icon-big"></i></a>-->
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
<div class="modal hide fade" id="presupuesto-guardado-modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Presupuesto</h3>
    </div>
    <div class="modal-body">
        <span id="msg-presupuesto"></span>
    </div>
    <div class="modal-footer">
        <!--<button class="btn" data-dismiss="modal" aria-hidden="true">Aceptar</button>-->
        <a class="btn" href="<?php echo site_url('administrador/presupuesto') ?>">Aceptar</a>
        <!--<button id="btn-guardar-precio" class="btn btn-primary">Guardar</button>-->
    </div>
</div>
<!-- END PAGE -->

<?php 

$data_forma_pago =  array();
$data_forma_pago['bancos'] = $bancos;

$this->load->view('ventas/forma_pago_modal', $data_forma_pago); 

?>

<?php $this->load->view('administrador/dashboard/footer_presupuesto'); ?>

<script>
    jQuery(document).ready(function() {
        EditableTable.init();
        
        $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});

        $('#fecha-presupuesto').datepicker({
            format: 'dd/mm/yyyy'
        });
        
        $('#btn-buscar').click(function() {
           $('#articulo-modal').val('');
           $('#oem-modal').val('');
           $('#descripcion-modal').val('');

           $('#resultado-busqueda-modal').html('');
           $('#consulta-articulos-modal').modal(); 

           setTimeout(doSearch, 1000);

            function doSearch()
            {
               $('#articulo-modal').focus();
               $('#btn-buscar-popup').click();
            }
        });       

    });
</script>