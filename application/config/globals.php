<?php
$link = mysqli_connect("db-mysql-nyc3-22736-do-user-11066346-0.b.db.ondigitalocean.com", "doadmin", "AmMG2DvQVU4GgWgk", "defaultdb", 25060);

/* comprobar la conexión */
if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
}

// Create customized config variables
$config['link'] = $link;

?>