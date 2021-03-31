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

            var oTable = $('#tabla-listado').dataTable({
                "aLengthMenu": [
                    [5, 15, 20, -1],
                    [5, 15, 20, "All"] // change per page values here
                ],
                 "aaSorting": [],
                // set the initial value
                "iDisplayLength": 10,
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ registros por pagina",
                    "oPaginate": {
                        "sPrevious": "Siguiente",
                        "sNext": "Anterior"
                    }
                }
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

                    var uri = '/fenix/sistema/compra_controller/guardarArtOcompra';
                    if (window.location.host !== 'localhost') {
                        uri = '/compra_controller/guardarArtOCompra';
                    }

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
        }
    };

}();