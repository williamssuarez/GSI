<?php 

namespace Models;

class Soportes_pendientes{

    private $id_pendiente;
    private $id_soporte;
    private $id_operador;
    private $caso;
    private $tipo;
    private $fecha_soporte;
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
                id_os,
                nombre,
                tipo,
                fecha_agregado
                FROM sistemas_operativos";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                sistemas_operativos(nombre, tipo)
                VALUES
                ('{$this->nombre}', '{$this->tipo}')";
        
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