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
    private $fecha_rechazo;
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
                '{$this->razon}')";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                equipos_rechazados
                WHERE
                ingreso = '{$this->ingreso}'";
        
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

    public function reporteIngresosdeEquipo(){

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
                INNER JOIN usuarios t3 ON t1.recibido_por = t3.id_user
                WHERE t1.id_equipo = 5";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;

    }

}





?>