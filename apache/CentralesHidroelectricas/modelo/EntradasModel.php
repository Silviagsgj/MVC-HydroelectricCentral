<?php
class EntradasModel extends AABasedatos{

    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "entradas";
        $this->conexion = $this->getConexion();
    
    }
  
 ////////////////////////////////////////////////     INSERTAR    //////////////////////////////////////////////////////
    
    function insertaEntrada($NumEmple, $CodAlmacen, $FechaEntrada, $Motivo) {
  
        try {
            $sql = "INSERT INTO $this->table (NumEmple, CodAlmacen, FechaEntrada, Motivo) VALUES (?,?,?,?)";

            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $NumEmple);
            $sentencia->bindParam(2, $CodAlmacen);
            $sentencia->bindParam(3, $FechaEntrada);
            $sentencia->bindParam(4, $Motivo);
            $sentencia->execute();
            $id = $this->conexion->lastInsertId();
            return $id;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
       
}



 ////////////////////////////////////////////////     LISTAR    //////////////////////////////////////////////////////
 
	

  //Funcion que me da todos los datos de las entradas
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
    



    //Función que me da un listado de las entradas realizadas en un almacen
     function getEntradasalmacen($id) {
   
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


    //Función que me da un listado de las entradas de un empleado
     function getEntradasempleado($id) {
   
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


    //Función que me da un listado de las entradas realizadas de un empleado en un almacen
     function getEntradasempleadoyalmacen($id, $al) {
   
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

    


////////////////////////////////////////////////     BORRAR    //////////////////////////////////////////////////////
    
    
     public function borrarElemento($id) {
        try {
            $sql = "delete from $this->table where NumEntrada= ? ";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();
            $num=$sentencia->rowCount();
            return $num;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


     ////////////////////////////////////////////////     MODIFICAR    //////////////////////////////////////////////////////
    
    public function actualizarentrada($Numentrada, $codal, $motivo){
        try {
            $sql = "update $this->table set CodAlmacen = ?, Motivo = ? where NumEntrada = ?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $codal);        
            $sentencia->bindParam(2, $motivo);
            $sentencia->bindParam(3, $Numentrada);            
            $num = $sentencia->execute();
      
            return $num; 
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
     

    
}
