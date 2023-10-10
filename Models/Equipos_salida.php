<?php 

namespace Models;

class Equipos_salida{

    private $id_entrega;
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
                t4.numero_bien as equipo,
                t4.usuario,
                t5.nombre_departamento as departamento,
                t1.fecha_entrega,
                t2.nombres as entregado_por,
                t3.problema,
                t1.conclusion
                FROM
                equipos_salida t1 
                INNER JOIN usuarios t2 ON t2.id_user = t1.entregado_por
                INNER JOIN equipos_ingresados t3 ON t3.id_ingreso = t1.ingreso 
                INNER JOIN equipos t4 ON t4.id_equipo = t3.id_equipo
                INNER JOIN departamentos t5 ON t5.id_departamento = t4.departamento";
                
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                equipos_salida(ingreso, 
                                fecha_entrega, 
                                entregado_por, 
                                conclusion)
                VALUES 
                ('{$this->ingreso}', 
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