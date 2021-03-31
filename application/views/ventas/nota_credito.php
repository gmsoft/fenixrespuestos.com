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
                        Nota Crédito -  Comprobante Nro: <?php echo $comprobante_nro;?>
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <div class="span12" style="margin-left: 0px;">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget green">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Datos del Comprobante</h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>
                        </span>
                    </div>
                    <div class="widget-body">

                        <div class="portlet-body">
                            <div class="row-fluid">
                               
                                <div class="span4 billing-form">
                                    <div class="control-group ">
                                        <label class="control-label">Cliente</label>
                                        <?php echo $comprobante[0]->razon_social;?>
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Fecha</label>
                                        <?php echo $comprobante[0]->fecha;?>
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Concepto</label>
                                        <?php
                                         if ($comprobante[0]->concepto == 1) {
                                            echo '01 - Productos';
                                         } else if ($presupuesto[0]->concepto == 2) {
                                            echo '02 - Servicios';
                                         } else if ($presupuesto[0]->concepto == 3) {
                                            echo '03 - Productos y Servicios';
                                         }
                                         ?>
                                    </div>
                                     <div class="control-group ">
                                        <label class="control-label">Tipo Cbte</label>
                                         <?php echo  $comprobante[0]->tipo_cbte; ?> - <?php echo  $comprobante[0]->tipo_cbte_descripcion; ?>
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Sucursal</label>
                                        <strong><?php echo $comprobante[0]->sucursal;?> - <?php echo $comprobante[0]->nombre_sucursal;?></strong>
                                    </div>
                                   
                                </div>
                                
                                <div class="span5 billing-form">
                                    
                                     <div class="control-group ">
                                        <label class="control-label">Importe Neto</label>
                                        $ <?php echo $comprobante[0]->importe_neto; ?>
                                    </div>
                                     <div class="control-group ">
                                        <label class="control-label">Importe Iva</label>
                                        $ <?php echo  $comprobante[0]->importe_iva;?>
                                    </div>
                                    <div class="control-group ">
                                        <label class="control-label">Importe Tot</label>
                                        $ <?php echo $comprobante[0]->importe_total;?>
                                    </div>
                                    
                                </div>
                            </div>
                            
                           
                        </div>
                        <div>
                            <div class="space15"></div>
                            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Cod Fenix</th>
                                        <th>OEM</th>
                                        <th>Descripcion</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //$articulos[] = array();
                                    foreach($comprobante_detalle as $v) {
                                        //$articulos['presupuesto_nro'] = $presupuesto_nro;
                                        //$articulos['codfenix'] = $v->codfenix;
                                        ?>
                                        <tr>
                                            <td><input type="checkbox" 
                                                       data-comprobante="<?php echo $comprobante_nro; ?>"
                                                       data-articulo="<?php echo $v->codigo_articulo; ?>"
                                                       data-oem="<?php echo $v->oem; ?>"
                                                       data-descripcion="<?php echo $v->descripcion; ?>"
                                                       data-cantidad="<?php echo $v->cantidad; ?>"
                                                       data-precio="<?php echo $v->precio; ?>"
                                                       /></td>
                                            <td style="text-align: center"><?php echo $v->codigo_articulo; ?></td>
                                            <td><?php echo $v->oem; ?></td>
                                            <td><?php echo $v->descripcion; ?></td>
                                            <td style="text-align: right"><?php echo $v->cantidad; ?></td>
                                            <td style="text-align: right"><?php echo $v->precio; ?></td>
                                            
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="row-fluid text-center">
                            
                            <a class="btn btn-inverse btn-large" id="btn-nota-credito">Generar Nota Credito <i class="icon-archive icon-big"></i></a>
                        </div>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE widget-->
            </div>
            <br/>
        </div>
    </div>
</div>
<!-- Modal - Facturar  -->
<div class="modal hide fade" id="facturar-presupuesto-modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Nota de Crédito</h3>
    </div>
    <div class="modal-body">
        <span id="facturar-presupuesto-body"></span>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
        <!-- <a class="btn" href="<?php echo site_url('administrador/presupuesto') ?>">Aceptar</a>-->
        <button id="btn-nota-credito-ok" class="btn btn-primary">Aceptar</button>
    </div>
</div>

<!-- Modal - Factura OK  -->
<div class="modal hide fade" id="factura-ok-modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Nueva factura</h3>
    </div>
    <div class="modal-body">
        <span id="factura-ok-body"></span>
    </div>
    <div class="modal-footer">
        <a class="btn" href="<?php echo site_url('administrador/presupuesto') ?>">Aceptar</a>
    </div>
</div>

<!-- END PAGE -->
<?php $this->load->view('administrador/dashboard/footer_compra'); ?>

<script>
//var URL_SISTEMA = '/fenix/sistema';// VALIDO PARA LOCALHOST DESARROLLO
//var URL_SISTEMA = '/sistema'; // VALIDO PARA FENIX
var URL_SISTEMA = ''; // VALIDO PARA local.sistema.fenix.com

var artsSeleccionados =  [];

function borrarArticulo(k) {
    artsSeleccionados.splice(k, 1);
}
jQuery(document).ready(function() {
    EditableTable.init();

});

$(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true});

$('input:checkbox').click(function(){
    var objArticuloFactura;
    var $comprobante_nro = $(this).data('comprobante');
    var $articulo = $(this).data('articulo');
    var $oem = $(this).data('oem');
    var $cantidad = $(this).data('cantidad');
    var $precio = $(this).data('precio');
    var $descripcion = $(this).data('descripcion');
    
    objArticuloFactura = {
            comprobante: $comprobante_nro,
            articulo: $articulo,
            cantidad: $cantidad,
            precio: $precio,
            oem: $oem,
            descripcion: $descripcion
    };
    
    if ($(this).is(":checked")) {
        //Verifica si existe
        $.each(artsSeleccionados, function(k, v) {
            if (v.articulo === objArticuloFactura.articulo) {
                //Si existe lo borra
                artsSeleccionados.splice(k, 1);
                return false;
            }
        });
        //Si no existe lo agrega
        artsSeleccionados[artsSeleccionados.length] = objArticuloFactura; 
    } else {
        //Verifica que el comercio no esté seleccionado
        $.each(artsSeleccionados, function(k, v) {
            if (v.articulo === objArticuloFactura.articulo) {
                //Si existe lo borra    
                artsSeleccionados.splice(k, 1);
                return false;
            }
        });
    }
    
});

$('#btn-nota-credito').click(function() {
   
   var importeTotal = 0;
   var importeNeto = 0;
   var importeIva = 0;

   var msgHTML = '<div>¿Desea generar la NOTA DE CREDITO los siguientes items?</div>';
   if (artsSeleccionados.length === 0) {
       alert('Debe seleccionar artículos para realizar la NOTA DE CREDITO');
   } else {
        msgHTML += '<table class="table table-striped table-hover table-bordered">';
        msgHTML += '<thead>'
        msgHTML += '<tr>';
	msgHTML += '<th>Cod Fenix</th>';
	msgHTML += '<th>OEM</th>';
	msgHTML += '<th>Descripcion</th>';
	msgHTML += '<th>Cantidad</th>';
	msgHTML += '<th>Precio</th>';
        msgHTML += '</tr>';
        msgHTML += '</thead>';
        msgHTML += '<tbody>';
        $.each(artsSeleccionados, function(k, v){
            msgHTML += '<tr>';
            msgHTML += '<td>' + v.articulo + '</td>';
            msgHTML += '<td>' + v.oem + '</td>';
            msgHTML += '<td>' + v.descripcion + '</td>';
            msgHTML += '<td style="text-align:right">' + v.cantidad + '</td>';
            msgHTML += '<td style="text-align:right">' + v.precio + '</td>';
            msgHTML += '</tr>';
            importeTotal = importeTotal + (v.precio * v.cantidad);
        });
        msgHTML += '</tbody>';
        msgHTML += '</table>';
        msgHTML += '<div>Items a facturar: ' +  artsSeleccionados.length  + '</div>';
        msgHTML += '<div>Importe Neto: $ ' +  (importeTotal / 1.21).toFixed(2) + '</div>';
        msgHTML += '<div>Importe Iva(21%): $ ' +  ((importeTotal) - (importeTotal / 1.21)).toFixed(2)  + '</div>';
        msgHTML += '<div>Importe TOTAL: <b>$ ' +  importeTotal.toFixed(2)  + '</b></div>';
        $('#facturar-presupuesto-body').html(msgHTML);
        $('#facturar-presupuesto-modal').modal(); 
    }
});

$('#btn-nota-credito-ok').click(function(){
        $(this).attr('disabled', true);
        $(this).text('Generando....');
        
        
        var _tipo_cbte = <?php echo $comprobante[0]->tipo_cbte;?>;
       
        if (_tipo_cbte == 1) { //Factura A
            _tipo_cbte = 3; //NOTA CREDITO A
        } if (_tipo_cbte == 6) {  //Factura B
            _tipo_cbte = 8;//NOTA CREDITO B
        }

        var _punto_vta = <?php echo $comprobante[0]->punto_vta;?>;
        var _sucursal = <?php echo $comprobante[0]->sucursal;?>;
        var _cliente_id = <?php echo $comprobante[0]->cliente_id;?>;
        var _concepto = <?php echo $comprobante[0]->concepto;?>;
        var _doc_tipo = <?php echo $comprobante[0]->doc_tipo;?>;
        var _doc_nro = <?php echo $comprobante[0]->doc_nro;?>;
        var _condicion_venta_id = <?php echo $comprobante[0]->condicion_venta_id;?>;
                
        var uri = URL_SISTEMA + '/venta_controller/notaCredito';
        
        //Actualiza el costo
        $.ajax({
            url: uri,
            data: {
               punto_vta: _punto_vta,
               sucursal: _sucursal,
               cliente_id: _cliente_id,
               tipo_cbte: _tipo_cbte,
               concepto: _concepto,
               doc_tipo: _doc_tipo,
               doc_nro: _doc_nro,
               condicion_venta_id: _condicion_venta_id,
               articulos: artsSeleccionados
           },
            type: 'POST',
            success: function(data) {
                var datosJson = JSON.parse(data);
                var factura_nro = datosJson.factura_nro;
                //$(this).text('Facturar');
                $('#facturar-presupuesto-modal').modal('toggle');
                $('#btn-facturar-ok').text('Generar Nota de Credito');
                $('#btn-facturar-ok').attr('disabled', false);
                
                //Modal Factura OK
                $('#factura-ok-body').html("Nota de Credito Nro: " + factura_nro + " generada con éxito");
                $('#factura-ok-modal').modal();
            },
            error:function() {
                  $('#msg-modal-error').html("Error al generar Nota de Credito");
                  $('#modal-error').modal();
                  $(this).attr('disabled', false);
                  $(this).text('Facturar');
            }
        });
});
</script>