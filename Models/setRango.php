<?php 

namespace Models;

class setRango{

    private $id;
    private $id_departamento;
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }

    public function set($atributo, $contenido){
        $this->$atributo = $contenido;
    }

    public function get($atributo){
        return $this->$atributo;
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