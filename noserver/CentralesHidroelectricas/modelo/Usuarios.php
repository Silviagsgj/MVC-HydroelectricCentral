<?php
	
class Usuarios {

    private $IdUsuario;
    private $Login;
    private $Password;
    private $Rol;
 

    function __construct($IdUsuario = "", $Login = "", $Password = "", $Rol = "") {
        $this->IdUsuario = $IdUsuario;
        $this->Login = $Login;
        $this->Password = $Password;
        $this->Rol = $Rol;
  
    }

    function getIdUsuario() {
        return $this->IdUsuario;
    }

    function getLogin() {
        return $this->Login;
    }

    function getPassword() {
        return $this->Password;
    }

    function getRol() {
        return $this->Rol;
    }



    function setIdUsuario($IdUsuario): void {
        $this->IdUsuario = $IdUsuario;
    }

    function setLogin($Login): void {
        $this->Login = $Login;
    }

    function setPassword($Password): void {
        $this->Password = $Password;
    }

    function setRol($Rol): void {
        $this->Rol = $Rol;
    }

   

}
