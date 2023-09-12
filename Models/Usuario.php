<?php namespace Models;

class Usuario{

    private $id;
    private $nombre_usuario;
    private $clave;
    private $con;
    private $user;

    public function __construct()
    {
        $this->con = new Conexion();    
        $this->user = array();
    }

    public function set($atributo, $contenido){
        $this->$atributo = $contenido;
    }

    public function get($atributo){
        return $this->$atributo;
    }


    public function getUser(){


        $sql = "SELECT 
                id, nombre_usuario, clave 
                FROM 
                usuarios 
                WHERE nombre_usuario = '{$this->nombre_usuario}'";
        $datos = $this->con->consultaRetorno($sql);
        while($row = $datos->fetch_assoc()){
            $this->user[] = $row;
        }

        return $this->user;        
        
    }

}


?>