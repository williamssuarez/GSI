<?php 
ob_start();

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('URL', "http://192.168.0.105/GSI/");

session_start();

require_once "Config/Autoload.php";
require_once "vendor/autoload.php";
Config\Autoload::run();

    //$requests = new Config\Request();
    if (!isset($_SESSION['usuario'])) {
        // El usuario no está autenticado, redirige al formulario de inicio de sesión.
        ob_start();
        require_once "Views/loginTemplate.php";
    } else { 
        
        if($_SESSION['rol'] == 1){

            ob_start();
            require_once "Views/headers/headers.php";
            //require_once "Views/adminTemplate.php";
            ob_get_contents();


        }elseif($_SESSION['rol'] == 2){
            ob_start();
            require_once "Views/headers/headersOperador.php";
            //require_once "Views/operadorTemplate.php";
            ob_get_contents();
        }

    }

Config\Enrutador::run(new Config\Request());