<?php

class Productos {

    private $CodProd;
    private $Nombre;
    private $Descripcion;
    private $Marca;
    private $Stock;
    private $Foto;

    function __construct($CodProd = "", $Nombre = "", $Descripcion = "", $Marca = "", $Stock = "", $Foto = "") {
        $this->CodProd = $CodProd;
        $this->Nombre = $Nombre;
        $this->Descripcion = $Descripcion;
        $this->Marca = $Marca;
        $this->Stock = $Stock;
        $this->Foto = $Foto;
    }

    function getCodProd() {
        return $this->CodProd;
    }

    function getNombre() {
        return $this->Nombre;
    }

    function getDescripcion() {
        return $this->Descripcion;
    }

    function getMarca() {
        return $this->Marca;
    }

    function getStock() {
        return $this->Stock;
    }


    function getFoto() {
        return $this->Foto;
    }

    function setCodProd($CodProd): void {
        $this->CodProd = $CodProd;
    }

    function setNombre($Nombre): void {
        $this->Nombre = $Nombre;
    }

    function setDescripcion($Descripcion): void {
        $this->Descripcion = $Descripcion;
    }

    function setMarca($Marca): void {
        $this->Marca = $Marca;
    }

    function setStock($Stock): void {
        $this->Stock = $Stock;
    }

 
    function setFoto($Foto): void {
        $this->Foto = $Foto;
    }

}
