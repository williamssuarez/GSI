<?php 

namespace Models;

class Equipos_ingresados{

    //VARIABLES PARA EL MODELO
    private $id_ingreso;
    private $id_equipo;
    private $fecha_recibido;
    private $recibido_por;
    private $problema;
    private $estado;
    //PARA EL HISTORIAL
    private $id_admin;
    private $usuario;
    private $accion;
    private $razon;
    //PARA RECHAZAR LA SALIDA DEL EQUIPO
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

    public function getProblema(){

        $sql = "SELECT
                problema
                FROM
                equipos_ingresados
                WHERE
                id_ingreso = '{$this->id_ingreso}'";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function getDataForEntrega(){

        $sql = "SELECT
                id_equipo
                FROM
                equipos_ingresados
                WHERE
                id_ingreso = '{$this->id_ingreso}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
        
    }

    public function actualizarEstadodeEquipo(){

        $sql = "UPDATE
                equipos_ingresados
                SET
                estado = 1             
                WHERE
                id_ingreso = '{$this->id_ingreso}' ";
        
        $this->con->consultaSimple($sql);
    }

    //CAMBIAR EL ESTADO A 2
    public function cambiarEstadoEquipoAprobacion(){

        $sql = "UPDATE
                equipos_ingresados
                SET
                estado = 2             
                WHERE
                id_ingreso = '{$this->id_ingreso}' ";
        
        $this->con->consultaSimple($sql);

    }

    //CAMBIAR EL ESTADO A 0
    public function rechazarAprobacionyCambiarestado(){

        $sql = "UPDATE
                equipos_ingresados
                SET
                estado = 0             
                WHERE
                id_ingreso = '{$this->id_ingreso}' ";
        
        $this->con->consultaSimple($sql);

    }

    public function getIngresosTotalesEquipos(){

        $sql = "SELECT COUNT(estado) AS totalIngreso FROM equipos_ingresados WHERE estado = 0";
        $datos = $this->con->consultaRetorno($sql);
        return $datos->fetch_assoc();
    }

    public function getIngresosTotalesEntregados(){

        $sql = "SELECT COUNT(estado) AS totalEntrega FROM equipos_ingresados WHERE estado != 0";
        $datos = $this->con->consultaRetorno($sql);
        return $datos->fetch_assoc();
    }

    public function getAsignacionesTotalesaUsuario(){
        $sql = "SELECT COUNT(estado) AS totalAsignaciones FROM equipos_ingresados WHERE estado = 0 AND recibido_por = '{$this->recibido_por}'";
        $datos = $this->con->consultaRetorno($sql);
        return $datos->fetch_assoc();
    }

    public function getEquipos(){

        $sql= "SELECT
                id_equipo,
                numero_bien
                FROM
                equipos_ingresados";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;

    }

    public function verificarExistencia(){

        $sql = "SELECT
                COUNT(id_equipo) as existencia
                FROM
                equipos_ingresados
                WHERE
                id_equipo = '{$this->id_equipo}' AND estado = 0";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();

    }

    public function lista(){

        $sql = "SELECT
                t1.id_ingreso,
                t4.id_equipo, 
                t4.numero_bien, 
                t2.nombre_departamento AS departamento, 
                t1.fecha_recibido, 
                t3.nombres as nombre_operador,
                t1.recibido_por,
                t1.problema,
                t1.estado
                FROM
                equipos_ingresados t1 
                INNER JOIN equipos t4 ON t1.id_equipo = t4.id_equipo
                INNER JOIN departamentos t2 ON t4.departamento = t2.id_departamento
                INNER JOIN usuarios t3 ON t1.recibido_por = t3.id_user";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                equipos_ingresados(id_equipo,
                                    fecha_recibido, 
                                    recibido_por, 
                                    problema)
                VALUES 
                ('{$this->id_equipo}',
                '{$this->fecha_recibido}', 
                '{$this->recibido_por}', 
                '{$this->problema}')";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                equipos_ingresados
                WHERE
                id_ingreso = '{$this->id_ingreso}'";
        
        $this->con->consultaSimple($sql);
    }

    public function edit(){

        $sql = "UPDATE
                equipos_ingresados
                SET
                id_equipo = '{$this->id_equipo}',
                fecha_recibido = '{$this->fecha_recibido}', 
                recibido_por = '{$this->recibido_por}'
                problema = '{$this->problema}'
                WHERE
                id_ingreso = '{$this->id_ingreso}' ";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT
                id_ingreso, 
                id_equipo,
                fecha_recibido, 
                recibido_por,
                problema 
                FROM
                equipos_ingresados
                WHERE
                id_ingreso = '{$this->id_ingreso}' ";

        $datos = $this->con->consultaRetorno($sql);
        $row = mysqli_fetch_assoc($datos);

        return $row;
    }

    //INSERTANDO EN HISTORIAL DEL EQUIPO
    public function ingresarEquipoHistorial(){


            $sql = "INSERT INTO
                    historial_equipos(id_admin, usuario, id_equipo, accion, razon)
                    VALUES 
                    ('{$this->id_admin}','{$this->usuario}', '{$this->id_equipo}', '{$this->accion}', '{$this->razon}')";
                
            $this->con->consultaSimple($sql);

    }

    //ADMINISTRANDO LOS RECHAZOS DE SALIDA DE LOS EQUIPOS
    //REVIRTIENDO LA INFORMACION EN TABLA EQUIPOS_ENTREGADOS
    public function rechazarAdmin(){

        $sql = "UPDATE
                equipos_ingresados
                SET
                estado = 0
                WHERE
                id_ingreso = '{$this->id_ingreso}'";

        $this->con->consultaSimple($sql);       

    }

    //ELIMINANDO DE LA TABLA EQUIPOS APROBACION
    public function eliminarDeEsperandoAprobacion(){

        $sql = "DELETE FROM
                equipos_aprobacion
                WHERE
                id_aprobacion = '{$this->id_aprobacion}'";

        $this->con->consultaSimple($sql);
    }

    //VERIFICAR RECHAZOS DEL OPERADOR
    public function verificarRechazosTotales(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                historial_equipos t1, equipos_ingresados t2
                WHERE
                t1.usuario = '{$this->usuario}' AND t1.usuario = t2.recibido_por AND t2.estado = 0 AND t2.id_equipo = t1.id_equipo";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }


    public function verificarRechazos(){

        $sql = "SELECT
                    t1.id_historial,
                    t1.id_admin,
                    t1.usuario, 
                    t1.id_equipo,
                    t1.accion,
                    t1.razon,
                    t2.problema,
                    t1.fecha_historial
                FROM
                    historial_equipos t1, equipos_ingresados t2
                WHERE
                        t1.usuario = t2.recibido_por AND t2.estado = 0 AND t1.usuario = 3 AND  t2.id_equipo = t1.id_equipo";

    }

}





?>