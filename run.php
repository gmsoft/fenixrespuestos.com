<?php


// $command = escapeshellcmd('python /domains/fenixrepuestos.com/public_html/test/command.py');
// $output = shell_exec($command);

$salida = shell_exec('ls');
echo $salida;