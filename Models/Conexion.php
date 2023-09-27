<?php 

namespace Models;

class Conexion{

    private $datos = array(
        "host" => "localhost",
        "user" => "root",
        "password" => "",
        "db" => "gsi",
    );

    private $con;

    public function __construct()
    {
        $this->con = new \mysqli($this->datos['host'], $this->datos['user'], $this->datos['password'], $this->datos['db']);
    }

    
 
    public function consultaSimple($sql){
        $this->con->query($sql);
    }

    public function consultaPreparada($sql, $param_types, $params)
    {
        $stmt = $this->con->prepare($sql);
        if (!$stmt) {
            return false; // Maneja el error de preparación de la consulta
        }

        // Vincular los parámetros
        if (!empty($params) && $stmt->bind_param($param_types, ...$params)) {
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $stmt->close();
                return $result;
            }
        }

        // Maneja el error en la ejecución de la consulta preparada
        $stmt->close();
        return false;
    }

    public function consultaRetorno($sql){
        $datos = $this->con->query($sql);

        return $datos;
    }


}
?>