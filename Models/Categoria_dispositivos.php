<?php 

namespace Models;

class Categoria_dispositivos{

    private $id_categoria;
    private $nombre_categoria;
    private $descripcion;
    private $fecha_creada;
    private $creado_por;
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

   public function getCategoriaforAuditoria(){

        $sql= "SELECT
                id_categoria,
                nombre_categoria,
                descripcion,
                fecha_creada,
                creado_por
                FROM
                categoria_dispositivos
                WHERE
                id_categoria = '{$this->id_categoria}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

   }

    public function getCategorias(){

        $sql = "SELECT
                id_categoria,
                nombre_categoria,
                descripcion,
                fecha_creada,
                creado_por
                FROM 
                categoria_dispositivos
                ORDER BY 
                nombre_categoria";
        
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function lista(){

        $sql= "SELECT 
                t1.id_categoria,
                t1.nombre_categoria,
                t1.descripcion,
                t1.fecha_creada,
                t2.nombres
                FROM 
                categoria_dispositivos t1
                INNER JOIN usuarios t2 ON t2.id_user = t1.creado_por";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                categoria_dispositivos(nombre_categoria,
                descripcion,
                creado_por)
                VALUES
                ('{$this->nombre_categoria}', '{$this->descripcion}', '{$this->creado_por}')";
        
        $this->con->consultaSimple($sql);
    }

    public function getDataforEdit(){

        $sql = "SELECT 
                id_categoria,
                nombre_categoria,
                descripcion,
                fecha_creada,
                creado_por
                FROM 
                categoria_dispositivos
                WHERE
                id_categoria = '{$this->id_categoria}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function edit(){

        $sql = "UPDATE
                categoria_dispositivos
                SET
                nombre_categoria = '{$this->nombre_categoria}',
                descripcion = '{$this->descripcion}'
                WHERE
                id_categoria = '{$this->id_categoria}'";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                categoria_dispositivos
                WHERE
                id_categoria = '{$this->id_categoria}'";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT 
                id_categoria,
                nombre_categoria,
                descripcion,
                fecha_creada,
                creado_por
                FROM 
                categoria_dispositivos
                WHERE id_categoria = '{$this->id_categoria}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }
}



?>