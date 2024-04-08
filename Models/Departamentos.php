<?php 

namespace Models;

class Departamentos{

    private $id_departamento;
    private $nombre_departamento;
    private $piso;
    private $descripcion;
    private $creado_por;
    private $fecha_creado;
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

    //DATA PARA LA AUDITORIA
    public function getDepartamentoforAuditoria(){

        $sql= "SELECT
                id_departamento,
                nombre_departamento,
                piso,
                descripcion,
                creado_por,
                fecha_creado
                FROM
                departamentos
                WHERE
                id_departamento = '{$this->id_departamento}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();
    }

    public function actualizarEquiposIngresados(){

        $sql = "UPDATE
                departamentos
                SET
                ingresos = ingresos + 1
                WHERE
                id_departamento = '{$this->id_departamento}' ";

        $this->con->consultaSimple($sql);
    }

    public function actualizarDireccionesAsignadas(){

        $sql = "UPDATE
                departamentos t1,
                setRango t2
                SET
                t1.direcciones_asignadas = t1.direcciones_asignadas + 1
                WHERE
                t1.id_departamento = t2.id_departamento";

        $this->con->consultaSimple($sql);
    }

    public function getDataEdit(){

        $sql = "SELECT
                id_departamento, 
                nombre_departamento, 
                piso,
                descripcion
                FROM
                departamentos
                WHERE
                id_departamento = '{$this->id_departamento}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function getDepartamentos(){
        $sql = "SELECT
                id_departamento,
                nombre_departamento
                FROM
                departamentos
                ORDER BY nombre_departamento";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
            
    }


    public function lista(){

        $sql = "SELECT
                t1.id_departamento, 
                t1.nombre_departamento, 
                t1.piso,
                t1.descripcion,
                t1.creado_por,
                t2.nombres,
                t2.apellidos,
                t1.fecha_creado,
                t1.direcciones_asignadas
                FROM
                departamentos t1
                LEFT JOIN usuarios t2 ON t1.creado_por = t2.id_user
                ORDER BY t1.nombre_departamento";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                departamentos(
                    nombre_departamento, 
                    piso, 
                    descripcion,
                    creado_por
                )
                VALUES 
                ('{$this->nombre_departamento}', '{$this->piso}', '{$this->descripcion}', '{$this->creado_por}')";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                departamentos
                WHERE
                id_departamento = '{$this->id_departamento}'";
        
        $this->con->consultaSimple($sql);
    }

    public function edit(){

        $sql = "UPDATE
                departamentos
                SET
                nombre_departamento = '{$this->nombre_departamento}', 
                piso = '{$this->piso}',
                descripcion = '{$this->descripcion}'
                WHERE
                id_departamento = '{$this->id_departamento}' ";
        
        $this->con->consultaSimple($sql);
    }


    public function view(){

        $sql = "SELECT 
                id_departamento, 
                nombre_departamento, 
                piso
                FROM
                departamentos
                WHERE
                id_departamento = '{$this->id_departamento}' ";

        $datos = $this->con->consultaRetorno($sql);
        $row = mysqli_fetch_assoc($datos);

        return $row;
    }

}





?>