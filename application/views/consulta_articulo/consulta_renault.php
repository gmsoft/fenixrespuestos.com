<?php $this->load->view('administrador/dashboard/header'); ?>
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
                        
                        Consulta de Lista Renault
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>

            <div class="row-fluid">
                <?php $this->load->view('consulta_articulo/campos_filtro_renault.php'); ?>    
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
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="OEM" style="width: 175px;">
                                                Original
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Descripcion" style="width: 430px;">
                                                Descripcion
                                            </th>
                                            
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Precio IVA
                                            </th>

                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Cod.Dto / %
                                            </th>

                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Reemplazo
                                            </th>

                                             <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Fecha Lista
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                        <?php
                                        //Fecha de la lista
                                        $sql = "SELECT DATE_FORMAT(fecha_actualizacion,'%d/%m/%Y') AS fecha_actualizacion FROM listas WHERE nombre_tabla = 'lista_renault'";
                                        $res = mysqli_query($link, $sql);
                                        $row = mysqli_fetch_array($res);
                                        $fecha_actualizacion = $row['fecha_actualizacion'];
                                        foreach($articulo as $campo => $valor) {
                                            $original = $valor['original'];
                                            //$orig = explode('/', $original);
                                            //$original = $orig[1].'/'.$orig[0].'/'.$orig[2].'/'.$orig[3];
                                            
                                            $descripcion = $valor['descripcion'];
                                            $reemplazo = $valor['reemplazo'];
                                            $precio_iva = $valor['precio'];
                                            $precio_iva = ($precio_iva * 1) / 100;
                                            
                                            $codigo_dto = $valor['cod_dto'];
                                            if ($codigo_dto == ''){
                                                $codigo_dto = 0;
                                            }
                                            $margen = 1.6666;
                                            
                                            //Precio Mas IVA
                                            $precio_venta = $precio_iva;

                                            //Obtiene id de Renault
                                            $sql_cod_prov = "SELECT id FROM proveedores "
                                                    . " WHERE codigo_proveedor = '051' ";
                                            $res_cod_prov = mysqli_query($link, $sql_cod_prov);
                                            $row_cod_prov = mysqli_fetch_array($res_cod_prov);
                                            $proveedor_id = $row_cod_prov['id'];
                                            
                                            //consulta la tabla de dtos del proveedor 15 (069 => TAGLE)
                                            $sql_dto = "SELECT porcentaje_dto FROM proveedor_dto_vw "
                                                    . " WHERE proveedor_id = $proveedor_id AND codigo = '$codigo_dto'";
                                            $res_dto = mysqli_query($link, $sql_dto);
                                            $row_dto = mysqli_fetch_array($res_dto);
                                            $porc_dto = $row_dto['porcentaje_dto'];
                                           
                                            //Controla si es descuento o recargo
                                            if ($porc_dto > 0 ) {
                                                //Recargo
                                               $precio_venta = $precio_venta + (($precio_venta * $porc_dto) / 100);
                                            } else {
                                                //Dto
                                                $porc_dto = $porc_dto * -1;
                                                $precio_venta = $precio_venta - (($precio_venta * $porc_dto) / 100);
                                            }


                                            //Margen de Ganancia    
                                            $precio_venta = $precio_venta * $margen;

                                            //Iva 
                                            $precio_venta = $precio_venta * 1.21;
                                            
                                            //$precio_venta = $precio_iva;
                                            $precio_venta = number_format($precio_venta, 2, '.', ',');

                                            ?>
                                            <tr class="gradeX odd">
                                                <td class=" sorting_1"><input type="checkbox" class="checkboxes" value="1"></td>
                                                <td class=" ">
                                                    <a href="#"><?php echo $original;?></a>
                                                </td>
                                                <td class=" "><a href="#"><?php echo $descripcion;?></a></td>
                                                <td class=" " style="text-align:right"><?php echo $precio_venta;?></td>
                                                <td class=" " style="text-align:right"><?php echo $codigo_dto . '/' . $porc_dto;?></td>
                                                <td class=" "><a onclick="copiarReemplazo('<?php echo $reemplazo;?>')" href="#"><?php echo $reemplazo;?></a></td>
                                                <td class=" "><?php echo $fecha_actualizacion;?></td>
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
    </script>
