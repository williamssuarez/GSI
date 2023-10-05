<?php 

namespace Controllers;

use Mpdf\Mpdf as mPDF;

class reportesController{

    private $mpdf;

    public function __construct() {

        $this->mpdf = new mPDF();

    }

    public function reporteprueba(){
        
        $html= '<h1>Ejemplo de PDF generado con mPDF</h1>
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

        // Salida del PDF
        $this->mpdf->Output();
    }
    

}





?>