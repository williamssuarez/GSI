<?php 

namespace Models;

class Auditoria{

    private $id_auditoria;
    private $tipo_cambio;
    private $tabla_afectada;
    private $registro_afectado;
    private $valor_antes;
    private $valor_despues;
    private $usuario;
    private $fecha;
    //Estos para setear la tabla y la id que va auditar
    private $tabla;
    private $id_tabla;
    private $id_set;
    //Parametros para el objeto JSON que guarda el valor anterior
    private $json_clave1;
    private $json_clave2;
    private $json_clave3;
    private $json_clave4;
    private $json_clave5;
    private $json_clave6;
    private $json_clave7;
    private $json_clave8;
    private $json_valor1;
    private $json_valor2;
    private $json_valor3;
    private $json_valor4;
    private $json_valor5;
    private $json_valor6;
    private $json_valor7;
    private $json_valor8;

    //Para la conexion y devolver un resultado
    private $con;
    private $resultado;

    public function __construct()
    {
        $this->con = new Conexion();
        $this->resultado = array();
    }

    public function set($atributo, $contenido){
        $this->$atributo = $contenido;
    }

    public function get($atributo){
        return $this->$atributo;
    }

    public function lista(){

        $sql= "SELECT 
                id_auditoria,
                tipo_cambio,
                tabla_afectada,
                registro_afectado,
                valor_antes,
                valor_despues,
                usuario,
                fecha
                FROM auditoria";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function getUser(){
        
        $sql = "SELECT 
                id_user,
                nombres,
                apellidos, 
                cedula, 
                usuario, 
                clave 
                FROM 
                usuarios 
                WHERE usuario = ?";
    
        $param_types = "s"; // Tipo de parámetro (en este caso, una cadena)
        $params = array($this->usuario); // Parámetros
    
        $result = $this->con->consultaPreparada($sql, $param_types, $params);
    
        if ($result !== false) {
            return $result->fetch_assoc();
        }
    
        return null; // Maneja el error de consulta preparada
    }

    public function auditar($tipoCambio, $tablaAfectada, $registroAfectado, $valoresAntes, $valoresDespues, $usuario) {
        // Construir y ejecutar la consulta de auditoría usando los parámetros proporcionados
        $sql = "INSERT INTO auditoria (tipo_cambio, tabla_afectada, registro_afectado, valor_antes, valor_despues, usuario)
                VALUES (?, ?, ?, ?, ?, ?)";

        $param_types = "ssssss"; // Tipo de parámetro (en este caso, una cadena)
        $params = array($tipoCambio, $tablaAfectada, $registroAfectado, $valoresAntes, $valoresDespues, $usuario); // Parámetros
        
        $this->con->consultaPreparada($sql, $param_types, $params);

    }

    public function auditarDelete(){

        $sql = "INSERT INTO auditoria 
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
        $this->con->consultaSimple($sql);
    }

    public function auditarEdit(){

        $sql = "INSERT INTO auditoria 
                (tipo_cambio, tabla_afectada, registro_afectado, valor_antes, valor_despues, usuario)
                VALUES('{$this->tipo_cambio}', 
                        '{$this->tabla_afectada}', 
                        '{$this->registro_afectado}', 
                       JSON_OBJECT('{$this->json_clave1}', '{$this->json_valor1}', 
                                    '{$this->json_clave2}', '{$this->json_valor2}', 
                                    '{$this->json_clave3}', '{$this->json_valor3}' 
                                    '{$this->json_clave4}', '{$this->json_valor4}'),
                        JSON_OBJECT('{$this->json_clave5}', '{$this->json_valor5}', 
                                    '{$this->json_clave6}', '{$this->json_valor6}', 
                                    '{$this->json_clave7}', '{$this->json_valor7}' 
                                    '{$this->json_clave8}', '{$this->json_valor8}'), 
                       '{$this->usuario}')";

        // Ejecutar la consulta
        $this->con->consultaSimple($sql);
    }

    public function auditarNew(){

        $sql = "INSERT INTO auditoria 
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
        $this->con->consultaSimple($sql);
    }



    public function view(){

        $sql = "SELECT 
                id_auditoria,
                tipo_cambio,
                tabla_afectada,
                registro_afectado,
                valor_antes,
                valor_despues,
                usuario,
                fecha
                FROM auditoria
                WHERE id_auditoria = '{$this->id_auditoria}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }
}



?>