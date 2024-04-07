<?php 

namespace Models;

class Equipos{

    private $id_equipo;
    private $numero_bien;
    private $departamento;
    private $usuario;
    private $direccion_mac;
    private $direccion_ip;
    private $fecha_registro;
    private $ingresos;
    private $cpu;
    private $almacenamiento;
    private $memoria_ram;
    private $sistema_operativo;
    private $registrado_por;
    private $estado;
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

    public function incrementarIngresosdeEquipo(){

        $sql = "UPDATE 
                equipos
                SET
                ingresos = ingresos + 1
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $this->con->consultaSimple($sql);
    }

    public function actualizarIngresosdeEquipoDepartamento(){

        $sql = "SELECT
                departamento
                FROM
                equipos
                WHERE
                id_equipo = '{$this->id_equipo}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function reducirIngresosdeEquipo(){

        $sql = "UPDATE 
                equipos
                SET
                ingresos = ingresos - 1
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $this->con->consultaSimple($sql);
    }

    public function cambiarEstadoAenProceso(){

        $sql = "UPDATE 
                equipos
                SET
                estado = 2
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $this->con->consultaSimple($sql);

    }

    public function cambiarEstadoaActivo(){

        $sql = "UPDATE 
                equipos
                SET
                estado = 0
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $this->con->consultaSimple($sql);

    }

    public function cambiarEstadoaPendienteAprobacion(){

        $sql = "UPDATE 
                equipos
                SET
                estado = 4
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $this->con->consultaSimple($sql);

    }

    public function aprobarRegistro(){
        $sql = "UPDATE 
                equipos
                SET
                estado = 0
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $this->con->consultaSimple($sql);
    }

    public function verificarEquipoBien(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                equipos
                WHERE
                numero_bien = '{$this->numero_bien}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function verificarEquipoMac(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                equipos
                WHERE
                direccion_mac = '{$this->direccion_mac}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function getEquipoForAuditoria(){
        $sql = "SELECT
                id_equipo, 
                numero_bien, 
                departamento, 
                usuario, 
                direccion_ip,
                direccion_mac,
                cpu,
                memoria_ram,
                almacenamiento,
                sistema_operativo
                FROM
                equipos
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function getEquipobyNumerodeBien(){

        $sql = "SELECT
                id_equipo,
                numero_bien,
                estado,
                departamento
                FROM
                equipos
                WHERE
                numero_bien = '{$this->numero_bien}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function getEquipobyDireccionMac(){

        $sql = "SELECT
                id_equipo,
                departamento
                FROM
                equipos
                WHERE
                direccion_mac = '{$this->direccion_mac}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function getEquipobyDireccionIP(){

        $sql = "SELECT
                id_equipo,
                numero_bien
                FROM
                equipos
                WHERE
                direccion_ip = '{$this->direccion_ip}'";
            
        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function lista(){

        $sql = "SELECT
                    t1.id_equipo, 
                    t1.numero_bien, 
                    t2.nombre_departamento AS departamento,
                    t1.usuario,
                    t1.direccion_mac,
                    t4.direccion AS direccion_ip,
                    t1.fecha_registro,
                    t5.nombres,
                    t5.apellidos,
                    t1.ingresos,
                    t1.estado,
                    t1.cpu,
                    t1.memoria_ram,
                    t1.almacenamiento,
                    t6.nombre AS sistema_operativo
                FROM
                    equipos t1 
                LEFT JOIN departamentos t2 ON t1.departamento = t2.id_departamento
                LEFT JOIN direcciones_asignadas t3 ON t1.direccion_ip = t3.id_asignacion
                LEFT JOIN direccion_ip t4 ON t3.id_direccion = t4.id_ip
                LEFT JOIN usuarios t5 ON t1.registrado_por = t5.id_user
                LEFT JOIN sistemas_operativos t6 ON t1.sistema_operativo = t6.id_os
                ";

                $datos = $this->con->consultaRetorno($sql);

                while($row = $datos->fetch_assoc()){

                    $this->resultado[] = $row;

                }

                return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                equipos
                (numero_bien, 
                departamento, 
                usuario, 
                direccion_mac, 
                cpu, 
                almacenamiento, 
                memoria_ram, 
                sistema_operativo,
                registrado_por)
                VALUES 
                ('{$this->numero_bien}', 
                '{$this->departamento}', 
                '{$this->usuario}', 
                '{$this->direccion_mac}', 
                '{$this->cpu}', 
                '{$this->almacenamiento}', 
                '{$this->memoria_ram}', 
                '{$this->sistema_operativo}',
                '{$this->registrado_por}')";
        
        $this->con->consultaSimple($sql);

    }

    public function AsignarDireccionEquipo(){

        $sql = "UPDATE
                equipos
                SET
                direccion_ip = '{$this->direccion_ip}'
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                equipos
                WHERE
                id_equipo = '{$this->id_equipo}'";
        
        $this->con->consultaSimple($sql);
    }

    public function edit(){

        $sql = "UPDATE
                equipos
                SET
                numero_bien = '{$this->numero_bien}', 
                departamento = '{$this->departamento}', 
                usuario = '{$this->usuario}', 
                direccion_mac = '{$this->direccion_mac}',
                cpu = '{$this->cpu}',
                almacenamiento = '{$this->almacenamiento}',
                memoria_ram = '{$this->memoria_ram}',
                sistema_operativo = '{$this->sistema_operativo}'
                WHERE
                id_equipo = '{$this->id_equipo}' ";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT
                    t1.id_equipo, 
                    t1.numero_bien, 
                    t3.nombre_departamento AS departamento,
                    t1.usuario,
                    t1.direccion_mac,
                    t6.direccion AS direccion_ip,
                    t1.fecha_registro,
                    t1.ingresos,
                    t1.cpu,
                    t1.almacenamiento,
                    t1.memoria_ram,
                    t4.nombre as sistema_operativo,
                    t4.tipo as tipo,
                    t1.estado,
                    t7.nombres,
                    t7.apellidos
                FROM
                    equipos t1
                INNER JOIN departamentos t3 ON t1.departamento = t3.id_departamento
                INNER JOIN sistemas_operativos t4 ON t1.sistema_operativo = t4.id_os
                LEFT JOIN direcciones_asignadas t5 ON t1.direccion_ip = t5.id_asignacion
                LEFT JOIN direccion_ip t6 ON t5.id_direccion = t6.id_ip
                INNER JOIN usuarios t7 ON t7.id_user = t1.registrado_por
                WHERE
                    t1.id_equipo = '{$this->id_equipo}' ";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }

    public function getDataEdit(){

        $sql = "SELECT
                id_equipo, 
                numero_bien, 
                departamento, 
                usuario, 
                direccion_ip,
                direccion_mac,
                cpu,
                memoria_ram,
                almacenamiento,
                sistema_operativo
                FROM
                equipos
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function desactivarEquipo(){

        $sql = "UPDATE
                equipos
                SET
                estado = 1
                WHERE
                id_equipo = '{$this->id_equipo}'";

        $this->con->consultaSimple($sql);
    }

    public function reactivarEquipo(){

        $sql = "UPDATE
                equipos
                SET
                estado = 0
                WHERE
                id_equipo = '{$this->id_equipo}'";

        $this->con->consultaSimple($sql);
    }

    public function historial(){

        $sql = "";
    }

    public function liberarDireccionEquipo(){

        $sql = "UPDATE
                equipos
                SET
                direccion_ip = NULL
                WHERE
                id_equipo = '{$this->id_equipo}'";

        $this->con->consultaSimple($sql);
    }

}





?>