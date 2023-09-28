<?php 

namespace Models;

class Equipos_ingresados{

    private $id_ingreso;
    private $id_equipo;
    private $departamento;
    private $fecha_recibido;
    private $recibido_por;
    private $problema;
    private $estado;
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

    public function getProblema(){

        $sql = "SELECT
                problema
                FROM
                equipos_ingresados
                WHERE
                id_ingreso = '{$this->id_ingreso}'";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function getDataForEntrega(){

        $sql = "SELECT
                departamento,
                id_equipo
                FROM
                equipos_ingresados
                WHERE
                id_ingreso = '{$this->id_ingreso}'
                ";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
        
    }

    public function actualizarEstadodeEquipo(){

        $sql = "UPDATE
                equipos_ingresados
                SET
                estado = 1             
                WHERE
                id_ingreso = '{$this->id_ingreso}' ";
        
        $this->con->consultaSimple($sql);
    }

    public function getIngresosTotalesEquipos(){

        $sql = "SELECT COUNT(estado) AS totalIngreso FROM equipos_ingresados WHERE estado = 0";
        $datos = $this->con->consultaRetorno($sql);
        return $datos->fetch_assoc();
    }

    public function getIngresosTotalesEntregados(){

        $sql = "SELECT COUNT(estado) AS totalEntrega FROM equipos_ingresados WHERE estado != 0";
        $datos = $this->con->consultaRetorno($sql);
        return $datos->fetch_assoc();
    }

    public function getEquipos(){

        $sql= "SELECT
                id_equipo,
                numero_bien
                FROM
                equipos_ingresados";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;

    }

    public function lista(){

        $sql = "SELECT
                t1.id_ingreso,
                t4.id_equipo, 
                t4.numero_bien, 
                t2.nombre_departamento AS departamento, 
                t1.fecha_recibido, 
                t3.nombre as nombre_operador,
                t1.problema,
                t1.estado
                FROM
                equipos_ingresados t1 
                INNER JOIN departamentos t2 ON t1.departamento = t2.id_departamento
                INNER JOIN operadores t3 ON t1.recibido_por = t3.id_operador
                INNER JOIN equipos t4 ON t1.id_equipo = t4.id_equipo";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                equipos_ingresados(id_equipo, 
                                    departamento, 
                                    fecha_recibido, 
                                    recibido_por, 
                                    problema)
                VALUES 
                ('{$this->id_equipo}', 
                '{$this->departamento}', 
                '{$this->fecha_recibido}', 
                '{$this->recibido_por}', 
                '{$this->problema}')";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                equipos_ingresados
                WHERE
                id_ingreso = '{$this->id_ingreso}'";
        
        $this->con->consultaSimple($sql);
    }

    public function edit(){

        $sql = "UPDATE
                equipos_ingresados
                SET
                id_equipo = '{$this->id_equipo}', 
                departamento = '{$this->departamento}', 
                fecha_recibido = '{$this->fecha_recibido}', 
                recibido_por = '{$this->recibido_por}'
                problema = '{$this->problema}'
                WHERE
                id_ingreso = '{$this->id_ingreso}' ";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT
                id_ingreso, 
                id_equipo, 
                departamento, 
                fecha_recibido, 
                recibido_por,
                problema 
                FROM
                equipos_ingresados
                WHERE
                id_ingreso = '{$this->id_ingreso}' ";

        $datos = $this->con->consultaRetorno($sql);
        $row = mysqli_fetch_assoc($datos);

        return $row;
    }

}





?>