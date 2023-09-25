<?php 

namespace Models;

class Direcciones_ip{

    private $id_ip;
    private $direccion;
    private $id_departamento;
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

    public function setRangoDepartamento($id){

        $this->id_departamento = $id;
    }

    public function get($atributo){
        return $this->$atributo;
    }

    public function getDireccionesporRango(){

        $sql= "SELECT 
                t1.id_ip,
                t1.direccion
                FROM direccion_ip t1, setrango t2
                WHERE t1.id_departamento = t2.id_departamento
                AND estado = 0
                ORDER BY RAND() LIMIT 10";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function ocupar(){

        $sql = "UPDATE
                direccion_ip
                SET
                estado = 1
                WHERE
                id_ip = '{$this->id_ip}'";

        $this->con->consultaSimple($sql);
    }

    public function release(){

        $sql = "UPDATE
                direccion_ip
                SET
                estado = 0
                WHERE
                id_ip = '{$this->id_ip}'";

        $this->con->consultaSimple($sql);

        $this->reducirDireccionesenDepartamento();
    }

    private function reducirDireccionesenDepartamento(){

        $sql = "UPDATE
                departamentos t2, direccion_ip t1
                SET
                t2.direcciones_asignadas = t2.direcciones_asignadas - 1
                WHERE t1.id_ip = '{$this->id_ip}'
                AND t1.id_departamento = t2.id_departamento
                ";
        $this->con->consultaSimple($sql);
    }

}



?>