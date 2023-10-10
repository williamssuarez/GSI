<?php 

namespace Controllers;

use Mpdf\Mpdf as mPDF;

class pdfController{

    private $mpdf;

    public function __construct() {

        $this->mpdf = new mPDF();

    }

    public function generarPdf(){

        $pdfContent = $this->generarReporte();

        $_SESSION['pdfContent'] = $pdfContent;

    }

    public function generarReporte(){
    $html = '<h1>Ejemplo de PDF generado con mPDF</h1>
        <table border="1">
            <tr>
                <th>Columna 1</th>
                <th>Columna 2</th>
            </tr>
            <tr>
                <td>Dato 1</td>
                <td>Dato 2</td>
            </tr>
        </table>';

    // Establecer el contenido HTML
    $this->mpdf->WriteHTML($html);

    // Obtener el contenido del PDF como una cadena
    $pdfContent = $this->mpdf->Output('', 'S');
    return $pdfContent;
}

    
    

}





?>