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
                        
                        Consulta de Lista Chevrolet
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>

            <div class="row-fluid">
                <?php $this->load->view('consulta_articulo/campos_filtro_chevrolet.php'); ?>    
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
                                                Interno
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Descripcion" style="width: 430px;">
                                                Descripcion
                                            </th>
                                            
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Precio IVA
                                            </th>

                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Precio Dto
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Fecha Lista
                                            </th>                                            
                                        </tr>
                                    </thead>

                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                        <?php
                                         //Fecha de la lista
                                        $sql = "SELECT DATE_FORMAT(fecha_actualizacion,'%d/%m/%Y') AS fecha_actualizacion FROM listas WHERE nombre_tabla = 'lista_chevrolet'";
                                        $res = mysqli_query($link, $sql);
                                        $row = mysqli_fetch_array($res);
                                        $fecha_actualizacion = $row['fecha_actualizacion'];

                                        foreach($articulo as $campo => $valor) {
                                            $cod_chevrolet = $valor['PIEZA'];
                                            $descripcion = $valor['DESCRIPCION'];
                                            $precio_iva = $valor['PRECONC'];

                                            //Descuento del 20%
                                            $precio_dto = $precio_iva - (($precio_iva * 20) / 100);
                                            $precio_dto = number_format($precio_dto, 2 , '.', '');

                                            ?>
                                            <tr class="gradeX odd">
                                                <td class=" sorting_1"><input type="checkbox" class="checkboxes" value="1"></td>
                                                <td class=" ">
                                                    <a href="#"><?php echo $valor['PIEZA'];?></a>
                                                </td>
                                                <td class=" "><a href="#"><?php echo $valor['DESCRIPCION'];?></a></td>
                                                <td class=" " style="text-align:right"><?php echo $precio_iva;?></td>
                                                <td class=" " style="text-align:right"><?php echo $precio_dto;?></td>
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
