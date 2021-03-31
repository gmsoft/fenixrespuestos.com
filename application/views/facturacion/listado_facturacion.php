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
                        Listado de Facturas
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <div class="span12" style="margin-left: 0px;">
                <!-- BEGIN EXAMPLE TABLE widget-->
                <div class="widget red">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Facturas</h4>
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
                                            <select id="cliente" name="cliente" class="chzn-select-deselect" data-placeholder="Seleccione cliente" style="width:500px">
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
                                        <th>Fac.Nro</th>
                                        <th>Tipo</th>
                                        <th>Cliente</th>
										<th>CUIT</th>
                                        <th>Fecha</th>
                                        <th>Sucursal</th>
                                        <th>Items</th>
                                        <th>Imp Neto</th>
                                        <th>Imp Iva</th>
                                        <th>Imp Total</th>
                                        <th>CAE</th>
                                        <th>Observaciones</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $id_btn = 0;
                                    foreach($facturas as $v) {
                                        
                                        $id_btn =  $v->tipo_cbte . $v->punto_vta . $v->comprobante_nro;

                                        ?>
                                        <tr>
                                            <td style="text-align: right"><?php echo $v->comprobante_nro; ?></td>
                                            <td style="text-align: center"><?php echo $v->tipo_cbte_descripcion; ?></td>
                                            <td><?php echo $v->razon_social; ?></td>
											<td><?php echo $v->cuit; ?></td>
                                            <td style="text-align: center"><?php echo $v->fecha; ?></td>
                                            <td style="text-align: center"><?php echo $v->sucursal; ?></td>
                                            <td style="text-align: right"><?php echo $v->items; ?></td>
                                            <td style="text-align: right"><?php echo $v->importe_neto; ?></td>
                                            <td style="text-align: right"><?php echo $v->importe_iva; ?></td>
                                            <td style="text-align: right"><?php echo $v->importe_total; ?></td>
                                            <td style="text-align: right"><?php echo $v->cae_afip; ?></td>
                                            <td style="text-align: right"><?php echo $v->observaciones; ?></td>
                                            <td>
                                                <?php
                                                if ($v->cae_afip != '') {
                                                    //?cbte_nro=' + _cbte_nro + '&tipo_cbte=' + _tipo_cbte + '&punto_vta=' + _punto_vta;
                                                ?>
                                                <a target="_blank" class="btn btn-primary"
                                                   href="<?php echo site_url('venta_controller/factura_pdf/?cbte_nro=' . $v->comprobante_nro . '&tipo_cbte=' . $v->tipo_cbte . '&punto_vta=' . $v->punto_vta) ?>" title="Imprimir a PDF" ><i class="icon-print"></i></a>
                                                <button class="btn btn-info" onclick="enviarMail(this)" data-cbte-nro="<?php echo $v->comprobante_nro;?>" data-tipo-cbte="<?php echo $v->tipo_cbte;?>" data-punto-vta="<?php echo $v->punto_vta;?>"  data-email="<?php echo $v->email;?>"
                                                    title="Enviar por mail" ><i class="icon-envelope"></i></button>
                                                </button>
                                                <?php
                                                    if ($v->tipo_cbte!=3 && $v->tipo_cbte!=8) {    
                                                    ?>
                                                    <a href="<?php echo site_url('venta_controller/nota_credito/?cbte_nro=' . $v->comprobante_nro . '&tipo_cbte=' . $v->tipo_cbte . '&punto_vta=' . $v->punto_vta) ?>" class="btn" title="Nota de Credito">
                                                        <i class="icon-list"></i> N.Cr</a>

                                                    <?php
                                                    }
                                                } else {
                                                ?>
                                                <button onclick="solicitarCAE(this)" class="btn btn-default" data-cbte-nro="<?php echo $v->comprobante_nro;?>" data-tipo-cbte="<?php echo $v->tipo_cbte;?>" data-punto-vta="<?php echo $v->punto_vta;?>">
                                                    <i class="icon-list"></i> CAE AFIP
                                                </button>
                                                <button id="<?php echo $id_btn; ?>" onclick="anularCbteModal(this)" class="btn btn-danger" data-cbte-nro="<?php echo $v->comprobante_nro;?>" data-tipo-cbte="<?php echo $v->tipo_cbte;?>" data-punto-vta="<?php echo $v->punto_vta;?>">
                                                    Anular
                                                </button>
                                                <?php    
                                                }
                                                ?>
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

<!-- Modal - Solicitud de CAE -->
<div class="modal hide fade" id="solicitar-cae-modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Solicitud de CAE</h3>
    </div>
    <div class="modal-body">
        <span id="msg-cae"></span>
    </div>
    <div class="modal-footer">
        <a href="<?php echo site_url('administrador/listado_facturas') ?>" class="btn btn-primary" >Aceptar</a>
        
    </div>
</div>

<!-- Modal - Confirmar Anular -->
<div class="modal hide fade" id="anular-cbte-modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Anular Comprobante</h3>
    </div>
    <div class="modal-body">
        Desea anular el comprobante <span id="cbte-nro-anular-text"></span>?
    </div>
    <div class="modal-footer">
        <input type="hidden" id="cbte-nro-anular">
        <input type="hidden" id="cbte-tipo-anular">
        <input type="hidden" id="punto-vta-anular">
        <input type="hidden" id="btn-anular-id">
        <a href="#" class="btn btn-primary" id="btn-anular-cbte-ok">Aceptar</a>
        <button class="btn btn-default" data-dismiss="modal">Cancelar</button>
    </div>
</div>

<!-- END PAGE -->
<?php $this->load->view('administrador/dashboard/footer_listado'); ?>

<script>

//var URL_SISTEMA = '/fenix/sistema';// VALIDO PARA LOCALHOST DESARROLLO
//var URL_SISTEMA = '/sistema'; // VALIDO PARA FENIX
var URL_SISTEMA = ''; // VALIDO PARA local.sistema.fenix.com

jQuery(document).ready(function() {
    EditableTable.init();
    //data-cbte-nro="<?php echo $v->comprobante_nro;?>" data-tipo-cbte="<?php echo $v->tipo_cbte;?>" data-punto-vta="<?php echo $v->punto_vta;?>"

});

function anularCbteModal(btn) {
    
    var _cbte_nro = $(btn).attr('data-cbte-nro');
    var _tipo_cbte = $(btn).attr('data-tipo-cbte');
    var _punto_vta = $(btn).attr('data-punto-vta');
    var _btn_anular_id = $(btn).attr('id');

    $('#cbte-nro-anular').val(_cbte_nro);
    $('#cbte-tipo-anular').val(_tipo_cbte);
    $('#punto-vta-anular').val(_punto_vta);
    $('#btn-anular-id').val(_btn_anular_id);

    $('#cbte-nro-anular-text').html(_cbte_nro + ' del tipo ' + _tipo_cbte + ' para el punto de venta ' + _punto_vta);

    $('#anular-cbte-modal').modal();
}

$('#btn-anular-cbte-ok').click(anularCbte);

function anularCbte() {
            
    var _cbte_nro = $('#cbte-nro-anular').val();
    var _tipo_cbte = $('#cbte-tipo-anular').val();
    var _punto_vta = $('#punto-vta-anular').val();

    $('#btn-anular-cbte').attr('disabled', true);
    $('#btn-anular-cbte').text('Anulando...');

    $('#anular-cbte-modal').modal('hide');

    var uri = URL_SISTEMA + '/venta_controller/anular_comprobante';
    
    //
    $.ajax({
        url: uri,
        data: {cbte_nro:_cbte_nro, cbte_tipo: _tipo_cbte, punto_vta:_punto_vta},
        type: 'POST',
        success: function(data) {
            var datosJson = JSON.parse(data);
            var cbte_nro_anulado = datosJson.cbte_nro;
            var resultado = datosJson.resultado;
            console.log(resultado);
            
            $('#' + $('#btn-anular-id').val()).hide();

        },
        error: function(){
            $('#btn-anular-cbte').attr('disabled', false);
            $('#btn-anular-cbte').text('Anular');
        }
    });
}

function solicitarCAE(btn) {
         
    var _cbte_nro = $(btn).attr('data-cbte-nro');
    var _tipo_cbte = $(btn).attr('data-tipo-cbte');
    var _punto_vta = $(btn).attr('data-punto-vta');

    $(btn).attr('disabled', true);
    $(btn).text('Solicitando CAE...');

    var uri =  URL_SISTEMA + '/wsfe_controller/solicitar_cae';
    var pdfUri = URL_SISTEMA + '/venta_controller/factura_pdf/?cbte_nro=' + _cbte_nro + '&tipo_cbte=' + _tipo_cbte + '&punto_vta=' + _punto_vta;
   
    //
    $.ajax({
        url: uri,
        data: {cbte_nro:_cbte_nro, cbte_tipo: _tipo_cbte, punto_vta:_punto_vta},
        type: 'GET',
        success: function(data) {
            var datosJson = JSON.parse(data);
            var resultado = datosJson.Resultado;
            var msgRta = datosJson.MsgRta;
            var cae = datosJson.CAE;
            var errores = datosJson.Errores * 1;
            var observaciones = datosJson.Observaciones * 1;
            var msgErr = '';

            if (resultado == 'A') {
                
                $(btn).hide();
    

                $('#msg-cae').html(msgRta 
                    + '<br/>CAE:' + cae
                    + '<br/><a href="' +  pdfUri + '" class="btn btn-primary" target="_blank">Imprimir Factura</a>');
            } else {
                
                 $(btn).attr('disabled', false);
                 $(btn).text('CAE AFIP');

                if (errores == 1) {
                    msgErr += datosJson.Errores_Code + ' - ' + datosJson.Errores_Msg + '<br/>';    
                }

                if (observaciones == 1) {
                    msgErr += datosJson.Observaciones_Code + ' - ' + datosJson.Observaciones_Msg + '<br/>';     
                }

                $('#msg-cae').html(msgRta + '<br/>' + msgErr);
            }
            
            $('#solicitar-cae-modal').modal();
        },
        error: function(){
            alert('Error en llamada para solicitar CAE');
            $(btn).attr('disabled', false);
            $(btn).text('CAE AFIP');
        }
    });

}


function enviarMail(btn) {
    
    $(btn).text("Enviando e-mail");
    $(btn).attr('disabled', true);

    var _cbte_nro = $(btn).attr('data-cbte-nro');
    var _tipo_cbte = $(btn).attr('data-tipo-cbte');
    var _punto_vta = $(btn).attr('data-punto-vta');
    
    var _para = $(btn).attr('data-email');

    var uri = URL_SISTEMA + '/mail_controller/sendMail';
   
    //var pdfUri = '/venta_controller/factura_pdf/?cbte_nro=' + _cbte_nro + '&tipo_cbte=' + _tipo_cbte + '&punto_vta=' + _punto_vta + '&empresa_id=' + _empresa_id;
    
    var _msj = 'Estimado,<br/>Dejamos a su disposici&oacute;n el comprobante electrónico número ' + _cbte_nro ;
    _msj += '<br/><br/><a href="#">Descargar comprobante</a>';
    _msj += '<br/><br/>Atte.<br/><br/>FENIX SRL'; 

     $.ajax({
        url: uri,
        data: {para:_para, asunto: ' Nueva factura electrónica', mensaje: _msj},
        type: 'GET',
        success: function(data) {
            
            $(btn).attr('disabled', false);
            $(btn).text("OK");
                        
        },
        error: function() {
            $(btn).text("ERROR");
            alert('Error al enviar mail de comprobante')
        }
    });
}

$(".chzn-select").chosen(); 
$(".chzn-select-deselect").chosen({allow_single_deselect:true});

</script>