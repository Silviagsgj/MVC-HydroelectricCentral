<?php

session_start();

class   UsuariosController extends ControladorBase {
    private $usumodel;
    private $emplemodel;
  

    public function __construct() {
        parent::__construct();
          $this->usumodel = new UsuariosModel();
        $this->emplemodel = new EmpleadosModel();

    }
    
    
    public function modificar() {
        $datos['titulo'] = "Nueva contraseña";
      
        $obj = $this->emplemodel->comprueboDni($_SESSION['usuario']); 
        $id = $obj->getIdUsuario();
        $objelemento = $this->usumodel->getUnUsuario($id);
        $datos['objelemento'] = $objelemento;
        $this->view("formulario", $datos);
    }

    /*
     *  FUNCION QUE MODIFICA LOS DATOS DE UN EMPLEADO SELECCIONADO
     */

    public function modificalacontraseña() {
        $password = password_hash($_POST['clave'], PASSWORD_BCRYPT);
      

        $obj = $this->emplemodel->comprueboDni($_SESSION['usuario']); 
        $idusu = $obj->getIdUsuario();
        
        $objelemento = $this->usumodel->cambiopass($password, $idusu);

        if (is_object($objelemento)) {
            $datos['objelemento'] = $objelemento;
         
            $mensaje = "Contraseña actualizada correctamente";
        
        } else {
            $mensaje = "ERROR AL ACTUALIZAR <br>" . $objelemento;
            $errores = '';
            $datos['errores'] = $errores;
        }

        $elementos = $this->usumodel->getUnUsuario($idusu);
        $datos['elementos'] = $elementos;
       

   
        $datos['mensaje'] = $mensaje;    


        $this->view("index", $datos);
    }

}