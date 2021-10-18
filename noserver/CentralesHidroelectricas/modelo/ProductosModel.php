<?php

class ProductosModel extends AABasedatos{
    
    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "productos";
        $this->conexion = $this->getConexion();
    }
   
    
  ////////////////////////////////////////////////     LISTAR    //////////////////////////////////////////////////////
 

  //Funcion que me da todos los datos de los productos
    public function getAll() {
        $objetos = array();
        try {
          	
            $sql = "select * from $this->table";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll();
            $statement = null;
 
            foreach ($registros as $row) {
                array_push($objetos,
                        new Productos($row['CodProd'],
                                $row['Nombre'],
                                $row['Descripcion'],
                                $row['Marca'],
                                $row['Stock'],                         
                                $row['Foto']                                
                ));
            }
            return $objetos;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
   

    
    //Funcion que me da los datos de un producto. Devuelve un objeto producto
    public function getUnProducto($CodProd) {
        try {
            $sql = "SELECT * FROM $this->table WHERE CodProd=?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $CodProd);
            $sentencia->execute();
            $row = $sentencia->fetch();
            if ($row) {
                $pro = new Productos(
                                $row['CodProd'],
                                $row['Nombre'],
                                $row['Descripcion'],
                                $row['Marca'],
                                $row['Stock'],                          
                                $row['Foto']);
                return $pro;
            }
            return null;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR .<br>" . $e->getMessage();
        }
    }
    
    
       //Funcion que me da el stock de un producto
       public function damestockprodu($CodProd) {
       
        try {
            $sql = "SELECT Stock FROM $this->table WHERE CodProd=?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $CodProd);
            $sentencia->execute();
            $prod = $sentencia->fetch();
            return $prod[0];
        } catch (PDOException $e) {
            return "ERROR AL CARGAR .<br>" . $e->getMessage();
        }
       
   }
   
   
   //Funcion que me da todos los productos cuyo stock sea menor o igual a 3
    public function getProductosminstock() {
        $objetos = array();
        try {
          	
            $sql = "select * from $this->table where Stock <= 3";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll();
            $statement = null;
           
            foreach ($registros as $row) {
                array_push($objetos,
                        new Productos($row['CodProd'],
                                $row['Nombre'],
                                $row['Descripcion'],
                                $row['Marca'],
                                $row['Stock'],                               
                                $row['Foto']                                
                ));
            }
            return $objetos;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
   
      ////////////////////////////////////////////////     BORRAR    //////////////////////////////////////////////////////
    
    
     public function borrarElemento($id) {
        try {
            $sql = "delete from $this->table where CodProd= ? ";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $id);
            $sentencia->execute();
            $num=$sentencia->rowCount();
            return $num;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
  
    
     ////////////////////////////////////////////////     INSERTAR    //////////////////////////////////////////////////////
    
    public function crear($nombre, $descripcion, $marca, $stock, $foto) {
        try {
            $sql = "insert into $this->table (Nombre, Descripcion, Marca, Stock, Foto) values (?,?,?,?,?)";
            $sentencia = $this->conexion->prepare($sql);          
            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $descripcion);
            $sentencia->bindParam(3, $marca);
            $sentencia->bindParam(4, $stock);            
            $sentencia->bindParam(5, $foto);
            $sentencia->execute();
           
            $id=$this->conexion->lastInsertId();
       
            $pro=$this->getUnProducto($id);
            return $pro; 
           
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
    }
    
    
	

     ////////////////////////////////////////////////     MODIFICAR    //////////////////////////////////////////////////////
    
    public function actualizarprod($CodProd, $Nombre, $Descripcion, $Marca, $Stock, $Foto){
        try {
            $sql = "update $this->table set Nombre = ? "
                    . ", Descripcion = ? ,"
                    . " Marca = ? ,"
                    . " Stock = ? ,"                
                    . " Foto = ? where CodProd = ? ";
            
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $Nombre);        
            $sentencia->bindParam(2, $Descripcion);
            $sentencia->bindParam(3, $Marca);        
            $sentencia->bindParam(4, $Stock);              
            $sentencia->bindParam(5, $Foto);
            $sentencia->bindParam(6, $CodProd);        
          
            
            $num = $sentencia->execute();
      
            $prod= $this->getUnProducto($CodProd);
           
            return $prod; 
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    
    //Funcion que actualiza el stock del producto si se ha realizado una entrada en el almacen
     public function actualizarstockprod($CodProd,  $Stock){
        try {
            $sql = "update $this->table set Stock = ? where CodProd = ? ";
            
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $Stock);        
            $sentencia->bindParam(2, $CodProd);                        
            
            $num = $sentencia->execute();
      
            $prod= $this->getUnProducto($CodProd);
           
            return $prod; 
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    
     //Funcion que actualiza el stock del producto a 10
    public function aumentarStock($CodProd){
        try {
            $sql = "update $this->table set Stock = (Stock + 10) where CodProd = ?";
      
                $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $CodProd);
            $num = $sentencia->execute();
           $prod= $this->getProductosminstock();
           return $prod;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
