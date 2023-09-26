<?php 

namespace Models;

class setRango{

    private $id;
    private $id_departamento;
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

    public function getRango(){

        $sql = "SELECT
                t2.nombre_departamento as nombre 
                FROM
                departamentos t2
                INNER JOIN
                setrango t1 ON t2.id_departamento = t1.id_departamento";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function validarRango(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                setrango";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }

    public function setRangoForIp(){

        $sql = "INSERT INTO setrango(id_departamento)
                VALUE('{$this->id_departamento}')";

        $this->con->consultaSimple($sql);
    }

    public function liberarRangoForIp(){

        $sql = "DELETE FROM setrango";

        $this->con->consultaSimple($sql);
    }
    
}


?>