<?php 

namespace Models;

class Conexion{

    private $datos = array(
        "host" => "localhost",
        "user" => "GSI",
        "password" => "WQ0tKWBeLEZlx2Db",
        "db" => "gsi",
    );

    /*private $datos = array(
        "host" => "localhost",
        "user" => "root",
        "password" => "",
        "db" => "gsi",
    );*/

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

    public function respaldo(){

        $db_host = $this->datos['host'];
        $db_user = $this->datos['user'];
        $db_password = $this->datos['password'];
        $db_name = $this->datos['db'];

        $fecha = date("Y-m-d");

        $name = $db_name."_". $fecha .".sql";

        $dump = "mysqldump -h$db_host -u$db_user -p$db_password --opt $db_name > $name";

        system($dump, $output);

    }

    public function auditarDelete(){

        /*$sql = "INSERT INTO auditoria 
                (tipo_cambio, tabla_afectada, registro_afectado, valor_antes, valor_despues, usuario)
                VALUES('{$this->tipo_cambio}', 
                        '{$this->tabla_afectada}', 
                        '{$this->registro_afectado}', 
                       JSON_OBJECT('{$this->json_clave1}', '{$this->json_valor1}', 
                                    '{$this->json_clave2}', '{$this->json_valor2}', 
                                    '{$this->json_clave3}', '{$this->json_valor3}'), 
                       '{$this->valor_despues}', 
                       '{$this->usuario}')";

        // Ejecutar la consulta
        $this->con->consultaSimple($sql);*/
    }



}
?>