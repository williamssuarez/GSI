<?php namespace Models;

class Usuario{

    private $id_user;
    private $rol;
    private $nombres;
    private $apellidos;
    private $cedula;
    private $usuario;
    private $clave;
    private $pregunta1;
    private $pregunta2
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
                rol,
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

    public function obtenerUserByCedula(){

        $sql = "SELECT 
                id_user,
                rol,
                nombres,
                apellidos, 
                cedula, 
                usuario, 
                clave 
                FROM 
                usuarios 
                WHERE cedula = ?";

        $param_types = "s"; // Tipo de parámetro (en este caso, una cadena)
        $params = array($this->cedula); // Parámetros

        $result = $this->con->consultaPreparada($sql, $param_types, $params);

        if ($result !== false) {
            return $result->fetch_assoc();
        }

        return null; // Maneja el error de consulta preparada


    }

    public function verificarCedula(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                usuarios
                WHERE
                cedula = '{$this->cedula}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function verificarUsuario(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                usuarios
                WHERE
                usuario = '{$this->usuario}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function lista(){

        $sql = "SELECT 
                id_user,
                rol,
                nombres,
                apellidos, 
                cedula, 
                usuario, 
                clave,
                estado 
                FROM 
                usuarios";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                usuarios(rol, nombres, apellidos, cedula, usuario, clave)
                VALUES 
                ('{$this->rol}', '{$this->nombres}', '{$this->apellidos}', '{$this->cedula}', '{$this->usuario}','{$this->clave}')";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT 
        id_user,
        rol,
        nombres,
        apellidos, 
        cedula, 
        usuario, 
        clave,
        estado 
        FROM 
        usuarios
        WHERE usuario = '{$this->usuario}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }
    
    //EN CASO DE RESTABLECER CLAVE
    public function getPreguntas(){

        $sql = "SELECT 
                    t1.id_relacion,
                    t1.id_usuario,
                    t2.pregunta,
                    t1.respuesta 
                FROM 
                    usuarios_preguntas t1
                INNER JOIN
                    preguntas_seguridad t2 ON t2.id_pregunta = t1.id_pregunta 
                WHERE 
                    t1.id_usuario = 1 AND t1.";

    }

}


?>