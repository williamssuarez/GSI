<?php 

namespace Models;

class Soportes_abiertos{

    private $id_soporte;
    private $id_departamento;
    private $id_operador;
    private $caso;
    private $fecha_soporte;
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

    public function getSistemas(){

        $sql = "SELECT
                id_os,
                nombre
                FROM sistemas_operativos
                ORDER BY nombre";
        
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function lista(){

        $sql= "SELECT
                    t1.id_soporte,
                    t2.nombre_departamento as departamento,
                    t3.nombres,
                    t3.apellidos,
                    t1.caso,
                    t1.tipo,
                    t1.fecha_soporte,
                    t1.estado 
                FROM
                    soportes_abiertos t1 
                INNER JOIN departamentos t2 ON t1.id_departamento = t2.id_departamento
                INNER JOIN usuarios t3 ON t1.id_operador = t3.id_user";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                soportes_abiertos(id_departamento, id_operador, caso, tipo)
                VALUES
                ('{$this->id_departamento}', 
                '{$this->id_operador}',
                '{$this->caso}',
                '{$this->tipo}')";
        
        $this->con->consultaSimple($sql);
    }

    public function getDataEdit(){

        $sql = "SELECT
                id_os,
                nombre,
                tipo
                FROM
                sistemas_operativos
                WHERE
                id_os = '{$this->id_os}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function edit(){

        $sql = "UPDATE
                sistemas_operativos
                SET
                nombre = '{$this->nombre}',
                tipo = '{$this->tipo}'
                WHERE
                id_os = '{$this->id_os}'";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                sistemas_operativos
                WHERE
                id_os = '{$this->id_os}'";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT 
                id_os,
                nombre,
                tipo,
                fecha_agregado
                FROM
                sistemas_operativos
                WHERE id_os = '{$this->id_os}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }
}



?>