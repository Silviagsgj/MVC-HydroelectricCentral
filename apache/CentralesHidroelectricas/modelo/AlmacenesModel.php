<?php

class AlmacenesModel extends AABasedatos {

    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "almacenes";
        $this->conexion = $this->getConexion();
    }

    ////////////////////////////////////////////////     LISTAR    //////////////////////////////////////////////////////
    //Funcion que me da todos los datos de los almacenes
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
                        new Almacenes($row['CodAlmacen'],
                                $row['Tipo'],
                                $row['IdCentral']
                ));
            }
            return $objetos;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //Funcion que me da los datos de un almacen. Devuelve un objeto almacen    
    public function getUnAlmacen($CodAlmacen) {
        try {
            $sql = "SELECT * FROM $this->table WHERE CodAlmacen=?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $CodAlmacen);
            $sentencia->execute();
            $row = $sentencia->fetch();
            if ($row) {
                $alm = new Almacenes(
                        $row['CodAlmacen'],
                        $row['Tipo'],
                        $row['IdCentral']);
                return $alm;
            }
            return null;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR .<br>" . $e->getMessage();
        }
    }

    //Funcion que obtiene los almacenes dada una central. Devuelve un array de objetos almacenes
    public function getAlmacenesCentral($id) {

        try {
            $objetos = array();
            $sql = "SELECT * FROM $this->table WHERE IdCentral=?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();
            $registros = $sentencia->fetchAll();
            foreach ($registros as $row) {
                array_push($objetos,
                        new Almacenes($row['CodAlmacen'],
                                $row['Tipo'],
                                $row['IdCentral']
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
            $sql = "delete from $this->table where CodAlmacen= ? ";
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


    public function crear($tipo, $idcentral) {
        try {
            $sql = "insert into $this->table (Tipo, IdCentral) values (?,?)";
            $sentencia = $this->conexion->prepare($sql);


            $sentencia->bindParam(1, $tipo);
            $sentencia->bindParam(2, $idcentral);


            $sentencia->execute();

            $id = $this->conexion->lastInsertId();
            //$codigo = $numalu;
            $al = $this->getUnAlmacen($id);
            return $al;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    ////////////////////////////////////////////////     MODIFICAR    //////////////////////////////////////////////////////


    public function actualizaral($CodAlmacen, $Tipo, $IdCentral) {
        try {
            $sql = "update $this->table set Tipo = ? ,"
                    . "IdCentral = ? where CodAlmacen = ? ";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $Tipo);
            $sentencia->bindParam(2, $IdCentral);
            $sentencia->bindParam(3, $CodAlmacen);

            $num = $sentencia->execute();

            $al = $this->getUnAlmacen($CodAlmacen);

            return $al;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
