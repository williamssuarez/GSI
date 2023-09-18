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
        
        $equipos_ingreso = new Equipos_ingresados();
        $equipos_salida  = new Equipos_salida();
        $departamentos = new Departamentos();
        $operadores = new Operadores();
        $con = new Conexion();

    }

    public function setReporte(){

        
    }
}

?>