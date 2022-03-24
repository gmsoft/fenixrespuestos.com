<?php

// Name of the file
$filename = 'update-db.sql';
// MySQL host
$mysql_host = 'localhost:3307';
// MySQL username
$mysql_username = 'root';
// MySQL password 
$mysql_password = 'Clave01';
// Database name
$mysql_database = 'fenix_base';

// Connect to MySQL server
mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
// Select database
mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);

$fecha_modificacion_archivo = filemtime($filename);

$sql_settings = "SELECT fecha_actualizacion FROM settings";
$res_settings = mysqli_query($link, $sql_settings);
$row_settings = mysqli_fetch_array($res_settings);
$fecha_modificacion_base = $row_settings['fecha_actualizacion'];

if ($fecha_modificacion_archivo != $fecha_modificacion_base) {
	
	// Loop through each line
	foreach ($lines as $line)
	{
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
		    continue;

		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';')
		{
		    // Perform the query
		    mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
		    // Reset temp variable to empty
		    $templine = '';
		}
	}

	echo "Base Actualizada con exito";

} else {

	echo "No hay nuevas actualizaciones";
} 

?>

<br/>

<a href="./"> << Volver</a>  

