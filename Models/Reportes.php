<?php 

namespace Models;

class Reportes{


    //PARA REPORTES POR OPERADOR
    private $id_usuario;
    //PARA REPORTES POR EQUIPO
    private $id_equipo;
    //PARA LA CONEXION Y LAS CONSULTAS
    private $con;
    private $resultado;

    //CONEXION
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

    //REPORTE DE INGRESOS POR OPERADOR
    public function getIngresosOperador(){

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
                INNER JOIN usuarios t3 ON t1.recibido_por = t3.id_user
                INNER JOIN departamentos t2 ON t4.departamento = t2.id_departamento
                WHERE t1.recibido_por = '{$this->id_usuario}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function getHistorialOperador(){

        $sql = "SELECT * FROM historial_usuarios where id_usuario = '{$this->id_usuario}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function getEntregasOperador(){

        $sql = "SELECT
                t1.id_entrega,
                t4.numero_bien as equipo,
                t4.usuario,
                t5.nombre_departamento as departamento,
                t1.fecha_entrega,
                t6.nombres as administrador,
                t1.fecha_aprobacion,
                t2.nombres as entregado_por,
                t3.problema,
                t1.conclusion
                FROM
                equipos_salida t1 
                INNER JOIN usuarios t2 ON t2.id_user = t1.entregado_por
                INNER JOIN equipos_ingresados t3 ON t3.id_ingreso = t1.ingreso 
                INNER JOIN equipos t4 ON t4.id_equipo = t3.id_equipo
                INNER JOIN departamentos t5 ON t5.id_departamento = t4.departamento
                INNER JOIN usuarios t6 ON t6.id_user = t1.id_administrador
                WHERE t1.entregado_por = '{$this->id_usuario}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;

    }

    //REPORTE DE INGRESOS Y SALIDAS DE UN EQUIPO
    public function reporteIngresoySalidasporEquipo(){

        $sql = "SELECT
                t1.id_entrega,
                t4.numero_bien as equipo,
                t4.usuario,
                t5.nombre_departamento as departamento,
                t4.fecha_registro,
                t4.cpu,
                t4.memoria_ram,
                t4.almacenamiento,
                t8.nombre,
                t3.fecha_recibido,
                t3.recibido_por,
                t7.nombres,
                t1.fecha_entrega,
                t6.nombres as administrador,
                t1.fecha_aprobacion,
                t2.nombres as entregado_por,
                t3.problema,
                t1.conclusion
                FROM
                equipos_salida t1 
                INNER JOIN usuarios t2 ON t2.id_user = t1.entregado_por
                INNER JOIN equipos_ingresados t3 ON t3.id_ingreso = t1.ingreso 
                INNER JOIN equipos t4 ON t4.id_equipo = t3.id_equipo
                INNER JOIN departamentos t5 ON t5.id_departamento = t4.departamento
                INNER JOIN usuarios t6 ON t6.id_user = t1.id_administrador
                INNER JOIN usuarios t7 ON t7.id_user = t3.recibido_por 
                INNER JOIN sistemas_operativos t8 ON t8.id_os = t4.sistema_operativo
                WHERE t4.id_equipo = '{$this->id_equipo}'
                ORDER BY  t3.fecha_recibido ASC";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

}





?>