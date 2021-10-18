<?php
class DetEntradasModel extends AABasedatos{

    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "detentradas";
        $this->conexion = $this->getConexion();   
    }
    
////////////////////////////////////////////////     INSERTAR    //////////////////////////////////////////////////////
    
   function insertarDetalleEntrada($NumEntrada, $CodProd, $Unidades, $UnidadesActuales, $UnidadesenAlmacen) {   
        try {
            $sql = "INSERT INTO $this->table ( NumEntrada, CodProd, Unidades, UnidadesActuales, UnidadesenAlmacen) VALUES (?,?,?,?,?)";

            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $NumEntrada);
            $sentencia->bindParam(2, $CodProd);
            $sentencia->bindParam(3, $Unidades);
            $sentencia->bindParam(4, $UnidadesActuales);
            $sentencia->bindParam(5, $UnidadesenAlmacen);
            $sentencia->execute();
            $iddetalle = $this->conexion->lastInsertId();
            return $iddetalle;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }    
}

////////////////////////////////////////////////     LISTAR    //////////////////////////////////////////////////////

//Funcion que me da el detalle de una entrada de productos. Devuelve un listado de los productos añadidos.
function getDetalleEntradas($identrada) {
  
        try {
            $sql = "SELECT * FROM $this->table WHERE NumEntrada = ?";
            $sentencia = $this->conexion ->prepare($sql);
            $sentencia->bindParam(1, $identrada);
            $sentencia->execute();
            $registros = $sentencia->fetchAll();
            $sentencia = null;        
       
            return $registros;
        } catch (PDOException $e) {
            echo "Error " . $e->getMessage();
        }       
}


//Funcion que me da el detalle de una entrada de productos de un almacen
function getDetalleEntradasAll($codalma) {  
        try {         
            $sql = "SELECT CodProd, SUM(Unidades) - UnidadesActualesAlmacen as unida, CodAlmacen , (SUM(UnidadesActuales) - UnidadesActualesAlmacen) as Uniact, UnidadesActualesAlmacen FROM $this->table join entradas using(NumEntrada) where CodAlmacen=? group by CodProd";
           
            $sentencia = $this->conexion ->prepare($sql);
            $sentencia->bindParam(1, $codalma);
            $sentencia->execute();
            $registros = $sentencia->fetchAll();
            $sentencia = null;       
       
            return $registros;
        } catch (PDOException $e) {
            echo "Error " . $e->getMessage();
        }       
}


//Funcion que me da las unidades de un producto en un almacen
function dameunidades($codalma, $codprodu) {
  
        try {
            $sql = "SELECT (SUM(UnidadesActuales) - UnidadesActualesAlmacen) FROM $this->table join entradas using(NumEntrada) where CodAlmacen=? and CodProd = ?";
            $sentencia = $this->conexion ->prepare($sql);
            $sentencia->bindParam(1, $codalma);
                $sentencia->bindParam(2, $codprodu);
            $sentencia->execute();
                $prod = $sentencia->fetch();
            return $prod[0];
        } catch (PDOException $e) {
            echo "Error " . $e->getMessage();
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
     
    
     //Funcion que actualiza las unidades disponibles en el almacen
        public function actualizarunidadesalmacen($CodAlmacen, $uni, $unialm, $CodProd) {

        try {
            $sql = "update $this->table join entradas using(NumEntrada) set UnidadesActualesAlmacen = (UnidadesActualesAlmacen + ?), UnidadesenAlmacen = (UnidadesenAlmacen + ?) where CodAlmacen = ? and CodProd = ?";

            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $uni);
            $sentencia->bindParam(2, $unialm);
            $sentencia->bindParam(3, $CodAlmacen);
            $sentencia->bindParam(4, $CodProd);

            $num = $sentencia->execute();

            return $num;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    
}
