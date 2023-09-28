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

    public function reducirIngresosdeEquipo(){

        $sql = "UPDATE 
                equipos
                SET
                ingresos = ingresos - 1
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $this->con->consultaSimple($sql);
    }


    public function verificarNumeroBien(){

        $sql = "SELECT
                COUNT(*) as cuenta
                FROM
                equipos
                WHERE
                numero_bien = '{$this->numero_bien}'";
            
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
                t1.direccion_ip,
                t1.fecha_registro,
                t1.ingresos
                FROM
                equipos t1 
                INNER JOIN departamentos t2 ON t1.departamento = t2.id_departamento";

                $datos = $this->con->consultaRetorno($sql);

                while($row = $datos->fetch_assoc()){

                    $this->resultado[] = $row;

                }

                return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                equipos(numero_bien, 
                        departamento, 
                        usuario, 
                        direccion_mac, 
                        direccion_ip, 
                        cpu, 
                        almacenamiento, 
                        memoria_ram, 
                        sistema_operativo)
                VALUES 
                ('{$this->numero_bien}', 
                '{$this->departamento}', 
                '{$this->usuario}', 
                '{$this->direccion_mac}', 
                '{$this->direccion_ip}', 
                '{$this->cpu}',
                '{$this->almacenamiento}',
                '{$this->memoria_ram}',
                '{$this->sistema_operativo}', )";
        
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
                direccion_ip = '{$this->direccion_ip}',
                WHERE
                id_equipo = '{$this->id_equipo}' ";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT
                t1.id_equipo, 
                t1.numero_bien, 
                t2.nombre_departamento AS departamento,
                t1.usuario,
                t1.direccion_mac,
                t1.direccion_ip,
                t1.fecha_registro,
                t1.ingresos,
                t1.cpu,
                t1.almacenamiento,
                t1.memoria_ram,
                t3.nombre as sistema_operativo,
                t3.tipo as tipo
                FROM
                equipos t1 
                INNER JOIN departamentos t2 ON t1.departamento = t2.id_departamento
                INNER JOIN sistemas_operativos t3 ON t1.sistema_operativo = t3.id_os
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }

    public function getDataEdit(){

        $sql = "SELECT
                id_equipo, 
                numero_bien, 
                departamento, 
                usuario, 
                direccion_mac,
                direccion_ip
                FROM
                equipos
                WHERE
                id_equipo = '{$this->id_equipo}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function historial(){

        $sql = "";
    }

}





?>