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
                        
                        Consulta de Lista Ford
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>

            <div class="row-fluid">
                <?php $this->load->view('consulta_articulo/campos_filtro_ford.php'); ?>    
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
                                                Reemplazo
                                            </th>

                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Cod.Dto / %
                                            </th>
                                            
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Fecha Lista
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                        <?php
                                        //Fecha de la lista
                                        $sql = "SELECT DATE_FORMAT(fecha_actualizacion,'%d/%m/%Y') AS fecha_actualizacion FROM listas WHERE nombre_tabla = 'lista_ford'";
                                        $res = mysqli_query($link, $sql);
                                        $row = mysql_fetch_array($res);
                                        $fecha_actualizacion = $row['fecha_actualizacion'];

                                        //Fecha Actualizacion Ofertas
                                        $sql = "SELECT DATE_FORMAT(fecha_actualizacion,'%d/%m/%Y') AS fecha_actualizacion FROM listas WHERE nombre_tabla = 'ofertas_ford'";
                                        $res = mysqli_query($link, $sql);
                                        $row = mysql_fetch_array($res);
                                        $fecha_actualizacion_ofertas = $row['fecha_actualizacion'];


                                        foreach($articulo as $campo => $valor) {
                                            $original = trim($valor['original']);
                                           
                                            //$orig = explode('/', $original);
                                            //$original = $orig[1].'/'.$orig[0].'/'.$orig[2].'/'.$orig[3];
                                            
                                            $descripcion = $valor['descripcion'];
                                            $precio_iva = $valor['precio_iva'];
                                            $reemplazo = $valor['reemplazo'];
                                            if ($reemplazo === '///') {
                                                $reemplazo = '';
                                            }

                                            $precio_iva = ($precio_iva * 1) / 100;
                                            
                                            $codigo_dto = $valor['cod_dto'];
                                            if ($codigo_dto == '') {
                                                $codigo_dto = 0;
                                            }
                                            $margen = 1.6666;
                                            //$margen = 1;
                                            
                                            //Precio Mas IVA
                                            $precio_venta = $precio_iva;
                                            //Obtiene id de Renault
                                            
                                            $sql_cod_prov = "SELECT id FROM proveedores "
                                                    . " WHERE codigo_proveedor = '005' ";
                                            $res_cod_prov = mysqli_query($link, $sql_cod_prov);
                                            $row_cod_prov = mysql_fetch_array($res_cod_prov);
                                            $proveedor_id = $row_cod_prov['id'];
                                            
                                            
                                            //consulta la tabla de dtos del proveedor 5 (001 => FENIX)
                                            $sql_dto = "SELECT porcentaje_dto FROM proveedor_dto_vw "
                                                    . "WHERE proveedor_id = $proveedor_id AND codigo = '$codigo_dto'";
                                            $res_dto = mysqli_query($link, $sql_dto);
                                            $row_dto = mysql_fetch_array($res_dto);
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
                                                <td class=" "><a href="#" onclick="copiarReemplazo('<?php echo $reemplazo;?>')"><?php echo $reemplazo;?></a></td>
                                                <td class=" " style="text-align:right"><?php echo $codigo_dto . '/' . $porc_dto;?></td>
                                                <td class=" "><?php echo $fecha_actualizacion;?></td>
                                            </tr>
                                        
                                            
                                            <?php
                                            //Verifica si tiene oferta
                                            $original_oferta = trim(str_replace(' ', '',$original));
                                            $sql_oferta = "SELECT interno, descripcion, precio FROM ofertas_ford WHERE interno = '$original_oferta' or interno='$original'";
                                            //echo $sql_oferta.'<br>';
                                            @$res_oferta = mysqli_query($link, $sql_oferta);
                                            @$nrows_oferta = mysql_num_rows($res_oferta);
                                            @$row_oferta = mysql_fetch_array($res_oferta);
                                            if ($nrows_oferta > 0) {
                                                //Fecha de la lista
                                                $sql_fechalista = "SELECT DATE_FORMAT(fecha_actualizacion,'%d/%m/%Y') AS fecha_actualizacion FROM listas WHERE nombre_tabla = 'ofertas_ford'";
                                                $res_fechalista = mysqli_query($link, $sql_fechalista);
                                                $row_fechalista = mysql_fetch_array($res_fechalista);
                                                $fecha_actualizacion_oferta = $row_fechalista['fecha_actualizacion'];

                                                $precio_oferta = str_replace("\$", "", $row_oferta['precio']); 
                                                //$precio_oferta = str_replace(".", "", $precio_oferta);
                                                //$precio_oferta = str_replace(",", ".", $precio_oferta); 
                                                
                                                $precio_oferta = $precio_oferta * 1.21;

                                                $precio_oferta = $precio_oferta / 0.6;

                                                $precio_oferta = number_format($precio_oferta, 2, '.', ',');
                                            ?>
                                                <tr class="gradeX odd" style="background-color:yellow">
                                                    <td class=" sorting_1"><input type="checkbox" class="checkboxes" value="1"></td>
                                                    <td class=" ">
                                                        <a href="consulta_articulos?oem_vw=<?php echo $row_oferta['interno']?>"><?php echo $row_oferta['interno'];?></a>
                                                    </td>
                                                    <td class=" "><a href="consulta_articulos?oem_vw=<?php echo $row_oferta['interno']?>"><?php echo $row_oferta['descripcion'];?></a></td>
                                                    <td class=" " style="text-align:right"><?php echo $precio_oferta;?></td>
                                                    <td class=" " style="text-align:center"></td>
                                                    <td class=" " style="text-align:center">*** OFERTA ***</td>
                                                    <td class=" "><?php echo $fecha_actualizacion_ofertas;?></td>
                                                </tr>
                                            <?php
                                            }
                                                                                    
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
