<?php $this->load->view('administrador/dashboard/header');?>
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
                        Consulta de Lista VW
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <div class="row-fluid">
                <?php $this->load->view('consulta_articulo/campos_filtro_vw.php'); ?>    
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
                                                OEM
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Descripcion" style="width: 430px;">
                                                Descripcion
                                            </th>
                                            
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Precio Publico
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
                                        $sql = "SELECT DATE_FORMAT(fecha_actualizacion,'%d/%m/%Y') AS fecha_actualizacion, DATE_FORMAT(fecha_actualizacion,'%m') AS mes_actualizacion FROM listas WHERE nombre_tabla = 'lista_vw'";
                                        $res = mysqli_query($link, $sql);
                                        $row = mysql_fetch_array($res);
                                        $fecha_actualizacion = $row['fecha_actualizacion'];
                                        $mes_actualizacion = $row['mes_actualizacion'];
                                        $mes_actual = date('m');

                                        foreach($articulo as $campo => $valor){
                                            $codigo_dto = $valor['cod_dto'];
                                            $precio_publico = $valor['precio_publico'];
                                            $precio_iva = $valor['precio_iva'];

                                            $precio_iva = ($precio_iva * 1) / 100;
                                            $margen = 1.6666;
                                            
                                            //Precio Mas IVA
                                            $precio_venta = $precio_iva;
                                            $pp = $precio_venta;
                                            
                                            //Porcentaje de DTO
                                            /*
                                            $sql_dto = "select d.`porcentaje_dto` from proveedor_dto_vw d where d.`id` IN(
                                                        select id from proveedores p where p.`codigo_proveedor` in(
                                                        select proveedor FROM lista_fenix WHERE codigo_oem = '" . $valor['original'] . "'))";*/
                                            
                                            //consulta la tabla de dtos del proveedor 5 (001 => FENIX)
                                            $sql_dto = "select porcentaje_dto from proveedor_dto_vw where proveedor_id = 1 and codigo = '$codigo_dto'";
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

                                            //Verifica si la lista es vieja
                                            $style_lista_vieja = '';
                                            if ($mes_actualizacion != $mes_actual) {
                                                $style_lista_vieja = 'background-color:#FFBBBB';
                                            }

                                            ?>
                                            <tr class="gradeX odd">
                                                <td class=" sorting_1"><input type="checkbox" class="checkboxes" value="1"></td>
                                                <td class=" ">
                                                    <a href="consulta_articulos?oem_vw=<?php echo $valor['original']?>"><?php echo $valor['original'];?></a>
                                                </td>
                                                <td class=" " ><a href="consulta_articulos?oem_vw=<?php echo $valor['original']?>"><?php echo $valor['descripcion'];?></a></td>
                                                <td class=" " style="text-align:right"><?php echo $precio_venta;?></td>
                                                <td class=" "><a href="#" onclick="copiarReemplazo('<?php echo $valor["reemplazo"];?>')"><?php echo $valor['reemplazo'];?></a></td>
                                                <td class=" " style="text-align:center"><?php echo $codigo_dto . ' / ' . $porc_dto . '%' ;?></td>
                                                <td class=" " style="<?php echo $style_lista_vieja; ?>"><?php echo $fecha_actualizacion;?></td>
                                            </tr>
                                        <?php
                                            //Verifica si tiene oferta
                                            $sql_oferta = "SELECT articulo, descripcion, precio FROM ofertas WHERE articulo = '" . $valor['original'] . "'";
                                            $res_oferta = mysqli_query($link, $sql_oferta);
                                            $nrows_oferta = mysql_num_rows($res_oferta);
                                            $row_oferta = mysql_fetch_array($res_oferta);
                                            if ($nrows_oferta > 0) {
                                                 //Fecha de la lista
                                                $sql_fechalista = "SELECT DATE_FORMAT(fecha_actualizacion,'%d/%m/%Y') AS fecha_actualizacion FROM listas WHERE nombre_tabla = 'ofertas'";
                                                $res_fechalista = mysqli_query($link, $sql_fechalista);
                                                $row_fechalista = mysql_fetch_array($res_fechalista);

                                                $fecha_actualizacion_oferta = $row_fechalista['fecha_actualizacion'];

                                                $precio_oferta = str_replace("\$", "", $row_oferta['precio']); 
                                                //$precio_oferta = str_replace(".", "", $precio_oferta); 
                                                //$precio_oferta = str_replace(",", ".", $precio_oferta);
                                                $precio_oferta = str_replace(",", "", $precio_oferta); 
                                                //$precio_oferta = str_replace(".", ".", $precio_oferta); 
                                                $precio_oferta = $precio_oferta * 1;
                                                
												
												//Agrega IVA
                                                $precio_oferta = $precio_oferta * 1.21;
												
                                                //Agrega utilidad del 40%
												$precio_oferta = $precio_oferta / 0.6;
												
                                                
                                                $precio_oferta = number_format($precio_oferta, 2, '.', ',');
                                            ?>
                                                <tr class="gradeX odd">
                                                    <td class=" sorting_1" style="background-color:#FFFFBB"><input type="checkbox" class="checkboxes" value="1"></td>
                                                    <td class=" " style="background-color:#FFFFBB">
                                                        <a href="consulta_articulos?oem_vw=<?php echo $row_oferta['articulo']?>"><?php echo $row_oferta['articulo'];?></a>
                                                    </td>
                                                    <td class=" " style="background-color:#FFFFBB"><a href="consulta_articulos?oem_vw=<?php echo $row_oferta['articulo']?>"><?php echo $row_oferta['descripcion'];?></a></td>
                                                    <td class=" " style="text-align:right;background-color:#FFFFBB"><?php echo $precio_oferta;?></td>
                                                    <td class=" " style="background-color:#FFFFBB">*** OFERTA ***</td>
                                                    <td class=" " style="background-color:#FFFFBB">*** OFERTA ***</td>
                                                    <?php
                                                    if ($fecha_actualizacion_oferta != $fecha_actualizacion) {
                                                        ?>
                                                        <td class=" " style="background-color:orange"><?php echo $fecha_actualizacion_oferta;?></td>
                                                        <?php

                                                    } else {
                                                        ?>
                                                        <td class=" " style="background-color:#FFFFBB"><?php echo $fecha_actualizacion_oferta;?></td>
                                                        <?php
                                                    }
                                                    ?>
                                                    
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
