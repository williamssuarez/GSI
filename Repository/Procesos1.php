<?php namespace Repository;

use Models\Equipos_ingresados;
use Models\Equipos_salida;
use Models\Operadores;

class Procesos1{

    private $equipos_ingreso; 
    private $equipos_salida;
    
    public function __construct() {
        
        $equipos_ingreso = new Equipos_ingresados();
        $equipos_salida  = new Equipos_salida();

    }

    public function setReporte(){

        
    }
}

?>