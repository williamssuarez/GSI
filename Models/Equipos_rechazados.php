<?php 

namespace Models;

class Equipos_rechazados{

    //VARIABLES PARA EL MODELO
    private $id_rechazo;
    private $ingreso;
    private $id_equipo;
    private $id_administrador;
    private $id_usuario;
    private $razon_rechazo;
    //PARA RECHAZAR LA SALIDA DEL EQUIPO

    //PARA OBTENER DEL HISTORIAL
    private $accion = "Rechazo entrega";
    private $id_aprobacion;
    //PARA LA CONEXION A LA DB
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

    //GET RECHAZOS TOTALES POR USUARIO DEL DESDE EL HISTORIAL DEL EQUIPO
    public function getHistorialRechazosByUser(){

        $sql = "SELECT 
                COUNT(*) as rechazos
                FROM 
                historial_equipos
                WHERE usuario = '{$this->id_usuario}' AND accion = '{$this->accion}'";
        
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    //GET RECHAZOS TOTALES ALL TIME FROM HISTORIAL
    public function verificarRechazosTotalesDelDepartamentoAllTime(){

        $sql = "SELECT
                COUNT(*) as rechazos
                FROM
                historial_equipos WHERE accion = '{$this->accion}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }

    //OBTENIENDO RECHAZOS TOTALES
    public function verificarRechazosTotalesDelDepartamento(){

        $sql = "SELECT
                COUNT(*) as rechazos
                FROM
                equipos_rechazados";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }

    public function listaAdmin(){

        $sql = "SELECT 
                t1.id_rechazo,
                t2.numero_bien,
                t3.nombres as admin,
                t4.nombres as operador,
                t1.razon,
                t1.fecha_rechazo 
                FROM 
                equipos_rechazados t1
                INNER JOIN equipos t2 ON t2.id_equipo = t1.id_equipo
                INNER JOIN usuarios t3 ON t3.id_user = t1.id_administrador
                INNER JOIN usuarios t4 ON t4.id_user = t1.id_usuario";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function listaOperador(){

        $sql = "SELECT 
                t1.id_rechazo,
                t2.numero_bien,
                t3.nombres as admin,
                t4.nombres as operador,
                t1.razon,
                t1.fecha_rechazo 
                FROM 
                equipos_rechazados t1
                INNER JOIN equipos t2 ON t2.id_equipo = t1.id_equipo
                INNER JOIN usuarios t3 ON t3.id_user = t1.id_administrador
                INNER JOIN usuarios t4 ON t4.id_user = t1.id_usuario
                WHERE t1.id_usuario = '{$this->id_usuario}'";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                equipos_rechazados(ingreso,
                                    id_equipo,
                                    id_administrador,
                                    id_usuario,
                                    razon)
                VALUES 
                ('{$this->ingreso}',
                '{$this->id_equipo}',
                '{$this->id_administrador}', 
                '{$this->id_usuario}', 
                '{$this->razon_rechazo}')";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                equipos_rechazados
                WHERE
                ingreso = '{$this->ingreso}'";
        
        $this->con->consultaSimple($sql);
    }

    //INSERTANDO EN HISTORIAL DEL EQUIPO
    

}





?>