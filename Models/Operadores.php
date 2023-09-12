<?php 

namespace Models;

class Operadores{

    private $id_operador;
    private $nombre;
    private $apellido;
    private $cedula_identidad;
    private $correo;
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

    public function lista(){

        $sql = "SELECT
                id_operador, 
                nombre, 
                apellido, 
                cedula_identidad, 
                correo
                FROM
                operadores";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                operadores(nombre, apellido, cedula_identidad, correo)
                VALUES 
                ('{$this->nombre}', '{$this->apellido}', '{$this->cedula_identidad}', '{$this->correo}')";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                operadores
                WHERE
                id_operador = '{$this->id_operador}'";
        
        $this->con->consultaSimple($sql);
    }

    public function edit(){

        $sql = "UPDATE
                operadores
                SET
                nombre = '{$this->nombre}', 
                apellido = '{$this->apellido}', 
                cedula_identidad = '{$this->cedula_identidad}', 
                correo = '{$this->correo}'
                WHERE
                id_operador = '{$this->id_operador}' ";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT
                *
                FROM
                operadores
                WHERE
                id_operador = '{$this->id_operador}' ";

        $datos = $this->con->consultaRetorno($sql);
        $row = mysqli_fetch_assoc($datos);

        return $row;
    }

}





?>