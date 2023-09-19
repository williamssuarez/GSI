<?php namespace Repository;

use Models\Equipos_ingresados;
use Models\Equipos_salida;
use Models\Departamentos;
use Models\Operadores;
use Models\Conexion;

class Procesos1{

    private $equipos_ingreso; 
    private $equipos_salida;
    private $departamentos;
    private $operadores;
    private $con;
    
    public function __construct() {
        
        $this->equipos_ingreso = new Equipos_ingresados();
        $this->equipos_salida  = new Equipos_salida();
        $this->departamentos = new Departamentos();
        $this->operadores = new Operadores();
        $this->con = new Conexion();

    }

    public function getIngresosEnTotal(){

        $datos = $this->equipos_ingreso->getIngresosTotalesEquipos();

        return $datos;
    }

    public function getEntregasEnTotal(){

        $datos = $this->equipos_ingreso->getIngresosTotalesEntregados();

        return $datos;
    }

    public function Entrega(){

    }
  

    public function setReporte(){

        
    }
}

?>