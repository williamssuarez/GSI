<?php namespace Models;

class Usuario{

    private $id_user;
    private $rol;
    private $nombres;
    private $apellidos;
    private $cedula;
    private $correo;
    private $telefono;
    private $usuario;
    //Para la edicion de credenciales del usuario
    private $current_user;
    private $clave;
    //PREGUNTAS DE SEGURIDAD
    private $id_pregunta;
    private $respuesta;
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

    public function verificarCorreo(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                usuarios
                WHERE
                correo = '{$this->correo}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function verificarTelefono(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                usuarios
                WHERE
                telefono = '{$this->telefono}'";
            
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
                correo,
                telefono, 
                usuario, 
                clave,
                estado,
                fecha_agregado 
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
                usuarios(rol, nombres, apellidos, cedula, correo, telefono, usuario, clave)
                VALUES 
                ('{$this->rol}', '{$this->nombres}', '{$this->apellidos}', '{$this->cedula}', '{$this->correo}', '{$this->telefono}', '{$this->usuario}','{$this->clave}')";
        
        $this->con->consultaSimple($sql);
    }

    //EDITAR PERFIL
    public function getDataEdit(){

        $sql = "SELECT
                id_user,
                nombres,
                apellidos,
                cedula,
                correo,
                telefono,
                usuario,
                rol
                FROM
                usuarios
                WHERE
                usuario = '{$this->usuario}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function edit(){

        $sql = "UPDATE
                usuarios
                SET
                nombres = '{$this->nombres}',
                apellidos = '{$this->apellidos}',
                cedula = '{$this->cedula}',
                correo = '{$this->correo}'
                telefono = '{$this->telefono}'
                WHERE
                usuario = '{$this->usuario}'";

        $this->con->consultaSimple($sql);
    }

    public function editCredencialesAdmin(){

        $sql = "UPDATE
                usuarios
                SET
                usuario = '{$this->usuario}',
                clave = '{$this->clave}',
                rol = '{$this->rol}'
                WHERE
                usuario = '{$this->current_user}'";

        $this->con->consultaSimple($sql);

    }

    public function editCredencialesOperador(){

        $sql = "UPDATE
                usuarios
                SET
                usuario = '{$this->usuario}',
                clave = '{$this->clave}'
                WHERE
                usuario = '{$this->current_user}'";

        $this->con->consultaSimple($sql);

    }

    public function view(){

        $sql = "SELECT 
                id_user,
                rol,
                nombres,
                apellidos, 
                cedula,
                correo,
                telefono, 
                usuario, 
                clave,
                estado,
                fecha_agregado 
                FROM 
                usuarios
                WHERE usuario = '{$this->usuario}'";

                $result = $this->con->consultaRetorno($sql);

                return $result->fetch_assoc();

    }
    
    //EN CASO DE RESTABLECER CLAVE

    public function getPreguntasSeguridad(){

        $sql = "SELECT 
                    preguntas_seguridad.id_pregunta AS id_pregunta,
                    preguntas_seguridad.pregunta AS pregunta
                FROM 
                    usuarios_preguntas
                JOIN 
                    preguntas_seguridad ON usuarios_preguntas.id_pregunta = preguntas_seguridad.id_pregunta
                WHERE 
                    usuarios_preguntas.id_usuario = '{$this->id_user}'";
        
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function getRespuestaPregunta(){

        $sql = "SELECT
                    respuesta
                FROM
                    usuarios_preguntas
                WHERE id_usuario = '{$this->id_user}' AND id_pregunta = '{$this->id_pregunta}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }

    public function restablecerClaveyUsuario(){

        $sql = "UPDATE
                usuarios
                SET
                usuario = '{$this->usuario}', 
                clave = '{$this->clave}'
                WHERE
                id_user = '{$this->id_user}'";

        $this->con->consultaSimple($sql);
    }


    //PREGUNTAS DE SEGURIDAD
    public function verificarPreguntasExistencia(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                usuarios_preguntas
                WHERE
                id_usuario = '{$this->id_user}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }

    public function getIdUserbyUsuario(){

        $sql = "SELECT
                id_user
                FROM
                usuarios
                WHERE
                usuario = '{$this->usuario}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }

    public function editarPreguntas(){

        $sql = "UPDATE
                usuarios_preguntas
                SET
                respuesta = '{$this->respuesta}'
                WHERE
                id_usuario = '{$this->id_user}' AND id_pregunta = '{$this->id_pregunta}'";
            
        $this->con->consultaSimple($sql);

    }

    public function insertarPreguntas(){

        $sql = "INSERT INTO
                usuarios_preguntas(id_usuario, id_pregunta, respuesta)
                VALUES 
                ('{$this->id_user}', '{$this->id_pregunta}', '{$this->respuesta}')";
            
        $this->con->consultaSimple($sql);

    }



}


?>