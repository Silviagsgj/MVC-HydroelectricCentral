<?php

session_start();

class AlmacenesController extends ControladorBase {

    private $almodel;
    private $cenmodel;
    private $entmodel;
    private $detentmodel;
    private $salmodel;
    private $detsalmodel;

    public function __construct() {
        parent::__construct();
        $this->almodel = new AlmacenesModel();
        $this->cenmodel = new CentralesModel();
        $this->entmodel = new EntradasModel();
        $this->detentmodel = new DetEntradasModel();
        $this->salmodel = new SalidasModel();
        $this->detsalmodel = new DetSalidasModel();
    }

    public function gestion() {
        $centrales = $this->cenmodel->getAll();
        $datos['centrales'] = $centrales;
        $datos['titulo'] = "Gestion de almacenes";
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE DA UN LISTADO DE LOS ALMACENES DISPONIBLES 
     */

    public function listar() {
        $centrales = $this->cenmodel->getAll();
        $datos['centrales'] = $centrales;
        $datos['titulo'] = "Almacenes";
        $elementos = $this->almodel->getAll();
        $datos['elementos'] = $elementos;
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE DA UN LISTADO DE LOS ALMACENES DE UNA CENTRAL SELECCIONADA
     */

    public function verporcentral() {
        $centrales = $this->cenmodel->getAll();
        $datos['centrales'] = $centrales;
        $id = $_POST['centrales'];
        $almacenesporcentral = $this->almodel->getAlmacenesCentral($id);
        $titulo = "Almacenes de la central: " . $this->cenmodel->getUnaCentral($id)->getNombre();
        $datos['titulo'] = $titulo;
        $datos['elementos'] = $almacenesporcentral;
        $titulo2 = "Total almacenes: " . count($almacenesporcentral);
        $datos['titulo2'] = $titulo2;
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE BORRA TODOS LOS ALMACENES Y LOS DATOS ASOCIADOS A ESE ALMACEN --> Si tiene entradas y salidas de productos
     */

    public function borrar() {
        $id = $_GET['num'];
        //comprobar si el almacen tiene entradas y salidas
        $entradas = $this->entmodel->getEntradasalmacen($id);
        $salidas = $this->salmodel->getSalidasalmacen($id);

        if (count($entradas) != 0) {
            //borro las entradas
            foreach ($entradas as $fila) {
                //borro el detalle
                $this->detentmodel->borrarElemento($fila['NumEntrada']);
                //borro la entrada
                $this->entmodel->borrarElemento($fila['NumEntrada']);
            }
        }

        //compruebo si para ese almacen tiene salidas de productos    
        if (count($salidas) != 0) {
            //borro las entradas
            foreach ($salidas as $fila2) {
                //borro el detalle
                $this->detsalmodel->borrarElemento($fila2['NumSalida']);
                //borro la entrada
                $this->salmodel->borrarElemento($fila2['NumSalida']);
            }
        }

        $res = $this->almodel->borrarElemento($id);
        if ($res >= 1) {
            $mensaje = "Almacen borrado correctamente: " . $id;
        } else {
            $mensaje = "Error al borrar: <br>" . $res;
            $errores = '';
            $datos['errores'] = $errores;
        }
        //Vuelvo a listar los almacenes
        $titulo = "Almacenes";
        $elementos = $this->almodel->getAll();
        $datos['titulo'] = $titulo;
        $datos['elementos'] = $elementos;
        $datos['mensaje'] = $mensaje;
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE LLEVA A UN FORMULARIO PARA DAR DE ALTA UN NUEVO ALMACEN
     */

    public function insertar() {
        $elementos = $this->cenmodel->getAll();
        $datos['elementos'] = $elementos;
        $datos['ope'] = "Insertar";
        $datos['opcion'] = "almacen";
        $datos['titulo'] = "Insertar Almacen";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCIÓN QUE DA DE ALTA UN NUEVO ALMACEN
     */

    public function insertarelalmacen() {
        $Tipo = $_POST['Tipo'];
        $IdCentral = $_POST['IdCentral'];
        //llamo a la funcion insertar
        $res = $this->almodel->crear($Tipo, $IdCentral);
        //Pongo los mensajes de errores preguntando si es objeto
        if (is_object($res)) {
            $datos['objelemento'] = $res;
            $mensaje = "Almacen insertado correctamente con ID: " . $res->getCodAlmacen();
        } else {
            $mensaje = "Se ha producido un error al insertar: <br>" . $res;
            $errores = '';
            $datos['errores'] = $errores;
        }

        //vuelvo a mostrar la vista con el formulario congelado y los mensajes
        $elementos = $this->cenmodel->getAll();
        $datos['elementos'] = $elementos;
        $datos['mensaje'] = $mensaje;
        $datos['opcion'] = "almacen";
        $datos['ope'] = "Insertar";
        $datos['titulo'] = "Insertar Almacen";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCIÓN QUE LLEVA A UN FORMULARIO PARA MODIFICAR UN ALMACEN SELECCIONADO
     */

    public function modificar() {
        $datos['titulo'] = "Actualizar Almacen";
        $id = $_GET['num'];
        $elementos = $this->cenmodel->getAll();
        $datos['elementos'] = $elementos;
        $objelemento = $this->almodel->getUnAlmacen($id);
        $datos['objelemento'] = $objelemento;
        $datos['opcion'] = "almacen";
        $datos['cen'] = $_POST['centrales'];
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE MODIFICA LOS DATOS DE UN ALMACEN SELECCIONADO
     */

    public function modificarelalmacen() {
        $CodAlmacen = $_POST['CodAlmacen'];
        $Tipo = $_POST['Tipo'];
        $IdCentral = $_POST['IdCentral'];

        $objelemento = $this->almodel->actualizaral($CodAlmacen, $Tipo, $IdCentral);

        if (is_object($objelemento)) {
            $datos['objelemento'] = $objelemento;
            $mensaje = "Almacen actualizado correctamente, codigo: " . $objelemento->getCodAlmacen();
        } else {
            $mensaje = "ERROR AL ACTUALIZAR <br>" . $objelemento;
            $errores = '';
            $datos['errores'] = $errores;
        }

        $elementos = $this->cenmodel->getAll();
        $datos['elementos'] = $elementos;
        $datos['mensaje'] = $mensaje;
        $datos['opcion'] = "almacen";
        $datos['valu'] = $_POST['centrales'];
        $datos['titulo'] = "Actualizar Almacen";
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

}
