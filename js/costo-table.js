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
                jqTds[0].innerHTML = '<input type="text" id="cod-fenix" class="input-medium" value="' + aData[0] + '">';
                jqTds[1].innerHTML = '<input type="text" id="interno" class="input-small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<select name="testigo" id="testigo" style="width: 60px;"><option value="SI">SI</option><option value="NO" selected>NO</option></select>';
                jqTds[3].innerHTML = '<input type="text" id="utilidad" style="width: 50px;" class="input-small" value="' + aData[3] + '" readonly="readonly">';
                jqTds[4].innerHTML = '<input type="text" id="costo" class="input-small" style="width: 70px;" value="' + aData[4] + '">';
                jqTds[5].innerHTML = '<input type="text" id="dto1" class="input-small" style="width: 50px;" value="' + aData[5] + '">';
                jqTds[6].innerHTML = '<input type="text" id="dto2" class="input-small" style="width: 50px;" value="' + aData[6] + '">';
                jqTds[7].innerHTML = '<input type="text" id="dto3" class="input-small" style="width: 50px;" value="' + aData[7] + '">';
                jqTds[8].innerHTML = '<input type="text" id="rec1" class="input-small" style="width: 50px;" value="' + aData[8] + '">';
                jqTds[9].innerHTML = '<a class="edit" id="guardar-costo" href="">Guardar</a>';
                jqTds[10].innerHTML = '<a class="cancel" href="">Cancelar</a>';
                
                //$('#info-consulta').html('*');
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);

                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(document.getElementById('testigo').value, nRow, 2, false);
                oTable.fnUpdate(document.getElementById('utilidad').value, nRow, 3, false);
                oTable.fnUpdate(document.getElementById('costo').value, nRow, 4, false);
                oTable.fnUpdate(document.getElementById('dto1').value, nRow, 5, false);
                oTable.fnUpdate(document.getElementById('dto2').value, nRow, 6, false);
                oTable.fnUpdate(document.getElementById('dto3').value, nRow, 7, false);
                oTable.fnUpdate(document.getElementById('rec1').value, nRow, 8, false);
                oTable.fnUpdate('<a class="edit" href="">Editar</a>', nRow, 9, false);
                oTable.fnUpdate('<a class="delete" href="">Borrar</a>', nRow, 10, false);
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
                oTable.fnUpdate('<a class="edit" href="">Editar</a>', nRow, 9, false);
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

            $('#editable-sample_new').click(function (e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '','','','','','',
                        '<a class="edit" href="">Editar</a>', '<a class="cancel" data-mode="new" href="">Cancelar</a>'
                ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
                $('#cod-fenix').focus();
            });

            $('#editable-sample a.delete').live('click', function (e) {
                e.preventDefault();

                if (confirm("Desea borrar el registro ?") == false) {
                    return;
                }

                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);
                //alert("Deleted! Do not forget to do some ajax to sync with backend :)");
            });

            $('#editable-sample a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);

                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });

            $('#editable-sample a.edit').live('click', function (e) {
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
                    var _fechacosto = $('#fecha-costo').val();
                    var _codfenix = $('#cod-fenix').val();
                    var _interno = $('#interno').val();
                    var _testigo = $('#testigo').val();
                    var _utilidad = $('#utilidad').val();
                    var _moneda = $('#moneda').val();
                    var _costo = $('#costo').val();
                    var _costo_lista = $('#costo-lista').val();
                    var _dto1 = $('#dto1').val();
                    var _dto2 = $('#dto2').val();
                    var _dto3 = $('#dto3').val();
                    var _rec1 = $('#rec1').val();
                    
                    var _descripcion_lista = $('#descripcion-lista').val();
                    var _marca_lista = $('#marca-lista').val();
                                        
                     
                    /* Editing this row and want to save it */
                    saveRow(oTable, nEditing);
                    nEditing = null;
                    
                    var uri = '/fenix/sistema/costo_proveedor_controller/guardarCosto';
                    if (window.location.host !== 'localhost') {
                        uri = '/sistema/costo_proveedor_controller/guardarCosto';
                    }
                    
                    var costoData =  {proveedor:_proveedor,
                      fecha:_fechacosto,
                      codfenix:_codfenix,
                      interno:_interno,
                      costo:_costo,
                      dto1: _dto1,
                      dto2: _dto2,
                      dto3: _dto3,
                      rec1 : _rec1,
                      moneda:_moneda,
                      utilidad:_utilidad,
                      testigo:_testigo,
                      marca_lista:_marca_lista,
                      descripcion_lista:_descripcion_lista,
                      costo_lista: _costo_lista};
                    
                    //Actualiza el costo
                    $.ajax({
                       url: uri,
                       data: costoData,
                       type: 'POST',
                       success: function(data){
                           //var datosJson = JSON.parse(data);
                           $('#info-consulta').html(data);
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
                if (e.keyCode == 13) {
                
                    var _proveedor = $('#proveedor').val();
                    var _codfenix = $('#cod-fenix').val();
                    var _interno = $('#interno').val();
                    
                    var uri = '/fenix/sistema/costo_proveedor_controller/buscarCosto';
                    if (window.location.host !== 'localhost') {
                        uri = '/sistema/costo_proveedor_controller/buscarCosto';
                    }
                    
                    $.ajax({
                           url: uri,
                           data: {proveedor:_proveedor,codfenix:_codfenix, interno:_interno},
                           type: 'POST',
                           success: function(data){
                               var datosJson = JSON.parse(data);
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
                               
                               if (testigo === 'SI') {
                                    $('#utilidad').attr('readonly', false);
                               } else {
                                    $('#utilidad').attr('readonly', true);
                               }
                               
                               $('#descripcion-lista').val(datosJson.descripcion_lista);
                               $('#marca-lista').val(datosJson.marca_lista);
                               $('#costo-lista').val(datosJson.precio_lista);
                               
                               $('#costo').select();
                           } 
                    });
               }
                
            });
            

             //Tecla Enter
            $('#cod-fenix').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode == 13) {
                    
                    var _codfenix = $('#cod-fenix').val();
                    var _proveedor = $('#proveedor').val();
                    
                    var uri = '/fenix/sistema/costo_proveedor_controller/buscarArticuloCosto';
                    if (window.location.host != 'localhost') {
                        uri = '/sistema/costo_proveedor_controller/buscarArticuloCosto';
                    }
                    
                    $.ajax({
                           url: uri,
                           data: {codfenix:_codfenix,proveedor:_proveedor},
                           type: 'POST',
                           success: function(data) {
                               var datosJson = JSON.parse(data);
                               var err = datosJson.err * 1;
                                                              
                               $('#info-consulta').html(datosJson.descripcion);
                               $('#interno').val(datosJson.interno_proveedor);
                               $('#costo').val(datosJson.costo);
                               $('#dto1').val(datosJson.dto1);
                               $('#dto2').val(datosJson.dto2);
                               $('#dto3').val(datosJson.dto3);
                               $('#rec1').val(datosJson.rec1);
                               $('#utilidad').val(datosJson.utilidad);
                               
                               var testigo = datosJson.testigo;
                               console.log('testigo:' + testigo);
                               if (testigo !== '' && testigo !== undefined) {
                                   $('#testigo').val(testigo);
                               } else {
                                   $('#testigo').val('NO');
                               }
                               
                               if (testigo == 'SI') {
                                    $('#utilidad').attr('readonly', false);
                               } else {
                                    $('#utilidad').attr('readonly', true);
                               }

                               if (err == 0) {
                                $('#info-consulta').attr('class', 'label label-success');
                                $('#interno').focus();
                               } else {
                                $('#info-consulta').attr('class', 'label label-warning');
                                $('#cod-fenix').focus();
                               }

                           } 
                    });
                    
                    $('#interno').focus(); //  handles submit buttons
                    return false;
                }
            });

            $('#costo').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode == 13) {
                    $('#dto1').focus(); //  handles submit buttons
                    return false;
                }
            });
            
            $('#testigo').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode == 13) {
                    var _codfenix = $('#cod-fenix').val();
                    
                    var uri = '/fenix/sistema/costo_proveedor_controller/buscarUtilidad';
                    if (window.location.host != 'localhost') {
                        uri = '/sistema/costo_proveedor_controller/buscarUtilidad';
                    }
                    
                    $.ajax({
                           url: uri,
                           data: { codfenix : _codfenix },
                           type: 'POST',
                           success: function(data){
                               var datosJson = JSON.parse(data);
                               $('#utilidad').val(datosJson.utilidad);
                               $('#utilidad').focus(); 
                           } 
                    });
                    
                    return false;
                }
            });
            
            $('#utilidad').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode == 13) {
                    $('#costo').focus(); 
                    return false;
                }
            });

            $('#utilidad').live("blur", function(e) {
                var utilidad = $(this).val() * 1;
                
                if (utilidad < 20) {
                  alert('La utilidad no puede ser menor al 20%');
                  $(this).focus();
                  $(this).select();
                }

                if(utilidad > 99.99) {
                  alert('La utilidad no puede ser mayor al 99.99%'); 
                  $(this).focus();
                  $(this).select();
                }

            });

            $('#dto1').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode == 13) {
                    $('#dto2').focus(); //  handles submit buttons
                    return false;
                }
            });

            $('#dto2').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode == 13) {
                    $('#dto3').focus(); //  handles submit buttons
                    return false;
                }
            });

            $('#dto3').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode == 13) {
                    $('#rec1').focus(); //  handles submit buttons
                    return false;
                }
            });

            $('#rec1').live("keypress", function(e) {
                /* ENTER PRESSED*/
                if (e.keyCode == 13) {
                    $('#guardar-costo').click(); //  handles submit buttons
                    //return false;
                }
            });
            
            $('#testigo').live("change", function(e) {
                var testigo = $(this).val();
                if (testigo == 'SI') {
                    $('#utilidad').attr('readonly', false);
                } else {
                    $('#utilidad').attr('readonly', true);
                }
            });

            
        }

    };

}();