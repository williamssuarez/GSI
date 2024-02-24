<?php 

namespace Models;

class Dispositivos_general{

    private $id_dispositivo;
    private $marca;
    private $serial;
    private $modelo;
    private $departamento;
    private $caracteristicas;
    private $fecha_creado;
    private $creado_por;
    private $tipo_id;
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

   public function getDispositivosGeneralesforAuditoria(){

        $sql= "SELECT
                id_dispositivo,
                marca,
                serial,
                modelo,
                departamento,
                caracteristicas,
                fecha_creado,
                creado_por,
                tipo_id
                FROM
                dispositivos_general
                WHERE
                id_dispositivo = '{$this->id_dispositivo}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

   }

    public function getDispositivosGenerales(){

        $sql = "SELECT 
                id_dispositivo,
                marca,
                serial,
                modelo,
                departamento,
                caracteristicas,
                fecha_creado,
                creado_por,
                tipo_id
                FROM
                dispositivos_general
                ORDER BY 
                tipo_id";
        
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function lista(){

        $sql = "SELECT
                    t1.id_dispositivo, 
                    t1.marca, 
                    t1.serial, 
                    t1.modelo, 
                    t2.nombre_departamento AS departamento,
                    t1.caracteristicas,
                    t1.fecha_creado,
                    t3.nombres AS creado_por,
                    t4.nombre_tipo AS tipo_dispositivo
                FROM
                    dispositivos_general t1 
                LEFT JOIN departamentos t2 ON t1.departamento = t2.id_departamento
                LEFT JOIN usuarios t3 ON t1.creado_por = t3.id_user
                LEFT JOIN tipo_dispositivos t4 ON t1.tipo_id = t4.id_tipo
                ";

                $datos = $this->con->consultaRetorno($sql);

                while($row = $datos->fetch_assoc()){

                    $this->resultado[] = $row;

                }

                return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                dispositivos_general(marca,
                serial,
                modelo,
                departamento,
                caracteristicas,
                creado_por,
                tipo_id)
                VALUES
                ('{$this->marca}', 
                '{$this->serial}', 
                '{$this->modelo}', 
                '{$this->departamento}', 
                '{$this->caracteristicas}', 
                '{$this->creado_por}', 
                '{$this->tipo_id}',)";
        
        $this->con->consultaSimple($sql);
    }

    public function getDataforEdit(){

        $sql = "SELECT 
                    id_dispositivo,
                    marca,
                    serial,
                    modelo,
                    departamento,
                    caracteristicas,
                    fecha_creado,
                    creado_por,
                    tipo_id
                FROM 
                    dispositivos_general
                WHERE
                id_dispositivo = '{$this->id_dispositivo}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function edit(){

        $sql = "UPDATE
                    marca,
                    serial,
                    modelo,
                    departamento,
                    caracteristicas,
                    tipo_id
                SET
                marca = '{$this->marca}',
                serial = '{$this->serial}',
                modelo = '{$this->modelo}',
                departamento = '{$this->departamento}',
                caracteristicas = '{$this->caracteristicas}',
                tipo_id = '{$this->tipo_id}',
                WHERE
                id_dispositivo = '{$this->id_dispositivo}'";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                dispositivos_general
                WHERE
                id_dispositivo = '{$this->id_dispositivo}'";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT
                    t1.id_dispositivo, 
                    t1.marca, 
                    t1.serial, 
                    t1.modelo, 
                    t2.nombre_departamento AS departamento,
                    t1.caracteristicas,
                    t1.fecha_creado,
                    t3.nombre AS creado_por,
                    t4.nombre_tipo AS tipo_dispositivo
                FROM
                    dispositivos_general t1 
                LEFT JOIN departamentos t2 ON t1.departamento = t2.id_departamento
                LEFT JOIN usuarios t3 ON t1.creado_por = t3.id_user
                LEFT JOIN tipo_dispositivos t4 ON t1.tipo_id = t4.id_tipo
                WHERE id_dispositivo = '{$this->id_dispositivo}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }
}



?>