<?php


namespace Models;


class Empleados
{
    private $id_empleado;
    private $nombre_completo;
    private $cedula;
    private $departamento_id;
    private $fecha_registro;
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

    public function getEmpleados(){
        
        $sql = "SELECT
                id_empleado,
                nombre_completo,
                cedula,
                departamento_id
                FROM
                empleados
                ORDER BY cedula";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
            
    }

    public function getEmpleadosforAuditoria(){

        $sql= "SELECT
                id_empleado,
                nombre_completo,
                cedula,
                departamento_id
                FROM
                empleados
                WHERE
                id_empleado = '{$this->id_empleado}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }

    public function getEmpleadobyCedulaforAjax(){

        $sql = "SELECT 
                nombre_completo,
                cedula 
                FROM
                empleados
                WHERE
                cedula = '{$this->cedula}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function lista(){

        $sql= "SELECT
                t1.id_empleado,
                t1.nombre_completo,
                t1.cedula,
                t2.nombre_departamento AS departamento,
                t1.fecha_registro
                FROM empleados t1
                LEFT JOIN departamentos t2 ON t1.departamento_id = t2.id_departamento";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){

        $sql = "INSERT INTO
                empleados
                (nombre_completo, 
                cedula, 
                departamento_id)
                VALUES 
                ('{$this->nombre_completo}', 
                '{$this->cedula}', 
                '{$this->departamento_id}')";

        $this->con->consultaSimple($sql);
    }

    public function getDataEdit(){

        $sql = "SELECT
                id_empleado,
                nombre_completo,
                cedula,
                departamento_id
                FROM
                empleados
                WHERE
                id_empleado = '{$this->id_empleado}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }


    public function edit(){

        $sql = "UPDATE
                empleados
                SET
                nombre_completo = '{$this->nombre_completo}', 
                cedula = '{$this->cedula}', 
                departamento_id = '{$this->departamento_id}'
                WHERE
                id_empleado = '{$this->id_empleado}' ";

        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT 
                id_empleado,
                nombre_completo,
                cedula,
                departamento_id,
                fecha_registro
                FROM
                dispositivos
                WHERE id_empleado = '{$this->id_empleado}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

}