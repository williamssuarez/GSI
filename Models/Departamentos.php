<?php 

namespace Models;

class Departamentos{

    private $id_departamento;
    private $nombre_departamento;
    private $piso;
    private int $ingresos;
    private int $suma_ingresos;
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
                departamentos
                SET
                direcciones_asignadas = direcciones_asignadas + 1
                id_departamento = '{$this->id_departamento}'";
    }


    public function lista(){

        $sql = "SELECT
                id_departamento, 
                nombre_departamento, 
                piso
                FROM
                departamentos";
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                departamentos(nombre_departamento, piso )
                VALUES 
                ('{$this->nombre_departamento}', '{$this->piso}')";
        
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
                piso = '{$this->piso}'
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