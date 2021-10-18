<?php

class DetSalidas {

    private $IdDetalle;
    private $NumSalida;
    private $CodProd;
    private $Unidades;

    function __construct($IdDetalle = "", $NumSalida = "", $CodProd = "", $Unidades = "") {
        $this->IdDetalle = $IdDetalle;
        $this->NumSalida = $NumSalida;
        $this->CodProd = $CodProd;
        $this->Unidades = $Unidades;
    }

    function getIdDetalle() {
        return $this->IdDetalle;
    }

    function getNumSalida() {
        return $this->NumSalida;
    }

    function getCodProd() {
        return $this->CodProd;
    }

    function getUnidades() {
        return $this->Unidades;
    }

    function setIdDetalle($IdDetalle): void {
        $this->IdDetalle = $IdDetalle;
    }

    function setNumSalida($NumSalida): void {
        $this->NumSalida = $NumSalida;
    }

    function setCodProd($CodProd): void {
        $this->CodProd = $CodProd;
    }

    function setUnidades($Unidades): void {
        $this->Unidades = $Unidades;
    }

}
