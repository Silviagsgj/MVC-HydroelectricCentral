<?php

class ControladorBase {

    public function __construct() {
        foreach (glob("modelo/*.php") as $file) {
            require_once $file;
        }
    }

    public function url($controlador = CONTROLADOR_DEFECTO, $accion = ACCION_DEFECTO, $num = "", $numa = "") {
        if ($numa != "") {
            $urlString = "index.php?controller=" . $controlador . "&action=" . $accion . "&num=" . $num . "&numa=" . $numa;
        } else {
            if ($num != "") {
                $urlString = "index.php?controller=" . $controlador . "&action=" . $accion . "&num=" . $num;
            } else {
                $urlString = "index.php?controller=" . $controlador . "&action=" . $accion;
            }
        }
        return $urlString;
    }

    public function view($vista, $data) {
        foreach ($data as $id_assoc => $value) {
            ${$id_assoc} = $value;
        }

        if ($vista != 'login') {
            //Aqui añado la estructura general de la pag
            require_once 'vista/comun/cabecera.php';
            require_once 'vista/comun/sidebar.php';
            require_once 'vista/' . $vista . 'View.php';
            require_once 'vista/comun/pie.php';
        } else {
            require_once 'vista/' . $vista . 'View.php';
        }
    }

    public function redirect($controlador = CONTROLADOR_DEFECTO, $accion = ACCION_DEFECTO) {
        header("Location:index.php?controller=" . $controlador . "&action=" . $accion);
    }

}

?>