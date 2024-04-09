<?php 

namespace Models;

class Direcciones{

    private $id_asignacion;
    private $id_administrador;
    private $id_direccion;
    private $tipo_dispositivo;
    private $numero_bien;
    private $equipo;
    private $fecha_asignada;
    //DATA PARA EL HISTORIAL

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

    public function getAsignacionIDbyNumeroBien(){

        $sql = "SELECT
                id_asignacion
                FROM
                direcciones_asignadas
                WHERE 
                numero_bien = {$this->numero_bien}";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function getAsignacionbyDireccionId(){

        $sql = "SELECT
                id_asignacion,
                id_direccion,
                equipo
                FROM
                direcciones_asignadas
                WHERE 
                id_direccion = {$this->id_direccion}";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function listar(){

        $sql = "SELECT 
                t1.id_asignacion,
                t2.direccion as direccion,
                t3.nombre_departamento as departamento,
                t4.nombre_dispositivo as dispositivo,
                t1.numero_bien,
                t1.equipo,
                t1.fecha_asignada
                FROM
                direcciones_asignadas t1
                INNER JOIN direccion_ip t2 ON t1.id_direccion = t2.id_ip
                INNER JOIN departamentos t3 ON t2.id_departamento = t3.id_departamento
                INNER JOIN dispositivos t4 ON t1.tipo_dispositivo = t4.id_dispositivos";
        
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                direcciones_asignadas(id_administrador, id_direccion, tipo_dispositivo, numero_bien, equipo)
                VALUES 
                ('{$this->id_administrador}', '{$this->id_direccion}', '{$this->tipo_dispositivo}', '{$this->numero_bien}', '{$this->equipo}')";
        
        $this->con->consultaSimple($sql);
    }

    public function getDataForLiberation(){

        $sql = "SELECT
                id_asignacion,
                id_direccion,
                tipo_dispositivo,
                numero_bien,
                equipo
                FROM
                direcciones_asignadas
                WHERE
                id_asignacion = {$this->id_asignacion}";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function getIdDireccionByIdAsignacion(){

        $sql = "SELECT
                id_asignacion,
                id_direccion
                FROM
                direcciones_asignadas
                WHERE
                id_asignacion = {$this->id_asignacion}";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();

    }

    public function getIdAsignacionByDireccion(){

        $sql = "SELECT
                id_asignacion,
                id_direccion
                FROM
                direcciones_asignadas
                WHERE
                id_direccion = {$this->id_direccion}";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();

    }

    public function delete(){

        $sql = "DELETE FROM
                direcciones_asignadas
                WHERE
                id_asignacion = '{$this->id_asignacion}'";
        
        $this->con->consultaSimple($sql);
    }

    public function edit(){

        $sql = "UPDATE
                direcciones_asignadas
                SET
                id_direccion = '{$this->id_direccion}', tipo_dispositivo = '{$this->tipo_dispositivo}', numero_bien = '{$this->numero_bien}'
                WHERE
                id_direccion = '{$this->id_direccion}'";
        
        $this->con->consultaSimple($sql);
    }

    
}



?>