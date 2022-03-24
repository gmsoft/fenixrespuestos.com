<?php
$link = mysqli_connect("db-mysql-nyc3-22736-do-user-11066346-0.b.db.ondigitalocean.com", "doadmin", "AmMG2DvQVU4GgWgk", "defaultdb", 25060);

/* comprobar la conexión */
if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}
?>
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
                        Consulta de Articulos
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>

            <div class="row-fluid">
                
                <?php $this->load->view('consulta_articulo/campos_filtro'); ?>
                <?php $this->load->view('consulta_articulo/campos_filtro2'); ?>

                <?php
                if (isset($_articulo)) {
                    if (count($articulo) > 0) {
                        ?>
                        <div class="span6"  id="detalles-articulo">
                            <div class="widget red">
                                <div class="widget-title">
                                    <h4><i class="icon-reorder"></i> Detalles del Articulo</h4>
                                    <span class="tools">
                                        <a href="javascript:;" class="icon-chevron-down"></a>
                                        <a href="javascript:;" class="icon-remove"></a>
                                    </span>
                                </div>

                                <div class="widget-body">
                                    <div class="bs-docs-example">
                                        <ul class="nav nav-tabs" id="myTab">
                                            <li class="active"><a data-toggle="tab" href="#comparativo">Comparativo</a></li>
                                            <li class=""><a data-toggle="tab" href="#compras">Compras</a></li>
                                            <li class=""><a data-toggle="tab" href="#stock">Stock</a></li>
                                            <li class=""><a data-toggle="tab" href="#compras">Ultima Compra</a></li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div id="comparativo" class="tab-pane fade active in">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>CODIGO</th>
                                                            <th>PROVEEDOR</th>
                                                            <th>PRECIO</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>BALSAMO</td>
                                                            <td>100</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="compras" class="tab-pane fade">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>CODIGO</th>
                                                            <th>PROVEEDOR</th>
                                                            <th>PRECIO</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>BALSAMO</td>
                                                            <td>100</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="stock" class="tab-pane fade">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Sucursal</th>
                                                            <th>Stock</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>100</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="span2"  id="foto-articulo">
                            <div class="widget red">
                                <div class="widget-title">
                                    <h4><i class="icon-reorder"></i> Foto</h4>
                                    <span class="tools">
                                        <a href="javascript:;" class="icon-chevron-down"></a>
                                        <a href="javascript:;" class="icon-remove"></a>
                                    </span>
                                </div>
                                <div class="widget-body">
                                    <img src="http://www.balsamo.com.ar/aplicacion/infobal/Imagenes/11088.JPG" >
                                </div>
                            </div>
                        </div>


                        <?php
                    }
                }
                ?>

            </div>

            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN EXAMPLE TABLE widget-->
                    <div class="widget red">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i> Listado de Articulos</h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>
                                <!--<a href="javascript:;" class="icon-remove"></a>-->
                            </span>
                        </div>
                        <div class="widget-body">
                            <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <table class="table table-striped table-bordered dataTable" id="sample_1" aria-describedby="sample_1_info">
                                    <thead>
                                        <tr role="row">
                                            <th style="width: 13px;" class="sorting_disabled" role="columnheader" rowspan="1" colspan="1" aria-label="">
                                                <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes">
                                            </th>
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Articulo" style="width: 175px;">
                                                Articulo
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="OEM" style="width: 175px;">
                                                OEM
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Descripcion" style="width: 430px;">
                                                Descripcion
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Marca" style="width: 150px;">
                                                Marca
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Prov
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Precio
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Stk
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Rubro
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                        <?php
                                        foreach($articulo as $campo => $valor){
                                            ?>
                                            <tr class="gradeX odd">
                                                <td class=" sorting_1"><input type="checkbox" class="checkboxes" value="1"></td>
                                                <td class=" ">
                                                    <a href="articulo/<?php echo $valor['id']?>"><?php echo $valor['codigo_fenix']?></a>
                                                </td>
                                                <td class=" "><a href="articulo/<?php echo $valor['id']?>"><?php echo $valor['codigo_oem']?></a></td>
                                                <td class=" "><?php echo $valor['descripcion']?></td>
                                                <td class=" "><?php echo $valor['marca']?></td>
                                                <td class=" ">
                                                    <?php
                                                     $prov_id = $valor['proveedor_testigo'];
                                                     $sql_prov = "SELECT codigo_proveedor FROM proveedores WHERE id = $prov_id";
                                                     $res_prov = mysqli_query($link, $sql_prov);
                                                     $row_prov = mysqli_fetch_array($res_prov);
                                                     echo $row_prov['codigo_proveedor'];
                                                     ?>
                                                </td>
                                                <td style="text-align: right">
                                                    <span id="precio-<?php echo $valor['id']?>"><?php echo $valor['precio_lista']?></span>
                                                    <button  class="btn-edit-precio" class="btn btn-primary" data-precio="<?php echo $valor['precio_lista'];?>" data-articulo="<?php echo $valor['id'];?>" >
                                                        <i class="icon-edit"></i></button>
                                                </td>
                                                <?php
                                                //Rubro
                                                /*
                                                $sql_rubro = "SELECT nombre FROM rubros WHERE id = '".$valor['rubro']."'";
                                                $res_rubro = mysqli_query($sql_rubro);
                                                $row_rubro = mysqli_fetch_array($res_rubro);
                                                */
                                                /*
                                                //Stock
                                                $sql_stock = "SELECT cantidad FROM stock WHERE articulo_fenix = '".$valor['codigo_fenix']."' and sucursal_id = 1";
                                                $res_stock = mysqli_query($sql_stock);
                                                $row_stock = mysqli_fetch_array($res_stock);
                                                */
                                                ?>
                                                <td class=" ">
                                                    <span id="stock-<?php //echo $valor['id']?>"><?php //echo $row_stock['cantidad'];?></span>
                                                    <button  class="btn-edit-stock" class="btn btn-primary" data-cantidad="<?php //echo $row_stock['cantidad'];?>" data-articulo="<?php //echo $valor['codigo_fenix'];?>" data-art="<?php //echo $valor['id'];?>" >
                                                        <i class="icon-edit"></i></button>
                                                </td>
                                                <td class=" "><span class="label label-success"><?php //echo $row_rubro['nombre']?></span></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                </div>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE widget-->
                </div>
            </div>

        </div>
        <!-- END PAGE -->  
    </div>
<!-- Modal - Edit Precio -->
        <div class="modal hide fade" id="edit-precio-modal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Cambiar Precio</h3>
            </div>
            <div class="modal-body">
                Precio: <input type="text" id="precio-edit">
                <input type="hidden" id="art-edit-precio">
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button id="btn-guardar-precio" class="btn btn-primary">Guardar</button>
            </div>
        </div>

<!-- Modal - Edit Stock -->
        <div class="modal hide fade" id="edit-stock-modal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Cambiar Stock</h3>
            </div>
            <div class="modal-body">
                Stock: <input type="text" id="cantidad-edit">
                <input type="hidden" id="art-edit-stock">
                <input type="hidden" id="id-edit-stock">
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button id="btn-guardar-stock" class="btn btn-primary">Guardar</button>
            </div>
        </div>

    <!-- END PAGE -->
    <?php $this->load->view('administrador/dashboard/footer'); ?>

    <script>
        function consultarArt() {
            //$('#detalles-articulo').attr('style','display:bock');
            $('#form_consulta').submit();
        }

        $('input[type=text]').keypress(function(e) {
            if (e.which == 13) {
                $('#form_consulta').submit();
            }
        });

        $('#cod-articulo').click(function(e) {
            $('#cod-oem').val('');
            $('#descripcion').val('');
        });

        $('#cod-oem').click(function(e) {
            $('#cod-articulo').val('');
            $('#descripcion').val('');
        });

        $('#descripcion').click(function(e) {
            $('#cod-oem').val('');
            $('#cod-articulo').val('');
        });
        
        //Precio
        $('.btn-edit-precio').click(function(){
            var art = $(this).attr('data-articulo');
            var precio = $(this).attr('data-precio');
            
            $('#art-edit-precio').val(art);
            $('#precio-edit').val(precio);
            
            $('#edit-precio-modal').modal();
            
        });

        $('.btn-edit-precio').live('click' , function(){
            var art = $(this).attr('data-articulo');
            var precio = $(this).attr('data-precio');
            
            $('#art-edit-precio').val(art);
            $('#precio-edit').val(precio);
            
            $('#edit-precio-modal').modal();
            
        });
        
         $('#btn-guardar-precio').click(function(){
             
             var precio = $('#precio-edit').val();
             var art_edit = $('#art-edit-precio').val();
             
             
             $.ajax({
                type: "POST",
                url: "edit_precio",
                data: { art: art_edit, precio: precio }
              })
                .done(function( msg ) {
                  //console.log( "Data Saved: " + msg );
             });
             
             $('#precio-' + $('#art-edit-precio').val()).html(precio);
             
             $('#edit-precio-modal').modal('hide');
         });
         
         //Stock
         $('.btn-edit-stock').click(function(){
            var art = $(this).attr('data-articulo');
            var cantidad = $(this).attr('data-cantidad');
            var art_id = $(this).attr('data-art');
            
            $('#art-edit-stock').val(art);
            $('#id-edit-stock').val(art_id);
            $('#cantidad-edit').val(cantidad);
            
            $('#edit-stock-modal').modal();
            
        });
        
         $('#btn-guardar-stock').click(function(){
             
             var stock = $('#cantidad-edit').val();
             var art_edit = $('#art-edit-stock').val();
             
             $.ajax({
                type: "POST",
                url: "edit_stock",
                data: { art: art_edit, cantidad: stock }
              })
                .done(function( msg ) {
                  //console.log( "Data Saved: " + msg );
             });
             
             $('#stock-' + $('#id-edit-stock').val()).html(stock);
             
             $('#edit-stock-modal').modal('hide');
         });

         //$('#proveedor').keypress(function(e) {
          $('#btn-filtrar-articulos').click(function() {
            var proveedor = $('#proveedor').val();
            
            $(this).text('Filtrando...');
            $(this).attr('disabled', true);

            $.ajax({
                type: "POST",
                url: "filtrar_articulos",
                data: { prov: proveedor }
              })
                .done(function(data) {
                    $('#sample_1 > tbody > tr').remove();
                    var articulosJson = JSON.parse(data);
                    var respuestaHTML = '';
                    
                    $.each(articulosJson, function(k, v) {
                        respuestaHTML+='<tr>';
                        respuestaHTML+='<td><input type="checkbox" class="checkboxes" value="1"></td>';
                        respuestaHTML+='<td><a href="articulo/' + v.id + '">' + v.codigo_fenix + '</a></td>';
                        respuestaHTML+='<td><a href="articulo/' + v.id + '">' + v.codigo_oem + '</a></td>';
                        respuestaHTML+='<td>' + v.descripcion + '</td>';
                        respuestaHTML+='<td>' + v.marca + '</td>';
                        respuestaHTML+='<td>' + v.proveedor_testigo + '</td>';
                        respuestaHTML+='<td style="text-align: right"><span id="precio-' + v.id + '">' + v.precio_lista + '</span>'
                                        + '<button  class="btn-edit-precio" class="btn btn-primary" data-precio="' + v.precio_lista + '" data-articulo="' + v.id + '" >'
                                        + '<i class="icon-edit"></i></button></td>';
                        respuestaHTML+='<td></td>';
                        respuestaHTML+='<td></td>';
                        respuestaHTML+='</tr>';
                    });
                    
                    $('#sample_1 > tbody').append(respuestaHTML);

                    $('#btn-filtrar-articulos').text('Filtrar');
                    $('#btn-filtrar-articulos').attr('disabled', false);
                        
             });
            
         });
    </script>
