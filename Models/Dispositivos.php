<?php 

namespace Models;

class Dispositivos{

    private $id_dispositivos;
    private $nombre_dispositivo;
    private $total_asignaciones;
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

    public function getDispositivoforAuditoria(){

        $sql= "SELECT
                id_dispositivos,
                nombre_dispositivo
                FROM
                dispositivos
                WHERE
                id_dispositivos = '{$this->id_dispositivos}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

    }

    public function actualizarDireccionesAsignadas(){

        $sql = "UPDATE
                dispositivos
                SET
                total_asignaciones = total_asignaciones + 1
                WHERE
                id_dispositivos = '{$this->id_dispositivos}'";

        $this->con->consultaSimple($sql);
    }

    public function reducirDireccionesenAsignadas(){

        $sql = "UPDATE
                dispositivos
                SET
                total_asignaciones = total_asignaciones - 1
                WHERE
                id_dispositivos = '{$this->id_dispositivos}'";

        $this->con->consultaSimple($sql);

    }

    public function lista(){

        $sql= "SELECT 
                id_dispositivos,
                nombre_dispositivo,
                total_asignaciones
                FROM dispositivos";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                dispositivos(nombre_dispositivo)
                VALUES
                ('{$this->nombre_dispositivo}')";
        
        $this->con->consultaSimple($sql);
    }

    public function getDataEdit(){

        $sql = "SELECT
                id_dispositivos,
                nombre_dispositivo
                FROM
                dispositivos
                WHERE
                id_dispositivos = '{$this->id_dispositivos}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }


    public function edit(){

        $sql = "UPDATE
                dispositivos
                SET
                nombre_dispositivo = '{$this->nombre_dispositivo}'
                WHERE
                id_dispositivos = '{$this->id_dispositivos}'";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT 
                id_dispositivos,
                nombre_dispositivo,
                total_asignaciones
                FROM
                dispositivos
                WHERE id_dispositivos = '{$this->id_dispositivos}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }
}



?>