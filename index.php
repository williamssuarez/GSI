<?php 

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('URL', "http://localhost/GSI/");

session_start();

require_once "Config/Autoload.php";
require_once "vendor/autoload.php";
Config\Autoload::run();
if (!isset($_SESSION['usuario'])) {
    // El usuario no está autenticado, redirige al formulario de inicio de sesión.
    require_once "Views/loginTemplate.php";
} else { 

    require_once "Views/template.php";

}
Config\Enrutador::run(new Config\Request());

?>