<?php  namespace Controllers;

use Repository\Procesos1;

class inicioController{

    private $proceso1;
    private $equipos_ingresados;

    public function __construct()
    {
        $this->proceso1 = new Procesos1();
    }

    public function index(){
        
        $datos['pendiente'] = $this->proceso1->getIngresosEnTotal();

        return $datos;
    }

    public function ato(){

        $datos['xd'] = $this->proceso1->getEntregasEnTotal();

        return $datos;
    }

}

$inicio = new inicioController();

?>