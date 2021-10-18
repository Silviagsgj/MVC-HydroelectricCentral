<?php

class Almacenes {

    private $CodAlmacen;
    private $Tipo;
    private $IdCentral;

    function __construct($CodAlmacen = "", $Tipo = "", $IdCentral = "") {
        $this->CodAlmacen = $CodAlmacen;
        $this->Tipo = $Tipo;
        $this->IdCentral = $IdCentral;
    }

    function getCodAlmacen() {
        return $this->CodAlmacen;
    }

    function getTipo() {
        return $this->Tipo;
    }

    function getIdCentral() {
        return $this->IdCentral;
    }

    function setCodAlmacen($CodAlmacen): void {
        $this->CodAlmacen = $CodAlmacen;
    }

    function setTipo($Tipo): void {
        $this->Tipo = $Tipo;
    }

    function setIdCentral($IdCentral): void {
        $this->IdCentral = $IdCentral;
    }

}
