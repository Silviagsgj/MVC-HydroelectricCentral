<?php

class DetEntradas {

    private $IdDetalle;
    private $NumEntrada;
    private $CodProd;
    private $Unidades;

    function __construct($IdDetalle = "", $NumEntrada = "", $CodProd = "", $Unidades = "") {
        $this->IdDetalle = $IdDetalle;
        $this->NumEntrada = $NumEntrada;
        $this->CodProd = $CodProd;
        $this->Unidades = $Unidades;
    }

    function getIdDetalle() {
        return $this->IdDetalle;
    }

    function getNumEntrada() {
        return $this->NumEntrada;
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

    function setNumEntrada($NumEntrada): void {
        $this->NumEntrada = $NumEntrada;
    }

    function setCodProd($CodProd): void {
        $this->CodProd = $CodProd;
    }

    function setUnidades($Unidades): void {
        $this->Unidades = $Unidades;
    }

}
