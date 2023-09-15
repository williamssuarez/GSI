<?php 

namespace Models;

class Direcciones{

    private $id_ip;
    private $ip;
    private $departamento;
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

    public function getDireccionesRandom(){

        $sql= "SELECT 
                id,
                ip as direccion
                FROM direcciones_ip
                WHERE id NOT IN (SELECT ip FROM direcciones)
                ORDER BY RAND()
                LIMIT 10;";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function listar(){

        $sql = "SELECT 
        t1.id_ip,
        t2.ip as direccion,
        t3.nombre_departamento as departamento 
        FROM
        direcciones t1
        INNER JOIN direcciones_ip t2 ON t1.ip = t2.id
        INNER JOIN departamentos t3 ON t1.departamento = t3.id_departamento
        ";
        
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                direcciones(ip, departamento)
                VALUES
                ( '{$this->ip}', '{$this->departamento}')";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){

        $sql = "DELETE FROM
                direcciones
                WHERE
                id_ip = '{$this->id_ip}'";
        
        $this->con->consultaSimple($sql);
    }

    public function edit(){

        $sql = "UPDATE
                direcciones
                SET
                ip = '{$this->ip}', departamento = '{$this->departamento}'
                WHERE
                id_ip = '{$this->id_ip}'";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT 
                t1.id_ip,
                t2.ip as direccion,
                t3.nombre_departamento as departamento 
                FROM
                direcciones t1
                INNER JOIN direcciones_ip t2 ON t1.ip = t2.id
                INNER JOIN departamentos t3 ON t1.departamento = t3.id_departamento
                WHERE a.id_ip = '{$this->id_ip}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }
}



?>