<?php

class ProveedoresModel extends AABasedatos {
 
    private $table;
    private $conexion;

    public function __construct() {
        $this->table = "proveedores";
        $this->conexion = $this->getConexion();
    }

    ////////////////////////////////////////////////     LISTAR    //////////////////////////////////////////////////////

    //Funcion que me da todos los datos de los proveedores
    public function getAll() {
        $objetos = array();
        try {

            $sql = "select * from $this->table";
            $statement = $this->conexion->query($sql);
            $registros = $statement->fetchAll();
            $statement = null;
            //Retorna array de objetos proveedores
            foreach ($registros as $row) {
                array_push($objetos,
                        new Proveedores($row['IdProveedor'],
                                $row['Nombre'],
                                $row['CIF'],
                                $row['Telefono'],
                                $row['Direccion'],
                                $row['Provincia'],
                                $row['Poblacion'],
                                $row['CP']
                ));
            }
            return $objetos;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    

    //Funcion que me da los datos de un proveedor. Devuelve un objeto proveedor    
    public function getUnProveedor($IdProveedor) {
        try {
            $sql = "SELECT * FROM $this->table WHERE IdProveedor=?";
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $IdProveedor);
            $sentencia->execute();
            $row = $sentencia->fetch();
            if ($row) {
                $prov = new Proveedores(
                        $row['IdProveedor'],
                        $row['Nombre'],
                        $row['CIF'],
                        $row['Telefono'],
                        $row['Direccion'],
                        $row['Provincia'],
                        $row['Poblacion'],
                        $row['CP']);
                return $prov;
            }
            return null;
        } catch (PDOException $e) {
            return "ERROR AL CARGAR .<br>" . $e->getMessage();
        }
    }

    
    ////////////////////////////////////////////////     BORRAR    //////////////////////////////////////////////////////


    public function borrarElemento($id) {
        try {
            $sql = "delete from $this->table where IdProveedor= ? ";
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
    
    
    public function crear($nombre, $cif, $telefono, $direccion, $provincia, $poblacion, $cp) {
        try {
            $sql = "insert into $this->table (Nombre, CIF, Telefono, Direccion, Provincia, Poblacion, CP) values (?,?,?,?,?,?,?)";
            $sentencia = $this->conexion->prepare($sql);
            
            $sentencia->bindParam(1, $nombre);
            $sentencia->bindParam(2, $cif);
            $sentencia->bindParam(3, $telefono);
            $sentencia->bindParam(4, $direccion);
            $sentencia->bindParam(5, $provincia);
            $sentencia->bindParam(6, $poblacion);
            $sentencia->bindParam(7, $cp);

            $sentencia->execute();

            $id = $this->conexion->lastInsertId();

            $prov = $this->getUnProveedor($id);
            return $prov;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    

    ////////////////////////////////////////////////     MODIFICAR    //////////////////////////////////////////////////////
    
    
    public function actualizarprov($IdProveedor, $Nombre, $CIF, $Telefono, $Direccion, $Provincia, $Poblacion, $CP) {
        try {
            $sql = "update $this->table set Nombre = ?"
                    . ", CIF = ?, "
                    . " Telefono = ?, "
                    . "Direccion = ? ,"
                    . "Provincia = ? ,"
                    . "Poblacion = ? ,"
                    . "CP = ? where IdProveedor = ? ";

            $sentencia = $this->conexion->prepare($sql);
            $sentencia->bindParam(1, $Nombre);
            $sentencia->bindParam(2, $CIF);
            $sentencia->bindParam(3, $Telefono);
            $sentencia->bindParam(4, $Direccion);
            $sentencia->bindParam(5, $Provincia);
            $sentencia->bindParam(6, $Poblacion);
            $sentencia->bindParam(7, $CP);
            $sentencia->bindParam(8, $IdProveedor);

            $num = $sentencia->execute();

            $prov = $this->getUnProveedor($IdProveedor);

            return $prov;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

}
