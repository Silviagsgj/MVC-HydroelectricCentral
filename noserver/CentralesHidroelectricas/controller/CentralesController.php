<?php

session_start();

class CentralesController extends ControladorBase {

    private $cenmodel;
    private $usumodel;
    private $almodel;
    private $entmodel;
    private $detentmodel;
    private $salmodel;
    private $detsalmodel;
    private $emplemodel;
    private $prodmodel;
    private $provmodel;

    public function __construct() {
        parent::__construct();
        $this->cenmodel = new CentralesModel();
        $this->usumodel = new UsuariosModel();
        $this->almodel = new AlmacenesModel();
        $this->entmodel = new EntradasModel();
        $this->detentmodel = new DetEntradasModel();
        $this->salmodel = new SalidasModel();
        $this->detsalmodel = new DetSalidasModel();
        $this->emplemodel = new EmpleadosModel();
        $this->prodmodel = new ProductosModel();
        $this->provmodel = new ProveedoresModel();
    }

    public function login() {
        $datos['titulo'] = "¡Bienvenido!";
        $datos['username'] = "";
        $datos['clave'] = "";

        $this->view("login", $datos);
    }

    public function tarjetas() {
        $datos['titulo'] = "Elije la central";
        $elementos = $this->cenmodel->getAll();
        $datos['elementos'] = $elementos;
        $this->view("salidas", $datos);
    }

    
    public function miconexion() {
        //Cojo las variables del formulario
        $username = $_POST['username'];
        $clave = $_POST['clave'];
        // $intentos = 5;
        //llamo a la funcion que comprueba si existe en la base de datos
        $datosusu = $this->usumodel->comprobarUsuario($username, $clave);
        //$mensaje = "";
        //Pregunto si es una cadena
        if (is_array($datosusu)) {
            $datos['titulo'] = "¡Bienvenido!";
            $mensaje = $datosusu[0];
            $errores = '';
            $datos['mensaje'] = $mensaje;
            $datos['errores'] = $errores;

            $datos['username'] = $username;
            $datos['clave'] = $clave;

            $this->view("login", $datos);
        } else {
            if (is_string($datosusu)) {
           
                $mensaje = $datosusu;
                $datos['titulo'] = "¡Bienvenido!";
                $datos['mensaje'] = $mensaje;
                $datos['username'] = $username;
                $datos['clave'] = $clave;

             
                $this->view("login", $datos);
            } else {
                //$bienvenida =  $username;
                //una vez conectados creo la variable de sesion usuario
                $objetoemple = $this->emplemodel->comprueboDni($username);
                $_SESSION['idemple'] = $objetoemple->getNumEmple(); 
 
                $_SESSION['usuario'] = $username; //dni            
                 $_SESSION['rol'] = $datosusu->getRol(); //rol
                 $_SESSION['login'] = $datosusu->getLogin(); //permisos
                $datos['titulo'] = "Inicio";
                  $datos['mensaje'] = 'Bienvenido ' . $objetoemple->getNombre() . " " . $objetoemple->getApellidos();
                $correcto = false;
                $datos['correcto'] = $correcto;
               
                
                
                 if ($_SESSION['rol'] == "Emple") {
                    $datos['data1'] = count($this->entmodel->getEntradasempleado($objetoemple->getNumEmple()));
                    $datos['data2'] = count($this->salmodel->getSalidasempleado($objetoemple->getNumEmple()));
                    $datos['canvasemple'] = 'canvasemple';
                } else {
                    
                  
                    $datos['data1'] = count($this->cenmodel->getAll());
                    $datos['data2'] = count($this->emplemodel->getAll());
                    $datos['data3'] = count($this->prodmodel->getAll());
                    $datos['data4'] = count($this->provmodel->getAll());
                    $datos['data5'] = count($this->entmodel->getAll());
                    $datos['data6'] = count($this->salmodel->getAll());
                    $datos['canvasadmin'] = 'canvasadmin';
                }
                
                
                
                $this->view("index", $datos);
            }
        }
    }

    public function cerrarsesion() {
   
        if (isset($_SESSION['usuario'])) {
            unset($_SESSION['rol']); //borro el rol
            unset($_SESSION['usuario']); //borro usuario conectado
            unset($_SESSION['login']); //borro los permisos
        }
        if (isset($_SESSION['idemple'])) {
            unset($_SESSION['idemple']);
            unset($_SESSION['alma2']);
        }

        $datos['titulo'] = "¡Bienvenido!";
        $datos['username'] = "";
        $datos['clave'] = "";
        $this->view("login", $datos);
    }

    public function index() {
        $datos['titulo'] = "Inicio";
      
        if ($_SESSION['rol'] == 'Admin') {

            //if (isset($_SESSION['idemple']) && $_SESSION['idemple'] == 1) {

                $datos['data1'] = count($this->cenmodel->getAll());
                $datos['data2'] = count($this->emplemodel->getAll());
                $datos['data3'] = count($this->prodmodel->getAll());
                $datos['data4'] = count($this->provmodel->getAll());
                $datos['data5'] = count($this->entmodel->getAll());
                $datos['data6'] = count($this->salmodel->getAll());
                $datos['canvasadmin'] = 'canvasadmin';
           // }
        } else {

            if ($_SESSION['rol'] == 'Emple') {

                if (isset($_SESSION['idemple'])) {
                    //obtengo el objeto empleado
                    $objetoemple = $this->emplemodel->getEmpleado($_SESSION['idemple']);


                    $datos['data1'] = count($this->entmodel->getEntradasempleado($_SESSION['idemple']));
                    $datos['data2'] = count($this->salmodel->getSalidasempleado($_SESSION['idemple']));
                    $datos['canvasemple'] = 'canvasemple';
                }
            }
        }
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE DA UN LISTADO DE LAS CENTRALES DISPONIBLES 
     */

    public function listar() {
        $datos['titulo'] = "Centrales";
        $elementos = $this->cenmodel->getAll();
        $datos['elementos'] = $elementos;
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE BORRA UNA CENTRAL Y TODOS LOS DATOS ASOCIADOS A ELLA
     */

    public function borrar() {
        //cargo el id de la central
        $id = $_GET['num'];
        //BORRAR DATOS ASOCIADOS --->>>>>>>>>>> EMPLEADOS/ALMACENES/ENTRADAS/SALIDAS.....!!!!!!!!!!!!!
        //$this->almodel = new AlmacenesModel();
        $almacenes = $this->almodel->getAlmacenesCentral($id);

        if (count($almacenes) != 0) {

            //recorro los almacenes asociados a esa central y los borro
            //compruebo si para ese almacen tiene entradas de productos 
            foreach ($almacenes as $fila) {
                $entradas = $this->entmodel->getEntradasalmacen($fila->getCodAlmacen());
                $salidas = $this->salmodel->getSalidasalmacen($fila->getCodAlmacen());

                if (count($entradas) != 0) {

                    //borro las entradas
                    foreach ($entradas as $fila2) {
                        //borro el detalle
                        $this->detentmodel->borrarElemento($fila2['NumEntrada']);
                        //borro la entrada
                        $this->entmodel->borrarElemento($fila2['NumEntrada']);
                    }
                }

                //compruebo si para ese almacen tiene salidas de productos    
                if (count($salidas) != 0) {
                    //$this->almodel->borrarElemento($fila->getCodAlmacen());  
                    //borro las entradas
                    foreach ($salidas as $fila4) {
                        //borro el detalle
                        $this->detsalmodel->borrarElemento($fila4['NumSalida']);
                        //borro la entrada
                        $this->salmodel->borrarElemento($fila4['NumSalida']);
                    }
                }

                //borro el almacen
                $this->almodel->borrarElemento($fila->getCodAlmacen());
            }
        }

        //saco los empleados de la central 
        $empleados = $this->emplemodel->getEmpleadosCentral($id);
        if (count($empleados) != 0) {
            //si la central tiene empleados borralos
            foreach ($empleados as $fila6) {
                $this->emplemodel->borrarElemento($fila6->getNumEmple());
            }
        }

        //borro la central
        $res = $this->cenmodel->borrarElemento($id);


        if ($res >= 1) {
            $mensaje = "Central borrada correctamente: " . $id;
        } else {
            $mensaje = "Error al borrar: <br>" . $res;
        }
        //Vuelvo al listado de centrales
        $titulo = "Centrales";
        $elementos = $this->cenmodel->getAll();
        $datos['titulo'] = $titulo;
        $datos['elementos'] = $elementos;
        $datos['mensaje'] = $mensaje;
        $this->view("index", $datos);
    }

    /*
     *  FUNCION QUE LLEVA A UNA FICHA ÚNICA QUE CONTIENE LOS DATOS DE LA CENTRAL SELECCIONADA
     */

    public function verficha() {
        //cargo el numero de la central
        $id = $_GET['num'];
        $elemento = $this->cenmodel->getUnaCentral($id);
        $datos['titulo'] = "Datos central";
        $datos['elementocentral'] = $elemento;
        $this->view("ficha", $datos);
    }

    /*
     *  FUNCIÓN QUE LLEVA A UN FORMULARIO PARA DAR DE ALTA UNA NUEVA CENTRAL
     */

    public function insertar() {
        $datos['opcion'] = "central";
        $datos['ope'] = "Insertar";
        $datos['titulo'] = "Insertar Central";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCIÓN QUE DA DE ALTA UNA NUEVA CENTRAL
     */

    public function insertarlaCentral() {
        $Nombre = $_POST['Nombre'];
        $Telefono = $_POST['Telefono'];
        $Constructor = $_POST['Constructor'];
        $Provincia = $_POST['Provincia'];
        $Poblacion = $_POST['Poblacion'];
        $CP = $_POST['CP'];
        $TipoTurbina = $_POST['TipoTurbina'];
        $SaltoBruto = $_POST['SaltoBruto'];
        $NumGeneradores = $_POST['NumGeneradores'];
        $Potencia = $_POST['Potencia'];
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
                // echo "<br>Imagen convertida a cadena: " . $convertida;
            }
        }//foto
        //llamo a la funcion insertar
        $res = $this->cenmodel->crear($Nombre, $Telefono, $Constructor, $Provincia, $Poblacion, $CP, $TipoTurbina, $SaltoBruto, $NumGeneradores, $Potencia, $Foto);

        //Pongo los mensajes de errores preguntando si es objeto

        if (is_object($res)) {
            $datos['objelemento'] = $res;
            $mensaje = "Central insertada correctamente con ID: " . $res->getIdCentral();
        } else {
            $mensaje = "Se ha producido un error al insertar: <br>" . $res;
        }

        //vuelvo a mostrar la vista con el formulario congelado y los mensajes

        $datos['mensaje'] = $mensaje;
        $datos['opcion'] = "central";
        $datos['ope'] = "Insertar";
        $datos['titulo'] = "Insertar Central";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE LLEVA A UN FORMULARIO PARA MODIFICAR UNA CENTRAL SELECCIONADA
     */

    public function modificar() {
        $datos['titulo'] = "Actualizar central";
        $id = $_GET['num'];
        $objelemento = $this->cenmodel->getUnaCentral($id);
        $datos['objelemento'] = $objelemento;
        $datos['opcion'] = "central";
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE MODIFICA LOS DATOS DE UNA CENTRAL SELECCIONADA
     */

    public function modificarlaCentral() {
        $IdCentral = $_POST['IdCentral'];
        $Nombre = $_POST['Nombre'];
        $Telefono = $_POST['Telefono'];
        $Constructor = $_POST['Constructor'];
        $Provincia = $_POST['Provincia'];
        $Poblacion = $_POST['Poblacion'];
        $CP = $_POST['CP'];
        $TipoTurbina = $_POST['TipoTurbina'];
        $SaltoBruto = $_POST['SaltoBruto'];
        $NumGeneradores = $_POST['NumGeneradores'];
        $Potencia = $_POST['Potencia'];
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

        $objelemento = $this->cenmodel->actualizarcen($IdCentral, $Nombre, $Telefono, $Constructor, $Provincia, $Poblacion, $CP, $TipoTurbina, $SaltoBruto, $NumGeneradores, $Potencia, $Foto);

        //var_dump($objelemento);
        if (is_object($objelemento)) {
            $datos['objelemento'] = $objelemento;
            $mensaje = "Central actualizada correctamente, codigo: " . $objelemento->getIdCentral();
        } else {
            $mensaje = "ERROR AL ACTUALIZAR <br>" . $objelemento;
        }

        $datos['mensaje'] = $mensaje;
        $datos['titulo'] = "Actualizar central";
        $datos['opcion'] = "central";
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

}
