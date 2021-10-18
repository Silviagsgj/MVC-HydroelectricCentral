<?php

session_start();

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\XLsx;
use Fpdf\Fpdf;

class SalidasController extends ControladorBase {

    private $salmodel;
    private $entmodel;
    private $detentmodel;
    private $prodmodel;

    public function __construct() {
        parent::__construct();
        $this->salmodel = new SalidasModel();
    }

    //Funcion que me lleva a una vista que me da un listado de productos disponibles en un almacen
    public function verproductosalmacen() {        
        $this->detentmodel = new DetEntradasModel();
        $this->prodmodel = new ProductosModel();
        $arrayprod = Array();
        $id = $_POST['CodAlmacen'];
        $detalle = $this->detentmodel->getDetalleEntradasAll($id);             
        $datos['titulo'] = "Seleccion de productos";      
        $datos['elementos'] = $detalle;
        $_SESSION['almacen'] = $id;
        $this->view("salidas", $datos);
    }

    public function verproductosalmacen2() {  
        $this->detentmodel = new DetEntradasModel();
        $this->prodmodel = new ProductosModel();
        $arrayprod = Array();
        $id = $_SESSION['almacen'];
        $detalle = $this->detentmodel->getDetalleEntradasAll($id);        
        $datos['titulo'] = "Seleccion de productos";    
        $datos['elementos'] = $detalle;
        $this->view("salidas", $datos);
    }

    
    //Funcion que realiza una salida de productos de un almacen
    public function salidaalma() {
        $this->detsalmodel = new DetSalidasModel();
        $this->detentmodel = new DetEntradasModel();
        $this->emplemodel = new EmpleadosModel();        

        if (isset($_SESSION['idemple'])) {
            $FechaSalida = date('Y-m-d H:i:s');
            $CodAlmacen = $_SESSION['almacen'];
            $Motivo = $_POST['Motivo'];          
            $NumEmple = $_SESSION['idemple']; 
            $NumSalida = $this->salmodel->insertaSalida($NumEmple, $CodAlmacen, $FechaSalida, $Motivo);

            //Insertar los detalles.
            foreach ($_SESSION['alma2'] as $reg) {
                $CodProd = $reg[0];
                $Unidades = $reg[1];
                $deta = $this->detsalmodel->insertarDetalleSalida($NumSalida, $CodProd, $Unidades);               
                $stockactu = $this->detentmodel->dameunidades($_SESSION['almacen'], $CodProd);              
                $Stockrestante = $Unidades;                
                $this->detentmodel->actualizarunidadesalmacen($_SESSION['almacen'], $Stockrestante, ( $stockactu - $Stockrestante), $CodProd);
            }          
            unset($_SESSION['alma2']);           
            $datos['mensaje'] = "Productos sacados correctamente del almacen";            
        } else {
            $datos['mensaje'] = "No se ha podido actualizar el almacen";
            $errores = '';
            $datos['errores'] = $errores;
        }
        $this->view("seleccion", $datos);
    }

    //Me lleva a la vista ver mis salidas realizadas (parte empleado)
    public function listar() {  
        if (isset($_SESSION['idemple'])) {
            $datos['titulo'] = "";
            $elementos = $this->salmodel->getSalidasempleado($_SESSION['idemple']);
            $datos['elementos'] = $elementos;      
        } else {
            $mensaje = "No existe ese empleado";
            $errores = '';
            $datos['errores'] = $errores;
        }       
        $datos['titulo'] = "Mis salidas";
        $this->view("salidas", $datos);
    }
    
    //Lleva a la vista gestion de las salidas
    public function gestion() {
        $this->emplemodel = new EmpleadosModel();
        $this->almodel = new AlmacenesModel();       
        $empleados = $this->emplemodel->getAll();
        $almacenes = $this->almodel->getAll();
        $datos['empleados'] = $empleados;
        $datos['almacenes'] = $almacenes;
        $datos['titulo'] = "Gestion de salidas";
        $this->view("salidas", $datos);
    }

    //LLeva a una vista con un listado de las salidas realizadas en un almacen (parte administrador)
    public function verporalmacen() {
        $id = $_POST['almacenes'];
        $this->almodel = new AlmacenesModel();
        $objetoalmacen = $this->almodel->getUnAlmacen($id);
        $this->cenmodel = new CentralesModel();
        $objetocentral = $this->cenmodel->getUnaCentral($objetoalmacen->getIdCentral());
        $datos['titulo'] = "Salidas del almacen: " . $objetoalmacen->getTipo() . " / " . $objetocentral->getNombre();
        $elementos = $this->salmodel->getSalidasalmacen($id);
        $datos['elementos'] = $elementos;
        $datos['id'] = $id;
        $this->view("salidas", $datos);
    }

    //LLeva a una vista con un listado de las salidas realizadas por un empleado (parte administrador)
    public function verporempleado() {
        $id = $_POST['empleados'];
        $this->emplemodel = new EmpleadosModel();
        $objetoempleado = $this->emplemodel->getEmpleado($id);
        $datos['titulo'] = "Salidas del empleado: " . $objetoempleado->getDNI();
        $elementos = $this->salmodel->getSalidasempleado($id);
        $datos['elementos'] = $elementos;
        $datos['id'] = $id;
        $this->view("salidas", $datos);
    }

    //LLeva a una vista con un listado de las salidas realizadas por un empleado en un almacen (parte administrador)
    public function verporempleadoyalmacen() {
        $id = $_POST['empleados'];
        $al = $_POST['almacenes'];
        $this->emplemodel = new EmpleadosModel();
        $objetoempleado = $this->emplemodel->getEmpleado($id);
        $this->almodel = new AlmacenesModel();
        $objetoalmacen = $this->almodel->getUnAlmacen($al);
        $this->cenmodel = new CentralesModel();
        $objetocentral = $this->cenmodel->getUnaCentral($objetoalmacen->getIdCentral());
        $datos['titulo'] = "Salidas del empleado: " . $objetoempleado->getDNI() . " Almacen: " . $objetoalmacen->getTipo() . " / " . $objetocentral->getNombre();
        $elementos = $this->salmodel->getSalidasempleadoyalmacen($id, $al);
        $datos['elementos'] = $elementos;
        $datos['id'] = $id;
        $datos['idal'] = $al;
        $this->view("salidas", $datos);
    }

    //LLeva a una vista con un listado de todas las salidas (parte administrador)
    public function listartodas() {
        $datos['titulo'] = "Salidas";
        $elementos = $this->salmodel->getAll();
        $datos['elementos'] = $elementos;
        $this->view("salidas", $datos);
    }

    //Devuelve un excell de las salidas realizadas
    public function generaexcell() {
        $tipo = $_POST['tipo'];
        $this->almodel = new AlmacenesModel();
        $this->cenmodel = new CentralesModel();
        $this->emplemodel = new EmpleadosModel();
        $this->detsalmodel = new DetSalidasModel();
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
                $objetosalidaempleado = $this->salmodel->getSalidasempleado($id);
                $dniemple = $this->emplemodel->getEmpleado($id)->getDNI();
                foreach ($objetosalidaempleado as $fila) {
                    //var_dump($fila);
                    $rowNum = $rowNum + 1;
                    $numsalida = $fila['NumSalida'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaSalida'];
                    $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($fila['CodAlmacen'])->getTipo();

                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Salida: " . $numsalida)
                            ->setCellValue('B' . $rowNum, "Fecha: " . $fecha)
                            ->setCellValue('C' . $rowNum, "Almacen " . $central)
                            ->setCellValue('D' . $rowNum, "Motivo " . $motivo);

                    $objetodet = $this->detsalmodel->getDetalleSalidas($numsalida);

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
                $objetosalidaemplealma = $this->salmodel->getSalidasempleadoyalmacen($id, $idal);
                $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($idal)->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($idal)->getTipo();
                $dniemple = $this->emplemodel->getEmpleado($id)->getDNI();
                foreach ($objetosalidaemplealma as $fila) {
                    //var_dump($fila);
                    $rowNum = $rowNum + 1;
                    $numsalida = $fila['NumSalida'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaSalida'];

                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Salida: " . $numsalida)
                            ->setCellValue('B' . $rowNum, "Fecha: " . $fecha)
                            ->setCellValue('C' . $rowNum, "Motivo " . $motivo);

                    $objetodet = $this->detsalmodel->getDetalleSalidas($numsalida);

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
                $objetosalidaalmacen = $this->salmodel->getSalidasalmacen($id);
                $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($id)->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($id)->getTipo();

                foreach ($objetosalidaalmacen as $fila) {
                    //var_dump($fila);
                    $rowNum = $rowNum + 1;
                    $numsalida = $fila['NumSalida'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaSalida'];
                    $dniemple = $this->emplemodel->getEmpleado($fila['NumEmple'])->getDNI();

                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Salida: " . $numsalida)
                            ->setCellValue('B' . $rowNum, "Fecha: " . $fecha)
                            ->setCellValue('C' . $rowNum, "Empleado " . $dniemple)
                            ->setCellValue('D' . $rowNum, "Motivo " . $motivo);

                    $objetodet = $this->detsalmodel->getDetalleSalidas($numsalida);

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
                $objetosalida = $this->salmodel->getAll();
                foreach ($objetosalida as $fila) {
                    //var_dump($fila);
                    $rowNum = $rowNum + 1;
                    $numsalida = $fila['NumSalida'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaSalida'];
                    $dniemple = $this->emplemodel->getEmpleado($fila['NumEmple'])->getDNI();
                    $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($fila['CodAlmacen'])->getTipo();

                    $spreadsheet->getActiveSheet()
                            ->setCellValue('A' . $rowNum, "Salida: " . $numsalida)
                            ->setCellValue('B' . $rowNum, "Fecha: " . $fecha)
                            ->setCellValue('C' . $rowNum, "Almacen " . $central)
                            ->setCellValue('D' . $rowNum, "Empleado " . $dniemple)
                            ->setCellValue('E' . $rowNum, "Motivo " . $motivo);
                    
                    $objetodet = $this->detsalmodel->getDetalleSalidas($numsalida);

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
        }
        $writer = new XLsx($spreadsheet);
        try {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="ListadoSalidas.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit();          
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    //Devuelve un pdf de las salidas realizadas
    public function generapdf() {
        $tipo = $_POST['tipo'];
       
        $this->almodel = new AlmacenesModel();
        $this->cenmodel = new CentralesModel();
        $this->emplemodel = new EmpleadosModel();
        $this->detsalmodel = new DetSalidasModel();
        $this->prodmodel = new ProductosModel();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image('./recursos/img/logo2.png', 10, 10, -300);

        $pdf->SetTextColor(35, 52, 63);
        switch ($tipo) {
            case 'empleado':
                $id = $_POST['numemple'];
                $dniemple = $this->emplemodel->getEmpleado($id)->getDNI();
                $pdf->SetFont('courier', 'b', 14);
                $pdf->Cell(50);
                $pdf->Cell(100, 10, 'Salidas del empleado: ' . $dniemple, 0, 1, 'C');
                $pdf->SetFont('courier', '', 10);
                $pdf->Ln();

                $objetosalidaempleado = $this->salmodel->getSalidasempleado($id);

                foreach ($objetosalidaempleado as $fila) {
                    $pdf->Cell(15);
                    $numsalida = $fila['NumSalida'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaSalida'];
                    $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($fila['CodAlmacen'])->getTipo();
                    $objetodet = $this->detsalmodel->getDetalleSalidas($numsalida);
                    $pdf->Cell(40, 5, "Salida: " . $numsalida);
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
                        $pdf->SetFont('courier', 'b', 10);
                        $pdf->Cell(50, 8, $col, 1, 0, 'C');
                    }
                    foreach ($objetodet as $fila2) {
                        $pdf->Ln();
                        $pdf->Cell(40);
                        $pdf->SetFont('courier', '', 10);
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
                $pdf->SetFont('courier', 'b', 12);
                $pdf->Cell(5);
                $pdf->Cell(180, 10, 'Salidas del empleado: ' . $dniemple . ' / Central: ' . $central, 0, 1, 'C');
                $pdf->SetFont('courier', '', 10);
                $pdf->Ln();
                $objetosalidaempleado = $this->salmodel->getSalidasempleadoyalmacen($id, $idal);
                foreach ($objetosalidaempleado as $fila) {
                    $numsalida = $fila['NumSalida'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaSalida'];
                    $objetodet = $this->detsalmodel->getDetalleSalidas($numsalida);
                    $pdf->Cell(15);
                    $pdf->Cell(60, 5, "Salida: " . $numsalida);
                    $pdf->Cell(60, 5, "Fecha: " . $fecha);
                    $pdf->Ln();
                    $pdf->Cell(15);
                    $pdf->Cell(300, 5, "Motivo: " . $motivo);
                    $pdf->Ln();
                    $pdf->Ln();
                    $header = array('Producto', 'Unidades');
                    $pdf->Cell(40);
                    foreach ($header as $col) {
                        $pdf->SetFont('courier', 'B', 10);
                        $pdf->Cell(50, 8, $col, 1, 0, 'C');
                    }
                    foreach ($objetodet as $fila2) {
                        $pdf->Ln();
                        $pdf->SetFont('courier', '', 10);
                        $pdf->Cell(40);
                        $pdf->Cell(50, 7, $this->prodmodel->getUnProducto($fila2['CodProd'])->getNombre(), 1, 0, 'C');
                        $pdf->Cell(50, 7, $fila2['Unidades'], 1, 0, 'C');
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
                $pdf->SetFont('courier', 'B', 14);
                $pdf->Cell(30);
                $pdf->Cell(130, 10, 'Salidas en el almacen: ' . $central, 0, 1, 'C');
                $pdf->SetFont('courier', '', 10);
                $pdf->Ln();
                $salidasalma = $this->salmodel->getSalidasalmacen($id);
                foreach ($salidasalma as $fila) {
                    $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($fila['CodAlmacen'])->getTipo();
                    $pdf->Cell(15);
                    $numsalida = $fila['NumSalida'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaSalida'];
                    $dniemple = $this->emplemodel->getEmpleado($fila['NumEmple'])->getDNI();
                    $objetodet = $this->detsalmodel->getDetalleSalidas($numsalida);
                    $pdf->Cell(40, 5, "Salida: " . $numsalida);
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
                        $pdf->SetFont('courier', 'b', 10);
                        $pdf->Cell(50, 8, $col, 1, 0, 'C');
                    }
                    foreach ($objetodet as $fila2) {
                        $pdf->Ln();
                        $pdf->Cell(40);
                        $pdf->SetFont('courier', '', 10);
                        $pdf->Cell(50, 6, $this->prodmodel->getUnProducto($fila2['CodProd'])->getNombre(), 1, 0, 'C');
                        $pdf->Cell(50, 6, $fila2['Unidades'], 1, 0, 'C');
                    }//foreachdetalleentrada
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                }  //foreachentrada 
                break;
            case 'todas':
                $objetoentrada = $this->salmodel->getAll();             
                $pdf->SetFont('courier', 'b', 14);
                $pdf->Cell(65);
                $pdf->Cell(60, 10, 'Listado de salidas', 0, 1, 'C');
                $pdf->SetFont('courier', '', 10);
                $pdf->Ln();
                foreach ($objetoentrada as $fila) {
                    $pdf->Cell(15);
                    $numsalida = $fila['NumSalida'];
                    $motivo = $fila['Motivo'];
                    $fecha = $fila['FechaSalida'];
                    $dniemple = $this->emplemodel->getEmpleado($fila['NumEmple'])->getDNI();
                    $central = $this->cenmodel->getUnaCentral($this->almodel->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre() . " " . $this->almodel->getUnAlmacen($fila['CodAlmacen'])->getTipo();
                    $objetodet = $this->detsalmodel->getDetalleSalidas($numsalida);
                    $pdf->Cell(100, 5, "Salida: " . $numsalida);
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
                        $pdf->SetFont('courier', 'b', 10);
                        $pdf->Cell(50, 8, $col, 1, 0, 'C');
                    }
                    foreach ($objetodet as $fila2) {
                        $pdf->Ln();
                        $pdf->SetFont('courier', '', 10);
                        $pdf->Cell(40);
                        $pdf->Cell(50, 6, $this->prodmodel->getUnProducto($fila2['CodProd'])->getNombre(), 1, 0, 'C');
                        $pdf->Cell(50, 6, $fila2['Unidades'], 1, 0, 'C');
                    }//foreachdetalleentrada
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                    $pdf->Ln();
                }  //foreachentrada
                break;
        }
        $pdf->Output('ListadoSalidas.pdf', 'D');
    }
}
