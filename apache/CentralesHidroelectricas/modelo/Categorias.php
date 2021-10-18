<?php

class Categorias {

    private $IdCategoria;
    private $SalarioBase;
    private $HoraExtraNormal;
    private $HoraExtraNocturna;
    private $HoraExtraFestivo;

    function __construct($IdCategoria = "", $SalarioBase = "", $HoraExtraNormal = "", $HoraExtraNocturna = "", $HoraExtraFestivo = "") {
        $this->IdCategoria = $IdCategoria;
        $this->SalarioBase = $SalarioBase;
        $this->HoraExtraNormal = $HoraExtraNormal;
        $this->HoraExtraNocturna = $HoraExtraNocturna;
        $this->HoraExtraFestivo = $HoraExtraFestivo;
    }

    function getIdCategoria() {
        return $this->IdCategoria;
    }

    function getSalarioBase() {
        return $this->SalarioBase;
    }

    function getHoraExtraNormal() {
        return $this->HoraExtraNormal;
    }

    function getHoraExtraNocturna() {
        return $this->HoraExtraNocturna;
    }

    function getHoraExtraFestivo() {
        return $this->HoraExtraFestivo;
    }

    function setIdCategoria($IdCategoria): void {
        $this->IdCategoria = $IdCategoria;
    }

    function setSalarioBase($SalarioBase): void {
        $this->SalarioBase = $SalarioBase;
    }

    function setHoraExtraNormal($HoraExtraNormal): void {
        $this->HoraExtraNormal = $HoraExtraNormal;
    }

    function setHoraExtraNocturna($HoraExtraNocturna): void {
        $this->HoraExtraNocturna = $HoraExtraNocturna;
    }

    function setHoraExtraFestivo($HoraExtraFestivo): void {
        $this->HoraExtraFestivo = $HoraExtraFestivo;
    }

}
