<?php 

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('URL', "http://localhost/GSI/");

session_start();

require_once "Config/Autoload.php";
require_once "vendor/autoload.php";
Config\Autoload::run();

// Comprueba si hay contenido del PDF en la variable de sesión
if(isset($_SESSION['pdfContent'])){
    // Establece los encabezados adecuados para un archivo PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="prueba.pdf"');

    // Imprime el contenido del PDF
    echo $_SESSION['pdfContent'];

    // Limpia el búfer de salida y termina la ejecución del script
    ob_end_clean();
    unset($_SESSION['pdfContent']);
    echo '<script>window.location = "' . URL . 'direcciones/index"</script>';
    exit;
}

if (!isset($_SESSION['usuario'])) {
    // El usuario no está autenticado, redirige al formulario de inicio de sesión.
    require_once "Views/loginTemplate.php";
} else { 
    if($_SESSION['rol'] == 1){

        require_once "Views/adminTemplate.php";

    }else{
        require_once "Views/operadorTemplate.php";
    }

}
Config\Enrutador::run(new Config\Request());

?>