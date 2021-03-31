 <!-- Modal - Consulta de articulos -->
 <div class="modal hide fade" id="consulta-articulos-modal" style="width: 673px;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Consulta de articulos</h3>
        </div>
        <div class="modal-body">
            <div class="span6">
                <div class="widget green">
                    <div class="widget-title">
                        <h4><i class="icon-reorder"></i> Buscar por </h4>
                        <span class="tools">
                            <a href="javascript:;" class="icon-chevron-down"></a>                                
                        </span>
                    </div>
                    <div class="widget-body">
                        <form method="get" action="#" id="form_consulta">
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <!--<label class="control-label">Articulo</label>-->
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" placeholder="Articulo" name="articulo" value="<?php echo isset($codigo_fenix)?$codigo_fenix:'';?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="control-group">
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" placeholder="OEM" name="oem" value="<?php echo isset($oem)?$oem:'';?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="control-group">
                                        <div class="controls controls-row">
                                            <input type="text" class="input-block-level" placeholder="Descripcion" name="descripcion" value="<?php echo isset($descripcion)?$descripcion:'';?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </form>
                        
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
                                            <th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="sample_1" rowspan="1" colspan="1" aria-label="Prov" style="width: 150px;">
                                                Precio
                                            </th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody role="alert" aria-live="polite" aria-relevant="all" id="resultado-busqueda">
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
                                                <td style="text-align: right">
                                                    <span id="precio-<?php echo $valor['id']?>"><?php echo $valor['precio_lista']?></span>
                                                    <button  class="btn-edit-precio" class="btn btn-primary" data-precio="<?php echo $valor['precio_lista'];?>" data-articulo="<?php echo $valor['id'];?>" >
                                                        <i class="icon-edit"></i></button>
                                                </td>
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
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
        </div>
    </div>