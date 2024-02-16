<?php 

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('URL', "http://localhost/GSI/");

session_start();

require_once "Config/Autoload.php";
require_once "vendor/autoload.php";
Config\Autoload::run();

    //$requests = new Config\Request();
    if (!isset($_SESSION['usuario'])) {
        // El usuario no está autenticado, redirige al formulario de inicio de sesión.
        require_once "Views/loginTemplate.php";
    } else { 
        
        if($_SESSION['rol'] == 1){

            require_once "Views/adminTemplate.php";

        }elseif($_SESSION['rol'] == 2){
            require_once "Views/operadorTemplate.php";
        }

    }

Config\Enrutador::run(new Config\Request());

?>