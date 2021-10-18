<?php

class Proveedores {

    private $IdProveedor;
    private $Nombre;
    private $CIF;
    private $Telefono;
    private $Direccion;
    private $Provincia;
    private $Poblacion;
    private $CP;

    function __construct($IdProveedor = "", $Nombre = "", $CIF = "", $Telefono = "", $Direccion = "", $Provincia = "", $Poblacion = "", $CP = "") {
        $this->IdProveedor = $IdProveedor;
        $this->Nombre = $Nombre;
        $this->CIF = $CIF;
        $this->Telefono = $Telefono;
        $this->Direccion = $Direccion;
        $this->Provincia = $Provincia;
        $this->Poblacion = $Poblacion;
        $this->CP = $CP;
    }

    function getIdProveedor() {
        return $this->IdProveedor;
    }

    function getNombre() {
        return $this->Nombre;
    }

    function getCIF() {
        return $this->CIF;
    }

    function getTelefono() {
        return $this->Telefono;
    }

    function getDireccion() {
        return $this->Direccion;
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

    function setIdProveedor($IdProveedor): void {
        $this->IdProveedor = $IdProveedor;
    }

    function setNombre($Nombre): void {
        $this->Nombre = $Nombre;
    }

    function setCIF($CIF): void {
        $this->CIF = $CIF;
    }

    function setTelefono($Telefono): void {
        $this->Telefono = $Telefono;
    }

    function setDireccion($Direccion): void {
        $this->Direccion = $Direccion;
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

}
