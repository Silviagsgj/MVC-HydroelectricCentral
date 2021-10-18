<?php

class CentralesModel extends AABasedatos {

    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "centrales";
        $this->conexion = $this->getConexion();
    }

    ////////////////////////////////////////////////     LISTAR    ////////////////////////////////////////////////////// 
    //Funcion que me da todos los datos de las centrales
    public function getAll() {
        $objetos = array();
        try {

            $sql = "select * from $this->table";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll();
            $statement = null;
            //Retorna array de objetos centrales
            foreach ($registros as $row) {
                array_push($objetos,
                        new Centrales($row['IdCentral'],
                                $row['Nombre'],
                                $row['Telefono'],
                                $row['Constructor'],
                                $row['Provincia'],
                                $row['Poblacion'],
                                $row['CP'],
                                $row['TipoTurbina'],
                                $row['SaltoBruto'],
                                $row['NumGeneradores'],
                                $row['Potencia'],
                                $row['Foto']
                ));
            }
            return $objetos;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    

    //Funcion que me da los datos de una central. Devuelve un objeto central    
    public function getUnaCentral($IdCentral) {
        try {
            $sql = "SELECT * FROM $this->table WHERE IdCentral=?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $IdCentral);
            $sentencia->execute();
            $row = $sentencia->fetch();
            if ($row) {
                $cen = new Centrales(
                        $row['IdCentral'],
                        $row['Nombre'],
                        $row['Telefono'],
                        $row['Constructor'],
                        $row['Provincia'],
                        $row['Poblacion'],
                        $row['CP'],
                        $row['TipoTurbina'],
                        $row['SaltoBruto'],
                        $row['NumGeneradores'],
                        $row['Potencia'],
                        $row['Foto']);
                return $cen;
            }
            return null;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR .<br>" . $e->getMessage();
        }
    }

    ////////////////////////////////////////////////     BORRAR    //////////////////////////////////////////////////////

    public function borrarElemento($id) {
        try {
            $sql = "delete from $this->table where IdCentral= ? ";
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


    public function crear($nombre, $telefono, $constructor, $provincia, $poblacion, $cp, $tipoturbina, $saltobruto, $numgeneradores, $potencia, $foto) {
        try {
            $sql = "insert into $this->table (Nombre, Telefono, Constructor, Provincia, Poblacion, CP, TipoTurbina, SaltoBruto, NumGeneradores, Potencia, Foto) values (?,?,?,?,?,?,?,?,?,?,?)";
            $sentencia = $this->conexion->prepare($sql);


            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $telefono);
            $sentencia->bindParam(3, $constructor);
            $sentencia->bindParam(4, $provincia);
            $sentencia->bindParam(5, $poblacion);
            $sentencia->bindParam(6, $cp);
            $sentencia->bindParam(7, $tipoturbina);
            $sentencia->bindParam(8, $saltobruto);
            $sentencia->bindParam(9, $numgeneradores);
            $sentencia->bindParam(10, $potencia);
            $sentencia->bindParam(11, $foto);


            $sentencia->execute();
            $id = $this->conexion->lastInsertId();
            $cen = $this->getUnaCentral($id);
            return $cen;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    ////////////////////////////////////////////////     MODIFICAR    //////////////////////////////////////////////////////


    public function actualizarcen($IdCentral, $Nombre, $Telefono, $Constructor, $Provincia, $Poblacion, $CP, $TipoTurbina, $SaltoBruto, $NumGeneradores, $Potencia, $Foto) {
        try {
            $sql = "update $this->table set Nombre = ?, "
                    . "Telefono = ?, "
                    . "Constructor = ?, "
                    . "Provincia = ? ,"
                    . "Poblacion = ? ,"
                    . "CP = ? ,"
                    . "TipoTurbina = ? ,"
                    . "SaltoBruto = ? ,"
                    . "NumGeneradores = ?,"
                    . "Potencia = ?,"
                    . "Foto = ? where IdCentral = ? ";

            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $Nombre);
            $sentencia->bindParam(2, $Telefono);
            $sentencia->bindParam(3, $Constructor);
            $sentencia->bindParam(4, $Provincia);
            $sentencia->bindParam(5, $Poblacion);
            $sentencia->bindParam(6, $CP);
            $sentencia->bindParam(7, $TipoTurbina);
            $sentencia->bindParam(8, $SaltoBruto);
            $sentencia->bindParam(9, $NumGeneradores);
            $sentencia->bindParam(10, $Potencia);
            $sentencia->bindParam(11, $Foto);
            $sentencia->bindParam(12, $IdCentral);

            $num = $sentencia->execute();

            $cen = $this->getUnaCentral($IdCentral);

            return $cen;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
