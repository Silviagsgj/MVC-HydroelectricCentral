<?php

class Departamentos {

    private $CodDepart;
    private $Nombre;

    function __construct($CodDepart = "", $Nombre = "") {
        $this->CodDepart = $CodDepart;
        $this->Nombre = $Nombre;
    }

    function getCodDepart() {
        return $this->CodDepart;
    }

    function getNombre() {
        return $this->Nombre;
    }

    function setCodDepart($CodDepart): void {
        $this->CodDepart = $CodDepart;
    }

    function setNombre($Nombre): void {
        $this->Nombre = $Nombre;
    }

}
