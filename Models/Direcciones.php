<?php 

namespace Models;

class Direcciones{

    private $id_ip;
    private $ip;
    private $estado;
    private $departamento;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }

    public function listar(){

        $sql = "SELECT 
        a.*,
        b.nombre_departamento as departamento 
        FROM
        direcciones a
        INNER JOIN departamentos b ON a.departamento = b.id_departamento";
        
        $datos = $this->con->consultaRetorno($sql);

        return $datos;
    }

    public function add(){
        
        $sql = "INSERT INTO
                direcciones(ip, estado, departamento)
                VALUES
                ( '{$this->ip}', '{$this->estado}', '{$this->departamento}')";
        
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
                ip = '{$this->ip}', estado = '{$this->estado}', departamento = '{$this->departamento}'
                WHERE
                id_ip = '{$this->id_ip}'";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT 
                a.*,
                b.nombre_departamento as departamento 
                FROM
                direcciones a
                INNER JOIN departamentos b ON a.departamento = b.id_departamento
                WHERE a.id_ip = '{$this->id_ip}'";

        $datos = $this->con->consultaRetorno($sql);
        $row = mysqli_fetch_assoc($datos);

        return $row;
    }
}



?>