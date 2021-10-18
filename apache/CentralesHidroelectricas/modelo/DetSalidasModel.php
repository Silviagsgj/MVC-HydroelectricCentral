<?php
class DetSalidasModel extends AABasedatos {

    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "detsalidas";
        $this->conexion = $this->getConexion();
    }

    
    
    ////////////////////////////////////////////////     INSERTAR    //////////////////////////////////////////////////////
    
    function insertarDetalleSalida($NumSalida, $CodProd, $Unidades) {

        try {
            $sql = "INSERT INTO $this->table ( NumSalida, CodProd, Unidades) VALUES (?,?,?)";

            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $NumSalida);
            $sentencia->bindParam(2, $CodProd);
            $sentencia->bindParam(3, $Unidades);

            $sentencia->execute();
            $iddetalle = $this->conexion->lastInsertId();
            return $iddetalle;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    
 ////////////////////////////////////////////////     LISTAR    ////////////////////////////////////////////////////// 
 
 //Funcion que me da el detalle de una salida de productos. Devuelve un listado de los productos sacados.
    function getDetalleSalidas($idsalida) {

        try {
            $sql = "SELECT * FROM $this->table WHERE NumSalida = ?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $idsalida);
            $sentencia->execute();
            $registros = $sentencia->fetchAll();
            $sentencia = null; 
          

            return $registros;
        } catch (PDOException $e) {
            echo "Error " . $e->getMessage();
        }
    }
    

////////////////////////////////////////////////     BORRAR    //////////////////////////////////////////////////////


    public function borrarElemento($id) {
        try {
            $sql = "delete from $this->table where NumSalida= ? ";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();
            $num = $sentencia->rowCount();
            return $num;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    
    

}
