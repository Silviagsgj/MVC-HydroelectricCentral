<?php

session_start();

class DetEntradasController extends ControladorBase {

    private $detentmodel;

    public function __construct() {
        parent::__construct();
        $this->detentmodel = new DetEntradasModel();
    }

    /*
     *  FUNCIÓN QUE DA UN LISTADO DE LOS PRODUCTOS DE CADA ENTRADA REALIZADA
    */

    public function mostrardetalle() {
        $id = $_GET['num'];
        $datos['titulo'] = "Detalle entrada";
        $elementos = $this->detentmodel->getDetalleEntradas($id);
        $datos['elementos'] = $elementos;
        $datos['cambio'] = "entradas";
        $this->view("detalle", $datos);
    }

}
