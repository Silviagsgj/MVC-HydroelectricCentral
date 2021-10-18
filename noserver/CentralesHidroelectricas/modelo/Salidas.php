<?php

class Salidas {

    private $NumSalida;
    private $NumEmple;
    private $CodAlmacen;
    private $FechaSalida;
    private $Motivo;

    function __construct($NumSalida = "", $NumEmple = "", $CodAlmacen = "", $FechaSalida = "", $Motivo = "") {
        $this->NumSalida = $NumSalida;
        $this->NumEmple = $NumEmple;
        $this->CodAlmacen = $CodAlmacen;
        $this->FechaSalida = $FechaSalida;
        $this->Motivo = $Motivo;
    }

    function getNumSalida() {
        return $this->NumSalida;
    }

    function getNumEmple() {
        return $this->NumEmple;
    }

    function getCodAlmacen() {
        return $this->CodAlmacen;
    }

    function getFechaSalida() {
        return $this->FechaSalida;
    }

    function getMotivo() {
        return $this->Motivo;
    }

    function setNumSalida($NumSalida): void {
        $this->NumSalida = $NumSalida;
    }

    function setNumEmple($NumEmple): void {
        $this->NumEmple = $NumEmple;
    }

    function setCodAlmacen($CodAlmacen): void {
        $this->CodAlmacen = $CodAlmacen;
    }

    function setFechaSalida($FechaSalida): void {
        $this->FechaSalida = $FechaSalida;
    }

    function setMotivo($Motivo): void {
        $this->Motivo = $Motivo;
    }

}
