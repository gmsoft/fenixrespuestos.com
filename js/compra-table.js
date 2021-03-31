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
                jqTds[0].innerHTML = '<input type="text" id="cod-fenix" class="input-medium" value="' + aData[0] + '">';
                jqTds[1].innerHTML = '<input type="text" id="interno" class="input-small" value="' + aData[1] + '">';
                //jqTds[2].innerHTML = '<select name="testigo" id="testigo" style="width: 60px;"><option value="SI">SI</option><option value="NO" selected>NO</option></select>';
                jqTds[2].innerHTML = '<input name="testigo" id="testigo" type="text" style="width: 60px;" readonly="readonly">';
                jqTds[3].innerHTML = '<input type="number" id="cantidadped" style="width: 50px;" class="input-small" value="' + aData[3] + '">';
                jqTds[4].innerHTML = '<input type="text" id="costo" class="input-small" style="width: 70px;text-align:right" value="' + aData[4] + '">';
                jqTds[5].innerHTML = '<input type="text" id="dto1" class="input-small" style="width: 40px;text-align:right" value="' + aData[5] + '" readonly="readonly">';
                jqTds[6].innerHTML = '<input type="text" id="dto2" class="input-small" style="width: 40px;text-align:right" value="' + aData[6] + '" readonly="readonly">';
                jqTds[7].innerHTML = '<input type="text" id="dto3" class="input-small" style="width: 40px;text-align:right" value="' + aData[7] + '" readonly="readonly">';
                jqTds[8].innerHTML = '<input type="text" id="rec1" class="input-small" style="width: 40px;text-align:right" value="' + aData[8] + '" readonly="readonly">';
                jqTds[9].innerHTML = '<input type="text" id="importe" class="input-small" style="width: 70px;text-align:right" value="' + aData[9] + '" readonly="readonly">';
                jqTds[10].innerHTML = '<a class="edit" id="guardar-articulo" href="">Guardar</a>';
                jqTds[11].innerHTML = '<a class="cancel" href="">Cancelar</a>';

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
                oTable.fnUpdate('<a class="edit" href="">Editar</a>', nRow, 10, false);
                oTable.fnUpdate('<a class="delete" href="">Borrar</a>', nRow, 11, false);
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
                oTable.fnUpdate('<a class="edit" href="">Editar</a>', nRow, 10, false);
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

            jQuery('#editable-sample_wrapper .dataTables_filter input').addClass(" medium"); // modify table search input
            jQuery('#editable-sample_wrapper .dataTables_length select').addClass(" xsmall"); // modify table per page dropdown

            var nEditing = null;
            
            $('#editable-sample_new').click(function(e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '', '', '', '', '', '','',
                    '<a class="edit" href="">Editar</a>', '<a class="cancel" data-mode="new" href="">Cancelar</a>'
                ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
                $('#cod-fenix').focus();
            });

            $('#editable-sample a.delete').live('click', function(e) {
                e.preventDefault();

                if (confirm("Desea borrar el registro ?") == false) {
                    return;
                }

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

                    var _proveedor = $('#proveedor').val();
                    
                    var _fecha_oc = $('#fecha-oc').val();
                    
                    var _codfenix = $('#cod-fenix').val();
                    var _interno = $('#interno').val();
                    var _testigo = $('#testigo').val();
                    var _moneda = $('#moneda').val();
                    var _costo = $('#costo').val();
                    var _cantidadped = $('#cantidadped').val();
                    //var _costo_lista = $('#costo-lista').val();
                    var _descripcion_lista = $('#descripcion-lista').val();
                    var _dto1 = $('#dto1').val();
                    var _dto2 = $('#dto2').val();
                    var _dto3 = $('#dto3').val();
                    var _rec1 = $('#rec1').val();
                    var _sucursal = $('#sucursal').val();

                    /* Editing this row and want to save it */
                    saveRow(oTable, nEditing);
                    nEditing = null;

                    var uri = URL_SISTEMA +  '/compra_controller/guardarArtOcompra';
                    
                    //Actualiza el costo
                    $.ajax({
                        url: uri,
                        data: {proveedor: _proveedor, fecha: _fecha_oc, codfenix: _codfenix, interno: _interno, costo: _costo, cantidadped: _cantidadped, dto1: _dto1, dto2: _dto2, dto3: _dto3, rec1: _rec1, moneda: _moneda, testigo: _testigo, descripcion_lista: _descripcion_lista, sucursal: _sucursal},
                        type: 'POST',
                        success: function(data) {
                            var datosJson = JSON.parse(data);
                            $('#info-consulta').html(datosJson.mensaje);
                            $('#items-orden').val(datosJson.items);
                            $('#total-orden').val(datosJson.importe_total);
                            
                            $('#editable-sample_new').click();
                        }
                    });
                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });

            //Busca datos del costo
            $('#interno').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {

                    var _proveedor = $('#proveedor').val();
                    var _codfenix = $('#cod-fenix').val();
                    var _interno = $('#interno').val();

                    var uri = URL_SISTEMA +  '/compra_controller/buscarCosto';
                    

                    $.ajax({
                        url: uri,
                        data: {proveedor: _proveedor, codfenix: _codfenix, interno: _interno},
                        type: 'POST',
                        success: function(data) {
                            var datosJson = JSON.parse(data);
                            var error = datosJson.err * 1;
                            //Si es un articulo no existente
                            if (error === 1) {
                                $('#cod-fenix').val('');
                                $('#interno').val('');
                                $('#testigo').val('');
                                $('#cod-fenix').focus();
                                $('#info-consulta').attr('class', 'label label-warning');
                                $('#info-consulta').html(datosJson.msg_err);
                            } else {

                                $('#info-consulta').attr('class', 'label label-success');
                                $('#info-consulta').html(datosJson.descripcion_lista + ' // Costo Lista: ' + datosJson.precio_lista + ' // Marca:' + datosJson.marca_lista);

                                $('#costo').val(datosJson.costo);
                                $('#dto1').val(datosJson.dto1);
                                $('#dto2').val(datosJson.dto2);
                                $('#dto3').val(datosJson.dto3);
                                $('#rec1').val(datosJson.rec1);
                                $('#utilidad').val(datosJson.utilidad);
                                if ($('#cod-fenix').val() === '') {
                                    $('#cod-fenix').val(datosJson.codigofenix);
                                }

                                var testigo = datosJson.testigo;

                                if (testigo !== '') {
                                    $('#testigo').val(testigo);
                                } else {
                                    $('#testigo').val('NO');
                                }

                                $('#descripcion-lista').val(datosJson.descripcion_lista);
                                $('#marca-lista').val(datosJson.marca_lista);
                                $('#costo-lista').val(datosJson.precio_lista);

                                $('#cantidadped').focus();
                                $('#cantidadped').select();
                            }
                        }
                    });
                }

            });

            $('#cantidadped').live("keypress", function(e) {
                if (e.keyCode === 13) {
                    var cantidad = $('#cantidadped').val() * 1;
                    
                    if (cantidad === 0) {
                        $('#info-consulta').attr('class', 'label label-warning');
                        $('#info-consulta').html('Cantidad Incorrecta');
                        $('#cantidadped').val('');
                    } else {
                        $('#info-consulta').attr('class', 'label label-success');
                        $('#info-consulta').html('');
                        $('#importe').val(getImporte());
                        $('#costo').focus();
                    }
                }
            });
            
            $('#costo').live("change", function() {
                    
            });

            //Tecla Enter
            $('#cod-fenix').live("keypress", function(e) {
               
                if (e.keyCode === 13) {

                    var _codfenix = $('#cod-fenix').val();
                    var _proveedor = $('#proveedor').val();
                    var _sucursal = $('#sucursal').val();
                    var uri = URL_SISTEMA + '/compra_controller/buscarArticuloCosto';

                    $.ajax({
                        url: uri,
                        data: {codfenix: _codfenix, proveedor: _proveedor, sucursal:_sucursal},
                        type: 'POST',
                        success: function(data) {
                            var datosJson = JSON.parse(data);

                            var error = datosJson.err * 1;
                            //Si es un articulo no existente
                            if (error === 1) {
                                $('#cod-fenix').val('');
                                $('#cod-fenix').focus();
                                $('#info-consulta').attr('class', 'label label-warning');
                                $('#info-consulta').html(datosJson.descripcion);
                            } else {
                                $('#info-consulta').attr('class', 'label label-success');
                                $('#info-consulta').html(datosJson.descripcion);
                                $('#interno').val(datosJson.interno_proveedor);
                                $('#costo').val(datosJson.costo);
                                $('#dto1').val(datosJson.dto1);
                                $('#dto2').val(datosJson.dto2);
                                $('#dto3').val(datosJson.dto3);
                                $('#rec1').val(datosJson.rec1);
                                $('#utilidad').val(datosJson.utilidad);

                                var testigo = datosJson.testigo;
                                if (testigo !== '' && testigo !== undefined) {
                                    $('#testigo').val(testigo);
                                } else {
                                    $('#testigo').val('NO');
                                }
                            }
                        }
                    });
                    $('#interno').focus();
                    return false;
                }
            });

            $('#costo').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode === 13) {
                    var costo = $('#costo').val() * 1;
                    if (costo === 0) {
                        $('#info-consulta').attr('class', 'label label-warning');
                        $('#info-consulta').html('Costo Incorrecta');
                    } else {
                        $('#info-consulta').attr('class', 'label label-success');
                        $('#info-consulta').html('');
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
            $('#guardar-orden').click(function() {
                
                var _proveedor = $('#proveedor').val();
                var _sucursal = $('#sucursal').val();
                
                var uri = URL_SISTEMA +  '/compra_controller/guardarOcompra';
                
                //
                $.ajax({
                    url: uri,
                    data: {proveedor:_proveedor, sucursal: _sucursal},
                    type: 'POST',
                    success: function(data) {
                        var datosJson = JSON.parse(data);
                        $('#msj-ocompra').html(datosJson.mensaje 
                                + '<br>Items:' + datosJson.items 
                                + '<br>Importe:' + datosJson.importe_total);
                        $('#orden-guardada-modal').modal();
                    }
                });
            });
            
            //Guarda la orden de compra
            $('#guardar-orden').click(function() {
                
                var _proveedor = $('#proveedor').val();
                var _sucursal = $('#sucursal').val();
                
                var uri = URL_SISTEMA +  '/fenix/sistema/compra_controller/guardarOcompra';
                
                //
                $.ajax({
                    url: uri,
                    data: {proveedor:_proveedor, sucursal: _sucursal},
                    type: 'POST',
                    success: function(data) {
                        var datosJson = JSON.parse(data);
                        $('#msj-ocompra').html(datosJson.mensaje 
                                + '<br>Items:' + datosJson.items 
                                + '<br>Importe:' + datosJson.importe_total);
                        $('#orden-guardada-modal').modal();
                    }
                });
            });
            
            function getImporte() {
                    var cantidad = $('#cantidadped').val() * 1;
                    var costo = $('#costo').val() * 1;
                    var dto1 = $('#dto1').val() * 1;
                    var dto2 = $('#dto2').val() * 1;
                    var dto3 = $('#dto3').val() * 1;
                    var rec1 = $('#rec1').val() * 1;
                    var importe = 0;
                    
                    var precio = costo * (1 - (dto1/100))* (1 - (dto2/100))* (1 - (dto3/100));
                    importe = precio * cantidad;
                    return importe.toFixed(2);
            }
        }
    };

}();