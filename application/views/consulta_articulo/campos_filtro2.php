<div class="span4">
                    <div class="widget green">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i> Buscar por </h4>
                            <span class="tools">
                                <a href="javascript:;" class="icon-chevron-down"></a>                                
                            </span>
                        </div>
                        <div class="widget-body">
                            <form  onsubmit="return false;">
                                <div class="row-fluid">
                                    <div class="span5">
                                        <div class="control-group">
                                            <div class="controls controls-row">
                                                <?php
                                                $query_prov = "SELECT id, codigo_proveedor, nombre_proveedor FROM proveedores";
                                                $result_prov = mysql_query($query_prov);

                                                ?>
                                                <select id="proveedor" name="proveedor" class="chzn-select-deselect" data-placeholder="Seleccione proveedor">
                                                    <option value=""></option>
                                                    <?php
                                                    while ($row_prov =  mysql_fetch_array($result_prov)) {
                                                        echo '<option value="' . $row_prov['codigo_proveedor'] . '">' . $row_prov['nombre_proveedor'] .'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row-fluid">
                                    <div class="span5">
                                        <div class="control-group">
                                            <div class="controls controls-row">
                                                <input type="text" class="input-block-level" placeholder="Marca" name="marca">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span5">
                                        <div class="control-group">
                                            <div class="controls controls-row">
                                                <input type="text" class="input-block-level" placeholder="Marca" name="marca2">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row-fluid">
                                    <div class="span5">
                                        <div class="control-group">
                                            <div class="controls controls-row">
                                                <input type="text" class="input-block-level" placeholder="Reemplazo" name="reemplazo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span5">
                                        <div class="control-group">
                                            <div class="controls controls-row">
                                                <input type="text" class="input-block-level" placeholder="Relacion" name="relacion">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" id="btn-filtrar-articulos" class="btn">Filtrar</button>
                            </form>
                        </div>  
                    </div>
                </div>