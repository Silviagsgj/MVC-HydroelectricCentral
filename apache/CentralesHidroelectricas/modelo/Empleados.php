<?php

class Empleados {

    private $NumEmple;
    private $DNI;
    private $Nombre;
    private $Apellidos;
    private $FechaNac;
    private $Telefono;
    private $Email;
    private $Direccion;
    private $Provincia;
    private $Poblacion;
    private $CP;
    private $IdUsuario;
    private $IdCategoria;
    private $CodDepart;
    private $IdCentral;
    private $Foto;

    function __construct($NumEmple = "", $DNI = "", $Nombre = "", $Apellidos = "", $FechaNac = "", $Telefono = "", $Email = "", $Direccion = "", $Provincia = "", $Poblacion = "", $CP = "", $IdUsuario = "", $IdCategoria = "", $CodDepart = "", $IdCentral = "", $Foto="") {
        $this->NumEmple = $NumEmple;
        $this->DNI = $DNI;
        $this->Nombre = $Nombre;
        $this->Apellidos = $Apellidos;
        $this->FechaNac = $FechaNac;
        $this->Telefono = $Telefono;
        $this->Email = $Email;
        $this->Direccion = $Direccion;
        $this->Provincia = $Provincia;
        $this->Poblacion = $Poblacion;
        $this->CP = $CP;
        $this->IdUsuario = $IdUsuario;
        $this->IdCategoria = $IdCategoria;
        $this->CodDepart = $CodDepart;
        $this->IdCentral = $IdCentral;
        $this->Foto = $Foto;
    }

    function getNumEmple() {
        return $this->NumEmple;
    }

    function getDNI() {
        return $this->DNI;
    }

    function getNombre() {
        return $this->Nombre;
    }

    function getApellidos() {
        return $this->Apellidos;
    }

    function getFechaNac() {
        return $this->FechaNac;
    }

    function getTelefono() {
        return $this->Telefono;
    }

    function getEmail() {
        return $this->Email;
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

    function getIdUsuario() {
        return $this->IdUsuario;
    }

    function getIdCategoria() {
        return $this->IdCategoria;
    }

    function getCodDepart() {
        return $this->CodDepart;
    }

    function getIdCentral() {
        return $this->IdCentral;
    }

    function getFoto() {
        return $this->Foto;
    }
    
    function setNumEmple($NumEmple): void {
        $this->NumEmple = $NumEmple;
    }

    function setDNI($DNI): void {
        $this->DNI = $DNI;
    }

    function setNombre($Nombre): void {
        $this->Nombre = $Nombre;
    }

    function setApellidos($Apellidos): void {
        $this->Apellidos = $Apellidos;
    }

    function setFechaNac($FechaNac): void {
        $this->FechaNac = $FechaNac;
    }

    function setTelefono($Telefono): void {
        $this->Telefono = $Telefono;
    }

    function setEmail($Email): void {
        $this->Email = $Email;
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

    function setIdUsuario($IdUsuario): void {
        $this->IdUsuario = $IdUsuario;
    }

    function setIdCategoria($IdCategoria): void {
        $this->IdCategoria = $IdCategoria;
    }

    function setCodDepart($CodDepart): void {
        $this->CodDepart = $CodDepart;
    }

    function setIdCentral($IdCentral): void {
        $this->IdCentral = $IdCentral;
    }

      function setFoto($Foto): void {
        $this->Foto = $Foto;
    }

}
