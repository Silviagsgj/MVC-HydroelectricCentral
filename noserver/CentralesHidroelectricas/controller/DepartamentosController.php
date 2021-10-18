<?php

session_start();

class DepartamentosController extends ControladorBase {

    private $depmodel;

    public function __construct() {
        parent::__construct();
        $this->depmodel = new DepartamentosModel();
    }

    /*
     *  FUNCIÓN QUE DA UN LISTADO DE LOS DEPARTAMENTOS DISPONIBLES 
     */

    public function listar() {
        $datos['titulo'] = "Departamentos";
        $elementos = $this->depmodel->getAll();
        $datos['elementos'] = $elementos;
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE BORRA UN DEPARTAMENTO
     */

    public function borrar() {
        $id = $_GET['num'];

        $res = $this->depmodel->borrarElemento($id);

        if ($res >= 1) {
            $mensaje = "Departamento borrado correctamente: " . $id;
        } else {
            $mensaje = "Error al borrar: Hay trabajadores asociados a este departamento";
            $errores = '';
            $datos['errores'] = $errores;
        }

        $titulo = "Departamentos";
        $elementos = $this->depmodel->getAll();
        $datos['titulo'] = $titulo;
        $datos['elementos'] = $elementos;
        $datos['mensaje'] = $mensaje;
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE LLEVA A UN FORMULARIO PARA DAR DE ALTA UN NUEVO DEPARTAMENTO
     */

    public function insertar() {
        $datos['ope'] = "Insertar";
        $datos['opcion'] = "departamento";
        $datos['titulo'] = "Insertar Departamento";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCIÓN QUE DA DE ALTA UNA NUEVO DEPARTAMENTO
     */

    public function insertareldep() {
        $Nombre = $_POST['Nombre'];

        //llamo a la funcion insertar
        $res = $this->depmodel->crear($Nombre);

        if (is_object($res)) {
            $datos['objelemento'] = $res;
            $mensaje = "Departamento insertado correctamente con ID: " . $res->getCodDepart();
        } else {
            $mensaje = "Se ha producido un error al insertar: <br>" . $res;
            $errores = '';
            $datos['errores'] = $errores;
        }

        //vuelvo a mostrar la vista con el formulario congelado y los mensajes            
        $datos['mensaje'] = $mensaje;
        $datos['ope'] = "Insertar";
        $datos['opcion'] = "departamento";
        $datos['titulo'] = "Insertar Departamento";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE LLEVA A UN FORMULARIO PARA MODIFICAR UN DEPARTAMENTO SELECCIONADO
     */

    public function modificar() {
        $datos['titulo'] = "Actualizar Departamento";
        $id = $_GET['num'];
        $objelemento = $this->depmodel->getUnDepart($id);
        $datos['objelemento'] = $objelemento;
        $datos['opcion'] = "departamento";
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE MODIFICA LOS DATOS DE UN DEPARTAMENTO SELECCIONADO
     */

    public function modificareldep() {
        $CodDepart = $_POST['CodDepart'];
        $Nombre = $_POST['Nombre'];

        $objelemento = $this->depmodel->actualizardep($CodDepart, $Nombre);

        if (is_object($objelemento)) {
            $datos['objelemento'] = $objelemento;
            $mensaje = "Departamentos actualizado correctamente, codigo: " . $objelemento->getCodDepart();
        } else {
            $mensaje = "ERROR AL ACTUALIZAR <br>" . $objelemento;
            $errores = '';
            $datos['errores'] = $errores;
        }

        $datos['mensaje'] = $mensaje;
        $datos['opcion'] = "departamento";
        $datos['titulo'] = "Actualizar Departamento";
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

}
