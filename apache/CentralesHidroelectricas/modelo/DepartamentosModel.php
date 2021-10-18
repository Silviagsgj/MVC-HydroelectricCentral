<?php

class DepartamentosModel extends AABasedatos {
    
    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "departamentos";
        $this->conexion = $this->getConexion();
    }

    ////////////////////////////////////////////////     LISTAR    //////////////////////////////////////////////////////
    
    //Funcion que me da todos los datos de los departamentos
    public function getAll() {
        $objetos = array();
        try {
            $sql = "select * from $this->table";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll();
            $statement = null;
            //Retorna array de objetos departamentos
            foreach ($registros as $row) {
                array_push($objetos,
                        new Departamentos($row['CodDepart'],
                                $row['Nombre']
                ));
            }
            return $objetos;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //Funcion que me da los datos de un almacen. Devuelve un objeto almacen    
    public function getUnDepart($CodDepart) {
        try {
            $sql = "SELECT * FROM $this->table WHERE CodDepart=?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $CodDepart);
            $sentencia->execute();
            $row = $sentencia->fetch();
            if ($row) {
                $dep = new Departamentos(
                        $row['CodDepart'],
                        $row['Nombre']);

                return $dep;
            }
            return null;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR .<br>" . $e->getMessage();
        }
    }

    
    ////////////////////////////////////////////////     BORRAR    //////////////////////////////////////////////////////

    public function borrarElemento($id) {
        try {
            $sql = "delete from $this->table where CodDepart= ? ";
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
    
    
    public function crear($nombre) {
        try {
            $sql = "insert into $this->table (Nombre) values (?)";
            $sentencia = $this->conexion->prepare($sql);


            $sentencia->bindParam(1, $nombre);



            $sentencia->execute();
            //esto para auto increment
            $id = $this->conexion->lastInsertId();
            //$codigo = $numalu;
            $dep = $this->getUnDepart($id);
            return $dep; //devuelvo un objeto departamento
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    
    ////////////////////////////////////////////////     MODIFICAR    //////////////////////////////////////////////////////
    
    
    public function actualizardep($CodDepart, $Nombre) {
        try {
            $sql = "update $this->table set Nombre = ? where CodDepart = ? ";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $Nombre);
            $sentencia->bindParam(2, $CodDepart);


            $num = $sentencia->execute();

            $dep = $this->getUnDepart($CodDepart);

            return $dep;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
