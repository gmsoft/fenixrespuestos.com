//var URL_SISTEMA = '/fenix/sistema';// VALIDO PARA LOCALHOST DESARROLLO
//var URL_SISTEMA = '/sistema'; // VALIDO PARA FENIX
var URL_SISTEMA = ''; // VALIDO PARA local.sistema.fenix.com

var EditableTable = function() {

    return {
        //main function to initiate the module
        init: function() {
            

            function restoreRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable.fnUpdate(aData[i], nRow, i, false);
                }

                oTable.fnDraw();
            }

            function editRow(oTable, nRow) {

                var aData = oTable.fnGetData(nRow);

                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML = '<input type="text" id="codfenix" class="input-medium" value="' + aData[0] + '">';
                jqTds[1].innerHTML = '<input type="text" id="oem" class="input-small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" id="descripcion" class="input-medium" value="' + aData[2] + '" readonly="readonly">';
                //jqTds[2].innerHTML = '<select name="testigo" id="testigo" style="width: 60px;"><option value="SI">SI</option><option value="NO" selected>NO</option></select>';
                jqTds[3].innerHTML = '<input name="testigo" id="testigo" type="text" style="width: 60px;" readonly="readonly">';
                jqTds[4].innerHTML = '<input type="number" id="cantidadped" style="width: 50px;" class="input-small" value="' + aData[4] + '">';
                jqTds[5].innerHTML = '<input type="text" id="precio" class="input-small" style="width: 70px;text-align:right" value="' + aData[5] + '">';
                jqTds[6].innerHTML = '<input type="text" id="dto1" class="input-small" style="width: 40px;text-align:right" value="' + aData[6] + '" >';
                jqTds[7].innerHTML = '<input type="text" id="dto2" class="input-small" style="width: 40px;text-align:right" value="' + aData[7] + '" >';
                jqTds[8].innerHTML = '<input type="text" id="dto3" class="input-small" style="width: 40px;text-align:right" value="' + aData[8] + '" >';
                jqTds[9].innerHTML = '<input type="text" id="rec1" class="input-small" style="width: 40px;text-align:right" value="' + aData[9] + '" >';
                jqTds[10].innerHTML = '<input type="text" id="importe" class="input-small" style="width: 70px;text-align:right" value="' + aData[10] + '" >';
                jqTds[11].innerHTML = '<a class="edit" id="guardar-articulo" href="">Guardar</a>';
                jqTds[12].innerHTML = '<a class="cancel" href="">Cancelar</a>';

                //$('#info-consulta').html('*');
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
                oTable.fnUpdate(jqInputs[5].value, nRow, 5, false);
                oTable.fnUpdate(jqInputs[6].value, nRow, 6, false);
                oTable.fnUpdate(jqInputs[7].value, nRow, 7, false);
                oTable.fnUpdate(jqInputs[8].value, nRow, 8, false);
                oTable.fnUpdate(jqInputs[9].value, nRow, 9, false);
                oTable.fnUpdate(jqInputs[10].value, nRow, 10, false);
                oTable.fnUpdate('<a class="edit" href="">Editar</a>', nRow, 11, false);
                oTable.fnUpdate('<a class="delete" data-art="' + jqInputs[0].value + '" href="">Borrar</a>', nRow, 12, false);
                oTable.fnDraw();

                //$('#editable-sample_new').click();
            }


            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate(jqInputs[4].value, nRow, 4, false);
                oTable.fnUpdate(jqInputs[5].value, nRow, 5, false);
                oTable.fnUpdate(jqInputs[6].value, nRow, 6, false);
                oTable.fnUpdate(jqInputs[7].value, nRow, 7, false);
                oTable.fnUpdate(jqInputs[8].value, nRow, 8, false);
                oTable.fnUpdate(jqInputs[9].value, nRow, 9, false);
                oTable.fnUpdate(jqInputs[10].value, nRow, 10, false);
                oTable.fnUpdate('<a class="edit" href="">Editar</a>', nRow, 11, false);
                oTable.fnDraw();
            }

            var oTable = $('#editable-sample').dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 5,
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ registros por pagina",
                    "oPaginate": {
                        "sPrevious": "Siguiente",
                        "sNext": "Anterior"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });

            //Agrega y muestra los articulos del Temp
            function cargarArticulosCarrito() {

                //limpiar grilla
                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);

                var uri = URL_SISTEMA + '/venta_controller/getArticulosCarrito';
                    
                    $.ajax({
                        url: uri,
                        type: 'GET',
                        success: function(data) {
                            var datosJson = JSON.parse(data);
                            var articulos = datosJson.articulos;
                            var importeTotal = datosJson.importe_total;
                            
                            $('#total-presupuesto').val(importeTotal);

                            var aiNew = oTable.fnAddData(['', '', '', '', '', '', '', '', '','',
                                '<a class="edit" href="">Editar</a>', '<a class="cancel" data-mode="new" href="">Cancelar</a>'
                                ]);
                            var nRow = oTable.fnGetNodes(aiNew[0]);
                            editRow(oTable, nRow);
                            nEditing = nRow;
                            $.each(articulos, function(k, v) {
                              
                                //Trae el dto base
                                var dto1_base = $('#dto1-base').val() * 1;
                                var dto2_base = $('#dto2-base').val() * 1;
                                var dto3_base = $('#dto3-base').val() * 1;
                                var rec1_base = $('#rec1-base').val() * 1;

                                $('#dto1').val(dto1_base);
                                $('#dto2').val(dto2_base);
                                $('#dto3').val(dto3_base);
                                $('#rec1').val(rec1_base);

                                $('#codfenix').focus();
                                
                                $('#codfenix').val(v.codfenix);
                                $('#oem').val(v.oem);
                                $('#cantidadped').val(v.cantidad);
                                $('#precio').val(v.precio);
                                $('#importe').val(v.importe);

                                //Guarda
                                //var nRow = $(this).parents('tr')[0];
                                saveRow(oTable, nEditing);
                                nEditing = null;
                                $('#editable-sample_new').click();

                            });
                            
                        }
                });
            }


            jQuery('#editable-sample_wrapper .dataTables_filter input').addClass(" medium"); // modify table search input
            jQuery('#editable-sample_wrapper .dataTables_length select').addClass(" xsmall"); // modify table per page dropdown

            var nEditing = null;
            
            $('#editable-sample_new').click(function(e) {
                e.preventDefault();
                
                var cliente = $('#cliente').val();
                var sucursal = $('#sucursal').val();
                //Validaciones
                //if (cliente  === '' || sucursal === '') {
                if (sucursal === '') {
                    //if(cliente === '') {
                        $('#msg-modal-error').html("Debe seleccionar un cliente");
                    //} else if(sucursal === '') {
                    if(sucursal === '') {
                        $('#msg-modal-error').html("Debe seleccionar una sucursal");
                    }                    
                    $('#modal-error').modal();
                    
                } else {
                    var aiNew = oTable.fnAddData(['', '', '', '', '', '', '', '', '','','',
                    '<a class="edit" href="">Editar</a>', '<a class="cancel" data-mode="new" href="">Cancelar</a>'
                    ]);
                    var nRow = oTable.fnGetNodes(aiNew[0]);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                    //Trae el dto base
                    var dto1_base = $('#dto1-base').val() * 1;
                    var dto2_base = $('#dto2-base').val() * 1;
                    var dto3_base = $('#dto3-base').val() * 1;
                    var rec1_base = $('#rec1-base').val() * 1;

                    $('#dto1').val(dto1_base);
                    $('#dto2').val(dto2_base);
                    $('#dto3').val(dto3_base);
                    $('#rec1').val(rec1_base);

                    $('#codfenix').focus();
                }
            });
            
            $('#factura-nro').blur(function(){
                var factura = $(this).val();
                if (factura  === '') {
                    alert('Ingrese el nro de Factura');
                    $('#factura-nro').focus();
                } 
            });

            $('#editable-sample a.delete').live('click', function(e) {
                e.preventDefault();

                if (confirm("Desea borrar el registro ?") == false) {
                    return;
                }

                var _cliente = $('#cliente').val();
                var _art = $(this).attr('data-art');

                var appName = location.pathname.split('/')[1];

                var uri = URL_SISTEMA + '/venta_controller/borrarArticuloPresupuesto';
                
                //Borrar el articulo
                $.ajax({
                    url: uri,
                    data: {cliente: _cliente, articulo: _art},
                    type: 'POST',
                    success: function(data) {
                        var datosJson = JSON.parse(data);
                        $('#info-consulta').html(" Articulo "  + _art + " borrado del presupuesto");
                        $('#items-presupuesto').val(datosJson.items);

                        var flete = $('#importe-flete').val() * 1;
                        var totalPresupuesto = datosJson.importe * 1;
                        var importeTotPresupuesto = totalPresupuesto + flete; 
                        $('#total-presupuesto').val(totalPresupuesto.toFixed(2));
                        $('#total-presupuesto-flete').val(importeTotPresupuesto.toFixed(2));
                    }
                });


                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);
                //alert("Deleted! Do not forget to do some ajax to sync with backend :)");
            });

            $('#editable-sample a.cancel').live('click', function(e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);

                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });

            $('#editable-sample a.edit').live('click', function(e) {
                e.preventDefault();

                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];

                if (nEditing !== null && nEditing != nRow) {

                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                    
                } else if (nEditing == nRow && this.innerHTML == "Guardar") {
                    var _codfenix = $('#codfenix').val();
                    var _oem = $('#oem').val();
                    var _fecha = $('#fecha-presupuesto').val();
                    var _concepto = $('#concepto').val();
                    var _precio = $('#precio').val();
                    var _cantidadped = $('#cantidadped').val();
                    var _sucursal = $('#sucursal').val();
                    var _cliente = $('#cliente').val();
                    var _compania = $('#compania').val();
                    var _perito = $('#perito').val();
                    var _vehiculo = $('#vehiculo').val();
                    var _motor = $('#nro-motor').val();
                    var _chasis = $('#nro-chasis').val();
                    var _siniestro = $('#siniestro').val();
                    var _observaciones = $('#observaciones').val();

                    var _modelo_ano = $('#modelo-ano').val();
                    var _importe_flete = $('#importe-flete').val();
                    var _destino_flete = $('#destino-flete').val();
                    var _patente = $('#patente').val();

                    var _dto1 = $('#dto1').val() * 1;
                    var _dto2 = $('#dto2').val() * 1;
                    var _dto3 = $('#dto3').val() * 1;
                    var _rec1 = $('#rec1').val() * 1;
                    
                    /* Editing this row and want to save it */
                    saveRow(oTable, nEditing);
                    nEditing = null;

                    var uri = URL_SISTEMA + '/venta_controller/guardarArtPresupuesto';
                    
                    //Actualiza el costo
                    $.ajax({
                        url: uri,
                        data: {fecha: _fecha, codfenix: _codfenix, oem: _oem,
                            precio: _precio, cantidadped: _cantidadped,
                            cliente: _cliente, sucursal: _sucursal, compania: _compania,
                            perito: _perito, vehiculo: _vehiculo, motor: _motor, 
                            chasis: _chasis, siniestro: _siniestro, observaciones: _observaciones, 
                            concepto: _concepto, dto1: _dto1, dto2: _dto2, dto3: _dto3, rec1: _rec1,
                            modelo_ano:_modelo_ano, importe_flete:_importe_flete, destino_flete:_destino_flete,
                            patente:_patente},
                        type: 'POST',
                        success: function(data) {
                            var datosJson = JSON.parse(data);
                            $('#info-consulta').html(datosJson.mensaje);
                            //$('#info-ocompra').html('');
                            $('#items-presupuesto').val(datosJson.items);
                            
                            //Flete
                            var flete = $('#importe-flete').val() * 1;
                            var totalPresupuesto = datosJson.importe * 1;
                            var importeTotPresupuesto = totalPresupuesto + flete; 
                            $('#total-presupuesto').val(totalPresupuesto.toFixed(2));
                            $('#total-presupuesto-flete').val(importeTotPresupuesto.toFixed(2));
                            
                            if (datosJson.actualiza == false){ 
                                $('#editable-sample_new').click();
                            }
                        }
                    });
                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });

            //Busca datos del costo
            $('#oem').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {
                    var _codfenix = $('#codfenix').val();
                    var _oem = $('#oem').val();
                    
                    $('#cantidadped').focus();
                    $('#cantidadped').select();
                }
            });

            $('#dto1-base').live("change", function(e) {
                $('#dto1').val($(this).val());
            });

            $('#dto2-base').live("change", function(e) {
                $('#dto2').val($(this).val());
            });

            $('#dto3-base').live("change", function(e) {
                $('#dto3').val($(this).val());
            });

            $('#rec1-base').live("change", function(e) {
                $('#rec1').val($(this).val());
            });

             $('#dto1').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {
                    $('#dto2').focus();
                    $('#dto2').select();
                }
            });

            $('#dto2').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {
                    $('#dto3').focus();
                    $('#dto3').select();
                }
            });

            $('#dto3').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {
                    $('#rec1').focus();
                    $('#rec1').select();
                }
            });

            $('#rec1').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {
                    $('#importe').focus();
                    $('#importe').select();
                }
            });

            $('#cantidadped').live("keypress", function(e) {
                if (e.keyCode === 13) {
                    var cantidad = $('#cantidadped').val() * 1;
                    
                    //Si viaja cero le carga uno
                    if (cantidad === 0) {
                        cantidad = 1;
                        $('#cantidadped').val(cantidad);
                    }
                    
                    if (cantidad === 0) {
                        $('#info-consulta').attr('class', 'label label-warning');
                        $('#info-consulta').html('Cantidad Incorrecta');
                        $('#cantidadped').val('');
                    } else {
                        $('#info-consulta').attr('class', 'label label-success');
                        //$('#info-consulta').html('');
                        $('#importe').val(getImporte());
                        $('#precio').focus();
                    }
                }
            });
            

            //Tecla Enter
            $('#codfenix').live("keypress", function(e) {
               
                if (e.keyCode === 13) {

                    var _codfenix = $('#codfenix').val();
                    var _sucursal = $('#sucursal').val();
                    //var uri = '/venta_controller/buscarArticulo'; 5
                    var uri = URL_SISTEMA + '/venta_controller/buscarArticulo';

                    $.ajax({
                        url: uri,
                        data: {codfenix: _codfenix, sucursal: _sucursal},
                        type: 'POST',
                        success: function(data) {
                            var datosJson = JSON.parse(data);
                            var error = datosJson.err * 1;
                            
                            //Si es un articulo no existente
                            if (error === 1) {
                                /*
                                $('#codfenix').val('');
                                $('#codfenix').focus();
                                $('#info-consulta').attr('class', 'label label-warning');
                                $('#info-consulta').html(datosJson.msg_err);
                                $('#precio').val('');
                                $('#oem').val('');
                                $('#info-ocompra').html('');
                                */

                                $('#descripcion').val('');
                                $('#btn-buscar').click();
                                 var codfenix = $('#codfenix').val();
                                $('#articulo-modal').val(codfenix);
                            } else {
                                $('#descripcion').val(datosJson.descripcion);
                                $('#info-consulta').attr('class', 'label label-info');
                                $('#info-consulta').html('<h5>' + datosJson.descripcion + ' <u>STOCK:</u> ' + datosJson.stock + '</h5>');
                                $('#precio').val(datosJson.precio_lista);
                                $('#oem').val(datosJson.oem);
                                
                            }
                        }
                    });
                    $('#oem').focus();
                    return false;
                }
            });

            $('#precio').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {
                    var costo = $('#precio').val() * 1;
                    if (costo === 0) {
                        $('#info-consulta').attr('class', 'label label-warning');
                        $('#info-consulta').html('Costo Incorrecta');
                    } else {
                        $('#info-consulta').attr('class', 'label label-success');
                        //$('#info-consulta').html('');
                        $('#importe').val(getImporte());
                        $('#importe').focus();
                    }                    
                }
            });
            
            $('#importe').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {
                    $('#guardar-articulo').click(); //  handles submit buttons
                    return false;
                }
            });
            
            //Guarda la orden de compra
            $('#guardar-presupuesto').click(function() {
                
                var _cliente = $('#cliente').val();
                var _sucursal = $('#sucursal').val();
                var _cond_venta = $('#cond-venta').val();

                var _fecha = $('#fecha-presupuesto').val();
                var _concepto = $('#concepto').val();
                
                var _sucursal = $('#sucursal').val();
                var _cliente = $('#cliente').val();
                var _compania = $('#compania').val();
                var _perito = $('#perito').val();
                var _vehiculo = $('#vehiculo').val();
                var _motor = $('#nro-motor').val();
                var _chasis = $('#nro-chasis').val();
                var _siniestro = $('#siniestro').val();
                var _observaciones = $('#observaciones').val();

                var _modelo_ano = $('#modelo-ano').val();
                var _importe_flete = $('#importe-flete').val();
                var _destino_flete = $('#destino-flete').val();
                var _patente = $('#patente').val();
/*
                var _dto1 = $('#dto1').val() * 1;
                var _dto2 = $('#dto2').val() * 1;
                var _dto3 = $('#dto3').val() * 1;
                var _rec1 = $('#rec1').val() * 1;
                    
  */                               
                //Validaciones
                if (_cliente  === '' || _sucursal === '') {
                    if(_cliente === '') {
                        $('#msg-modal-error').html("Debe seleccionar un cliente");
                    } else if(_sucursal === '') {
                        $('#msg-modal-error').html("Debe seleccionar una sucursal");
                    }                    
                    $('#modal-error').modal();
                    
                } else {

                    $(this).attr('disabled', true);
                    $(this).text('Guardando....');
                    
                    var uri = URL_SISTEMA + '/venta_controller/guardarPresupuesto';                    
                    var pdfUri = URL_SISTEMA + '/venta_controller/presupuesto_pdf/';
                    
                    //
                    $.ajax({
                        url: uri,
                        //data: {cliente:_cliente, sucursal: _sucursal, cond_venta: _cond_venta},
                        data: {
                                fecha: _fecha, 
                                cliente: _cliente,
                                sucursal: _sucursal,
                                compania: _compania,
                                perito: _perito,
                                vehiculo: _vehiculo,
                                motor: _motor, 
                                chasis: _chasis,
                                siniestro: _siniestro,
                                observaciones: _observaciones, 
                                concepto: _concepto,
                                //dto1: _dto1, dto2: _dto2, dto3: _dto3, rec1: _rec1,
                                modelo_ano:_modelo_ano,
                                importe_flete:_importe_flete,
                                destino_flete:_destino_flete, 
                                patente:_patente, 
                                cond_venta: _cond_venta
                            },
                        type: 'POST',
                        success: function(data) {
                            var datosJson = JSON.parse(data);
                            
                            if (datosJson.err == false) {
                                $('#msg-presupuesto').html(datosJson.mensaje 
                                        + '<br/>Items:' + datosJson.items 
                                        + '<br/><b>Importe:' + datosJson.importe_total + '</b>'
                                        + '<br/><br/><a href="'  + pdfUri + datosJson.presupuesto_nro + '" class="btn" target="_blank">Imprimir PDF</a>');
                                
                                $('#presupuesto-guardado-modal').modal();
                                $('#guardar-presupuesto').hide();

                            } else {

                                $('#msg-modal-error').html(datosJson.mensaje);
                                $('#guardar-presupuesto').attr('disabled', false);
                                $('#guardar-presupuesto').text('Guardar presupuesto');
                                $('#modal-error').modal();
                            }
                        },
                        error: function(){
                             $('#guardar-presupuesto').attr('disabled', false);
                             $('#guardar-presupuesto').text('Guardar presupuesto');

                            $('#msg-modal-error').html("Error al guardar presupuesto");
                            $('#modal-error').modal();
                        }
                    });
                }
            });
            
            $('#cliente').on('change',function(){
                var cliente_id = $(this).val();
                var serviceUrl =  URL_SISTEMA + '/customer_controller/get_cliente';

                $.ajax({
                    type: 'POST',
                    url: serviceUrl,
                    data: {cliente : cliente_id}
                }).done(function (data) {
                    
                    var datosJson = JSON.parse(data);
                    $('#domicilio-cliente').val(datosJson.domicilio);
                    //cargarArticulosCarrito();
                    
                }).error(function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText || textStatus);
                });
            });

            var locactionHref = window.location.href;
            if (locactionHref.indexOf('carrito') != -1) {
                cargarArticulosCarrito();
            }


            /*
            Buscador dentro del popup
            */
            $('#btn-buscar-popup').click(function() {
                 
                 var serviceUrl =  URL_SISTEMA + '/articulo_controller/consulta_articulos_modal';
                 var _articulo = $('#articulo-modal').val();
                 var _oem = $('#oem-modal').val();
                 var _descripcion = $('#descripcion-modal').val();

                 $('#btn-buscar-popup').text('Buscando...');
                 $('#btn-buscar-popup').attr('disabled',true);
                 $('#resultado-busqueda-modal').html('<tr><td colspan="4">Buscando...</td></tr>');

                 $.ajax({
                    type: 'POST',
                    url: serviceUrl,
                    data: {articulo : _articulo, oem : _oem, descripcion : _descripcion}
                 }).done(function (data) {
                    
                    var datosJson = JSON.parse(data);
                    var htmlTable = '';

                    $.each(datosJson, function(k, v) {
                        htmlTable+= '<tr>';
                        htmlTable+= '<td><a href="#" onclick="seleccionarArticulo(\'' + v.codigo_fenix  + '\', \'codfenix\')">' + v.codigo_fenix + '</a></td>';
                        htmlTable+= '<td>' + v.codigo_oem + '</td>';
                        htmlTable+= '<td>' + v.descripcion + '</td>';
                        htmlTable+= '<td style="text-align:right">' + v.precio_lista + '</td>';    
                        htmlTable+= '</tr>';
                    });
                    
                    $('#resultado-busqueda-modal').html(htmlTable);
                    
                    $('#btn-buscar-popup').text('Buscar');
                    $('#btn-buscar-popup').attr('disabled', false);
                    
                 }).error(function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText || textStatus);
                    $('#btn-buscar-popup').text('Buscar');
                    $('#btn-buscar-popup').attr('disabled', false);
                 });
            });

            $('#articulo-modal').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {
                     $('#btn-buscar-popup').click();                                       
                }
            });

            $('#oem-modal').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {
                     $('#btn-buscar-popup').click();                                       
                }
            });

            $('#descripcion-modal').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {
                     $('#btn-buscar-popup').click();                                       
                }
            });

            $('#importe-flete').blur(function() {
                var importeFlete = $('#importe-flete').val() * 1;
                var totalPresupuesto = $('#total-presupuesto').val() * 1;
                var totalMasFlete = totalPresupuesto + importeFlete;
                $('#total-presupuesto-flete').val(totalMasFlete.toFixed(2));
            });

            //Realiza la facturacion directa
            $('#guardar-factura').click(function() {
                
                var _cliente = $('#cliente').val();
                var _sucursal = $('#sucursal').val();
                var _cond_venta = $('#cond-venta').val();

                var _fecha = $('#fecha-presupuesto').val();
                var _concepto = $('#concepto').val();
                
                var _compania = $('#compania').val();
                var _perito = $('#perito').val();
                var _vehiculo = $('#vehiculo').val();
                var _motor = $('#nro-motor').val();
                var _chasis = $('#nro-chasis').val();
                var _siniestro = $('#siniestro').val();
                var _observaciones = $('#observaciones').val();

                var _modelo_ano = $('#modelo-ano').val();
                var _importe_flete = $('#importe-flete').val();
                var _destino_flete = $('#destino-flete').val();
                var _patente = $('#patente').val();

                //
                //Cobranza
                //
                var _cobranza = [];
                var _cond_venta_id = $('#cond-venta').val();
                var _empresa_tarjeta_id = 0;
                var _tarjeta_plan_id = 0;
                var _dni_titular = 0;
                var _nombre_titular = '';
                var _telefono = '';
                var _codigo_autorizacion = 0;
                //Cheque
                var _banco = 0;
                var _nroCheque = 0;
                var _fechaCobro = '';
                var _fechaCobroArray;
                var _importeCheque = 0;


                //Tarjeta de Credito
                $.each(formaPagoTarjetaCredito, function(k, v) {    
                    _empresa_tarjeta_id = v.empresa;
                    _tarjeta_plan_id = v.plan_pago;
                    _dni_titular = v.dni;
                    _nombre_titular = v.titular;
                    _telefono = v.telefono;
                    _codigo_autorizacion = v.codigo_autorizacion;
                });

                 //Tarjeta de Debito
                $.each(formaPagoTarjetaDebito, function(k, v) {    
                    _empresa_tarjeta_id = v.empresa;
                    _dni_titular = v.dni;
                    _nombre_titular = v.titular;
                    _telefono = v.telefono;
                    _codigo_autorizacion = v.codigo_autorizacion;
                });

                //Cheque
                $.each(formaPagoCheque, function(k, v) {    
                    _banco = v.banco;
                    _nroCheque = v.nroCheque;
                    _fechaCobroArray = v.fechaCobro.split('/');
                    _fechaCobro = _fechaCobroArray[2] + '-' + _fechaCobroArray[1] + '-' + _fechaCobroArray[0];
                    _importeCheque = v.importe;
                });

                var _datosCobranza = {
                    cond_venta_id : _cond_venta_id,
                    empresa_tarjeta_id : _empresa_tarjeta_id,
                    tarjeta_plan_id: _tarjeta_plan_id,
                    dni_titular: _dni_titular,
                    nombre_titular: _nombre_titular,
                    telefono_titular: _telefono,
                    codigo_autorizacion: _codigo_autorizacion,
                    nro_cheque: _nroCheque,
                    banco_id : _banco,
                    fecha_cobro: _fechaCobro,
                    importe: _importeCheque
                }

                _cobranza.push(_datosCobranza);

                //Validaciones
                if (_cliente  === '' || _sucursal === '') {
                    if(_cliente === '') {
                        $('#msg-modal-error').html("Debe seleccionar un cliente");
                    } else if(_sucursal === '') {
                        $('#msg-modal-error').html("Debe seleccionar una sucursal");
                    }                    
                    $('#modal-error').modal();
                    
                } else {

                    $(this).attr('disabled', true);
                    $(this).text('Facturando...');
                    
                    var uri = URL_SISTEMA + '/venta_controller/facturaDirecta';
                    //
                    $.ajax({
                        url: uri,
                        data: {cliente:_cliente, sucursal: _sucursal, cond_venta: _cond_venta, cobranza: _cobranza,
                        fecha:_fecha, concepto: _concepto, compania: _compania, perito: _perito,
                        vehiculo: _vehiculo, motor : _motor, chasis: _chasis, siniestro: _siniestro,
                        observaciones: _observaciones, modelo_ano: _modelo_ano, importe_flete: _importe_flete,
                        destino_flete: _destino_flete, patente: _patente},
                        type: 'POST',
                        success: function(data) {
                            var datosJson = JSON.parse(data);
                            if (datosJson.error == false) {
                                $('#msg-presupuesto').html(datosJson.mensaje);
                                $('#presupuesto-guardado-modal').modal();
                            } else {                                
                                $('#guardar-factura').attr('disabled', false);
                                $('#guardar-factura').text('Guardar factura');
                                $('#msg-modal-error').html(datosJson.mensaje);
                                $('#modal-error').modal();
                            }                            
                        },
                        error: function(){
                            $('#msg-modal-error').html("Error al facturar");
                            $('#modal-error').modal();

                            $('#guardar-factura').attr('disabled', false);
                            $('#guardar-factura').text('Guardar factura');
                        }
                    });
                }
            });
            
            function getImporte() {
                    var cantidad = $('#cantidadped').val() * 1;
                    var precio = $('#precio').val() * 1;
                    var dto1 = $('#dto1').val() * 1;
                    var dto2 = $('#dto2').val() * 1;
                    var dto3 = $('#dto3').val() * 1;
                    var rec1 = $('#rec1').val() * 1;
                    var importe = 0;
                    
                    precio = precio * (1 - (dto1/100)) * (1 - (dto2/100)) * (1 - (dto3/100));
                    precio = precio / (1 - (rec1/100));
                    importe = precio * cantidad;
                    return importe.toFixed(2);
            }

            
        }
    };

}();

