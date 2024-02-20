<?php namespace Config;

class Enrutador{

    public static function run(Request $request){
        
        $controlador = $request->getControlador() . "Controller";
        $ruta = ROOT . "Controllers" . DS . $controlador . ".php";
        //print "<br>".$ruta."<br>";
        $metodo = $request->getMetodo();

        /*if(!method_exists($controlador, $metodo)){
            $metodo = 'index';            
        }*/
        if($metodo == "index.php"){
            $metodo = "index";
        }
        $argumento = $request->getArgumento();
        //print $ruta;
        if(is_readable($ruta)){
            require_once $ruta;
            $mostrar = "Controllers\\" . $controlador;
            $controlador = new $mostrar;

            if(!isset($argumento)){
                $data = call_user_func(array($controlador, $metodo));
            } else {
                $data = call_user_func_array(array($controlador, $metodo), $argumento);
            }
        } 
        
        else {
            $ruta = ROOT . "Views" . DS . "error" . DS . "404" . ".php";
            require_once $ruta;
        }

        //print "<br>".$ruta."<br>";
        //Cargar Vista
        
        $controllerView = $request->getControlador();

        if ($controllerView == 'ajax'){
            exit;
        } else {
            $ruta = ROOT . "Views" . DS . $controllerView . DS . $metodo . ".php";
            //print "<br>".$ruta."<br>";
            if(is_readable($ruta)){
                require_once $ruta;
            } else {
                $ruta = ROOT . "Views" . DS . "error" . DS . "404" . ".php";
                require_once $ruta;
            }
        }
    }
}
?>