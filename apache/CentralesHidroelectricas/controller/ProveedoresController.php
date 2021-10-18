<?php

session_start();

class ProveedoresController extends ControladorBase {

    private $provmodel;

    public function __construct() {
        parent::__construct();
        $this->provmodel = new ProveedoresModel();
    }

    /*
     *  FUNCIÓN QUE DA UN LISTADO DE LOS PROVEEDORES DISPONIBLES 
     */

    public function listar() {
        $datos['titulo'] = "Proveedores";
        $elementos = $this->provmodel->getAll();
        $datos['elementos'] = $elementos;
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE BORRA UN PROVEEDOR
     */

    public function borrar() {
        $id = $_GET['num'];
        $res = $this->provmodel->borrarElemento($id);

        if ($res >= 1) {
            $mensaje = "Proveedor borrado correctamente";
        } else {
            $mensaje = "Error al borrar: <br>" . $res;
            $errores = '';
            $datos['errores'] = $errores;
        }

        //vuelvo a cargar los proveedores
        $titulo = "Proveedores";
        $elementos = $this->provmodel->getAll();
        $datos['titulo'] = $titulo;
        $datos['elementos'] = $elementos;
        $datos['mensaje'] = $mensaje;

        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE LLEVA A UN FORMULARIO PARA DAR DE ALTA UNA NUEVO PROVEEDOR
     */

    public function insertar() {
        $datos['opcion'] = "proveedor";
        $datos['ope'] = "Insertar";
        $datos['titulo'] = "Insertar Proveedor";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCIÓN QUE DA DE ALTA UNA NUEVO PROVEEDOR
     */

    public function insertarelproveedor() {

        $Nombre = $_POST['Nombre'];
        $CIF = $_POST['CIF'];
        $Telefono = $_POST['Telefono'];
        $Direccion = $_POST['Direccion'];
        $Provincia = $_POST['Provincia'];
        $Poblacion = $_POST['Poblacion'];
        $CP = $_POST['CP'];

        //llamo a la funcion insertar
        $res = $this->provmodel->crear($Nombre, $CIF, $Telefono, $Direccion, $Provincia, $Poblacion, $CP);

        //Pongo los mensajes de errores preguntando si es objeto

        if (is_object($res)) {
            $datos['objelemento'] = $res;
            $mensaje = "Proveedor insertado correctamente con ID: " . $res->getIdProveedor();
        } else {
            $mensaje = "Se ha producido un error al insertar: <br>" . $res;
            $errores = '';
            $datos['errores'] = $errores;
        }

        //vuelvo a mostrar la vista con el formulario congelado y los mensajes

        $datos['mensaje'] = $mensaje;
        $datos['opcion'] = "proveedor";
        $datos['ope'] = "Insertar";
        $datos['titulo'] = "Insertar Proveedor";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE LLEVA A UN FORMULARIO PARA MODIFICAR UN PROVEEDOR SELECCIONADO
     */

    public function modificar() {
        $datos['titulo'] = "Actualizar Proveedor";
        $id = $_GET['num'];
        $objelemento = $this->provmodel->getUnProveedor($id);
        $datos['objelemento'] = $objelemento;
        $datos['opcion'] = "proveedor";
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE MODIFICA LOS DATOS DE UN PROVEEDOR SELECCIONADO
     */

    public function modificarelproveedor() {
        $IdProveedor = $_POST['IdProveedor'];
        $Nombre = $_POST['Nombre'];
        $CIF = $_POST['CIF'];
        $Telefono = $_POST['Telefono'];
        $Direccion = $_POST['Direccion'];
        $Provincia = $_POST['Provincia'];
        $Poblacion = $_POST['Poblacion'];
        $CP = $_POST['CP'];

        $objelemento = $this->provmodel->actualizarprov($IdProveedor, $Nombre, $CIF, $Telefono, $Direccion, $Provincia, $Poblacion, $CP);

        if (is_object($objelemento)) {
            $datos['objelemento'] = $objelemento;
            $mensaje = "Proveedor actualizado correctamente";
        } else {
            $mensaje = "ERROR AL ACTUALIZAR <br>" . $objelemento;
            $errores = '';
            $datos['errores'] = $errores;
        }

        $datos['mensaje'] = $mensaje;
        $datos['opcion'] = "proveedor";
        $datos['titulo'] = "Actualizar Proveedor";
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

}
