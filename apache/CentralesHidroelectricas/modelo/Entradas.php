<?php

class Entradas {

    private $NumEntrada;
    private $NumEmple;
    private $CodAlmacen;
    private $FechaEntrada;
    private $Motivo;

    function __construct($NumEntrada = "", $NumEmple = "", $CodAlmacen = "", $FechaEntrada = "", $Motivo = "") {
        $this->NumEntrada = $NumEntrada;
        $this->NumEmple = $NumEmple;
        $this->CodAlmacen = $CodAlmacen;
        $this->FechaEntrada = $FechaEntrada;
        $this->Motivo = $Motivo;
    }

    function getNumEntrada() {
        return $this->NumEntrada;
    }

    function getNumEmple() {
        return $this->NumEmple;
    }

    function getCodAlmacen() {
        return $this->CodAlmacen;
    }

    function getFechaEntrada() {
        return $this->FechaEntrada;
    }

    function getMotivo() {
        return $this->Motivo;
    }

    function setNumEntrada($NumEntrada): void {
        $this->NumEntrada = $NumEntrada;
    }

    function setNumEmple($NumEmple): void {
        $this->NumEmple = $NumEmple;
    }

    function setCodAlmacen($CodAlmacen): void {
        $this->CodAlmacen = $CodAlmacen;
    }

    function setFechaEntrada($FechaEntrada): void {
        $this->FechaEntrada = $FechaEntrada;
    }

    function setMotivo($Motivo): void {
        $this->Motivo = $Motivo;
    }

}
