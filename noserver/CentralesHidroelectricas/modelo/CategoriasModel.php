<?php

class CategoriasModel extends AABasedatos {

    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "categorias";
        $this->conexion = $this->getConexion();
    }

    ////////////////////////////////////////////////     LISTAR    //////////////////////////////////////////////////////
    //Funcion que me da todos los datos de las categorias
    public function getAll() {
        $objetos = array();
        try {

            $sql = "select * from $this->table";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll();
            $statement = null;
            //Retorna array de objetos categorias
            foreach ($registros as $row) {
                array_push($objetos,
                        new Categorias($row['IdCategoria'],
                                $row['SalarioBase'],
                                $row['HoraExtraNormal'],
                                $row['HoraExtraNocturna'],
                                $row['HoraExtraFestivo']
                ));
            }
            return $objetos;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    //Funcion que me da los datos de una categoria. Devuelve un objeto categoria    
    public function getUnaCategoria($IdCategoria) {
        try {
            $sql = "SELECT * FROM $this->table WHERE IdCategoria=?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $IdCategoria);
            $sentencia->execute();
            $row = $sentencia->fetch();
            if ($row) {
                $cat = new Categorias(
                        $row['IdCategoria'],
                        $row['SalarioBase'],
                        $row['HoraExtraNormal'],
                        $row['HoraExtraNocturna'],
                        $row['HoraExtraFestivo']);
                return $cat;
            }
            return null;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR .<br>" . $e->getMessage();
        }
    }

    ////////////////////////////////////////////////     BORRAR    //////////////////////////////////////////////////////


    public function borrarElemento($id) {
        try {
            $sql = "delete from $this->table where IdCategoria= ? ";
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


    public function crear($salariobase, $horaextranormal, $horaextranocturna, $horaextrafestivo) {
        try {
            $sql = "insert into $this->table (SalarioBase, HoraExtraNormal, HoraExtraNocturna, HoraExtraFestivo) values (?,?,?,?)";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $salariobase);
            $sentencia->bindParam(2, $horaextranormal);
            $sentencia->bindParam(3, $horaextranocturna);
            $sentencia->bindParam(4, $horaextrafestivo);
            $sentencia->execute();
            $id = $this->conexion->lastInsertId();

            $cat = $this->getUnaCategoria($id);
            return $cat;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    ////////////////////////////////////////////////     MODIFICAR    //////////////////////////////////////////////////////


    public function actualizarcat($IdCategoria, $SalarioBase, $HoraExtraNormal, $HoraExtraNocturna, $HoraExtraFestivo) {
        try {
            $sql = "update $this->table set SalarioBase = ?,"
                    . "HoraExtraNormal = ?,"
                    . "HoraExtraNocturna = ?,"
                    . "HoraExtraFestivo = ? where IdCategoria = ? ";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $SalarioBase);
            $sentencia->bindParam(2, $HoraExtraNormal);
            $sentencia->bindParam(3, $HoraExtraNocturna);
            $sentencia->bindParam(4, $HoraExtraFestivo);
            $sentencia->bindParam(5, $IdCategoria);


            $num = $sentencia->execute();

            $dep = $this->getUnaCategoria($IdCategoria);

            return $dep;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
