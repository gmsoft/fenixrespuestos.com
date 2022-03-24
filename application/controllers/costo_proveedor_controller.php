<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('MAX_EXECUTION_TIME', -1);
error_reporting(E_ALL ^ E_WARNING);


class costo_proveedor_controller extends CI_Controller {

    private $_guestProfile;
    
    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
                //user is already logged in
                redirect('ingresar');
        } else {
            $this->load->library('grocery_CRUD');
            $this->_guestProfile = $this->session->userdata('logged_in');
        }
    }

    public function index()
    {       
        $this->load->view('administrador/dashboard/dashboard.php');
    }
    
    public function menu() 
    {
       $this->load->view('costos/costos_proveedor.php');
        /*try {

            $crud = new grocery_CRUD();
            $crud->set_theme('twitter-bootstrap');
            $crud->set_table('relacion_proveedor');
            $crud->set_subject('Relacion Proveedor');

            $crud->set_relation('proveedor_id', 'proveedores', '{codigo_proveedor}, {nombre_proveedor}');    
            $crud->set_relation('proveedor_id', 'proveedores', '{codigo_proveedor}, {nombre_proveedor}');    
            
            $output = $crud->render();
            $this->output('administrador/default_layout/abm.php', $output);
            
        } catch(Exception $e){
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
        }*/
    }

    public function guardarCosto() {
        $var = $_POST;
        $proveedor = $var['proveedor'];
        $fecha = $var['fecha'];
        $codfenix = $var['codfenix'];
        $interno = $var['interno'];
        $costo = $var['costo'];
        $costo_lista = $var['costo_lista'];
        $dto1 = $var['dto1'];
        $dto2 = $var['dto2'];
        $dto3 = $var['dto3'];
        $rec1 = $var['rec1'];
        $testigo = $var['testigo'];
        $utilidad = $var['utilidad'];

        if (($utilidad < 20 || $utilidad > 99.99) && $testigo == 'SI') {
            echo '*** <span style="color:red">ATENCIÓN: La utilidad no puede ser menor a 20% ni mayor a 99.99% ***</span>';
        } else {
        
            $descripcion_lista = $var['descripcion_lista'];
            $marca_lista = $var['marca_lista'];
            
            //TODO: Falta filtro por moneda
            $sql_costo = "SELECT costo, moneda, dto1, dto2, dto3, rec1 "
                    . "FROM costos_proveedor "
                    . "WHERE proveedor_id = $proveedor "
                    . "AND codigo_fenix = '$codfenix' "
                    . "AND interno_proveedor = '$interno'";                
            $res_costo = mysqli_query($link, $sql_costo);
            
            $num_row = mysql_num_rows($res_costo);
            
            $strMensaje = "";
            
            //Limpia los testigos
            if ($testigo == 'SI') {
                $sql_limpiar_testigos = "UPDATE costos_proveedor SET testigo = 'NO' WHERE codigo_fenix = '$codfenix'";
                $res_limpiar_testigos = mysqli_query($link, $sql_limpiar_testigos);
                if (!$res_limpiar_testigos) {
                    $strMensaje .= "Error al limpiar testigos. ";
                }
            }
            
            //Crea o Actualiza el costo
            if($num_row == 0) {
                $sql = "INSERT INTO costos_proveedor "
                        . "(proveedor_id, codigo_fenix, interno_proveedor, fecha, costo, moneda, dto1, dto2, dto3, rec1,testigo,utilidad, descripcion, marca, costo_lista)"
                        . " VALUES".
                    "('$proveedor','$codfenix','$interno','$fecha','$costo', 'PES' , '$dto1', '$dto2','$dto3','$rec1','$testigo', '$utilidad', '$descripcion_lista', '$marca_lista', '$costo_lista')";
                
                $strMensaje .= "*** Nuevo costo cargado con exito ***";
            } else {
                $sql = "UPDATE costos_proveedor SET  costo_anterior = costo, costo = '$costo', "
                        . "dto1 = '$dto1', dto2 = '$dto2', dto3 = '$dto3', rec1 = '$rec1',"
                        . "testigo = '$testigo', utilidad = '$utilidad', "
                        . "descripcion = '$descripcion_lista', marca = '$marca_lista',"
                        . "costo_lista = '$costo_lista'"
                        . " WHERE proveedor_id = '$proveedor' AND codigo_fenix = '$codfenix' AND interno_proveedor = '$interno'";

                $strMensaje .= "*** Costo actualizado con exito ***";
            }
            
            $res = mysqli_query($link, $sql);
            
            if($res) {
                //Si es el Testigo actualiza el precio de lista
                if ($testigo == 'SI') {
                    
                    $precio_lista = 0;
                    
                    $precio_lista = $costo * (1 - ($dto1/100)) * (1 - ($dto2/100)) * (1 - ($dto3/100)) * (1  + ($rec1 / 100));
                    
                    /* // FORMULA DE MARIELA
                    $n = $utilidad / 100;
                    $parte_entera = floor($n);      // 1
                    $parte_decimal = ($n - $parte_entera) * 100; // .25
                    
                    //Margen sobre el precio de venta  (utilidades mayores a 100)
                    $precio_lista = ($precio_lista * $parte_entera) + ( $precio_lista / ((100 - $parte_decimal ) / 100 ));
                    */

                    //FORMULA JUAMPABLO  
                    //Suma Utilidad (Funciona para utilidades menores a 99.99)
                    $coef_utilidad = 1 - ($utilidad / 100);
                    $precio_lista = $precio_lista / $coef_utilidad;                    

                    //Agrega el IVA
                    $precio_lista = $precio_lista * 1.21;
                            
                    //Actualiza el precio de lista y la utilidad
                    $sql_precio_lista = "UPDATE articulos SET precio_lista = '$precio_lista', utilidad = '$utilidad' WHERE codigo_fenix = '$codfenix'";
                    $res_precio_lista = mysqli_query($link, $sql_precio_lista);
                }
                echo $strMensaje;
            } else {
                echo 'ERROR: ' . $sql;
            }
        }
    }

    public function barrerCostos() {
		 try {
			 //$path_batch = "D:/batch_scripts/barrer_costos.bat";
			 $path_batch = "D:/batch_scripts/exec_cmd.bat";
			 
			 $proveedor_id = $_POST['proveedor_id'];
			 $fecha_barrido = $_POST['fecha_barrido'];
			 
			 $cmd = 'start cmd.exe @cmd /k ' . $path_batch . ' ' . $proveedor_id . ' ' .  $fecha_barrido;
			 			 
			 $so = substr(php_uname(), 0, 7);
			 			 
			 //EJEMPLO : $this->execInBackground('start cmd.exe @cmd /k "ping google.com"');
			 //$this->execInBackground('start cmd.exe @cmd /k "ping google.com"', $so);
			 $this->execInBackground($cmd, $so);
			 /*
			 $this->execInBackground('start cmd.exe @cmd /k ' . $path_batch . ' ' . $proveedor_id . ' ' .  $fecha_barrido .'"', $so);
			 echo json_encode(
				array(
					'proveedor_id' => $proveedor_id,
					'path'=> $path_batch,
					'so'=> $so,
					'cmd'=> $cmd
					)
			);
			*/
		 } catch(Exception $e){
			 echo json_encode(array('exception' =>  $e->getMessage()));
		 }

    }

    public function execInBackground($cmd, $so) { 
		if ($so == "Windows") { 
			pclose(popen("start /B ". $cmd, "r"));  		
		} else { 
			exec($cmd . " > /dev/null &");   
		}
	}
	
	public function execCursor () {
		 /* 
         //CURSOR
         //http://chiapanecode.mx/crear-un-cursor-en-mysql
         $query = $this->db->query('call Select_foo()');
         echo '<pre>'
         print_r($query->result());    
         */
	}

    public function calcularPrecioVenta() {
        $n = 213 / 100;
        $parte_entera = floor($n);      // 1
        $parte_decimal = ($n - $parte_entera) * 100; // .25
        
        $precio_lista = 50;

       

        //Suma Utilidad (Funciona para utilidades menores a 99.99)
        //$coef_utilidad = 1 - ($utilidad / 100);
        //$precio_lista = $precio_lista / $coef_utilidad;

        //Margen sobre el precio de venta  (utilidades mayores a 100)
        $precio_lista = ($precio_lista * $parte_entera) + ( $precio_lista / ((100 - $parte_decimal ) / 100 ));

         echo "$parte_entera - $parte_decimal -  $precio_lista";
                
    }
    
    public function buscarCosto(){
        
        $var = $_POST;
        $proveedor = $var['proveedor'];
        $codfenix = $var['codfenix'];
        $interno = $var['interno'];
        
        $items = array(); 
        $items['costo'] = 0;
        $items['dto1'] = 0;
        $items['dto2'] = 0;
        $items['dto3'] = 0;
        $items['rec1'] = 0;
        $items['codigofenix'] = 0;
        $items['utilidad'] = 0;
        $items['testigo'] = '';
        //Precio Lista
        $items['descripcion_lista'] = '';
        $items['precio_lista'] = 0;
        
        //TODO: Falta filtro por moneda
        $sql_costo = "SELECT codigo_fenix, costo, moneda, dto1, dto2, dto3, rec1, testigo, utilidad "
                . "FROM costos_proveedor "
                . "WHERE proveedor_id = $proveedor "
                . "AND (codigo_fenix = '$codfenix' "
                . "OR interno_proveedor = '$interno')";
        $res_costo = mysqli_query($link, $sql_costo);
        
        while($row_costo = mysqli_fetch_array($res_costo)) {
            
            $codigofenix = $row_costo['codigo_fenix'];
            $costo = $row_costo['costo'];
            $dto1 = $row_costo['dto1'];
            $dto2 = $row_costo['dto2'];
            $dto3 = $row_costo['dto3'];
            $rec1 = $row_costo['rec1'];
            $utilidad = $row_costo['utilidad'];
            $testigo = $row_costo['testigo'];
            
            $items['codigofenix'] = $codigofenix;
            $items['costo'] = $costo * 1;
            $items['dto1'] = $dto1 * 1;
            $items['dto2'] = $dto2 * 1;
            $items['dto3'] = $dto3 * 1;
            $items['rec1'] = $rec1 * 1;
            $items['testigo'] = $testigo;
            $items['utilidad'] = $utilidad * 1;
            
        }

        $items['marca_lista'] = '';
        $items['descripcion_lista'] = '';
        $items['precio_lista'] = 0;

        //Lee la lista del proveedor 
        /* @TODO: Arreglar las columnas de Precios de las listas
        $sql_lista = "SELECT nombre_tabla , columna_cod_interno FROM listas WHERE proveedor_id = $proveedor";
        $res_lista = mysqli_query($link, $sql_lista);
        while($row_lista = mysqli_fetch_array($res_lista)) {
            $nombre_tabla = $row_lista['nombre_tabla'];
            $columna_cod_interno = $row_lista['columna_cod_interno'];
            
            $sql_lista_prov = "SELECT descripcion, precio_lista, marca FROM $nombre_tabla WHERE $columna_cod_interno = '$interno'";
            die($sql_lista_prov);
            $res_lista_prov = mysqli_query($link, $sql_lista_prov);
            while($row_lista_prov = mysqli_fetch_array($res_lista_prov)) {
                $descripcion_lista = $row_lista_prov['descripcion'];
                $precio_lista = $row_lista_prov['precio_lista'];
                $marca_lista = $row_lista_prov['marca'];
                
                $items['descripcion_lista'] = $descripcion_lista;
                $items['marca_lista'] = $marca_lista;
                $items['precio_lista'] = $precio_lista * 1;
            }
        }
        */
                
        echo json_encode($items);
    }

    public function buscarUtilidad() {
        
        $var = $_POST;
        $codfenix = $var['codfenix'];
                
        $items = array(); 
        $items['utilidad'] = 0;

        $sql_costo = "SELECT utilidad FROM costos_proveedor WHERE codigo_fenix = '$codfenix' AND testigo = 'SI'";
        $res_costo = mysqli_query($link, $sql_costo);
        
        while($row_costo = mysqli_fetch_array($res_costo)) {
            $utilidad = $row_costo['utilidad'];
            $items['utilidad'] = $utilidad * 1;
        }

        echo json_encode($items);

    }

    public function buscarArticuloCosto(){
        
        $var = $_POST;
        
        $codfenix = $var['codfenix'];
        $proveedor = $var['proveedor'];
        
        //TODO: Falta filtro por moneda
        $sql_costo = "SELECT descripcion "
                . "FROM articulos "
                . "WHERE codigo_fenix = '$codfenix' ";
            
        $res_costo = mysqli_query($link, $sql_costo);
        
        $items = array(); 
        $items['descripcion'] = "";
        $items['err'] = "0";
        $descripcion = '';
        while($row_costo = mysqli_fetch_array($res_costo)) {
            
            $descripcion = $row_costo['descripcion'];
               
            $items['descripcion'] = $descripcion;
        }
        
        if ($descripcion == '' || $codfenix == '') {
            $items['descripcion'] = 'Articulo Inexistente!';   
            $items['err'] = "1";
        }
        
        //Busca en Costo Particular
        $sql_interno_costo = "SELECT codigo_fenix, interno_proveedor, costo, dto1,dto2,dto3,rec1,testigo, utilidad "
                . "FROM costos_proveedor "
                . "WHERE codigo_fenix = '$codfenix' AND proveedor_id = $proveedor";
        $res_interno_costo = mysqli_query($link, $sql_interno_costo);
        
        while($row_interno_costo = mysqli_fetch_array($res_interno_costo)) {
            
            $codigo_fenix = $row_interno_costo['codigo_fenix'];
            $interno_proveedor = $row_interno_costo['interno_proveedor'];
            $dto1 = $row_interno_costo['dto1'];
            $dto2 = $row_interno_costo['dto2'];
            $dto3 = $row_interno_costo['dto3'];
            $rec1 = $row_interno_costo['rec1'];
            $costo = $row_interno_costo['costo'];
            $testigo = $row_interno_costo['testigo'];
            $utilidad = $row_interno_costo['utilidad'];
            
            $items['codigofenix'] = $codigo_fenix;
            $items['interno_proveedor'] = $interno_proveedor;
            $items['costo'] = $costo * 1;
            $items['dto1'] = $dto1 * 1;
            $items['dto2'] = $dto2 * 1;
            $items['dto3'] = $dto3 * 1;
            $items['rec1'] = $rec1 * 1;
            $items['testigo'] = $testigo;
            $items['utilidad'] = $utilidad;
        }

        echo json_encode($items);
    }

    /**
     * Muestra las vistas
     * @param string $output 
     */
    public function output($view, $output = null)
    {
        $this->load->view($view, $output);
    }
}

?>