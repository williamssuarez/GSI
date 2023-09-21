<?php  namespace Controllers;

use Repository\Procesos1;
use Models\Equipos_ingresados;

class inicioController{

    private $proceso1;
    private $equipos_ingresados;

    public function __construct()
    {
        $this->proceso1 = new Procesos1();
        $this->equipos_ingresados = new Equipos_ingresados();

    }

    public function index(){
        
        $datos['pendiente'] = $this->equipos_ingresados->getIngresosTotalesEquipos();
        $datos['entregado'] = $this->equipos_ingresados->getIngresosTotalesEntregados();

        return $datos;
    }

}

$inicio = new inicioController();

?>