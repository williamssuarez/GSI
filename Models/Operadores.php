<?php 

namespace Models;

class Operadores{

    private $id_operador;
    private $nombre;
    private $apellido;
    private $cedula_identidad;
    private $correo;
    private int $equipos_entregados;
    private int $equipos_ingresados;
    private int $suma_entrega;
    private int $suma_ingreso;
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

    public function ingresos(){

        $sql = "UPDATE 
                operadores
                SET
                equipos_ingresados = '{$this->equipos_ingresados}'
                WHERE
                id_operador = '{$this->id_operador}' ";

        $this->con->consultaSimple($sql);
    }

    public function entrega(){

        $sql = "UPDATE 
                operadores
                SET
                equipos_entregados = '{$this->equipos_entregados}'
                WHERE
                id_operador = '{$this->id_operador}' ";

        $this->con->consultaSimple($sql);
    }

    public function totalIngreso(){

        $sql = "SELECT
                equipos_ingresados
                FROM
                operadores
                WHERE
                id_operador = '{$this->id_operador}'";

        $datos = $this->con->consultaRetorno($sql);

        return $datos;
    }

    public function totalEntrega(){

        $sql = "SELECT
                equipos_entregados
                FROM
                operadores
                WHERE
                id_operador = '{$this->id_operador}'";

        $datos = $this->con->consultaRetorno($sql);

        return $datos;
    }

    public function getOperador(){

        $sql= "SELECT
                id_operador,
                nombre
                FROM
                operadores";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;   
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
                id_operador, 
                nombre, 
                apellido, 
                cedula_identidad, 
                correo
                FROM
                operadores
                WHERE
                id_operador = '{$this->id_operador}' ";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

}





?>