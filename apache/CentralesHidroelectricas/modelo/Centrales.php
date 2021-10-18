<?php

class Centrales {

    private $IdCentral;
    private $Nombre;
    private $Telefono;
    private $Constructor;
    private $Provincia;
    private $Poblacion;
    private $CP;
    private $TipoTurbina;
    private $SaltoBruto;
    private $NumGeneradores;
    private $Potencia;
    private $Foto;

    function __construct($IdCentral = "", $Nombre = "", $Telefono = "", $Constructor = "", $Provincia = "", $Poblacion = "", $CP = "", $TipoTurbina = "", $SaltoBruto = "", $NumGeneradores = "", $Potencia = "", $Foto = "") {
        $this->IdCentral = $IdCentral;
        $this->Nombre = $Nombre;
        $this->Telefono = $Telefono;
        $this->Constructor = $Constructor;
        $this->Provincia = $Provincia;
        $this->Poblacion = $Poblacion;
        $this->CP = $CP;
        $this->TipoTurbina = $TipoTurbina;
        $this->SaltoBruto = $SaltoBruto;
        $this->NumGeneradores = $NumGeneradores;
        $this->Potencia = $Potencia;
        $this->Foto = $Foto;
    }

    function getIdCentral() {
        return $this->IdCentral;
    }

    function getNombre() {
        return $this->Nombre;
    }

    function getTelefono() {
        return $this->Telefono;
    }

    function getConstructor() {
        return $this->Constructor;
    }

    function getProvincia() {
        return $this->Provincia;
    }

    function getPoblacion() {
        return $this->Poblacion;
    }

    function getCP() {
        return $this->CP;
    }

    function getTipoTurbina() {
        return $this->TipoTurbina;
    }

    function getSaltoBruto() {
        return $this->SaltoBruto;
    }

    function getNumGeneradores() {
        return $this->NumGeneradores;
    }

    function getPotencia() {
        return $this->Potencia;
    }

    function getFoto() {
        return $this->Foto;
    }

    function setIdCentral($IdCentral): void {
        $this->IdCentral = $IdCentral;
    }

    function setNombre($Nombre): void {
        $this->Nombre = $Nombre;
    }

    function setTelefono($Telefono): void {
        $this->Telefono = $Telefono;
    }

    function setConstructor($Constructor): void {
        $this->Constructor = $Constructor;
    }

    function setProvincia($Provincia): void {
        $this->Provincia = $Provincia;
    }

    function setPoblacion($Poblacion): void {
        $this->Poblacion = $Poblacion;
    }

    function setCP($CP): void {
        $this->CP = $CP;
    }

    function setTipoTurbina($TipoTurbina): void {
        $this->TipoTurbina = $TipoTurbina;
    }

    function setSaltoBruto($SaltoBruto): void {
        $this->SaltoBruto = $SaltoBruto;
    }

    function setNumGeneradores($NumGeneradores): void {
        $this->NumGeneradores = $NumGeneradores;
    }

    function setPotencia($Potencia): void {
        $this->Potencia = $Potencia;
    }

    function setFoto($Foto): void {
        $this->Foto = $Foto;
    }

}
