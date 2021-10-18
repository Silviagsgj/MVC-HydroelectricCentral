<?php

abstract class AABasedatos {
    private $servername = "localhost:3306";
    private $database = "hidroelectrica";
    private $username = "root";
    private $password = "";
    private $registros = array();
    private $conexion;
    private $mensajeerror = "";

    # Conectar a la base de datos

    public function getConexion() {

        try {
            $this->conexion = new PDO("mysql:host=$this->servername;dbname=$this->database;charset=utf8",
                    $this->username, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $e) {
            $this->mensajeerror = $e->getMessage();
        }
    }

# Desconectar la base de datos

    public function closeConexion() {
        $this->conexion = null;
    }

# Devolver mensaje de error, por si hay error.

    public function getMensajeError() {
        return $this->mensajeerror;
    }

# Traer resultados de una consulta sin parámetros en un Array

    public function getAllreg($tabla) {
        try {
            $sql = "select * from $tabla";
            $statement = $this->conexion->query($sql);
            $this->registros = $statement->fetchAll();
            $statement = null;
            return $this->registros;
        } catch (PDOException $e) {
            $this->mensajeerror = $e->getMessage();
        }
    }

}
?>

