<?php

session_start();

class EmpleadosController extends ControladorBase {

    private $emplemodel;
    private $cenmodel;
    private $catmodel;
    private $depmodel;
    private $entmodel;
    private $detentmodel;
    private $salmodel;
    private $detsalmodel;
    private $usumodel;

    public function __construct() {
        parent::__construct();
        $this->emplemodel = new EmpleadosModel();
        $this->cenmodel = new CentralesModel();
        $this->catmodel = new CategoriasModel();
        $this->depmodel = new DepartamentosModel();
        $this->salmodel = new SalidasModel();
        $this->entmodel = new EntradasModel();
        $this->prodmodel = new ProductosModel();
        $this->provmodel = new ProveedoresModel();
        $this->detentmodel = new DetEntradasModel();
        $this->detsalmodel = new DetSalidasModel();
        $this->usumodel = new UsuariosModel();
    }

    public function gestion() {
        $centrales = $this->cenmodel->getAll();
        $datos['centrales'] = $centrales;
        $datos['titulo'] = "Gestion de empleados";
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE DA UN LISTADO DE LOS EMPLEADOS
     */

    public function listar() {
        $datos['titulo'] = "Empleados";
        $elementos = $this->emplemodel->getAll();
        $datos['elementos'] = $elementos;
        $this->view("index", $datos);
    }
    
public function empleadologin() {
    if($_SESSION['rol'] == "Admin"){
         $_SESSION['rol'] = "Emple";
           $objetoemple = $this->emplemodel->comprueboDni($_SESSION['usuario']);
          $datos['data1'] = count($this->entmodel->getEntradasempleado($objetoemple->getNumEmple()));
                    $datos['data2'] = count($this->salmodel->getSalidasempleado($objetoemple->getNumEmple()));
                    $datos['canvasemple'] = 'canvasemple';
         
         
    }else{
        $_SESSION['rol'] = "Admin";
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



    /*
     *  FUNCIÓN QUE DA UN LISTADO DE LOS EMPLEADOS DE UNA CENTRAL SELECCIONADA
     */

    public function verporcentral() {
        $centrales = $this->cenmodel->getAll();
        $datos['centrales'] = $centrales;
        $id = $_POST['centrales'];
        $empleadosporcentral = $this->emplemodel->getEmpleadosCentral($id);
        $titulo = "Listado de empleados de la central: " . $this->cenmodel->getUnaCentral($id)->getNombre();
        $datos['titulo'] = $titulo;
        $datos['elementos'] = $empleadosporcentral;
        $titulo2 = "Total empleados: " . count($empleadosporcentral);
        $datos['titulo2'] = $titulo2;
        $this->view("index", $datos);
    }

    /*
     *  FUNCIÓN QUE BORRA UN EMPLEADO Y TODOS LOS DATOS ASOCIADOS A ELLA --> Sus entradas y salidas.
     */

    public function borrar() {
        $id = $_GET['num'];
        //comprobar si el empleado tiene entradas y salidas
        $entradas = $this->entmodel->getEntradasempleado($id);
        $salidas = $this->salmodel->getSalidasempleado($id);

        if (count($entradas) != 0) {
            //borro las entradas
            foreach ($entradas as $fila) {
                //borro el detalle
                $this->detentmodel->borrarElemento($fila['NumEntrada']);
                //borro la entrada
                $this->entmodel->borrarElemento($fila['NumEntrada']);
            }
        }

        //compruebo si para ese empleado tiene salidas de productos    
        if (count($salidas) != 0) {
            //borro las entradas
            foreach ($salidas as $fila2) {
                //borro el detalle
                $this->detsalmodel->borrarElemento($fila2['NumSalida']);
                //borro la entrada
                $this->salmodel->borrarElemento($fila2['NumSalida']);
            }
        }

        $res = $this->emplemodel->borrarElemento($id);

        if ($res >= 1) {
            $mensaje = "Empleado borrado correctamente: " . $id;
        } else {
            $mensaje = "Error al borrar: <br>" . $res;
            $errores = '';
            $datos['errores'] = $errores;
        }

        //vuelvo a cargar los empleados
        $titulo = "Empleados";
        $elementos = $this->emplemodel->getAll();
        $datos['titulo'] = $titulo;
        $datos['elementos'] = $elementos;
        $datos['mensaje'] = $mensaje;
        $this->view("index", $datos);
    }

    /*
     *  FUNCION QUE LLEVA A UNA FICHA ÚNICA QUE CONTIENE LOS DATOS DEL EMPLEADO SELECCIONADO
     */

    public function verficha() {
        $id = $_GET['num'];
        $elemento = $this->emplemodel->getEmpleado($id);
        $datos['titulo'] = "Datos empleado";
        $datos['elementoemple'] = $elemento;
        $this->view("ficha", $datos);
    }

    /*
     *  FUNCIÓN QUE LLEVA A UN FORMULARIO PARA DAR DE ALTA UN NUEVO EMPLEADO
     */

    public function insertar() {
        $elementos = $this->cenmodel->getAll();
        $datos['elementos'] = $elementos;
        $elementoscat = $this->catmodel->getAll();
        $datos['elementoscat'] = $elementoscat;
        $elementosdep = $this->depmodel->getAll();
        $datos['elementosdep'] = $elementosdep;
        $elementosusu = $this->usumodel->getAllRol();
        $datos['elementosusu'] = $elementosusu;
        $datos['opcion'] = "empleado";
        $datos['ope'] = "Insertar";
        $datos['titulo'] = "Insertar Empleado";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCIÓN QUE DA DE ALTA UNA NUEVO EMPLEADO
     */

    public function insertarelemple() {
        //compruebo si el dni existe en la base de datos
        $DNI = $_POST['DNI']; 
        $empleadoexiste = $this->emplemodel->comprueboDni($DNI);
        if(is_object($empleadoexiste)){
            $mensaje = "No se puede registrar. DNI duplicado";
            $errores = '';
            $datos['errores'] = $errores;
       

        }else{
        //luego inserto el usuario
        //si el rol es admin el login es admin, en caso contrario emple (asi gestiono las distintas vistas)
        $rol=$_POST['Rol'];    
        if($rol == "Admin"){
            $login = "admin";
            $password=password_hash("Administrador1", PASSWORD_BCRYPT);    
        }else{
            $login="emple";
            $password=password_hash("Empleado1", PASSWORD_BCRYPT);    
        }
      
             
     
       
        $nuevousu = $this->usumodel->crear($login, $password, $rol);
        
        if (is_object($nuevousu)) {
            //luego los demas datos empleado
        
   
        $Nombre = $_POST['Nombre'];
        $Apellidos = $_POST['Apellidos'];
        $FechaNac = $_POST['FechaNac'];
        $Telefono = $_POST['Telefono'];
        $Email = $_POST['Email'];
        $Direccion = $_POST['Direccion'];
        $Provincia = $_POST['Provincia'];
        $Poblacion = $_POST['Poblacion'];
        $CP = $_POST['CP'];
        $IdUsuario = $nuevousu->getIdUsuario(); 
        $IdCategoria = $_POST['IdCategoria'];
        $CodDepart = $_POST['CodDepart'];
        $IdCentral = $_POST['IdCentral'];
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
        $res = $this->emplemodel->crear($DNI, $Nombre, $Apellidos, $FechaNac, $Telefono, $Email, $Direccion, $Provincia, $Poblacion, $CP, $IdUsuario, $IdCategoria, $CodDepart, $IdCentral, $Foto);

        //Pongo los mensajes de errores preguntando si es objeto
        if (is_object($res)) {
            $datos['objelemento'] = $res;
            $mensaje = "Empleado insertado correctamente con ID: " . $res->getNumEmple();
        } else {
            $mensaje = "Se ha producido un error al insertar: <br>" . $res;
            $errores = '';
            $datos['errores'] = $errores;
        }
        }else{
            $mensaje = "Se ha producido un error al insertar";
            $errores = '';
            $datos['errores'] = $errores;
        }
        
        
        }//fin si existe dni

        //vuelvo a mostrar la vista con el formulario congelado y los mensajes
        $elementos = $this->cenmodel->getAll();
        $datos['elementos'] = $elementos;
        $elementoscat = $this->catmodel->getAll();
        $datos['elementoscat'] = $elementoscat;
        $elementosdep = $this->depmodel->getAll();
        $datos['elementosdep'] = $elementosdep;
        $elementosusu = $this->usumodel->getAllRol();
        $datos['elementosusu'] = $elementosusu;
        $datos['mensaje'] = $mensaje;
        $datos['opcion'] = "empleado";
        $datos['ope'] = "Insertar";
        $datos['titulo'] = "Insertar Empleado";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE LLEVA A UN FORMULARIO PARA MODIFICAR UNA EMPLEADO SELECCIONADO
     */

    public function modificar() {
       if ($_SESSION['rol'] == 'Emple') {
            $datos['titulo'] = "Modificar datos";
        } else {
            $datos['titulo'] = "Actualizar Empleado";
        }
       
        $id = $_GET['num'];
        $elementos = $this->cenmodel->getAll();
        $datos['elementos'] = $elementos;
        $elementoscat = $this->catmodel->getAll();
        $datos['elementoscat'] = $elementoscat;
        $elementosdep = $this->depmodel->getAll();
        $datos['elementosdep'] = $elementosdep;
        $objelemento = $this->emplemodel->getEmpleado($id);
        $datos['objelemento'] = $objelemento;
        $elementosusu = $this->usumodel->getAllRol();
        $datos['elementosusu'] = $elementosusu;
        $datos['opcion'] = "empleado";
        if ($_SESSION['rol'] == 'Admin' && isset($_POST['centrales'])) {
            $datos['cen'] = $_POST['centrales'];
        }
        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE MODIFICA LOS DATOS DE UN EMPLEADO SELECCIONADO
     */

    public function modificarelemple() {
             $DNI = $_POST['DNI'];
      $obj = $this->emplemodel->comprueboDni($DNI); 
    
 //Compruebo si existe el dni en la base de datos
     
        if(is_object($obj) && $DNI!=$_POST["dniactual"]){
            $mensaje = "No se puede actualizar. DNI duplicado";
            $errores = '';
            $datos['errores'] = $errores;
            
      
            
        }else{
            
            $NumEmple = $_POST['NumEmple'];
  
        $Nombre = $_POST['Nombre'];
        $Apellidos = $_POST['Apellidos'];
        $FechaNac = $_POST['FechaNac'];
        $Telefono = $_POST['Telefono'];
        $Email = $_POST['Email'];
        $Direccion = $_POST['Direccion'];
        $Provincia = $_POST['Provincia'];
        $Poblacion = $_POST['Poblacion'];
        $CP = $_POST['CP'];    
        //tengo que sacar el dni original y luego el id me llevo por hidden el dni
        $act = $this->emplemodel->comprueboDni($_POST["dniactual"]);
        $IdUsuario =$act->getIdUsuario();
    
        $Rol = $_POST['Rol'];
        $IdCategoria = $_POST['IdCategoria'];
        $CodDepart = $_POST['CodDepart'];
        $IdCentral = $_POST['IdCentral'];
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
            
            //primero actualizo el rol y luego los demas datos. Si el rol es administrador cambio el login a admin para asi tener acceso a todas las vistas
        $objetousu = $this->usumodel->actualizarrol($Rol, $IdUsuario);
        if(is_object($objetousu)){
            if($objetousu->getRol()=="Admin"){
                $objetousu2 = $this->usumodel->actualizarvista("admin", $IdUsuario);
              
            }else{
                $objetousu2 = $this->usumodel->actualizarvista("emple", $IdUsuario);
            }
            
            
              $objelemento = $this->emplemodel->actualizaremple($NumEmple, $DNI, $Nombre, $Apellidos, $FechaNac, $Telefono, $Email, $Direccion, $Provincia, $Poblacion, $CP, $IdUsuario, $IdCategoria, $CodDepart, $IdCentral, $Foto);

        if (is_object($objelemento)) {
            $datos['objelemento'] = $objelemento;

            if ($_SESSION['rol'] == 'Emple') {
                $mensaje = "Datos actualizados correctamente";
            } else {
                $mensaje = "Empleado actualizado correctamente";
            }
        } else {
            $mensaje = "ERROR AL ACTUALIZAR <br>" . $objelemento;
            $errores = '';
            $datos['errores'] = $errores;
        }
        }else{
            $mensaje = "ERROR AL ACTUALIZAR <br>" . $objelemento;
            $errores = '';
            $datos['errores'] = $errores;
        }
        
        }
    
          
        
        
        
    
        

        $elementos = $this->cenmodel->getAll();
        $datos['elementos'] = $elementos;
        $elementoscat = $this->catmodel->getAll();
        $datos['elementoscat'] = $elementoscat;
        $elementosdep = $this->depmodel->getAll();
        $datos['elementosdep'] = $elementosdep;
        $elementosusu = $this->usumodel->getAllRol();
        $datos['elementosusu'] = $elementosusu;
        $datos['mensaje'] = $mensaje;
        $datos['opcion'] = "empleado";
        $datos['valu'] = $_POST['centrales'];

        if ($_SESSION['rol'] == 'Emple') {
            $datos['titulo'] = "Modificar datos";
        } else {
            $datos['titulo'] = "Actualizar Empleado";
        }

        $datos['ope'] = "Modificar";
        $this->view("formulario", $datos);
    }

}
