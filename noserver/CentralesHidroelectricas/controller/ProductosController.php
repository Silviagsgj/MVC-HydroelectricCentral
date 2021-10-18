<?php

session_start();

class ProductosController extends ControladorBase {

    private $prodmodel;
    private $almodel;

    public function __construct() {
        parent::__construct();
        $this->prodmodel = new ProductosModel();
    }

    /*
     *  FUNCIÓN QUE DA UN LISTADO DE LOS PRODUCTOS DISPONIBLES 
     */

    public function listar() {
        $this->almodel = new AlmacenesModel();
        if ($_SESSION['rol'] == "Admin") {
            $datos['titulo'] = "Productos";
        } else {
            $datos['titulo'] = "Seleccion de productos";
        }
        $elementos = $this->prodmodel->getAll();        
        $almacenes = $this->almodel->getAll();
        $datos['elementos'] = $elementos;
        $datos['almacenes'] = $almacenes;
        $this->view("index", $datos);
    }
    
        public function listaraumentar() {
        $this->almodel = new AlmacenesModel();
        $elementosmin = $this->prodmodel->getProductosminstock();
        foreach ($elementosmin as $fila){
           $res[] = $this->prodmodel->aumentarStock($fila->getCodProd());
      
        }
       
            $datos['titulo'] = "Productos";
        $elementos = $this->prodmodel->getAll();        
        $almacenes = $this->almodel->getAll();
        $datos['elementos'] = $elementos;
        $datos['almacenes'] = $almacenes;
      
        if(is_array($res) && !empty($res)){
                $datos['mensaje'] = "Stock aumentado correctamente";
        }else{
            $datos['mensaje'] = "No se ha podido aumentar el Stock";
            $errores = '';
            $datos['errores'] = $errores;
        }
        
        $this->view("index", $datos);
    }
    
    
    //ANADIIIIIIRRRRR
    public function anadiralalmacen() {
        $datos['titulo'] = "Selección de productos";
        $elementos = $this->prodmodel->getAll();

        $producto = $_POST['id'];
        $cantidad = $_POST['unidades'];
        $prod = array($producto, $cantidad);
        
        $_SESSION['alma'][$_POST['id']] = $prod;
        $datos['elementos'] = $elementos;
        $this->view("index", $datos);
    }

    //SACAR
    public function sacardelalmacen2() {
        $elementos = Array();
        $this->detentmodel = new DetEntradasModel();
        $datos['titulo'] = "Selecciona productos a sacar";

        $entrada = $_POST['entrada'];
        $producto = $_POST['id'];
        $cantidad = $_POST['unidades'];

        $prod = array($producto, $cantidad);
        //if (!isset($_SESSION['alma'])) {
        //     $_SESSION['alma'] = array();
        // }
        $_SESSION['alma2'][$_POST['id']] = $prod;
        $_SESSION['entrada'] = $entrada;
        //$_SESSION['alma']['prod'] = $producto;
        //$_SESSION['alma']['cant'] = $cantidad;


        $detalle = $this->detentmodel->getDetalleEntradas($entrada);

        array_push($elementos, $detalle);
        //var_dump($elementos);

        $datos['elementos'] = $elementos;

        $this->view("salidas", $datos);
    }

    //SACAR
    public function sacardelalmacen() {
        $elementos = Array();
        $this->detentmodel = new DetEntradasModel();
        $datos['titulo'] = "Selecciona productos a sacar";


        $producto = $_POST['id'];
        $cantidad = $_POST['unidades'];
        $cdalma = $_POST['cdalma'];

        $prod = array($producto, $cantidad);
        
        $_SESSION['alma2'][$_POST['id']] = $prod;   
        $_SESSION['almacen'] = $cdalma;
        $detalle = $this->detentmodel->getDetalleEntradasAll($cdalma);

        $datos['elementos'] = $detalle;
        $this->view("salidas", $datos);
    }

    //VER PRODUCTOS SELEC
    public function ver() {
        $this->almodel = new AlmacenesModel();
        $datos['titulo'] = "Productos seleccionados: ";

        $almacenes = $this->almodel->getAll();


        $datos['almacenes'] = $almacenes;
        $this->view("seleccion", $datos);
    }

    //VER PRODUCTOS SELEC
    public function verproductosasacar() {
        $datos['titulo'] = "Productos seleccionados: ";
        $this->view("seleccion", $datos);
    }

    //borrar producto del carrito
    public function borrardelcarrito() {
        $this->almodel = new AlmacenesModel();
        $almacenes = $this->almodel->getAll();
        $datos['titulo'] = "Productos seleccionados: ";
        $id = $_GET['num'];
        if (isset($_SESSION['alma'])) {
            unset($_SESSION['alma'][$id]);
        }
        $datos['almacenes'] = $almacenes;
        $this->view("seleccion", $datos);
    }

    public function borrardelcarrito2() {

        $datos['titulo'] = "Productos seleccionados: ";
        $id = $_GET['num'];
        if (isset($_SESSION['alma2'])) {
            unset($_SESSION['alma2'][$id]);
        }
        $this->view("seleccion", $datos);
    }

    /*
     *  FUNCIÓN QUE BORRA UN PRODUCTO Y TODOS SUS DATOS ASOCIADOS
     */

    public function borrar() {
        $id = $_GET['num'];
        $res = $this->prodmodel->borrarElemento($id);

        if ($res >= 1) {
            $mensaje = "Producto borrado correctamente: " . $id;
        } else {
            $mensaje = "Error al borrar. Hay entradas o salidas asociadas a este producto.<br>";
            $errores = '';
            $datos['errores'] = $errores;
        }

        //vuelvo a cargar los productos
        $titulo = "Productos";
        $elementos = $this->prodmodel->getAll();
        $datos['titulo'] = $titulo;
        $datos['elementos'] = $elementos;
        $datos['mensaje'] = $mensaje;
        $this->view("index", $datos);
    }

    /*
     *  FUNCION QUE LLEVA A UNA FICHA ÚNICA QUE CONTIENE LOS DATOS DE UN PRODUCTO SELECCIONADO
     */

    public function verficha() {
        $id = $_GET['num'];
        $elemento = $this->prodmodel->getUnProducto($id);
        $datos['titulo'] = "Datos producto";
        $datos['elementoproducto'] = $elemento;
        $this->view("ficha", $datos);
    }

    /*
     *  FUNCIÓN QUE LLEVA A UN FORMULARIO PARA DAR DE ALTA UN NUEVO PRODUCTO
     */

    public function insertar() {
        $datos['opcion'] = "producto";
        $datos['ope'] = "Insertar";
        $datos['titulo'] = "Insertar Producto";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCIÓN QUE DA DE ALTA UN NUEVO PRODUCTO
     */

    public function insertarelproducto() {
        $Nombre = $_POST['Nombre'];
        $Descripcion = $_POST['Descripcion'];
        $Marca = $_POST['Marca'];
        $Stock = $_POST['Stock'];      
        $Foto = "";

        if (isset($_FILES["Foto"])) {
            $imagen = $_FILES["Foto"];
            $archivo = $_FILES["Foto"]['name'];
            $tamano = $_FILES['Foto']['size'];
            if ($imagen['error'] != UPLOAD_ERR_OK || $imagen['size'] == 0) {
                //si no se elige foto, pongo una por defecto
                $Foto = file_get_contents('recursos/img/nodisponible.png');
            } else {
                $Foto = (file_get_contents($imagen['tmp_name']));
            }
        }//foto
        //llamo a la funcion insertar
        $res = $this->prodmodel->crear($Nombre, $Descripcion, $Marca, $Stock, $Foto);

        //Pongo los mensajes de errores preguntando si es objeto

        if (is_object($res)) {
            $datos['objelemento'] = $res;
            $mensaje = "Producto insertado correctamente con ID: " . $res->getCodProd();
        } else {
            $mensaje = "Se ha producido un error al insertar: <br>" . $res;
            $errores = '';
            $datos['errores'] = $errores;
        }

        //vuelvo a mostrar la vista con el formulario congelado y los mensajes

        $datos['mensaje'] = $mensaje;
        $datos['opcion'] = "producto";
        $datos['ope'] = "Insertar";
        $datos['titulo'] = "Insertar Producto";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE LLEVA A UN FORMULARIO PARA MODIFICAR UN PRODUCTO SELECCIONADO
     */

    public function modificar() {
        $datos['titulo'] = "Actualizar producto";

        $id = $_GET['num'];
        //Me llevo los datos del producto al formulario
        $objelemento = $this->prodmodel->getUnProducto($id);
        $datos['objelemento'] = $objelemento;
        $datos['opcion'] = "producto";
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE MODIFICA LOS DATOS DE UN PRODUCTO SELECCIONADO
     */

    public function modificarelproducto() {

        $CodProd = $_POST['CodProd'];
        $Nombre = $_POST['Nombre'];
        $Descripcion = $_POST['Descripcion'];
        $Marca = $_POST['Marca'];
        $Stock = $_POST['Stock'];
        $FotoAnterior = $_POST['FotoAnterior'];
        $Foto = "";

        if (isset($_FILES["Foto"])) {
            $imagen = $_FILES["Foto"];
            $archivo = $_FILES["Foto"]['name'];
            $tamano = $_FILES['Foto']['size'];
            if ($imagen['error'] != UPLOAD_ERR_OK || $imagen['size'] == 0) {
                $Foto = base64_decode($FotoAnterior);
                $FotoAnterior = $Foto;
            } else {
                $Foto = (file_get_contents($imagen['tmp_name']));
                $FotoAnterior = $Foto;
            }
        }//foto

        $objelemento = $this->prodmodel->actualizarprod($CodProd, $Nombre, $Descripcion, $Marca, $Stock, $Foto);

        if (is_object($objelemento)) {
            $datos['objelemento'] = $objelemento;
            $mensaje = "Producto actualizado correctamente, codigo: " . $objelemento->getCodProd();
        } else {
            $mensaje = "ERROR AL ACTUALIZAR <br>" . $objelemento;
            $errores = '';
            $datos['errores'] = $errores;
        }

        $datos['mensaje'] = $mensaje;
        $datos['titulo'] = "Actualizar producto";
        $datos['opcion'] = "producto";
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }  
    
    
     

}
