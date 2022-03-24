<?php

$ruta = $argv[0];
$proveedor_id = $argv[1];
$fecha_barrido = $argv[2];

$cn = mysql_connect('localhost:3307', 'root', 'Clave01');
if (!$cn) {
	echo "ERROR al conectar a la base de datos";
	die;
}
mysql_select_db('fenix_base');


$sql_prov = "SELECT codigo_proveedor, nombre_proveedor, l.`columnas`, l.`columna_cod_interno`,
 l.`columna_precio`,l.`separador_columnas`, l.`separador_decimal`,l.`separador_miles`,l.`nombre_tabla`,
 l.`dto1`, l.`dto2`, l.`dto3`, l.`rec1`
FROM proveedores p
INNER JOIN listas l ON L.`proveedor_id` = p.`id`
WHERE p.id = $proveedor_id";
$res_prov = mysqli_query($link, $sql_prov);

$contador_proveedor = 0;
$nombre_proveedor = "";
$columna_cod_interno = "";
$columna_precio = "";
$nombre_tabla = "";
$dto_rec1 = 0;
$dto_rec2 = 0;
$dto_rec3 = 0;
$recargo_lista = 0;
while($row_prov = mysqli_fetch_array($res_prov)) {
	$contador_proveedor++;
	$codigo_proveedor = $row_prov['codigo_proveedor'];
	$nombre_proveedor = $row_prov['nombre_proveedor'];
	$columna_cod_interno = $row_prov['columna_cod_interno'];
	$columna_precio = $row_prov['columna_precio'];
	$nombre_tabla = $row_prov['nombre_tabla'];
	/*
	$dto1 = $row_prov['dto1']; // Toma el de la tabla de descuentos
	*/

	//Si es positivo es Recargo, si es negativo es Descuento
	$dto_rec1 = $row_prov['dto1'] * 1;
	$dto_rec2 = $row_prov['dto2'] * 1;
	$dto_rec3 = $row_prov['dto3'] * 1;
	
	$dto1 = $dto_rec1;
	$dto2 = $dto_rec2;
	$dto3 = $dto_rec3;

	if ($dto1 < 0) {
		$dto1 = $dto1 * (-1);
	}

	$recargo_lista = $row_prov['rec1'];
	
}

if ($contador_proveedor == 0) {
	die("ERROR: Proveedor $proveedor_id inexistente ***\r\n ");
} else {
	echo "**** Procesando proveedor $nombre_proveedor *** \r\n";
}

//$filename_reporte_provedor = 'assets/uploads/files/importacion/' . $proveedor_id.'-'.date('Ymd').'-barrido-costos.txt';
$filename_reporte_provedor = 'D:/barridos/' . $proveedor_id.'-'.date('Ymd').'-barrido-costos.txt';
//$filename_reporte = 'assets/uploads/files/importacion/barrido-costos.txt';
$filename_reporte = 'D:/barridos/barrido-costos.txt';
$file_nuevos = fopen($filename_reporte, "w");
$file_content = "PROVEEDOR: $codigo_proveedor - $nombre_proveedor. FECHA: " . date('d/m/Y h:i:s') . " \r\n";


//Verifica si tiene la columna Codigo de Dtos
$sql_cod_dto = "SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT
  FROM INFORMATION_SCHEMA.COLUMNS
  WHERE table_name = '$nombre_tabla'
  AND COLUMN_NAME = 'cod_dto'
  LIMIT 1";
$res_cod_dto = mysqli_query($link, $sql_cod_dto);
$contador_cod_dto = 0;
while($row_cod_dto = mysqli_fetch_array($res_cod_dto)) {
	$contador_cod_dto++;
}

$columna_cod_dto = '';

if ($contador_cod_dto > 0) {
	$columna_cod_dto = ',cod_dto ';
}

$sql = "SELECT $columna_precio, $columna_cod_interno, descripcion $columna_cod_dto FROM $nombre_tabla";

//$sql = "SELECT $columna_precio, $columna_cod_interno, descripcion $columna_cod_dto FROM $nombre_tabla LIMIT 10";
//$sql = "SELECT $columna_precio, $columna_cod_interno, descripcion  $columna_cod_dto FROM $nombre_tabla WHERE original = '000-001-199'";
$res = mysqli_query($link, $sql);
if (!$res) {
	$file_content.="ERROR: No se pudo leer tabla $nombre_tabla : $sql\r\n";
	fwrite($file_nuevos, $file_content);
	fclose($file_nuevos);
	die("ERROR: No se pudo leer tabla $nombre_tabla : $sql\r\n");
}
while($row = mysqli_fetch_array($res)) {
	$original = $row[$columna_cod_interno];
	$descripcion = $row['descripcion'];
	$descripcion = str_replace("'","",$descripcion);
	//$reemplazo = $row['reemplazo'];
	$costo_proveedor = ($row[$columna_precio] * 1) / 100;
	//$precio_iva = ($row['precio_iva'] * 1) / 100;
	if ($contador_cod_dto > 0) {
		$cod_dto = $row['cod_dto'];
		echo "Cod Dto: $cod_dto \r\n";
	}
	
	echo "Procesando codigo: $original\r\n";
	
	$sql_costo = "SELECT codigo_fenix, interno_proveedor, descripcion, fecha, costo, testigo, costo_lista, utilidad, dto1, dto2, dto3, rec1
	FROM costos_proveedor 
	WHERE proveedor_id = $proveedor_id 
	AND interno_proveedor = '$original' LIMIT 1";
	$res_costo = mysqli_query($link, $sql_costo);
	$contador_costo = 0;
	while ($row_costo = mysqli_fetch_array($res_costo)) {
		
		$codigo_fenix = $row_costo['codigo_fenix'];
		$interno_proveedor = $row_costo['interno_proveedor'];
		
		$costo = $row_costo['costo'] * 1;
		$testigo = $row_costo['testigo'];
		$utilidad = $row_costo['utilidad'];
		//Dtos
		//$dto1 = $row_costo['dto1'];
		//$dto2 = $row_costo['dto2']; // Lo lee del ABM de listas
		//$dto3 = $row_costo['dto3']; //Lo lee del ABM de listas
		
		//Rec
		$rec1 = 0;

	    //Si NO trae recargo de la Lista, aplica el recargo del Costo		
		if ($recargo_lista == 0) {
			$rec1 = $row_costo['rec1'];	
		} else {
			$rec1 = $recargo_lista;
		}			
		//Se fija si tiene descuento por la tabla de descuento
		if ($contador_cod_dto > 0) {
			$sql_dto = "SELECT porcentaje_dto FROM proveedor_dto_vw WHERE proveedor_id = $proveedor_id AND codigo = '$cod_dto'";
			
			$res_dto = mysqli_query($link, $sql_dto);
			while ($row_dto = mysqli_fetch_array($res_dto)) {
				$porcentaje_dto = $row_dto['porcentaje_dto'];
				
				//Si el valor es POSITIVO es un Recargo, sino un descuento
				if ($porcentaje_dto > 0) {
					$rec1 = $porcentaje_dto;					
				} else {
					$dto1 = $porcentaje_dto * -1;
				}
			}
		}

		$contador_costo++;

		//Si los costos son distintos
		if ($costo != $costo_proveedor) {
			// El costo NUEVO es MENOR avisa que bajo de precio
			if ($costo_proveedor < $costo ) {
				/*
				Paso 1: de $5 a $6 es un aumento de $1
				Paso 2: divide entre el valor antiguo: $1/$5 = 0,2
				Paso 3: convierte 0,2 en porcentaje: 0,2×100 = aumento de 20%.
				*/
				$diff = $costo - $costo_proveedor;
				$porcentaje_dif = ($diff / $costo_proveedor) * 100;
				
				if (1==2){
				//if ($porcentaje_dif > 90) {
					//Si bajo el 20 avisa  		
					//fwrite($file_nuevos, "El articulo " . rtrim($codigo_fenix). " original " .rtrim($interno_proveedor) . " bajó un mas de un 20%. Bajó un ". number_format($porcentaje_dif,2,'.',',') ."% a un costo de \$$costo_proveedor. Costo actual \$$costo\r\n");
					$file_content.= "El articulo " . rtrim($codigo_fenix). " original " .rtrim($interno_proveedor) . "($descripcion) bajó un mas de un 20%. Bajó un ". number_format($porcentaje_dif,2,'.',',') ."% a un costo de \$$costo_proveedor. Costo actual \$$costo\r\n";
					continue;
				} else {
					$file_content.="El articulo " . rtrim($codigo_fenix). " original " . rtrim($interno_proveedor) . "($descripcion) bajó un " . number_format($porcentaje_dif,2,'.',',') . "%\r\n";
				}

			} else {
				//El costo es mayor, avisa que subio
				$diff = $costo_proveedor - $costo;
				$porcentaje_dif = ($diff / $costo) * 100;
				//Avisa % que cambio
				$file_content.="El articulo " . rtrim($codigo_fenix). " original " . rtrim($interno_proveedor) . "($descripcion) subió un ". number_format($porcentaje_dif,2,'.',',') . "%\r\n";
			}
			
			if ($dto2 == '') {
				$dto2 = 0;
			}
			if ($dto3 == '') {
				$dto3 = 0;
			}

			$sql_update = "UPDATE costos_proveedor 
			SET costo_anterior = costo, 
			costo = $costo_proveedor, 
			descripcion = '$descripcion', 
			dto1 = $dto1,
			dto2 = $dto2,
			dto3 = $dto3,
			rec1 = $rec1,
			fecha = '$fecha_barrido',
			cod_dto = '$cod_dto' 
			WHERE proveedor_id = $proveedor_id AND interno_proveedor = '$original'";
			
			$res_update = mysqli_query($link, $sql_update);
			if ($res_update) {
				
				echo "Costo del Código $original actualizado\r\n";
				
				//Verifica si es testigo
				if($testigo == 'SI') {
					$precio_lista = 0;
                	//$precio_lista = $costo_proveedor * (1 - ($dto1/100)) * (1 - ($dto2/100)) * (1 - ($dto3/100)) * (1  + ($rec1 / 100));
                	
					//Aplica dto y recargo de la tabla de descuentos
					$precio_lista = $costo_proveedor * (1 - ($dto1/100)) * (1  + ($rec1 / 100));
                	
					//Aplica dto y recargo de tabla ABM Listas
					//Dto Rec 1
					if ($dto_rec1 != 0 ){
						if ($dto_rec1 > 0) {
							$precio_lista = $precio_lista * (1 + ($dto_rec1/100)); //Recargo 1
						} else {
							$precio_lista = $precio_lista * (1 - (($dto_rec1 * (- 1))/100)); //Dto 1
						}
					}
					
					//Dto Rec 2
					if ($dto_rec2 != 0 ){
						if ($dto_rec2 > 0) {
							$precio_lista = $precio_lista * (1 + ($dto_rec2/100));//Recargo 2
						} else {
							$precio_lista = $precio_lista * (1 - (($dto_rec2 * (- 1))/100));//Dto 2
						}
					}
					
					//Dto Rec 3
					if ($dto_rec3 != 0 ){
						if ($dto_rec3 > 0) {
							$precio_lista = $precio_lista * (1 + ($dto_rec3/100));//Recargo 3
						} else {
							$precio_lista = $precio_lista * (1 - (($dto_rec3 * (- 1))/100));//Dto 3
						}
					}
					
                
                	//FORMULA JUAMPABLO  
                	$coef_utilidad = 1 - ($utilidad / 100);
                	$precio_lista = $precio_lista / $coef_utilidad;

                	//Agrega el IVA
                	$precio_lista = $precio_lista * 1.21;
                        
                	//Actualiza el precio de lista y la utilidad
                	$sql_precio_lista = "UPDATE articulos 
                	SET precio_lista = '$precio_lista', utilidad = '$utilidad' 
                	WHERE codigo_fenix = '$codigo_fenix'";
                	$res_precio_lista = mysqli_query($link, $sql_precio_lista);
                	if ($res_precio_lista) {
                		echo "Precio del articulo " . rtrim($codigo_fenix) . " actualizado\r\n";
                		$file_content.="Precio del articulo " . rtrim($codigo_fenix) . " actualizado\r\n";
                		
                	} else {
            			$file_content.="ERROR: Error al actualizar precio lista del articulo " . rtrim($codigo_fenix) . " : $sql_precio_lista";
            			fwrite($file_nuevos, $file_content);
						fclose($file_nuevos);
						die("ERROR: Error al actualizar precio lista del articulo " . rtrim($codigo_fenix) . " : $sql_precio_lista");    	
                	}
				}				
			} else {
				$file_content.="ERROR: Error al actualizar costo del original $original : $sql_update";
				fwrite($file_nuevos, $file_content);
				fclose($file_nuevos);
				die("ERROR: Error al actualizar costo del original $original : $sql_update");
			}
		} else {
			
			if ($dto2 == '') {
				$dto2 = 0;
			}
			if ($dto3 == '') {
				$dto3 = 0;
			}
			//Actualiza la fecha del costo
			$sql_update = "UPDATE costos_proveedor 
			SET fecha = '$fecha_barrido', 
			dto1 = $dto1,
			dto2 = $dto2,
			dto3 = $dto3,
			rec1 = $rec1,
			cod_dto = '$cod_dto' 
			WHERE proveedor_id = $proveedor_id AND interno_proveedor = '$original'";
			//echo $sql_update;
			$res_update = mysqli_query($link, $sql_update);
			if (!$res_update) {
				$file_content.="ERROR: Error al actualizar fecha de costo del original $original : $sql_update";
				fwrite($file_nuevos, $file_content);
				fclose($file_nuevos);
				die("ERROR: Error al actualizar fecha de costo del original $original : $sql_update");
			} else {
				$file_content.="Se actualiza fecha de costo, dtos y recs del articulo " . rtrim($codigo_fenix) . "\r\n";
			}
			
		}
	}

	if ($contador_costo == 0) {
		$file_content.= "El articulo $original ($descripcion) no tiene cargado costo para el proveedor\r\n";
	}
}

fwrite($file_nuevos, $file_content);
fclose($file_nuevos);

//copia el archivo para dejar de respaldo
if (!copy($filename_reporte, $filename_reporte_provedor)) {
    echo "Error al copiar $fichero...\n";
}
echo " *** PROCESO FINALIZADO *** ";