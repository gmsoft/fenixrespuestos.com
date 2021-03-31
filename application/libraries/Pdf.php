<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf extends FPDF {
        public function __construct() {
            parent::__construct();
        }
        // El encabezado del PDF
        public function Header(){
            $ci = get_instance();

            $this->Image('assets/img/logo.jpg',10,8,22);
            $this->SetFont('Arial','B',13);
            $this->Cell(30);
            $this->Cell(120,10,$ci->config->item('empresa_nombre'),0,0,'C');
            $this->Ln('5');
            $this->SetFont('Arial','',8);
            $this->Cell(30);
            $this->Cell(120,10,'Humberto Primo 801 - (X5000FAQ) Cordoba',0,0,'C');
            $this->Ln(20);
       }
       // El pie del pdf
       public function Footer(){
           $this->SetY(-15);
           $this->SetFont('Arial','I',8);
           $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
      }
    }

    class FacturaPdf extends FPDF {
        
        public $cbte_tipo = ''; //A - B - C
        public $cbte_tipo_nombre = ''; //FACTURA / NOTA DEBITO / NOTA CREDITO
        public $cbte_tipo_codigo = ''; //01-Fac A / 06-Fac B           
        public $punto_vta = '';//En formato 00001
        public $comprobante_nro = '';
        public $cae = '';
        public $cae_fecha_vto = '';
        public $cliente_id = 0;
        public $fecha_cbte = 0;
        public $condicion_venta = '';

        public function __construct() {
            parent::__construct();
        }

        // El encabezado del PDF
        public function Header(){
            $ci = get_instance();

            $this->Image('assets/img/logo.jpg',10,8,22);
             
            $this->SetFont('Arial','B',13);
            $this->Cell(100);
            $this->Cell(20,10, $this->cbte_tipo,1,0,'C');
            $this->Cell(40,10, $this->cbte_tipo_nombre,0,1,'C');
            
            $this->SetFont('Arial','', 7);
            $this->Cell(100);
            $this->Cell(20, 3, 'COD: ' . $this->cbte_tipo_codigo, 1,0,'C');
            $this->Cell(70, 3, '', 0, 1,'L');
            
            //
            //Datos del Emisor
            //
            $this->SetFont('Arial','', 8);

            $this->Cell(100);
            $this->Cell(50, 5, 'Punto de Venta: ' . $this->punto_vta, 0,0,'L');
            $this->Cell(40, 5, 'Comprobante: ' . $this->comprobante_nro, 0, 1,'L');

            $this->Cell(100, 5,'Razon Social: ' . $ci->config->item('empresa_nombre') , 0, 0,'L');
            $this->Cell(90, 5,'Fecha Emision: ' . $this->fecha_cbte, 0, 1,'L');

            $this->Cell(100, 5,'Domicilio Comercial: ' . $ci->config->item('empresa_domicilio'), 0, 0,'L');
            $this->Cell(90, 5,'CUIT: ' . $ci->config->item('empresa_cuit') , 0, 1,'L');

            $this->Cell(100, 5, '' , 0, 0,'L');
            $this->Cell(90, 5,'Ingresos Brutos: ' .  $ci->config->item('empresa_ingresos_brutos') , 0, 1,'L');

            $this->Cell(100, 5,'Condicion frente al IVA: ' .  $ci->config->item('empresa_iva'), 0, 0,'L');
            $this->Cell(90, 5,'Fecha de inicio de actividades: ' .  $ci->config->item('empresa_inicio_actividades') , 0, 1,'L');

            //
            //Datos del receptor
            //
            $ci->load->model('cliente_model');
            $ci->load->model('iva_model');
            $cliente = $ci->cliente_model->get_cliente_by_id($this->cliente_id);
            $iva = $ci->iva_model->get_tipo_iva($cliente['iva_id']);

            $this->Cell(190, 5,'DATOS DEL CLIENTE' , 1, 1,'C');

            $this->Cell(70, 5,'CUIT: ' . $cliente['cuit'] , 0, 0,'L');
            $this->Cell(120, 5,'Apellido y Nombre/Razon Social: '  . $cliente['razon_social'] , 0, 1,'L');

            $this->Cell(70, 5,'Condicion frente al IVA: ' . $iva['descripcion'], 0, 0,'L');
            $this->Cell(120, 5,'Domicilio Comercial: ' .  $cliente['domicilio'], 0, 1,'L');

            $this->Cell(70, 5,'Condicion de venta: ' . $this->condicion_venta , 0, 0,'L');
            $this->Cell(120, 5,'Nro de Remito: ' , 0, 1,'L');


            //$this->Cell(120,10,'Humberto Primo 801 - (X5000FAQ) Cordoba',0,0,'C');
            $this->Ln(5);
       }

       function Code39($xpos, $ypos, $code, $baseline=0.5, $height=5){

            $wide = $baseline;
            $narrow = $baseline / 3 ; 
            $gap = $narrow;

            $barChar['0'] = 'nnnwwnwnn';
            $barChar['1'] = 'wnnwnnnnw';
            $barChar['2'] = 'nnwwnnnnw';
            $barChar['3'] = 'wnwwnnnnn';
            $barChar['4'] = 'nnnwwnnnw';
            $barChar['5'] = 'wnnwwnnnn';
            $barChar['6'] = 'nnwwwnnnn';
            $barChar['7'] = 'nnnwnnwnw';
            $barChar['8'] = 'wnnwnnwnn';
            $barChar['9'] = 'nnwwnnwnn';
            $barChar['A'] = 'wnnnnwnnw';
            $barChar['B'] = 'nnwnnwnnw';
            $barChar['C'] = 'wnwnnwnnn';
            $barChar['D'] = 'nnnnwwnnw';
            $barChar['E'] = 'wnnnwwnnn';
            $barChar['F'] = 'nnwnwwnnn';
            $barChar['G'] = 'nnnnnwwnw';
            $barChar['H'] = 'wnnnnwwnn';
            $barChar['I'] = 'nnwnnwwnn';
            $barChar['J'] = 'nnnnwwwnn';
            $barChar['K'] = 'wnnnnnnww';
            $barChar['L'] = 'nnwnnnnww';
            $barChar['M'] = 'wnwnnnnwn';
            $barChar['N'] = 'nnnnwnnww';
            $barChar['O'] = 'wnnnwnnwn'; 
            $barChar['P'] = 'nnwnwnnwn';
            $barChar['Q'] = 'nnnnnnwww';
            $barChar['R'] = 'wnnnnnwwn';
            $barChar['S'] = 'nnwnnnwwn';
            $barChar['T'] = 'nnnnwnwwn';
            $barChar['U'] = 'wwnnnnnnw';
            $barChar['V'] = 'nwwnnnnnw';
            $barChar['W'] = 'wwwnnnnnn';
            $barChar['X'] = 'nwnnwnnnw';
            $barChar['Y'] = 'wwnnwnnnn';
            $barChar['Z'] = 'nwwnwnnnn';
            $barChar['-'] = 'nwnnnnwnw';
            $barChar['.'] = 'wwnnnnwnn';
            $barChar[' '] = 'nwwnnnwnn';
            $barChar['*'] = 'nwnnwnwnn';
            $barChar['$'] = 'nwnwnwnnn';
            $barChar['/'] = 'nwnwnnnwn';
            $barChar['+'] = 'nwnnnwnwn';
            $barChar['%'] = 'nnnwnwnwn';

            $this->SetFont('Arial','',10);
            $this->Text($xpos, $ypos + $height + 4, $code);
            $this->SetFillColor(0);

            $code = '*'.strtoupper($code).'*';
            for($i=0; $i<strlen($code); $i++){
                $char = $code[$i];
                if(!isset($barChar[$char])){
                    $this->Error('Invalid character in barcode: '.$char);
                }
                $seq = $barChar[$char];
                for($bar=0; $bar<9; $bar++){
                    if($seq[$bar] == 'n'){
                        $lineWidth = $narrow;
                    }else{
                        $lineWidth = $wide;
                    }
                    if($bar % 2 == 0){
                        $this->Rect($xpos, $ypos, $lineWidth, $height, 'F');
                    }
                    $xpos += $lineWidth;
                }
                $xpos += $gap;
            }
        }

       // El pie del pdf
       public function Footer(){
           $this->SetY(-15);
           $this->SetFont('Arial','I',8);
           $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
           $this->SetFont('Arial','B',9);
           $this->Code39(20,280,$this->cae,0.5,5);
           $this->Cell(0,10,'CAE: ' . $this->cae . '     Fecha Vto CAE: ' . $this->cae_fecha_vto,0,0,'R');
      }

    }
