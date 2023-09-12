<?php namespace Repository;

use Models\Estudiante;
use Models\Seccion;

class Procesos1{

    private $secciones; 
    private $estudiantes;
    
    public function __construct() {
        
        $secciones = new Seccion();
        $estudiantes  = new Estudiante();

    }

    public function getSecciones(){

        $secciones['secciones'] = $this->secciones->lista();

        return $secciones;
    }
}

?>