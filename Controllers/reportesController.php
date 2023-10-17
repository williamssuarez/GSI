<?php 

namespace Controllers;

use Models\Reportes;
use Models\Usuario;
use Mpdf\Mpdf as mPDF;

class reportesController{

    private $mpdf;
    private $reporte;
    private $usuario;

    public function __construct() {

        $this->mpdf = new mPDF();
        $this->reporte = new Reportes();
        $this->usuario = new Usuario();

    }

    //REPORTE POR ID DE EQUIPO
    public function generarPdfEquipo($id){

        $pdfContent = $this->generarReporteEquipo($id);

        $_SESSION['pdfContent'] = $pdfContent;

        echo '<script>window.location = "' . URL . 'reportes/generarPdfEquipo/' . $id . '"</script>';

    }

    //REPORTE DE USUARIO
    public function generarPdfUsuario($usuario){

        $this->usuario->set('usuario', $usuario);
        $id_user = $this->usuario->getIdUserbyUsuario();
        $id = $id_user['id_user'];

        $pdfContent = $this->generarReporteUsuario($id);

        $_SESSION['pdfContent'] = $pdfContent;

        echo '<script>window.location = "' . URL . 'reportes/generarPdfUsuario/' . $usuario . '"</script>';

    }

    public function generarReporteUsuario($id){

        $datos['titulo'] = "Equipos Ingresados";

        $this->reporte->set('id_equipo', $id);
        $datos['equipos'] = $this->reporte->reporteIngresoySalidasporEquipo();

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

    //REPORTE POR ID DE EQUIPO
    public function generarReporteEquipo($id){

    $datos['titulo'] = "Equipos Ingresados";

    $this->reporte->set('id_equipo', $id);
    $datos['equipos'] = $this->reporte->reporteIngresoySalidasporEquipo();

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