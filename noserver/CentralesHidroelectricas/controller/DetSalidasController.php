<?php

session_start();

class DetSalidasController extends ControladorBase {

    private $detsalmodel;

    public function __construct() {
        parent::__construct();
        $this->detsalmodel = new DetSalidasModel();
    }

    /*
     *  FUNCIÓN QUE DA UN LISTADO DE LOS PRODUCTOS DE CADA SALIDA REALIZADA
     */

    public function mostrardetalle() {
        $id = $_GET['num'];
        $datos['titulo'] = "Detalle salida";
        $elementos = $this->detsalmodel->getDetalleSalidas($id);
        $datos['elementos'] = $elementos;
        $datos['cambio'] = "salidas";
        $this->view("detalle", $datos);
    }

}
