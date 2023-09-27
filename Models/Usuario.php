<?php namespace Models;

class Usuario{

    private $id_user;
    private $nombres;
    private $apellidos;
    private $cedula;
    private $usuario;
    private $clave;
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


    /*public function getUser(){

        $sql = "SELECT 
                id_user,
                nombres,
                apellidos, 
                cedula, 
                usuario, 
                clave 
                FROM 
                usuarios 
                WHERE usuario = '{$this->usuario}'";
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
        
    }*/

    public function getUser(){
        
    $sql = "SELECT 
            id_user,
            nombres,
            apellidos, 
            cedula, 
            usuario, 
            clave 
            FROM 
            usuarios 
            WHERE usuario = ?";

    $param_types = "s"; // Tipo de parámetro (en este caso, una cadena)
    $params = array($this->usuario); // Parámetros

    $result = $this->con->consultaPreparada($sql, $param_types, $params);

    if ($result !== false) {
        return $result->fetch_assoc();
    }

    return null; // Maneja el error de consulta preparada
}
    

}


?>