<?php 

namespace Models;

class Equipos_salida{

    private $id_entrega;
    private $departamento;
    private $ingreso;
    private $fecha_entrega;
    private $entregado_por;
    private $conclusion;
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

    public function lista(){

        $sql = "SELECT
                t1.id_entrega, 
                t2.nombre_departamento AS departamento,
                t5.id_ingreso AS ingreso,
                t4.numero_bien AS equipo, 
                t1.fecha_entrega, 
                t3.nombre AS entregado_por,
                t1.conclusion
                FROM
                equipos_salida t1 
                INNER JOIN departamentos t2 ON t1.departamento = t2.id_departamento
                INNER JOIN operadores t3 ON t1.entregado_por = t3.id_operador
                INNER JOIN equipos t4 ON t1.ingreso = t4.id_equipo
                INNER JOIN equipos_ingresados t5 ON t1.ingreso = t4.id_equipo";
                
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                equipos_salida(departamento, 
                                ingreso, 
                                fecha_entrega, 
                                entregado_por, 
                                conclusion)
                VALUES 
                ('{$this->departamento}', 
                '{$this->ingreso}', 
                '{$this->fecha_entrega}', 
                '{$this->entregado_por}', 
                '{$this->conclusion}')";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                equipos_salida
                WHERE
                id_entrega = '{$this->id_entrega}'";
        
        $this->con->consultaSimple($sql);
    }

    public function edit(){

        $sql = "UPDATE
                equipos_salida
                SET
                departamento = '{$this->departamento}', 
                ingreso = '{$this->ingreso}', 
                fecha_entrega = '{$this->fecha_entrega}', 
                entregado_por = '{$this->entregado_por}'
                conclusion = '{$this->conclusion}'
                WHERE
                id_entrega = '{$this->id_entrega}' ";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT 
                id_entrega, 
                departamento, 
                ingreso, 
                fecha_entrega, 
                entregado_por,
                conclusion 
                FROM
                equipos_salida
                WHERE
                id_entrega = '{$this->id_entrega}' ";

        $datos = $this->con->consultaRetorno($sql);
        $row = mysqli_fetch_assoc($datos);

        return $row;
    }

}





?>