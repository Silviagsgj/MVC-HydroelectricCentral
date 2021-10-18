<?php

class EmpleadosModel extends AABasedatos {
  
    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "empleados";
        $this->conexion = $this->getConexion();
    }

    ////////////////////////////////////////////////     LISTAR    //////////////////////////////////////////////////////
    
//Funcion que me da todos los datos de los empleados
    public function getAll() {
        $objetos = array();
        try {

            $sql = "select * from $this->table";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll();
            $statement = null;
            //Retorna array de objetos empleados
            foreach ($registros as $row) {
                array_push($objetos,
                        new Empleados($row['NumEmple'],
                                $row['DNI'],
                                $row['Nombre'],
                                $row['Apellidos'],
                                $row['FechaNac'],
                                $row['Telefono'],
                                $row['Email'],
                                $row['Direccion'],
                                $row['Provincia'],
                                $row['Poblacion'],
                                $row['CP'],
                                $row['IdUsuario'],
                                $row['IdCategoria'],
                                $row['CodDepart'],
                                $row['IdCentral'],
                                $row['Foto']
                ));
            }
            return $objetos;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //Funcion que me da los datos de un empleado. Devuelve un objeto empleado   
    public function getEmpleado($NumEmple) {
        try {
            $sql = "SELECT * FROM $this->table WHERE NumEmple=?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $NumEmple);
            $sentencia->execute();
            $row = $sentencia->fetch();
            if ($row) {
                $emple = new Empleados(
                        $row['NumEmple'],
                        $row['DNI'],
                        $row['Nombre'],
                        $row['Apellidos'],
                        $row['FechaNac'],
                        $row['Telefono'],
                        $row['Email'],
                        $row['Direccion'],
                        $row['Provincia'],
                        $row['Poblacion'],
                        $row['CP'],
                        $row['IdUsuario'],
                        $row['IdCategoria'],
                        $row['CodDepart'],
                        $row['IdCentral'],
                        $row['Foto']);
                return $emple;
            }
            return null;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR .<br>" . $e->getMessage();
        }
    }

    //Funcion que obtiene los empleados de una central dada. Devuelve un array de objetos empleados
    public function getEmpleadosCentral($id) {

        try {
            $objetos = array();
            $sql = "SELECT * FROM $this->table WHERE IdCentral=?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();
            $registros = $sentencia->fetchAll(); 
          
            foreach ($registros as $row) {
                array_push($objetos,
                        new Empleados($row['NumEmple'],
                                $row['DNI'],
                                $row['Nombre'],
                                $row['Apellidos'],
                                $row['FechaNac'],
                                $row['Telefono'],
                                $row['Email'],
                                $row['Direccion'],
                                $row['Provincia'],
                                $row['Poblacion'],
                                $row['CP'],
                                $row['IdUsuario'],
                                $row['IdCategoria'],
                                $row['CodDepart'],
                                $row['IdCentral'],
                                $row['Foto']
                ));
            }
            return $objetos;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR .<br>" . $e->getMessage();
        }
    }

    
    ////////////////////////////////////////////////     BORRAR    //////////////////////////////////////////////////////


    public function borrarElemento($id) {
        try {
            
            $sql = "delete from $this->table where NumEmple= ? ";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();
            $num = $sentencia->rowCount();
            return $num;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    
    ////////////////////////////////////////////////     INSERTAR    //////////////////////////////////////////////////////
    
    
    public function crear($dni, $nombre, $apellidos, $fechanac, $telefono, $email, $direccion, $provincia, $poblacion, $cp, $idusuario, $idcategoria, $coddepart, $idcentral, $foto) {
        try {
            $sql = "insert into $this->table (DNI, Nombre, Apellidos, FechaNac, Telefono, Email, Direccion, Provincia, Poblacion, CP, IdUsuario, IdCategoria, CodDepart, IdCentral, Foto) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $dni);
            $sentencia->bindParam(2, $nombre);
            $sentencia->bindParam(3, $apellidos);
            $sentencia->bindParam(4, $fechanac);
            $sentencia->bindParam(5, $telefono);
            $sentencia->bindParam(6, $email);
            $sentencia->bindParam(7, $direccion);
            $sentencia->bindParam(8, $provincia);
            $sentencia->bindParam(9, $poblacion);
            $sentencia->bindParam(10, $cp);
            $sentencia->bindParam(11, $idusuario);
            $sentencia->bindParam(12, $idcategoria);
            $sentencia->bindParam(13, $coddepart);
            $sentencia->bindParam(14, $idcentral);
            $sentencia->bindParam(15, $foto);
            $sentencia->execute();

            $id = $this->conexion->lastInsertId();
            $emple = $this->getEmpleado($id);
            return $emple;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    

    ////////////////////////////////////////////////     MODIFICAR    //////////////////////////////////////////////////////
    
    
    public function actualizaremple($NumEmple, $DNI, $Nombre, $Apellidos, $FechaNac, $Telefono, $Email, $Direccion, $Provincia, $Poblacion, $CP, $IdUsuario, $IdCategoria, $CodDepart, $IdCentral, $Foto) {
        try {
            $sql = "update $this->table set DNI = ?,"
                    . "Nombre = ?,"
                    . "Apellidos = ?,"
                    . "FechaNac = ?,"
                    . "Telefono = ?,"
                    . "Email = ?,"
                    . "Direccion = ?,"
                    . "Provincia = ?,"
                    . "Poblacion = ?,"
                    . "CP = ?,"
                    . "IdUsuario = ?,"
                    . "IdCategoria = ?,"
                    . "CodDepart = ?,"
                    . "IdCentral = ?,"
                    . "Foto = ? where NumEmple = ? ";

            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $DNI);
            $sentencia->bindParam(2, $Nombre);
            $sentencia->bindParam(3, $Apellidos);
            $sentencia->bindParam(4, $FechaNac);
            $sentencia->bindParam(5, $Telefono);
            $sentencia->bindParam(6, $Email);
            $sentencia->bindParam(7, $Direccion);
            $sentencia->bindParam(8, $Provincia);
            $sentencia->bindParam(9, $Poblacion);
            $sentencia->bindParam(10, $CP);
            $sentencia->bindParam(11, $IdUsuario);
            $sentencia->bindParam(12, $IdCategoria);
            $sentencia->bindParam(13, $CodDepart);
            $sentencia->bindParam(14, $IdCentral);
            $sentencia->bindParam(15, $Foto);
            $sentencia->bindParam(16, $NumEmple);

            $num = $sentencia->execute();

            $emple = $this->getEmpleado($NumEmple);

            return $emple;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    //Funcion que comprueba si el usuario existe en la BD
    public function comprueboDni($dni) {
        try {

            $sql = "SELECT * FROM $this->table WHERE DNI = ? ";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $dni);
            $sentencia->execute();
            if ($sentencia->rowCount() == 1) { //es decir true
                $reg = $sentencia->fetch();


                $obj = new Empleados(
                        $reg['NumEmple'],
                        $reg['DNI'],
                        $reg['Nombre'],
                        $reg['Apellidos'],
                        $reg['FechaNac'],
                        $reg['Telefono'],
                        $reg['Email'],
                        $reg['Direccion'],
                        $reg['Provincia'],
                        $reg['Poblacion'],
                        $reg['CP'],
                        $reg['IdUsuario'],
                        $reg['IdCategoria'],
                        $reg['CodDepart'],
                        $reg['IdCentral'],
                        $reg['Foto']
                );

                return $obj;
            } else {
                return "El DNI introducido no se encuentra en la base de datos";
            }
        } catch (PDOException $e) {
            return "ERROR AL CONECTAR.<br>" . $e->getMessage();
        }
    }

}
