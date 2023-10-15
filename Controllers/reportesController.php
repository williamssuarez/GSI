<?php 

namespace Controllers;

use Models\Equipos_ingresados;
use Mpdf\Mpdf as mPDF;

class reportesController{

    private $mpdf;
    private $equipo_ingresado;

    public function __construct() {

        $this->mpdf = new mPDF();
        $this->equipo_ingresado = new Equipos_ingresados();

    }

    public function generarPdf(){

        $pdfContent = $this->generarReporte();

        $_SESSION['pdfContent'] = $pdfContent;

        echo '<script>window.location = "' . URL . 'reportes/generarPdf"</script>';

    }

    public function generarReporte(){

    $datos['titulo'] = "Equipos Ingresados";
    $datos['equipos'] = $this->equipo_ingresado->reporteIngresosdeEquipo();

    $html = file_get_contents(ROOT . 'Views' . DS . 'reportes' . DS . 'plantilla.php');
    
    ob_start();
    foreach($datos['equipos'] as $data){
        include(ROOT . 'Views' . DS . 'reportes' . DS . 'plantilla.php');
    }
    
    $html = ob_get_clean();

    // Establecer el contenido HTML
    $this->mpdf->WriteHTML($html);

    // Obtener el contenido del PDF como una cadena
    $pdfContent = $this->mpdf->Output('', 'S');
    return $pdfContent;
}

    
    

}





?>