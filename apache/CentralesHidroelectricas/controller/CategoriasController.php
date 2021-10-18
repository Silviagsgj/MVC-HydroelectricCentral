<?php

session_start();

class CategoriasController extends ControladorBase {

    private $catmodel;

    public function __construct() {
        parent::__construct();
        $this->catmodel = new CategoriasModel();
    }

    /*
     *  FUNCIÓN QUE DA UN LISTADO DE LAS CATEGORIAS DISPONIBLES 
     */

    public function listar() {
        $datos['titulo'] = "Categorias";
        $elementos = $this->catmodel->getAll();
        $datos['elementos'] = $elementos;
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE BORRA UNA CATEGORIA
     */

    public function borrar() {
        $id = $_GET['num'];
        $res = $this->catmodel->borrarElemento($id);

        if ($res >= 1) {
            $mensaje = "Categoría borrada correctamente: " . $id;
        } else {

            $mensaje = "Error al borrar: Hay trabajadores asociados a esta categoria";
            $errores = '';
            $datos['errores'] = $errores;
        }

        //vuelvo a cargar las categorias
        $titulo = "Categorias";
        $elementos = $this->catmodel->getAll();
        $datos['titulo'] = $titulo;
        $datos['elementos'] = $elementos;
        $datos['mensaje'] = $mensaje;
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE LLEVA A UN FORMULARIO PARA DAR DE ALTA UNA NUEVA CATEGORIA
     */

    public function insertar() {
        $datos['opcion'] = "categoria";
        $datos['ope'] = "Insertar";
        $datos['titulo'] = "Insertar Categoría";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCIÓN QUE DA DE ALTA UNA NUEVA CATEGORIA
     */

    public function insertarlacategoria() {
        $SalarioBase = $_POST['SalarioBase'];
        $HoraExtraNormal = $_POST['HoraExtraNormal'];
        $HoraExtraNocturna = $_POST['HoraExtraNocturna'];
        $HoraExtraFestivo = $_POST['HoraExtraFestivo'];

        //llamo a la funcion insertar
        $res = $this->catmodel->crear($SalarioBase, $HoraExtraNormal, $HoraExtraNocturna, $HoraExtraFestivo);

        
        if (is_object($res)) {
            $datos['objelemento'] = $res;
            $mensaje = "Categoria insertado correctamente con ID: " . $res->getIdCategoria();
        } else {
            $mensaje = "Se ha producido un error al insertar: <br>" . $res;
            $errores = '';
            $datos['errores'] = $errores;
        }

        //vuelvo a mostrar la vista con el formulario congelado y los mensajes
        $datos['mensaje'] = $mensaje;
        $datos['opcion'] = "categoria";
        $datos['ope'] = "Insertar";
        $datos['titulo'] = "Insertar Categoria";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE LLEVA A UN FORMULARIO PARA MODIFICAR UNA CATEGORIA SELECCIONADA
     */

    public function modificar() {
        $datos['titulo'] = "Actualizar Categoria";
        $id = $_GET['num'];
        $objelemento = $this->catmodel->getUnaCategoria($id);
        $datos['objelemento'] = $objelemento;
        $datos['opcion'] = "categoria";
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE MODIFICA LOS DATOS DE UNA CATEGORIA SELECCIONADA
     */

    public function modificarlacategoria() {
        $IdCategoria = $_POST['IdCategoria'];
        $SalarioBase = $_POST['SalarioBase'];
        $HoraExtraNormal = $_POST['HoraExtraNormal'];
        $HoraExtraNocturna = $_POST['HoraExtraNocturna'];
        $HoraExtraFestivo = $_POST['HoraExtraFestivo'];

        $objelemento = $this->catmodel->actualizarcat($IdCategoria, $SalarioBase, $HoraExtraNormal, $HoraExtraNocturna, $HoraExtraFestivo);

        if (is_object($objelemento)) {
            $datos['objelemento'] = $objelemento;
            $mensaje = "Categoria actualizada correctamente, codigo: " . $objelemento->getIdCategoria();
        } else {
            $mensaje = "ERROR AL ACTUALIZAR <br>" . $objelemento;
            $errores = '';
            $datos['errores'] = $errores;
        }

        $datos['mensaje'] = $mensaje;
        $datos['opcion'] = "categoria";
        $datos['titulo'] = "Actualizar Categoria";
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

}
