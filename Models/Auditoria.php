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
    //Parametros para el objeto JSON que guarda el 
    private $json_clave1;
    private $json_clave2;
    private $json_clave3;
    private $json_valor1;
    private $json_valor2;
    private $json_valor3;
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
                id_dispositivos,
                nombre_dispositivo,
                total_asignaciones
                FROM dispositivos";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function auditarDelete(){

        $sql = "INSERT INTO auditoria 
                (tipo_cambio, tabla_afectada, registro_afectado, valor_antes, valor_despues, usuario)
                SELECT  '{$this->tipo_cambio}', 
                        {$this->tabla_afectada}, 
                        {$this->registro_afectado}, 
                       JSON_OBJECT('{$this->json_clave1}', '{$this->json_valor1}', 
                                    '{$this->json_clave2}', '{$this->json_valor2}', 
                                    '{$this->json_clave3}', '{$this->json_valor3}'), 
                       '{$this->valor_despues}', 
                       '{$this->usuario}'
                FROM {$this->tabla_afectada}
                WHERE '{$this->id_tabla}' = '{$this->registro_afectado}'";

        // Ejecutar la consulta
        $this->con->consultaSimple($sql);
    }

    public function add(){
        
        $sql = "INSERT INTO
                dispositivos(nombre_dispositivo)
                VALUES
                ('{$this->nombre_dispositivo}')";
        
        $this->con->consultaSimple($sql);
    }

    public function getDataEdit(){

        $sql = "SELECT
                id_dispositivos,
                nombre_dispositivo
                FROM
                dispositivos
                WHERE
                id_dispositivos = '{$this->id_dispositivos}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }


    public function edit(){

        $sql = "UPDATE
                dispositivos
                SET
                nombre_dispositivo = '{$this->nombre_dispositivo}'
                WHERE
                id_dispositivos = '{$this->id_dispositivos}'";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT 
                id_dispositivos,
                nombre_dispositivo,
                total_asignaciones
                FROM
                dispositivos
                WHERE id_dispositivos = '{$this->id_dispositivos}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }
}



?>