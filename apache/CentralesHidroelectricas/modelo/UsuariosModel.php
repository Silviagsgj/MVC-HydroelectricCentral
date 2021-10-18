<?php

class UsuariosModel extends AABasedatos {

    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "usuarios";
        $this->conexion = $this->getConexion();
    }

    //Funcion que comprueba si el usuario existe en la BD y si la clave es correcta
    public function comprobarUsuario($username, $clave) {
        try {

            $sql = "SELECT * FROM $this->table join empleados using(IdUsuario) WHERE DNI = ? ";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $username);
            $sentencia->execute();
            if ($sentencia->rowCount() == 1) { //es decir true
                $reg = $sentencia->fetch();

                //en la bd tengo la clave cifrada, uso password verify para descifrarla y comprobar si coincide
                if (password_verify($clave, $reg['Password'])) { //verifico la clave            
                    $obj = new Usuarios(
                            $reg['IdUsuario'],
                            $reg['Login'],
                            $reg['Password'],
                            $reg['Rol']
                         
                    );

                    return $obj;
                } else {
                    $dev1 = "Credenciales incorrectas.";
                    $dev2 = "";
                    $dev = [$dev1, $dev2];
                    return $dev;
                }
            } else {                
                $dev1 = "Credenciales incorrectas.";
                $dev2 = "";
                $dev = [$dev1, $dev2];
                return $dev;
            }
        } catch (PDOException $e) {
            $dev1 = "ERROR AL CONECTAR.<br>" . $e->getMessage();
            $dev2 = "";
            $dev = [$dev1, $dev2];
            return $dev;
        }
    }

     ////////////////////////////////////////////////     LISTAR    ////////////////////////////////////////////////////// 
    //Funcion que me da los datos de un usuario. Devuelve un objeto usuario
    public function getUnUsuario($IdUsuario) {
        try {
            $sql = "SELECT * FROM $this->table WHERE IdUsuario=?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $IdUsuario);
            $sentencia->execute();
            $row = $sentencia->fetch();
            if ($row) {
                $usu = new Usuarios(
                        $row['IdUsuario'],
                        $row['Login'],
                        $row['Password'],
                        $row['Rol']
                       );
                return $usu;
            }
            return null;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR .<br>" . $e->getMessage();
        }
    }

    
    //Cambio contraseña
    
     public function cambiopass($password, $idusu) {
        try {
            $sql = "update $this->table set Password = ? where IdUsuario = ? ";

            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $password);
            $sentencia->bindParam(2, $idusu);
           

            $num = $sentencia->execute();

            $usuario = $this->getUnUsuario($idusu);

            return $usuario;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    
       public function actualizarrol($rol, $idusu) {
        try {
            $sql = "update $this->table set Rol = ? where IdUsuario = ? ";

            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $rol);
            $sentencia->bindParam(2, $idusu);
           

            $num = $sentencia->execute();

            $usuario = $this->getUnUsuario($idusu);

            return $usuario;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
        public function actualizarvista($login, $idusu) {
        try {
            $sql = "update $this->table set Login = ? where IdUsuario = ? ";

            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $login);
            $sentencia->bindParam(2, $idusu);
           

            $num = $sentencia->execute();

            $usuario = $this->getUnUsuario($idusu);

            return $usuario;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    
    
        ////////////////////////////////////////////////     INSERTAR    //////////////////////////////////////////////////////
    
    
    public function crear($login, $password, $rol) {
        try {
            $sql = "insert into $this->table (Login, Password, Rol) values (?,?,?)";
            $sentencia = $this->conexion->prepare($sql);
      
            $sentencia->bindParam(1, $login);
            $sentencia->bindParam(2, $password);
            $sentencia->bindParam(3, $rol);
           
            $sentencia->execute();

            $id = $this->conexion->lastInsertId();
            $usu = $this->getUnUsuario($id);
            return $usu;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    
    //Funcion que me da todos los roles de los usuarios
    public function getAllRol() {
        
      
        try {
            $sql = "select distinct (Rol) from $this->table";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll();
            //Me devuelve un array con el rol de los usuarios
            return $registros;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    
        
        
        
      
    }

    
}
