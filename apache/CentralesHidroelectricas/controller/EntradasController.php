<?php

session_start();

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\XLsx;
use Fpdf\Fpdf;

class EntradasController extends ControladorBase {
  
    private $entmodel;
    private $emplemodel;
    private $almodel;
    private $detentmodel;
    private $prodmodel;
    private $cenmodel;

    public function __construct() {
        parent::__construct();
        $this->entmodel = new EntradasModel();
    }

    
    //Funcion que realiza una entrada de productos en un almacen
    public function entradaalma() {
        $this->detentmodel = new DetEntradasModel();
        $this->prodmodel = new ProductosModel();
        $this->emplemodel = new EmpleadosModel();
      
        if (isset($_SESSION['idemple'])) {
            $FechaEntrada = date('Y-m-d H:i:s');
            $CodAlmacen = $_POST['CodAlmacen'];
            $Motivo = $_POST['Motivo'];           
            $NumEmple = $_SESSION['idemple'];
           
            $NumEntrada = $this->entmodel->insertaEntrada($NumEmple, $CodAlmacen, $FechaEntrada, $Motivo);

            //Insertar los detalles. Recorremos carrito
            foreach ($_SESSION['alma'] as $reg) {
                $CodProd = $reg[0];
                $Unidades = $reg[1];
                $UnidadesActuales = $reg[1];

                $UnidadesenAlmacen = ($Unidades - $UnidadesActuales);
                $deta = $this->detentmodel->insertarDetalleEntrada($NumEntrada, $CodProd, $Unidades, $UnidadesActuales, $UnidadesenAlmacen);
                
                //saco el stock restante de cada producto y lo voy actualizando
                $stockactu = $this->prodmodel->damestockprodu($CodProd);
                $Stockrestante = ($stockactu - $Unidades);
                $this->prodmodel->actualizarstockprod($CodProd, $Stockrestante);
            }

            //Borramos sesion
            unset($_SESSION['alma']);

            $datos['mensaje'] = "Productos añadidos correctamente al almacen";
          
        } else {
            $datos['mensaje'] = "No se ha podido actualizar el almacen";
               $errores='';
               $datos['errores'] = $errores;
        }

        $this->view("seleccion", $datos);
    }

    
    //Me lleva a la vista gestion de entradas
    public function gestionar() {
        $datos['titulo'] = "Gestion entradas";
        $this->view("entradas", $datos);
    }

    public function gestion() {
        $this->emplemodel = new EmpleadosModel();
        $this->almodel = new AlmacenesModel();
        $empleados = $this->emplemodel->getAll();
        $almacenes = $this->almodel->getAll();
        $datos['empleados'] = $empleados;
        $datos['almacenes'] = $almacenes;
        $datos['titulo'] = "Gestion de entradas";
        $this->view("entradas", $datos);
    }
    
    
    //Me lleva a la vista ver mis entradas realizadas (parte empleado)
    public function listar() {
    
        if (isset($_SESSION['idemple'])) {
            $datos['titulo'] = "";

            $elementos = $this->entmodel->getEntradasempleado($_SESSION['idemple']);
            $datos['elementos'] = $elementos;
          
        } else {
            $mensaje = "No existe ese empleado";
               $errores='';
               $datos['errores'] = $errores;
        }
       
        $datos['titulo'] = "Mis entradas";
        $this->view("entradas", $datos);
    }

    //LLeva a una vista con un listado de las entradas realizadas en un almacen (parte administrador)
    public function verporalmacen() {     
        $id = $_POST['almacenes'];    
        $this->almodel = new AlmacenesModel();
        $objetoalmacen = $this->almodel->getUnAlmacen($id);
        $this->cenmodel = new CentralesModel();
        $objetocentral = $this->cenmodel->getUnaCentral($objetoalmacen->getIdCentral());
        $datos['titulo'] = "Entradas en almacen: " . $objetoalmacen->getTipo() . " / " . $objetocentral->getNombre();
        $elementos = $this->entmodel->getEntradasalmacen($id);
        $datos['elementos'] = $elementos;
        $datos['id'] = $id;
        $this->view("entradas", $datos);
    }

    //LLeva a una vista con un listado de las entradas realizadas por un empleado (parte administrador)
    public function verporempleado() {
        $id = $_POST['empleados'];
        $this->emplemodel = new EmpleadosModel();
        $objetoempleado = $this->emplemodel->getEmpleado($id);
        $datos['titulo'] = "Entradas del empleado: ". $objetoempleado->getDNI();
        $elementos = $this->entmodel->getEntradasempleado($id);
        $datos['elementos'] = $elementos;
        $datos['id'] = $id;
        $this->view("entradas", $datos);
    }

    //LLeva a una vista con un listado de las entradas realizadas en un almacen por un empleado (parte administrador)
    public function verporempleadoyalmacen() {
        $id = $_POST['empleados'];
        $al = $_POST['almacenes'];      
        $this->emplemodel = new EmpleadosModel();
        $objetoempleado = $this->emplemodel->getEmpleado($id);
        $this->almodel = new AlmacenesModel();
        $objetoalmacen = $this->almodel->getUnAlmacen($al);
        $this->cenmodel = new CentralesModel();
        $objetocentral = $this->cenmodel->getUnaCentral($objetoalmacen->getIdCentral());
        $datos['titulo'] = "Entradas del empleado: " . $objetoempleado->getDNI() .  " Almacen: " . $objetoalmacen->getTipo() . " / " . $objetocentral->getNombre();
        $elementos = $this->entmodel->getEntradasempleadoyalmacen($id, $al);
        $datos['elementos'] = $elementos;
        $datos['id'] = $id;
        $datos['idal'] = $al;
        $this->view("entradas", $datos);
    }

    //LLeva a una vista con un listado de todas las entradas realizadas (parte administrador)
    public function listartodas() {
        $datos['titulo'] = "Entradas";
        $elementos = $this->entmodel->getAll();
        $datos['elementos'] = $elementos;      
        $this->view("entradas", $datos);
    }   

   
    //Devuelve un excell de las entradas realizadas
    public function generaexcell() {
        $tipo = $_POST['tipo'];
        $this->almodel = new AlmacenesModel();
        $this->cenmodel = new CentralesModel();
        $this->emplemodel = new EmpleadosModel();
        $this->detentmodel = new DetEntradasModel();
        $this->prodmodel = new ProductosModel();

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet2 = $spreadsheet->getActiveSheet();

        switch ($tipo) {
            case 'empleado':
                $id = $_POST['numemple'];
                $objetoentradaempleado = $this->entmodel->getEntradasempleado($id);
                $dniemple = $this->emplemodel->getEmpleado($id)->getDNI();
                foreach ($objetoentradaempleado as $fila) {                
                    $rowNum = $rowNum + 1;
                    $numentrada = $fila['NumEntrada'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaEntrada'];
                    $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($fila['CodAlmacen'])->getTipo();
                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Entrada: " . $numentrada)
                            ->setCellValue('B' . $rowNum, "Fecha: " . $fecha)
                            ->setCellValue('C' . $rowNum, "Almacen " . $central)
                            ->setCellValue('D' . $rowNum, "Motivo " . $motivo);
                    $objetodet = $this->detentmodel->getDetalleEntradas($numentrada);
                    $rowNum = $rowNum + 1;
                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Producto")
                            ->setCellValue('B' . $rowNum, "Unidades");
                    //recorro el detalle de cada entrada
                    foreach ($objetodet as $fila2) {
                        $rowNum = $rowNum + 1;
                        $sheet2->setCellValue('A' . $rowNum, $this->prodmodel->getUnProducto($fila2['CodProd'])->getNombre());
                        $sheet2->setCellValue('B' . $rowNum, $fila2['Unidades']);
                    }//finforeach2
                }//finforeach
                break;
            case 'empleadoalma':
                $id = $_POST['numemple'];
                $idal = $_POST['codalma'];
                $objetoentradaemplealma = $this->entmodel->getEntradasempleadoyalmacen($id, $idal);
                $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($idal)->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($idal)->getTipo();
                $dniemple = $this->emplemodel->getEmpleado($id)->getDNI();
                foreach ($objetoentradaemplealma as $fila) {
                    //var_dump($fila);
                    $rowNum = $rowNum + 1;
                    $numentrada = $fila['NumEntrada'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaEntrada'];
                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Entrada: " . $numentrada)
                            ->setCellValue('B' . $rowNum, "Fecha: " . $fecha)
                            ->setCellValue('C' . $rowNum, "Motivo " . $motivo);
                    $objetodet = $this->detentmodel->getDetalleEntradas($numentrada);
                    $rowNum = $rowNum + 1;
                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Producto")
                            ->setCellValue('B' . $rowNum, "Unidades");
                    //recorro el detalle de cada entrada
                    foreach ($objetodet as $fila2) {
                        $rowNum = $rowNum + 1;
                        $sheet2->setCellValue('A' . $rowNum, $this->prodmodel->getUnProducto($fila2['CodProd'])->getNombre());
                        $sheet2->setCellValue('B' . $rowNum, $fila2['Unidades']);
                    }//finforeach2
                }//finforeach
                break;
            case 'almacen':
                $id = $_POST['codalma'];
                $objetoentradaalmacen = $this->entmodel->getEntradasalmacen($id);
                $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($id)->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($id)->getTipo();
                foreach ($objetoentradaalmacen as $fila) {
                    //var_dump($fila);
                    $rowNum = $rowNum + 1;
                    $numentrada = $fila['NumEntrada'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaEntrada'];
                    $dniemple = $this->emplemodel->getEmpleado($fila['NumEmple'])->getDNI();
                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Entrada: " . $numentrada)
                            ->setCellValue('B' . $rowNum, "Fecha: " . $fecha)
                            ->setCellValue('C' . $rowNum, "Empleado " . $dniemple)
                            ->setCellValue('D' . $rowNum, "Motivo " . $motivo);
                    $objetodet = $this->detentmodel->getDetalleEntradas($numentrada);
                    $rowNum = $rowNum + 1;
                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Producto")
                            ->setCellValue('B' . $rowNum, "Unidades");
                    //recorro el detalle de cada entrada
                    foreach ($objetodet as $fila2) {
                        $rowNum = $rowNum + 1;
                        $sheet2->setCellValue('A' . $rowNum, $this->prodmodel->getUnProducto($fila2['CodProd'])->getNombre());
                        $sheet2->setCellValue('B' . $rowNum, $fila2['Unidades']);
                    }//finforeach2
                }//finforeach
                break;
            case 'todas':
                $rowNum = 0;
                $ruta = "archivo/";
                $objetoentrada = $this->entmodel->getAll();
                foreach ($objetoentrada as $fila) {
                    //var_dump($fila);
                    $rowNum = $rowNum + 1;
                    $numentrada = $fila['NumEntrada'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaEntrada'];
                    $dniemple = $this->emplemodel->getEmpleado($fila['NumEmple'])->getDNI();
                    $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($fila['CodAlmacen'])->getTipo();
                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Entrada: " . $numentrada)
                            ->setCellValue('B' . $rowNum, "Fecha: " . $fecha)
                            ->setCellValue('C' . $rowNum, "Almacen " . $central)
                            ->setCellValue('D' . $rowNum, "Empleado " . $dniemple)
                            ->setCellValue('E' . $rowNum, "Motivo " . $motivo);
                    $objetodet = $this->detentmodel->getDetalleEntradas($numentrada);
                    $rowNum = $rowNum + 1;
                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Producto")
                            ->setCellValue('B' . $rowNum, "Unidades");
                    foreach ($objetodet as $fila2) {
                        $rowNum = $rowNum + 1;
                        $sheet2->setCellValue('A' . $rowNum, $this->prodmodel->getUnProducto($fila2['CodProd'])->getNombre());
                        $sheet2->setCellValue('B' . $rowNum, $fila2['Unidades']);
                    }//finforeach2
                }//finforeach
                break;
        }
        $writer = new XLsx($spreadsheet);
        try {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="ListadoEntradas.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            


            exit();
           } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    //devuelve un pdf con las entradas realizadas
    public function generapdf() {
        $tipo = $_POST['tipo'];
       
        $this->almodel = new AlmacenesModel();
        $this->cenmodel = new CentralesModel();
        $this->emplemodel = new EmpleadosModel();
        $this->detentmodel = new DetEntradasModel();
        $this->prodmodel = new ProductosModel();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image('./recursos/img/logo2.png',10,10,-300);
        $pdf->SetTextColor(35, 52, 63);
        
        switch ($tipo) {
            case 'empleado':
                $id = $_POST['numemple'];
                $dniemple = $this->emplemodel->getEmpleado($id)->getDNI();
                $pdf->SetFont('courier','b',14);
                $pdf->Cell(50);
                $pdf->Cell(100,10,'Entradas del empleado: '.$dniemple,0,1,'C');
                $pdf->SetFont('courier','',10);
                $pdf->Ln();              

                $objetoentradaempleado = $this->entmodel->getEntradasempleado($id);
                foreach ($objetoentradaempleado as $fila) {
                    $pdf->Cell(15);
                    $numentrada = $fila['NumEntrada'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaEntrada'];
                    $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($fila['CodAlmacen'])->getTipo();

                    $objetodet = $this->detentmodel->getDetalleEntradas($numentrada);
                    $pdf->Cell(40, 5, "Entrada: " . $numentrada);
                    $pdf->Cell(50, 5, "Fecha: " . $fecha);
                    $pdf->Cell(80, 5, " Central: " . $central);
                    $pdf->Ln();
                    $pdf->Cell(15);
                    $pdf->Cell(300, 5, "Motivo: " . $motivo);               
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Cell(40);                   
                    $header = array('Producto', 'Unidades');
                    foreach ($header as $col) {
                        $pdf->SetFont('courier','b',10);
                        $pdf->Cell(50, 8, $col, 1, 0, 'C');
                    }
                    foreach ($objetodet as $fila2) {
                        $pdf->Ln();
                        $pdf->Cell(40);
                        $pdf->SetFont('courier','',10);
                        $pdf->Cell(50, 6, $this->prodmodel->getUnProducto($fila2['CodProd'])->getNombre(), 1, 0, 'C');
                        $pdf->Cell(50, 6, $fila2['Unidades'], 1, 0, 'C');
                    }//foreachdetalleentrada
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                }  //foreachentrada
                break;
            case 'empleadoalma':
                $id = $_POST['numemple'];
                $idal = $_POST['codalma'];
                $dniemple = $this->emplemodel->getEmpleado($id)->getDNI();
                $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($idal)->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($idal)->getTipo();
                $pdf->SetFont('courier','b',12);
                    $pdf->Cell(5);
                    $pdf->Cell(180,10,'Entradas del empleado: '.$dniemple.' / Central: '.$central,0,1,'C');
                    $pdf->SetFont('courier','',10);
                    $pdf->Ln();
                $objetoentradaempleado = $this->entmodel-> getEntradasempleadoyalmacen($id, $idal);
                foreach ($objetoentradaempleado as $fila) {
                    $numentrada = $fila['NumEntrada'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaEntrada'];
                    $objetodet = $this->detentmodel->getDetalleEntradas($numentrada);
                    $pdf->Cell(15);
                    $pdf->Cell(60, 5, "Entrada: " . $numentrada);
                    $pdf->Cell(60, 5, "Fecha: " . $fecha);
                    $pdf->Ln();
                    $pdf->Cell(15);
                    $pdf->Cell(300, 5, "Motivo: " . $motivo);
                    $pdf->Ln();
                    $pdf->Ln();
                    $header = array('Producto', 'Unidades');
                    $pdf->Cell(40);
                    foreach ($header as $col) {
                        $pdf->SetFont('courier','B',10);
                        $pdf->Cell(50, 8, $col, 1,0,'C');
                    }
                    foreach ($objetodet as $fila2) {
                        $pdf->Ln();
                        $pdf->SetFont('courier','',10);
                        $pdf->Cell(40);
                        $pdf->Cell(50, 7, $this->prodmodel->getUnProducto($fila2['CodProd'])->getNombre(), 1,0,'C');
                        $pdf->Cell(50, 7, $fila2['Unidades'], 1,0,'C');
                    }//foreachdetalleentrada
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                }  //foreachentrada
                break;
            case 'almacen':
                $id = $_POST['codalma'];
                $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($id)->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($id)->getTipo();
                
                $pdf->SetFont('courier','B',14);                
                    $pdf->Cell(30);
                    $pdf->Cell(130,10,'Entradas en el almacen: '.$central,0,1,'C');
                    $pdf->SetFont('courier','',10);
                    $pdf->Ln();            
                $entradasalma = $this->entmodel->getEntradasalmacen($id);
                foreach ($entradasalma as $fila) {
                    $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($fila['CodAlmacen'])->getTipo();
                    $pdf->Cell(15);
                    $numentrada = $fila['NumEntrada'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaEntrada'];
                    $dniemple = $this->emplemodel->getEmpleado($fila['NumEmple'])->getDNI();
                    $objetodet = $this->detentmodel->getDetalleEntradas($numentrada);
                    $pdf->Cell(40, 5, "Entrada: " . $numentrada);
                    $pdf->Cell(50, 5, "Fecha: " . $fecha);
                    $pdf->Cell(80, 5, " Empleado: " . $dniemple);  
                    $pdf->Ln();
                    $pdf->Cell(15);
                    $pdf->Cell(300, 5, "Motivo: " . $motivo);
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Cell(40);
                    $header = array('Producto', 'Unidades');
                    foreach ($header as $col) {
                          $pdf->SetFont('courier','b',10);
                        $pdf->Cell(50, 8, $col, 1,0,'C');
                    }
                    foreach ($objetodet as $fila2) {
                        $pdf->Ln();
                        $pdf->Cell(40);
                        $pdf->SetFont('courier','',10);
                        $pdf->Cell(50, 6, $this->prodmodel->getUnProducto($fila2['CodProd'])->getNombre(), 1,0,'C');
                        $pdf->Cell(50, 6, $fila2['Unidades'], 1,0,'C');
                    }//foreachdetalleentrada
                    $pdf->Ln();
                    $pdf->Ln();
                     $pdf->Ln();
                    $pdf->Ln();
                }  //foreachentrada 
                break;
            case 'todas':
                $objetoentrada = $this->entmodel->getAll();             
                    $pdf->SetFont('courier','b',14);
                    $pdf->Cell(65);                           
                    $pdf->Cell(60,10,'Listado de entradas',0,1,'C');
                    $pdf->SetFont('courier','',10);
                    $pdf->Ln();
                foreach ($objetoentrada as $fila) {             
                    $pdf->Cell(15);
                    $numentrada = $fila['NumEntrada'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaEntrada'];
                    $dniemple = $this->emplemodel->getEmpleado($fila['NumEmple'])->getDNI();
                    $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($fila['CodAlmacen'])->getTipo();
                    $objetodet = $this->detentmodel->getDetalleEntradas($numentrada);
                    $pdf->Cell(100, 5, "Entrada: " . $numentrada);
                    $pdf->Cell(100, 5, "Fecha: " . $fecha);                  
                    $pdf->Ln();
                    $pdf->Cell(15);
                    $pdf->Cell(100, 5, "Central " . $central);  
                    $pdf->Cell(100, 5, "Empleado: " . $dniemple);  
                    $pdf->Ln();
                    $pdf->Cell(15);
                    $pdf->Cell(300, 5, "Motivo: " . $motivo);
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Cell(40);
                    $header = array('Producto', 'Unidades');
                    foreach ($header as $col) {
                       $pdf->SetFont('courier','b',10);
                        $pdf->Cell(50, 8, $col, 1,0, 'C');
                    }
                    foreach ($objetodet as $fila2) {
                        $pdf->Ln();
                        $pdf->SetFont('courier','',10);
                        $pdf->Cell(40);
                        $pdf->Cell(50, 6, $this->prodmodel->getUnProducto($fila2['CodProd'])->getNombre(), 1,0, 'C');
                        $pdf->Cell(50, 6, $fila2['Unidades'], 1,0, 'C');
                    }//foreachdetalleentrada
                    $pdf->Ln();
                    $pdf->Ln();
                       $pdf->Ln();
                          $pdf->Ln();
                }  //foreachentrada 
                break;
        }
        
        $pdf->Output('ListadoEntradas.pdf', 'D');
    }
}
