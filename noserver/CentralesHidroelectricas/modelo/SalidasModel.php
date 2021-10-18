<?php
class SalidasModel extends AABasedatos{

    private $table;
    private $conexion;

   
        
    public function __construct() {
        $this->table = "salidas";
        $this->conexion = $this->getConexion();
     
    }
      
    
     ////////////////////////////////////////////////     INSERTAR    //////////////////////////////////////////////////////
    
     function insertaSalida($NumEmple, $CodAlmacen, $FechaSalida, $Motivo) {
  
        try {
            $sql = "INSERT INTO $this->table (NumEmple, CodAlmacen, FechaSalida, Motivo) VALUES (?,?,?,?)";

            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $NumEmple);
            $sentencia->bindParam(2, $CodAlmacen);
            $sentencia->bindParam(3, $FechaSalida);
            $sentencia->bindParam(4, $Motivo);
            $sentencia->execute();
            $id = $this->conexion->lastInsertId();
            return $id;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
       
}


 ////////////////////////////////////////////////     LISTAR    ////////////////////////////////////////////////////// 
 


//Función que me da un listado de las salidas en un almacen
     function getSalidasalmacen($id) {
   
        try {
            $sql = "SELECT * FROM $this->table WHERE CodAlmacen = ?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();
            $registros = $sentencia->fetchAll();
            $sentencia = null; //cierra la conexion        
            return $registros;
        } catch (PDOException $e) {
            echo "Error" . $e->getMessage();
        }
      
}


    //Función que me da un listado de las salidas de un empleado
     function getSalidasempleado($id) {
   
        try {
            $sql = "SELECT * FROM $this->table WHERE NumEmple = ?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();
            $registros = $sentencia->fetchAll();
            $sentencia = null; //cierra la conexion        
            return $registros;
        } catch (PDOException $e) {
            echo "Error" . $e->getMessage();
        }
      
}


    //Función que me da un listado de las salidas de un empleado y de un almacen
     function getSalidasempleadoyalmacen($id, $al) {
   
        try {
            $sql = "SELECT * FROM $this->table WHERE NumEmple = ? and CodAlmacen = ?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $id);
            $sentencia->bindParam(2, $al);
            $sentencia->execute();
            $registros = $sentencia->fetchAll();
            $sentencia = null; //cierra la conexion        
            return $registros;
        } catch (PDOException $e) {
            echo "Error" . $e->getMessage();
        }
      
}


//Funcion que me da todos los datos de las salidas
    public function getAll() {
        $objetos = array();
        try {
          	
            $sql = "select * from $this->table";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll();
            $statement = null;
            //Retorna array de objetos departamentos
             return $registros;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


////////////////////////////////////////////////     BORRAR    //////////////////////////////////////////////////////
    
    
     public function borrarElemento($id) {
        try {
            $sql = "delete from $this->table where NumSalida= ? ";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();
            $num=$sentencia->rowCount();
            return $num;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
  
}
