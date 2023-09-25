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
    private int $estado;
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

    public function actualizarEquiposIngresados(){

        $sql = "UPDATE 
                operadores
                SET
                equipos_ingresados = equipos_ingresados + 1
                WHERE
                id_operador = '{$this->id_operador}' ";

        $this->con->consultaSimple($sql);
    }

    public function actualizarEquiposEntregados(){

        $sql = "UPDATE 
                operadores
                SET
                equipos_entregados = equipos_entregados + 1
                WHERE
                id_operador = '{$this->id_operador}' ";

        $this->con->consultaSimple($sql);
    }

    public function getOperador(){

        $sql= "SELECT
                id_operador,
                nombre,
                apellido
                FROM
                operadores";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;   
    }

    public function verificarCedula(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                operadores
                WHERE
                cedula_identidad = '{$this->cedula_identidad}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function verificarCorreo(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                operadores
                WHERE
                correo = '{$this->correo}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function lista(){

        $sql = "SELECT
                id_operador, 
                nombre, 
                apellido, 
                cedula_identidad, 
                correo,
                estado,
                equipos_entregados,
                equipos_ingresados
                FROM
                operadores";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    /*public function insertarOperador($nombre, $apellido, $cedula, $correo) {
        
        // Sentencia preparada para la inserción
        $stmt = $this->con->prepare("INSERT INTO operadores(nombre, apellido, cedula_identidad, correo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $apellido, $cedula, $correo);
        
        if ($stmt->execute()) {
            return true; // Éxito
        } else {
            return false; // Error
        }
    }*/

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

    public function getDataEdit(){

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

        return $datos->fetch_assoc();
    }

    public function historial(){

        $sql = "";
    }

    public function suspender(){

        $sql = "UPDATE
                operadores
                SET
                estado = 0
                WHERE
                id_operador = '{$this->id_operador}' ";

        $this->con->consultaSimple($sql);
    }

    public function activando(){

        $sql = "UPDATE
                operadores
                SET
                estado = 1
                WHERE
                id_operador = '{$this->id_operador}' ";

        $this->con->consultaSimple($sql);

    }

}





?>