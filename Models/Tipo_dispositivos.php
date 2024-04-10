<?php 

namespace Models;

class Tipo_dispositivos{

    private $id_tipo;
    private $numero_bien;
    private $categoria_id;
    private $nombre_tipo;
    private $descripcion;
    private $fecha_creado;
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

   public function getTipoDispositivoforAuditoria(){

        $sql= "SELECT
                id_tipo,
                categoria_id,
                nombre_tipo,
                descripcion,
                fecha_creado,
                creado_por
                FROM
                tipo_dispositivos
                WHERE
                id_tipo = '{$this->id_tipo}'";

        $result = $this->con->consultaRetorno($sql);

        return $result->fetch_assoc();

   }

    public function getTiposDispositivos(){

        $sql = "SELECT
                id_tipo,
                categoria_id,
                nombre_tipo,
                descripcion,
                fecha_creado,
                creado_por
                FROM
                tipo_dispositivos
                ORDER BY 
                categoria_id";
        
        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }

    public function lista(){

        $sql = "SELECT
                    t1.id_tipo, 
                    t2.nombre_categoria AS categoria,
                    t1.nombre_tipo,
                    t1.descripcion,
                    t1.fecha_creado,
                    t3.nombres
                FROM
                    tipo_dispositivos t1 
                LEFT JOIN categoria_dispositivos t2 ON t1.categoria_id = t2.id_categoria
                LEFT JOIN usuarios t3 ON t1.creado_por = t3.id_user
                ";

                $datos = $this->con->consultaRetorno($sql);

                while($row = $datos->fetch_assoc()){

                    $this->resultado[] = $row;

                }

                return $this->resultado;
    }

    public function add(){
        
        $sql = "INSERT INTO
                tipo_dispositivos(categoria_id,
                nombre_tipo,
                descripcion,
                creado_por)
                VALUES
                ('{$this->categoria_id}', '{$this->nombre_tipo}', '{$this->descripcion}', '{$this->creado_por}')";
        
        $this->con->consultaSimple($sql);
    }

    public function getDataforEdit(){

        $sql = "SELECT 
                id_tipo,
                categoria_id,
                nombre_tipo,
                descripcion,
                fecha_creado,
                creado_por
                FROM 
                tipo_dispositivos
                WHERE
                id_tipo = '{$this->id_tipo}' ";

        $datos = $this->con->consultaRetorno($sql);

        return $datos->fetch_assoc();
    }

    public function edit(){

        $sql = "UPDATE
                tipo_dispositivos
                SET
                categoria_id = '{$this->categoria_id}',
                nombre_tipo = '{$this->nombre_tipo}',
                descripcion = '{$this->descripcion}'
                WHERE
                id_tipo = '{$this->id_tipo}'";
        
        $this->con->consultaSimple($sql);
    }

    public function delete(){
        
        $sql = "DELETE FROM
                tipo_dispositivos
                WHERE
                id_tipo = '{$this->id_tipo}'";
        
        $this->con->consultaSimple($sql);
    }

    public function view(){

        $sql = "SELECT
                    t1.id_tipo, 
                    t2.nombre_categoria AS categoria,
                    t1.nombre_tipo,
                    t1.descripcion,
                    t1.fecha_registro,
                    t3.nombre AS nombre_usuario,
                FROM
                    tipo_dispositivos t1 
                LEFT JOIN categoria_dispositivos t2 ON t1.categoria_id = t2.id_categoria
                LEFT JOIN usuarios t3 ON t1.creado_por = t3.id_user
                WHERE id_tipo = '{$this->id_tipo}'";

        $datos = $this->con->consultaRetorno($sql);

        while($row = $datos->fetch_assoc()){

            $this->resultado[] = $row;

        }

        return $this->resultado;
    }
}



?>