<?php ini_set('MAX_EXECUTION_TIME', -1);

$link = mysqli_connect("db-mysql-nyc3-22736-do-user-11066346-0.b.db.ondigitalocean.com", "doadmin", "AmMG2DvQVU4GgWgk", "defaultdb", 25060);

/* comprobar la conexión */
if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}

echo 'Lista seleccionada: ' . $_GET['lista'];
if (isset($_GET['lista'])) {
    
     $registros_importados = 0;
     $date_array = preg_split( '/[-\.\/ ]/', $_GET['fecha-importacion']);
     $sql_date = date('Y-m-d', mktime(0,0,0,$date_array[1],$date_array[0],$date_array[2]));
     
     $fecha_importacion = $sql_date;

    
     $contador_actualizo = 0;
     $contador_nuevos = 0;
     $contador_bajo_costo = 0;
     $contador_noactualizo = 0;

     $filename_nuevos = '';
     $filename_bajaron = '';
     $filename_noactualizaron = '';

     $articulos_nuevos_csv = '';
     $articulos_noactualizo_csv = '';
     $articulos_bajo_costo_csv = '';
    
    $id_lista = $_GET['lista'];

    $query = "SELECT proveedor_id, p.`nombre_proveedor` , l.`nombre_archivo`, l.`id`
        , l.`nombre_tabla`, l.`columnas`, l.`separador_columnas`,l.`columna_cod_interno`,
        p.`codigo_proveedor`, l.`script`, l.`post_script`
        FROM listas l
        INNER JOIN proveedores p ON p.`id` =  l.`proveedor_id`
        WHERE l.`id` = $id_lista";
    $result = mysqli_query($link, $query);     
    
    $row = mysqli_fetch_array($result);         
    $archivo = $row['nombre_archivo'];
    $archivo = str_replace('\\', '/', $archivo);
    $proveedor_id = $row['proveedor_id'];
    $proveedor_nombre = $row['nombre_proveedor'];
    $codigo_proveedor = $row['codigo_proveedor'];
    $nombre_tabla = $row['nombre_tabla'];
    $columnas = $row['columnas'];
    $separador_columnas = $row['separador_columnas'];
    $columna_cod_interno = $row['columna_cod_interno'];
    $script = $row['script'];
    $post_script = $row['post_script'];

    //die('codigo ' . $codigo_proveedor . ' tabla: ' . $nombre_tabla . ' file: ' . $archivo);

    /*
        Lista VW
    */
    if($codigo_proveedor == '007') {

        //truncate
        $sql_truncate = "truncate table $nombre_tabla";
        $res = mysqli_query($link, $sql_truncate);

        //Load Data
        $load_data = "LOAD DATA LOCAL INFILE '$archivo' 
                        INTO TABLE $nombre_tabla (@row) 
                        SET 
                        campo1 = TRIM(SUBSTR(@row,1,4)),
                        campo2 = TRIM(SUBSTR(@row,5,1)),
                        original = SUBSTR(@row,6,20), 
                        precio_publico = TRIM(SUBSTR(@row,26,11)),
                        campo5 = TRIM(SUBSTR(@row,37,4)), 
                        ue = TRIM(SUBSTR(@row,41,7)), 
                        descripcion = TRIM(SUBSTR(@row,48,25)),
                        reemplazo = TRIM(SUBSTR(@row,85,21)),
                        cod_dto = TRIM(SUBSTR(@row,133,1)),
                        cod_lista = TRIM(SUBSTR(@row,134,2)),
                        precio_iva = TRIM(SUBSTR(@row,142,11))";
        $res = mysqli_query($link, $load_data);
        if (!$res) {
            die('Error al importar lista VW. Cod Prov: ' . $codigo_proveedor . ' Tabla: ' . $nombre_tabla . ' File: ' . $archivo . ' SQL: '. $load_data);
        } else {
            //die('Lista Importada OK');
        }
/*
        //Agrega columna ID
        $sql_columna_id = "ALTER TABLE $nombre_tabla ADD id INT(11)";//" PRIMARY KEY AUTO_INCREMENT";
        $res_ci = mysqli_query($link, $sql_columna_id);

        //Agrega Clave Primaria
        $sql_pk = "ALTER TABLE $nombre_tabla ADD PRIMARY KEY (id)";//" ";
        $res_pk = mysqli_query($link, $sql_pk);
*/
        //cantidad de registros
        $sql_cant = "select count(*) as registros from $nombre_tabla";    
        $res = mysqli_query($link, $sql_cant);
        $row = mysqli_fetch_array($res);
        $registros_importados = $row['registros'];
    }

    /*
        Lista FENIX
    */
    if($codigo_proveedor == '000') {
        die('Importacion no disponible');
        /*
        //CARGA LOS ARTICULOS CON LA LISTA VW
        $sql_truncate = "truncate table articulos";
        $res = mysqli_query($link, $sql_truncate);

         //Load Data
        $load_data = "LOAD DATA LOCAL INFILE '$archivo' 
                        INTO TABLE articulos (@row) 
                        SET
                        codigo_fenix = SUBSTR(@row,6,20), 
                        codigo_oem = SUBSTR(@row,6,20), 
                        descripcion = TRIM(SUBSTR(@row,48,25)),
                        proveedor_testigo = 8,
                        rubro = 1,
                        marca = 1,
                        utilidad = 40,
                        fecha_alta = NOW(),
                        precio_lista = TRIM(SUBSTR(@row,142,11))/100";
        $res = mysqli_query($link, $load_data);

        $sql_update = "UPDATE articulos SET codigo_fenix = CONCAT(SUBSTRING(codigo_fenix,1,3) , '/' ,SUBSTRING(codigo_fenix,5,3)  , SUBSTRING(codigo_fenix,9,3) , '/' ,SUBSTRING(codigo_fenix,13,2) , '/' ,SUBSTRING(codigo_fenix,16,3) )";
        $res_update = mysqli_query($link, $sql_update);
        */   

        /**
        * Carga Costos
        */

        /*
        $sql_truncate = "truncate table costos_proveedor";
        $res = mysqli_query($link, $sql_truncate);
        */
        
        
        //RUTINA CREADA PARA LA IMPORTACION DE COSTOS DESDE LA LISTA VW

        $pid = 20;

        $load_data = "LOAD DATA LOCAL INFILE '$archivo' 
                        INTO TABLE costos_proveedor (@row) 
                        SET
                        proveedor_id = $pid, 
                        codigo_fenix = SUBSTR(@row,6,20), 
                        interno_proveedor = SUBSTR(@row,6,20), 
                        descripcion = TRIM(SUBSTR(@row,48,25)),
                        moneda = 'PES',
                        marca = 1,
                        utilidad = 0,
                        testigo = 'NO',
                        dto1 = 0,
                        dto2 = 0,
                        dto3 = 0,
                        rec1 = 0,
                        fecha = NOW(),
                        costo = TRIM(SUBSTR(@row,142,11)) /100,
                        costo_lista = TRIM(SUBSTR(@row,142,11))/100";
        $res = mysqli_query($link, $load_data);

        $sql_update = "UPDATE costos_proveedor SET codigo_fenix = CONCAT(SUBSTRING(codigo_fenix,1,3) , '/' ,SUBSTRING(codigo_fenix,5,3)  , SUBSTRING(codigo_fenix,9,3) , '/' ,SUBSTRING(codigo_fenix,13,2) , '/' ,SUBSTRING(codigo_fenix,16,3) ) where proveedor_id = $pid";        
        $res_update = mysqli_query($link, $sql_update);
        

        /**
        * Carga Stock
        */
        /*
        $sql_truncate = "truncate table stock";
        $res = mysqli_query($link, $sql_truncate);

        $load_data = "LOAD DATA LOCAL INFILE '$archivo' 
                        INTO TABLE stock (@row) 
                        SET
                        articulo_fenix = SUBSTR(@row,6,20), 
                        cantidad = 999,
                        sucursal_id = 1,
                        ubicacion = 'A000'";
        $res = mysqli_query($link, $load_data);

        $sql_update = "UPDATE stock SET articulo_fenix = CONCAT(SUBSTRING(articulo_fenix,1,3) , '/' ,SUBSTRING(articulo_fenix,5,3) , SUBSTRING(articulo_fenix,9,3) , '/' ,SUBSTRING(articulo_fenix,13,2) , '/' ,SUBSTRING(articulo_fenix,16,3) )";
        $res_update = mysqli_query($link, $sql_update);
        */
        
        /*
        $sql_vw = "SELECT original, descripcion, precio_iva FROM lista_vw";
        $res_vw = mysqli_query($link, $sql_vw);
        $c = 0;
        while ($row_vw = mysqli_fetch_array($res_vw)) {
            $original = $row_vw['original'];
            $descripcion = $row_vw['descripcion'];
            $precio_iva = $row_vw['precio_iva'] / 100;

            //obtiene la descripcion
            
            $sql_descrip = "SELECT descripcion FROM lista_fenix WHERE codigo_oem = '$original'";
            $res_descrip = mysqli_query($link, $sql_descrip);
            while ($row_descrip = mysqli_fetch_array($res_descrip)) {
                $descripcion = $row_descrip['descripcion'];
            }

            $descripcion = str_replace("'", "", $descripcion);

            $insert_sql = "INSERT INTO articulos(codigo_fenix, codigo_oem, descripcion, precio_lista) 
                                            VALUES ('$original', '$original', '$descripcion', '$precio_iva');";   
            echo $insert_sql . '<br>';
            
            $res_insert = mysqli_query($link, $insert_sql);
            
            if (!$res_insert) {
                die('Error en:' . $insert_sql);
            }
            

            $c++;
        }
       

        $registros_importados = $c;
        */


        /*
        //
        //IMPORTACION DE LA LISTA FENIX
        //

        //truncate
        $sql_truncate = "truncate table lista_fenix";
        $res = mysqli_query($link, $sql_truncate);

        //Load Data
        $load_data = "LOAD DATA LOCAL INFILE '$archivo' 
                      INTO TABLE lista_fenix  
                      FIELDS TERMINATED BY ';'";
        $res = mysqli_query($link, $load_data);

        //Actualiza los articulos
        
        $sql_actualiza = "select codigo_fenix, codigo_oem, descripcion, stock, ubicacion, proveedor, reemplazo, marca, precio 
                          from lista_fenix";    
        $res = mysqli_query($link, $sql_actualiza);
        while($row = mysqli_fetch_array($res)) {
            
            $codigo_fenix = $row['codigo_fenix'];
            $codigo_oem = $row['codigo_oem'];
            $descripcion = $row['descripcion'];
            $descripcion = str_replace("'", "", $descripcion);
            $stock = $row['stock'];
            $ubicacion = $row['ubicacion'];
            $proveedor = $row['proveedor'];
            $reemplazo = $row['reemplazo'];
            $marca = $row['marca'];
            $precio = str_replace("\$", "", $row['precio']);
            $precio = str_replace(".", "", $precio);

            $sql_art = "select * from articulos WHERE codigo_fenix = '$codigo_fenix'";
            $res_art = mysqli_query($link, $sql_art);
            $c = 0;
            while($row_art = mysqli_fetch_array($res_art)) {
                $c++;    
                $update_sql = "UPDATE articulos SET codigo_oem = '$codigo_oem',"
                        . " descripcion = '$descripcion', precio_lista = '$precio',"
                        . " marca = '$marca', proveedor_testigo = '$proveedor' "
                        . " WHERE codigo_fenix = '$codigo_fenix'";
                $res_update = mysqli_query($link, $update_sql);
                if(!$res_update){
                    die('Error en:' . $update_sql);
                }
            }

            if($c == 0) {
                 $insert_sql = "INSERT INTO articulos(codigo_fenix, codigo_oem, descripcion, precio_lista) 
                                            values('$codigo_fenix', '$codigo_oem', '$descripcion', '$precio')";   
                 $res_insert = mysqli_query($link, $insert_sql);        
                 if(!$res_update){
                    die('Error en:' . $insert_sql);
                 }
            }
            
            //Actualiza stock y ubicacion
           
            $sql_stk = "SELECT articulo_fenix FROM stock WHERE articulo_fenix = '$codigo_fenix'";
            $res_stk = mysqli_query($link, $sql_stk);
            $c_stk = 0;
            while($row_stk = mysqli_fetch_array($res_stk)) {
                $c_stk++;    
                $update_stk = "UPDATE stock SET cantidad = '$stock', ubicacion = '$ubicacion'
                                WHERE articulo_fenix = '$codigo_fenix'";
                $res_update_stk = mysqli_query($link, $update_stk); 
            }

            if($c_stk == 0) {
                 $insert_stk = "INSERT INTO stock(articulo_fenix, cantidad, sucursal_id, ubicacion) 
                                            values('$codigo_fenix', '$stock', '1', '$ubicacion')";   
                 $res_insert = mysqli_query($link, $insert_stk);        
            }
            
        }
        */

        //cantidad de registros
        $sql_cant = "select count(*) as registros from articulos";    
        $res = mysqli_query($link, $sql_cant);
        $row = mysqli_fetch_array($res);
        $registros_importados = $row['registros'];
        
    }
    
    /*
        Lista OFERTAS
    */
    if($codigo_proveedor == '002') {
        //truncate
        $sql_truncate = "truncate table ofertas";
        $res = mysqli_query($link, $sql_truncate);

        //Load Data
        $load_data = "LOAD DATA LOCAL INFILE '$archivo' 
                      INTO TABLE ofertas  
                      FIELDS TERMINATED BY ';'";
        $res = mysqli_query($link, $load_data);

        //cantidad de registros
        $sql_cant = "select count(*) as registros from ofertas";    
        $res = mysqli_query($link, $sql_cant);
        $row = mysqli_fetch_array($res);
        $registros_importados = $row['registros'];
    }

    //Lista Renault (Tagle)
    if ($codigo_proveedor == '051') {
        //truncate
        $sql_truncate = "truncate table $nombre_tabla";
        $res = mysqli_query($link, $sql_truncate);

        //Load Data
        $load_data = "LOAD DATA LOCAL INFILE '$archivo' 
                        INTO TABLE $nombre_tabla (@row) 
                        SET 
                        original = TRIM(SUBSTR(@row,1,12)), 
                        descripcion = TRIM(SUBSTR(@row,14,25)),
                        cod_dto_viejo = TRIM(SUBSTR(@row,39,2)), 
                        cod_dto = TRIM(SUBSTR(@row,41,1)), 
                        nro_catalogo = TRIM(SUBSTR(@row,45,3)),
                        reemplazo = TRIM(SUBSTR(@row,56,12)),
                        fecha_baja = TRIM(SUBSTR(@row,70,6)),
                        campo1 = TRIM(SUBSTR(@row,76,8)),
                        precio = TRIM(SUBSTR(@row,84,10))";

        
        $res = mysqli_query($link, $load_data);

        //Agrega columna ID
        $sql_columna_id = "ALTER TABLE $nombre_tabla ADD id INT(11)";//" PRIMARY KEY AUTO_INCREMENT";
        $res_ci = mysqli_query($link, $sql_columna_id);

        //Agrega Clave Primaria
        $sql_pk = "ALTER TABLE $nombre_tabla ADD PRIMARY KEY (id)";//" ";
        $res_pk = mysqli_query($link, $sql_pk);

        //cantidad de registros
        $sql_cant = "select count(*) as registros from $nombre_tabla";    
        $res = mysqli_query($link, $sql_cant);
        $row = mysqli_fetch_array($res);
        $registros_importados = $row['registros'];
    }

    //Lista Chevrolet (Maipu Chevrolet)
    if ($codigo_proveedor == '006') {
        //truncate
        $sql_truncate = "truncate table $nombre_tabla";
        $res = mysqli_query($link, $sql_truncate);

        //Load Data
        $load_data = "LOAD DATA LOCAL INFILE '$archivo' 
                        INTO TABLE $nombre_tabla (@row) 
                        SET 
                        PIEZA = TRIM(SUBSTR(@row,1,20)), 
                        DESCRIPCION = TRIM(SUBSTR(@row,21,60)),
                        REEMP1 = TRIM(SUBSTR(@row,81,12)), 
                        REEMP2 = TRIM(SUBSTR(@row,93,25)), 
                        REEMP3 = TRIM(SUBSTR(@row,118,11)),
                        REEMP4 = TRIM(SUBSTR(@row,129,11)),
                        VEHICULO = TRIM(SUBSTR(@row,140,35)),
                        PRECONC = TRIM(SUBSTR(@row,175,10)),
                        CODMARG = TRIM(SUBSTR(@row,185,11)),
                        REEMP5 = TRIM(SUBSTR(@row,196,11)),
                        REEMP6 = TRIM(SUBSTR(@row,207,11)),
                        REEMP7 = TRIM(SUBSTR(@row,218,30)),
                        CAMPCLAS = TRIM(SUBSTR(@row,248,14)),
                        REEMP8 = TRIM(SUBSTR(@row,262,15)),
                        ULTIACTU = TRIM(SUBSTR(@row,277,8)),
                        UNIFICA = TRIM(SUBSTR(@row,285,10))";

        
        $res = mysqli_query($link, $load_data);

        //Agrega columna ID
        $sql_columna_id = "ALTER TABLE $nombre_tabla ADD id INT(11)";//" PRIMARY KEY AUTO_INCREMENT";
        $res_ci = mysqli_query($link, $sql_columna_id);

        //Agrega Clave Primaria
        $sql_pk = "ALTER TABLE $nombre_tabla ADD PRIMARY KEY (id)";//" ";
        $res_pk = mysqli_query($link, $sql_pk);

        //cantidad de registros
        $sql_cant = "select count(*) as registros from $nombre_tabla";    
        $res = mysqli_query($link, $sql_cant);
        $row = mysqli_fetch_array($res);
        $registros_importados = $row['registros'];
    }

    
    /*
        Otros proveedores
    */
    if($codigo_proveedor != '000' &&
     $codigo_proveedor != '002' &&
      $codigo_proveedor != '007' &&
      $codigo_proveedor != '051' &&
      $codigo_proveedor != '006') {
        
        //die($nombre_tabla);

        $sql_articulos_actualizar = ''; 
        //Borra la tabla
        $sql_droptable = "DROP TABLE IF EXISTS $nombre_tabla;";
        $res_droptable = mysqli_query($link, $sql_droptable);
        //die($nombre_tabla);
        if ($res_droptable) {
            //Create tabla
            $sql_createtable = "CREATE TABLE $nombre_tabla (";
            $cols = explode(',', $columnas);
            foreach ($cols as $k => $colname) {
                $sql_createtable .= "$colname varchar(255)". ($k < (count($cols)-1)?',':'');
            }
            $sql_createtable .= ');';
            $res_createtable = mysqli_query($link, $sql_createtable);
            
            if ($res_createtable) {
                if (trim($script) == '') {
                    //Importa los datos
                     $load_data = "LOAD DATA LOCAL INFILE '$archivo' 
                                  INTO TABLE $nombre_tabla  
                                  FIELDS TERMINATED BY '$separador_columnas'";
                } else {
                    //Importa los datos
                     $script = str_replace('{archivo}', $archivo, $script);
                     $script = str_replace('{nombre_tabla}', $nombre_tabla, $script);
                     $load_data = $script;
                }
                $res_loaddata = mysqli_query($link, $load_data);
                
                //die('importa');

                //Ejecuta el post script
                if ($script != '' && $post_script != '') {
                    $res_postscript = mysqli_query($link, $post_script);
                    if (!$res_postscript){
                        die('Error al ejecutar post script:' . $post_script);
                    }
                    else {
                        //die ('Post script OK:' . $post_script);
                    }
                }

                 //Ejecuta el post script - Para lista Haimovixh
                if ($post_script != '' && $script == '') {
                    $res_postscript = mysqli_query($link, $post_script);
                    if (!$res_postscript){
                        die('Error al ejecutar post script:' . $post_script);
                    }
                }

                //Si cargo bien el archivo de la lista
                if ($res_loaddata) {
                    /*
                    //
                    // SE COMENTA PORQUE AHORA LO HACE LE BARRIDO
                    //
                    
                    //Busca los articulos cargados en costos del proveedor
                    $sql_costos_cargados = "SELECT codigo_fenix, interno_proveedor, descripcion, marca, costo, utilidad"
                            . " FROM costos_proveedor WHERE proveedor_id = $proveedor_id";
                    $res_costos_cargados = mysqli_query($link, $sql_costos_cargados);
                    //echo $sql_costos_cargados.'<br>';
                    while($row_costop = mysqli_fetch_array($res_costos_cargados)) {
                        $interno_prov = $row_costop['interno_proveedor'];
                        $codigo_fenix = $row_costop['codigo_fenix'];
                        $descripcion_costo = $row_costop['descripcion'];
                        $marca_costo = $row_costop['marca'];
                        $costo_actual = $row_costop['costo'];
                        
                        //Busca el articulo en la lista 
                        $sql_costos_lista = "SELECT $columnas FROM $nombre_tabla "
                                . " WHERE $columna_cod_interno = '$interno_prov'";
                        $res_costo_lista = mysqli_query($link, $sql_costos_lista);
                        
                        while($row_costo_lista = mysqli_fetch_array($res_costo_lista)) {
                            //id, cod_cromosol, descripcion, marca, precio_lista, cod_oem
                            $descripcion_lista = $row_costo_lista['descripcion'];
                            $marca_lista = $row_costo_lista['marca'];
                            $costo_nuevo = $row_costo_lista['precio_lista'];
                            
                            $sql_update = "UPDATE costos_proveedor";
                            
                            $sql_update .= " SET ";
                            
                            if(($descripcion_costo == $descripcion_lista) || $descripcion_costo == '') {
                                $sql_update .= " descripcion = '$descripcion_lista', ";
                            }
                            
                            if ($marca_costo == $marca_lista || $marca_costo == '') {
                                $sql_update .= " marca = '$marca_lista', "; 
                            }
                            
                            //BAJO COSTO
                            if(($costo_nuevo * 1) < ($costo_actual * 1)){
                                $sql_update .= " costo = '$costo_nuevo', ";
                            } else {
                                $sql_update .= " costo = '$costo_nuevo', ";
                            }
                            
                            $sql_update .= " costo_anterior = '$costo_actual', ";
                            
                            $sql_update .= " fecha = now() ";
                            
                            $sql_update .= " WHERE proveedor_id = $proveedor_id AND codigo_fenix = '$codigo_fenix' AND interno_proveedor = '$interno_prov';";
                            
                            $res_update = mysqli_query($link, $sql_update);
                            
                            if ($res_update) {
                                $contador_actualizo++;
                                
                                //Bajo el costo
                                if(($costo_nuevo * 1) < ($costo_actual * 1)){
                                    $contador_bajo_costo++;
                                    $articulos_bajo_costo_csv .= $codigo_fenix.';'.$interno_prov.';'.$descripcion_lista.';'.$descripcion_costo.'\r\n';
                                }
                                
                                //No actualizados
                                if(($costo_nuevo * 1) == ($costo_actual * 1)){
                                    $contador_noactualizo++;
                                    $articulos_noactualizo_csv .= $codigo_fenix.';'.$interno_prov.','.$descripcion_lista.';'.$descripcion_costo.'\r\n';
                                }
                                
                            }
                            
                            $sql_articulos_actualizar .= $sql_update;
                        }
                            
                    }*/
                
                    
                    //
                    //Articulos nuevos
                    //
                    //$sql_nuevos = "select $columna_cod_interno, descripcion, marca, precio_lista FROM $nombre_tabla c where c.`$columna_cod_interno` NOT IN (SELECT interno_proveedor FROM costos_proveedor WHERE proveedor_id = $proveedor_id)";
                    //$sql_nuevos = "select * FROM $nombre_tabla c where c.`$columna_cod_interno` NOT IN (SELECT interno_proveedor FROM costos_proveedor WHERE proveedor_id = $proveedor_id)";
                    $sql_nuevos = "select * FROM $nombre_tabla c where 1 = 1";
                    $res_nuevos = mysqli_query($link, $sql_nuevos);
                    while ($row_nuevos = mysqli_fetch_array($res_nuevos)) {
                        $articulos_nuevos_csv .= $row_nuevos[$columna_cod_interno].';'.$res_nuevos['descripcion'].';'.$res_nuevos['marca']. '\n\r';
                        $contador_nuevos++;
                    }
                    //die('nuevos');
                    $filename_nuevos = 'assets/uploads/files/importacion/' . $codigo_proveedor.'-'.date('Ymd').'-NUEVOS.csv';
                    $file_nuevos = fopen($filename_nuevos, "w");
                    fwrite($file_nuevos, $articulos_nuevos_csv);
                    fclose($file_nuevos);
                    
                    //
                    //Bajaron Costo
                    //
                    $filename_bajaron = 'assets/uploads/files/importacion/' .$codigo_proveedor.'-'.date('Ymd').'-SUBEUTILIDAD.csv';
                    $file_bajocosto = fopen($filename_bajaron, "w");
                    fwrite($file_bajocosto, $articulos_bajo_costo_csv);
                    fclose($file_bajocosto);
                    
                    //
                    //No Actualizaron
                    //
                    $filename_noactualizaron = 'assets/uploads/files/importacion/' . $codigo_proveedor.'-'.date('Ymd').'-NOACTUALIZADOS.csv'; 
                    $file_noactualizo = fopen($filename_noactualizaron, "w");
                    fwrite($file_noactualizo, $articulos_noactualizo_csv);
                    fclose($file_noactualizo);
                    
                    //cantidad de registros
                   $sql_cant = "select count(*) as registros from $nombre_tabla";    
                   $res = mysqli_query($link, $sql_cant);
                   $row = mysqli_fetch_array($res);
                   $registros_importados = $row['registros'];
                 } else {
                     die('Error al Importar lista:'. $load_data . '<br/>'. mysqli_error());    
                 }
            }
        }
        
    }

    //Update lista
    $sql_update_fecha = "UPDATE listas SET fecha_actualizacion = '$fecha_importacion' where id = $id_lista";
    $res = mysqli_query($link, $sql_update_fecha);
    

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
                        <button class="btn btn-danger" onclick="window.history.back()"><i class="icon-arrow-left"></i></button>
                        Importar listas de precio
                    </h3>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <?php
               $query = "SELECT proveedor_id, codigo_proveedor, p.`nombre_proveedor` , l.`nombre_archivo`, l.`id`, l.`nombre_tabla`, l.`columna_cod_interno`, l.`columna_precio`
                    FROM listas l
                    INNER JOIN proveedores p ON p.`id` =  l.`proveedor_id`
                    WHERE importa_lista = 'SI' ORDER BY p.`nombre_proveedor`";
               $result = mysqli_query($link, $query);

               $query_prov = "SELECT id, nombre_proveedor, codigo_proveedor
                    FROM proveedores ORDER BY nombre_proveedor";
               $result_prov = mysqli_query($link, $query_prov);
            ?>
            <div>
                <form method="get" action="" id="form-importar">
                    <label>Lista<label>
                    <select name="lista" class="chzn-select-deselect" id="lista-proveedor" data-placeholder="Seleccione la lista">
                        <option value="99999"></option>
                        <?php 
                         while($row = mysqli_fetch_array($result)) {
                            ?>
                            <option value="<?php echo $row['id'];?>" data-provid="<?php echo $row['proveedor_id'];?>" data-colprecio="<?php echo $row['columna_precio'];?>" data-colinterno="<?php echo $row['columna_cod_interno'];?>" data-codigo="<?php echo $row['codigo_proveedor'];?>" data-tabla="<?php echo $row['nombre_tabla'];?>"><?php echo $row['codigo_proveedor'] . ' - ' . $row['nombre_proveedor'];?></option>
                            <?php    
                         }  
                        ?>                    
                    </select>
                    <br/>

                    <label class="control-label">Fecha</label>
                    <input type="text" value="<?php echo date('d/m/Y'); ?>" size="8" id="fecha-importacion" class="span2" name="fecha-importacion">

                    <br/>

                    <button type="submit" id="btn-importar" class="btn btn-primay">Importar</button>
                </form>
            </div>
            <br>
            <div>
                <h3 class="page-title">
                        <button class="btn btn-danger" onclick="window.history.back()"><i class="icon-arrow-left"></i></button>
                        Barrer costos de proveedores
                    </h3>
                <form method="get" action="" id="form-barrer">
                    <label>Proveedor<label>
                    <select name="proveedor" class="chzn-select-deselect" id="proveedor" data-placeholder="Seleccione Proveedor">
                        <option value="99999"></option>
                        <?php 
                         while($row_prov = mysqli_fetch_array($result_prov)) {
                            ?>
                            <option value="<?php echo $row_prov['id'];?>"><?php echo $row_prov['codigo_proveedor'] . ' - ' . $row_prov['nombre_proveedor'];?></option>
                            <?php
                         }
                        ?>
                    </select>
                    <br/>
                    <label class="control-label">Fecha</label>
                    <input type="text" value="<?php echo date('d/m/Y'); ?>" size="8" id="fecha-barrido" class="span2">
                    <br/>
                    <button type="button" id="btn-costos" class="btn btn-primay">Cargar Costos</button>
                </form>
            </div>
            <br/>
            <?php

            if(isset($_GET['lista'])) {
                echo 'Se importaron ' . number_format($registros_importados,0,'','.') . ' registros de la lista '. $proveedor_nombre . '<br/>';
                echo 'Se actualizaron ' . number_format($contador_actualizo,0,'','.') . ' registros en el costo del proveedor<br>';
                echo 'Hay ' . number_format($contador_nuevos,0,'','.') . ' articulos nuevos <a href="http://'.$_SERVER['HTTP_HOST'].'/sistema/'.$filename_nuevos.'">Descargar CSV</a><br>';
                echo 'Hay ' . number_format($contador_bajo_costo,0,'','.') . ' articulos que bajaron de precio <a href="http://'.$_SERVER['HTTP_HOST'].'/sistema/'.$filename_bajaron.'">Descargar CSV</a><br>';
                echo 'Hay ' . number_format($contador_noactualizo,0,'','.') . ' articulos que no se actualizaron <a href="http://'.$_SERVER['HTTP_HOST'].'/sistema/'.$filename_noactualizaron.'">Descargar CSV</a><br>';
            }

            ?>    
            <script src="//oss.maxcdn.com/jquery/1.8.3/jquery-1.8.3.min.js"></script>
            <!--            
            <script src="<?= base_url() ?>assets/js/jquery.blockUI.js"></script>
            <script src="<?= base_url() ?>assets/js/ajaxupload.3.5.js"></script>
            <script src="<?= base_url() ?>assets/js/application.js"></script>
-->
        </div>
    </div>
</div>
 <!-- END PAGE -->
 <?php $this->load->view('administrador/dashboard/footer'); ?>
<script>
$.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };

    $.datepicker.setDefaults($.datepicker.regional['es']);

    jQuery(document).ready(function() {
    

        $('#fecha-importacion').datepicker({
           format: 'dd/mm/yyyy'
        });

        $('#fecha-barrido').datepicker({
            format: 'dd/mm/yyyy'
        });
    });

    $('#btn-importar').click(function() {
        $(this).text("Importando...");
        $(this).attr('disabled',true);
        $('#form-importar').submit();
    });

    $('#btn-costos').click(function() {
        var _proveedor_id = $('#proveedor').val();
        var _fecha_barrido = $('#fecha-barrido').val();
        var _fechaBarridoArray = _fecha_barrido.split('/');
        _fecha_barrido = _fechaBarridoArray[2] + '-' + _fechaBarridoArray[1] + '-' + _fechaBarridoArray[0];

        var uri = '/fenix/sistema/costo_proveedor_controller/barrerCostos';
        if (window.location.host != 'localhost') {
            uri = '/costo_proveedor_controller/barrerCostos';
        }

        var datos = {
            proveedor_id : _proveedor_id,
            fecha_barrido : _fecha_barrido
        };

        $.ajax({
               url: uri,
               data: datos,
               type: 'POST',
               success: function(data) {
                   var datosJson = JSON.parse(data);
                   console.log(datosJson);
               }
        });
                
    });
</script>
