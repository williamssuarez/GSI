<?php namespace Models;

class Usuario{

    //DATOS DEL MODELO DEL USUARIO
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
    //HISTORIAL DEL USUARIO
    private $usuario_administrador;
    private $accion;
    private $razon;
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
    
    public function getUsuarioforAuditoria(){

        $sql= "SELECT
                id_user,
                nombres,
                apellidos, 
                cedula, 
                telefono,
                correo,
                usuario, 
                clave, 
                estado
                FROM
                usuarios
                WHERE
                id_user = '{$this->id_user}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

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
                clave,
                estado 
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

    public function getUserById(){
        
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
                estado 
                FROM 
                usuarios 
                WHERE id_user = ?";

        $param_types = "s"; // Tipo de parámetro (en este caso, una cadena)
        $params = array($this->id_user); // Parámetros

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

    public function getUsuarios(){


        $sql= "SELECT
                id_user,
                usuario,
                nombres as nombre,
                apellidos as apellido
                FROM
                usuarios";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }
    
        return $this->resultado;  

    }

    public function getUsuariosActivos(){

        $sql= "SELECT
                id_user,
                nombres as nombre,
                apellidos as apellido
                FROM
                usuarios
                WHERE
                estado = 0";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }
    
        return $this->resultado;  


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
                usuarios(rol, 
                        nombres, 
                        apellidos, 
                        cedula, 
                        correo, 
                        telefono, 
                        usuario, 
                        clave)
                VALUES 
                ('{$this->rol}', 
                '{$this->nombres}', 
                '{$this->apellidos}', 
                '{$this->cedula}', 
                '{$this->correo}', 
                '{$this->telefono}', 
                '{$this->usuario}', 
                '{$this->clave}')";
        
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
                correo = '{$this->correo}',
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

    public function ViewById(){

        $sql = "SELECT 
                id_user,
                rol,
                nombres,
                apellidos, 
                cedula,
                correo,
                telefono, 
                usuario,
                estado,
                fecha_agregado 
                FROM 
                usuarios
                WHERE id_user = '{$this->id_user}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;

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

    //INSERTAR RAZON DE DESACTIVACION EN HISTORIAL ANTES DE DESACTIVAR
    public function desactivarUsuarioHistorial(){

        $sql = "INSERT INTO
                historial_usuarios(usuario_administrador, id_usuario, accion, razon)
                VALUES 
                ('{$this->usuario_administrador}', '{$this->id_user}', '{$this->accion}', '{$this->razon}')";
            
        $this->con->consultaSimple($sql);

    }

    //CAMBIAR UNA VEZ INSERTADO EN EL HISTORIAL
    public function desactivarUsuario(){

        $sql = "UPDATE
                usuarios
                SET
                estado = 1
                WHERE
                id_user = '{$this->id_user}'";

        $this->con->consultaSimple($sql);
    }

    //INSERTAR RAZON DE REACTIVACION EN HISTORIAL ANTES DE REACTIVAR
    public function reactivarUsuarioHistorial(){

        $sql = "INSERT INTO
                historial_usuarios(usuario_administrador, id_usuario, accion, razon)
                VALUES 
                ('{$this->usuario_administrador}', '{$this->id_user}', '{$this->accion}', '{$this->razon}')";
            
        $this->con->consultaSimple($sql);

    }

    //REACTIVAR UNA VEZ INSERTADO EN EL HISTORIAL
    public function reactivarUsuario(){

        $sql = "UPDATE
                usuarios
                SET
                estado = 0
                WHERE
                id_user = '{$this->id_user}'";

        $this->con->consultaSimple($sql);
    }



}


?>