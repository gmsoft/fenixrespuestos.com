@echo off
setlocal enabledelayedexpansion

rem if not defined BAR (
rem    set FOO=1
rem    echo Foo: !FOO!
rem )

set proveedor_id=%1

echo "Resguardando Base..."
rem DIA
set year=%date:~-4,4%
set day=%date:~-10,2%
set month=%date:~-7,2%

rem HORA
rem cut off fractional seconds
set t=%time:~0,8%
rem replace colons with dashes
set t=%t::=-%

rem FECHA_ACTUAL
set current_date=%year%%month%%day%
set current_datetime=%current_date%%d%-%t%
echo File: !current_datetime!

rem BACKUP DE LA BASE
rem http://cects.com/using-the-winrar-command-line-tools-in-windows/
rem TO IMPORT: --host=localhost --port=3307 --user=root --password= fenix_base < D:\fenix.sql
REM D:\xampp\mysql\bin\mysqldump --host=localhost --port=3307 --user=root --password= fenix_base > d:\fenix_base.sql

rem  COMPRIME LA BASE
REM "C:\Program Files\WinRAR\rar" a -r D:\fenix-base-!current_datetime!.rar fenix_base.sql

rem BARRIDO DE COSTOS
D:\xampp\php\php D:\Dropbox\proyectos\webs\fenix\sistema\application\controllers\batch.php %proveedor_id%

rem ABRE reporte 
c:\Windows\notepad D:\Dropbox\proyectos\webs\fenix\sistema\assets\uploads\files\importacion\barrido-costos.txt

@pause
@exit