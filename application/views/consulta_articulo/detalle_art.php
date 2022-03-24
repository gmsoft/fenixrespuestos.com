<?php
///print_r($articulo); die;
$sucursal = $this->session->userdata['logged_in']['sucursal'];
?>
<div class="span7">
    <div class="widget green">
        <div class="widget-title">
            <h4><i class="icon-reorder"></i> Datos de Articulo </h4>
            <span style="margin-left: 100px;">
                <button id="btn-add-art" class="btn btn-info">
                    <i class="icon-plus"></i> Agregar a presupuesto</button>
                <a id="btn-add-art" class="btn btn-warning" href="<?php echo base_url(); ?>administrador/presupuesto?carrito=1" target="_blank">
                    <i class="icon-list"></i> Ver presupuesto</a>
            </span>
            <span class="tools">
                <a href="javascript:;" class="icon-chevron-down"></a>                                
            </span>
        </div>
        <div class="widget-body">
            <form method="post" action="consulta_articulos" id="form_consulta">
                <div class="row-fluid">
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label">Codigo Fenix</label>
                            <h2><?php echo $articulo['codigo_fenix'];?></h2>
                            <input type="hidden" id="codfenix" value="<?php echo $articulo['codigo_fenix'];?>">
                            <input type="hidden" id="oem" value="<?php echo $articulo['codigo_oem'];?>">
                            <input type="hidden" id="precio" value="<?php echo $articulo['precio_lista'];?>">
                            <!--
                            <div class="controls controls-row">
                                <input type="text" class="input-block-level" placeholder="Articulo" name="articulo" value="<?php echo $articulo['codigo_fenix'];?>">
                            </div>
                        -->
                        </div>
                    </div>
                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label">Codigo OEM</label>
                            <h3><?php echo $articulo['codigo_oem'];?></h3>
                            <!--
                            <div class="controls controls-row">
                                <input type="text" class="input-block-level" placeholder="OEM" name="oem" value="<?php echo $articulo['codigo_oem'];?>">
                            </div>-->
                        </div>
                    </div>
                    <div class="span2">
                        <label class="control-label">Reemplazo</label>
                        <?php 
                        
                        $sql_reemplazo = "select reemplazo, proveedor, marca from lista_fenix where codigo_oem = '" . $articulo['codigo_oem'] . "'";
                        $res = mysqli_query($link, $sql_reemplazo);
                        $reemplazo = '';
                        $marca = '';
                        while($row_datos = mysqli_fetch_array($res)) {
                            $reemplazo = $row_datos['reemplazo'];
                            $marca = $row_datos['marca'];
                        }
                        
                        echo '<h3>' . $reemplazo . '</h3>';
                        ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span10">
                        <h3><?php echo $articulo['descripcion'];?></h3>
                        <!--<div class="control-group">
                            <div class="controls controls-row">
                                <input type="text" class="input-block-level" placeholder="Descripcion" name="descripcion" value="<?php echo $articulo['descripcion'];?>">
                            </div>
                        </div>-->
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span2">
                        <label class="control-label">Proveedor</label>
                        <?php 
                        
                        $sql_proveedor = "SELECT p.id, p.nombre_proveedor, p.codigo_proveedor FROM costos_proveedor c INNER JOIN proveedores p ON p.id = c.proveedor_id WHERE testigo = 'SI' AND codigo_fenix = '" . $articulo['codigo_fenix'] . "'";
                        $res = mysqli_query($link, $sql_proveedor);
                        @$row = mysqli_fetch_array($res);
                        echo '<h3>' . @$row['codigo_proveedor'] . '</h3>';

                        ?>
                    </div>
                    <div class="span2">
                        <label class="control-label">Marca</label>
                        <?php
                        /* 
                        $sql_marca = "select nombre from marcas where id = " . $articulo['marca'];
                        $res = mysqli_query($link, $sql_marca);
                        @$row = mysqli_fetch_array($res);
                        $marca = $row['nombre'];*/
                        if ($marca != '') {
                            echo '<h3>' . $marca . '</h3>';
                        }
                        ?>
                    </div>
                    <div class="span2">
                        <label class="control-label">Rubro</label>
                        <?php 
                        $sql_rubro = "select nombre from rubros where id = " . $articulo['rubro'];
                        $res = mysqli_query($link, $sql_rubro);
                        $row = mysqli_fetch_array($res);
                        echo '<h3>' . $row['nombre'] . '</h3>';
                        ?>
                    </div>
                    <div class="span2">
                        <label class="control-label">Ubicacion</label>
                        <?php 
                        $sql_ubi = "SELECT cantidad, c.`nombre`, u.ubicacion 
                        FROM stock s 
                        INNER JOIN sucursales c ON c.`id` = s.`sucursal_id` 
                        INNER JOIN ubicaciones u ON u.id = s.ubicacion
                        WHERE articulo_fenix = '" . $articulo['codigo_fenix'] . "' AND s.sucursal_id = $sucursal";
                        $res_ubi = mysqli_query($link, $sql_ubi);
                        @$row_ubi = mysqli_fetch_array($res_ubi);
                        $ubicacion = $row_ubi['ubicacion'];
                        $stock = $row_ubi['cantidad'];
                        echo '<h3>' . $ubicacion . '</h3>';
                        ?>
                    </div>
                    <div class="span2">
                        <label class="control-label">Stock</label>
                        <?php 
                        echo '<h3>' . $stock . '</h3>';
                        ?>
                    </div>
                    <div class="span2">
                        <div class="control-group">
                            <label class="control-label">Precio Venta</label>
                            <h3><?php echo $articulo['precio_lista'];?></h3>
                            <!--
                            <div class="controls controls-row">
                                <input type="text" class="input-block-level" placeholder="OEM" name="oem" value="<?php echo $articulo['codigo_oem'];?>">
                            </div>-->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>