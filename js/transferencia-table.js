var EditableTable = function () {

    return {

        //main function to initiate the module
        init: function () {
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
                jqTds[0].innerHTML = '<input type="text" id="cod-fenix-stk" class="input-medium" value="' + aData[0] + '">';
                jqTds[1].innerHTML = '<input type="number" id="cantidad-stk" class="input-small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<a class="edit" id="guardar-transferencia" href="">Guardar</a>';
                jqTds[3].innerHTML = '<a class="cancel" href="">Cancelar</a>';
                
                //$('#info-consulta').html('*');
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);

                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate('<a class="edit" href="">Editar</a>', nRow, 2, false);
                oTable.fnUpdate('<a class="delete" href="">Borrar</a>', nRow, 3, false);
                oTable.fnDraw();

                //$('#editable-sample_new').click();
            }

            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                
                oTable.fnUpdate('<a class="edit" href="">Editar</a>', nRow, 2, false);
                oTable.fnDraw();
            }

            var oTable = $('#editable-transferencia').dataTable({
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

            $('#editable-transferencia_new').click(function (e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '','','','','','',
                        '<a class="edit" href="">Editar</a>', '<a class="cancel" data-mode="new" href="">Cancelar</a>'
                ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
                $('#cod-fenix-stk').focus();
            });

            $('#editable-transferencia a.delete').live('click', function (e) {
                e.preventDefault();

                if (confirm("Desea borrar el registro ?") == false) {
                    return;
                }

                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);
                //alert("Deleted! Do not forget to do some ajax to sync with backend :)");
            });

            $('#editable-transferencia a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);

                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });

            $('#editable-transferencia a.edit').live('click', function (e) {
                e.preventDefault();

                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];

                if (nEditing !== null && nEditing != nRow) {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                } else if (nEditing == nRow && this.innerHTML == "Guardar") {
                    
                    var _codfenix = $('#cod-fenix-stk').val();
                    var _cantidad = $('#cantidad-stk').val();
                    var _desdeSucursal = $('#desde-sucursal').val();
                    var _hastaSucursal = $('#hasta-sucursal').val();
                    var _fechaTransferencia = $('#fecha-transferencia').val();
                    
                    /* Editing this row and want to save it */
                    saveRow(oTable, nEditing);
                    nEditing = null;
                    
                    var uri = '/fenix/sistema/stock_controller/cargarArticuloTransferencia';
                    if (window.location.host !== 'localhost') {
                        uri = '/sistema/stock_controller/cargarArticuloTransferencia';
                    }
                     
                    //Actualiza el costo
                    $.ajax({
                       url: uri,
                       data: {codfenix:_codfenix, cantidad:_cantidad, desdeSucursal:_desdeSucursal, hastaSucursal:_hastaSucursal,fecha:_fechaTransferencia },
                       type: 'POST',
                       success: function(data){
                           //var datosJson = JSON.parse(data);
                           $('#info-consulta').html(data);
                           $('#editable-transferencia_new').click();
                       } 
                    });
                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });
            
             //Tecla Enter
            $('#cod-fenix-stk').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode == 13) {
                    
                    var _codfenix = $('#cod-fenix-stk').val();
                    
                    var uri = '/fenix/sistema/costo_proveedor_controller/buscarArticuloCosto';
                    if (window.location.host !== 'localhost') {
                        uri = '/sistema/costo_proveedor_controller/buscarArticuloCosto';
                    }
                    
                    $.ajax({
                           url: uri,
                           data: {codfenix:_codfenix,proveedor:0},
                           type: 'POST',
                           success: function(data){
                               var datosJson = JSON.parse(data);
                                                              
                               $('#info-consulta').html(datosJson.descripcion);
                               
                           } 
                    });
                    
                    $('#cantidad-stk').focus(); //  handles submit buttons
                    return false;
                }
            });

            $('#cantidad-stk').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode == 13) {
                    $('#guardar-transferencia').click(); //  handles submit buttons
                    //return false;
                }
            });
            
        }

    };

}();