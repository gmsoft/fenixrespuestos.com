 <!-- Modal - Consulta de articulos -->
 <div class="modal hide fade" id="consulta-articulos-modal" style="width: 673px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Consulta de articulos</h3>
        </div>
        <div class="modal-body">

           <div class="row-fluid">
                <div class="span12">
                     <!-- FILTROS -->   
                    <div class="span12">
                        <div class="widget green">

                            <div class="widget-title">
                                <h4><i class="icon-reorder"></i> Buscar por </h4>
                                <span class="tools">
                                    <a href="javascript:;" class="icon-chevron-down"></a>                                
                                </span>
                            </div>
                        
                            <div class="widget-body">
                                
                                    <div class="row-fluid">
                                        <div class="span4">
                                            <div class="control-group">
                                                <!--<label class="control-label">Articulo</label>-->
                                                <div class="controls controls-row">
                                                    <input type="text" class="input-block-level" id="articulo-modal" placeholder="Articulo" name="articulo" value="" autofocus>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <div class="controls controls-row">
                                                    <input type="text" class="input-block-level" id="oem-modal" placeholder="OEM" name="oem" value="">
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span6">
                                            <div class="control-group">
                                                <div class="controls controls-row">
                                                    <input type="text" class="input-block-level" id="descripcion-modal" placeholder="Descripcion" name="descripcion" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span2">
                                            <div class="control-group">
                                                <div class="controls controls-row">
                                                    <button class="btn" id="btn-buscar-popup" type="button">Buscar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- FIN FILTROS -->


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
                                <table class="table table-striped table-bordered dataTable" id="sample_1_99999" aria-describedby="sample_1_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Articulo" style="width: 175px;">
                                                Articulo
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="OEM" style="width: 175px;">
                                                OEM
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Descripcion" style="width: 430px;">
                                                Descripcion
                                            </th>
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px">
                                                Precio
                                            </th>                                            
                                        </tr>
                                    </thead>

                                    <tbody role="alert" aria-live="polite" aria-relevant="all" id="resultado-busqueda-modal">
                                        <?php
                                        /*
                                        if (isset($articulo)) {
                                            foreach($articulo as $campo => $valor){
                                                ?>
                                                <tr class="gradeX odd">
                                                    <td class=" ">
                                                        <a href="#" onclick="seleccionarArticulo('<?php echo $valor['codigo_fenix']?>', 'codfenix')"><?php echo $valor['codigo_fenix']?></a>
                                                    </td>
                                                    <td class=" "><a href="#" onclick="seleccionarArticulo('<?php echo $valor['codigo_fenix']?>', 'codfenix')"><?php echo $valor['codigo_oem']?></a></td>
                                                    <td class=" "><?php echo $valor['descripcion']?></td>
                                                    <td style="text-align: right">
                                                        <span id="precio-<?php echo $valor['id']?>"><?php echo $valor['precio_lista']?></span>                                                    
                                                    </td>
                                                </tr>
                                            <?php
                                            }    
                                        }
                                        */
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
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" id="btn-cerrar-modal-art" aria-hidden="true">Cerrar</button>
        </div>
    </div>
 <script type="text/javascript">
     function seleccionarArticulo(art, selector) {
         $('#btn-cerrar-modal-art').click();
         $('#' + selector).val(art);
         $('#' + selector).focus();
         $('#' + selector).trigger({type: 'keypress', which: 13, keyCode: 13});

     }
 </script>