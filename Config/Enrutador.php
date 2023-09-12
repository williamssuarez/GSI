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
                call_user_func(array($controlador, $metodo));
            } else {
                call_user_func_array(array($controlador, $metodo), $argumento);
            }
        } 
        
        else {
            print"<h1>No se encontro la ruta al controlador o no ha sido creado</h1>";
        }

        //print "<br>".$ruta."<br>";
        //Cargar Vista
        $metodo = $request->getMetodo();
        if(!method_exists($controlador, $metodo)){
            $metodo = 'index';            
        }
        if($metodo == "index.php"){
            $metodo = "index";
        }
        $ruta = ROOT . "Views" . DS . $request->getControlador() . DS . $metodo . ".php";
        //print "<br>".$ruta."<br>";
        if(is_readable($ruta)){
            require_once $ruta;
        } else {
            print "<br>No se encontro la ruta, no existe o no ha sido creada<br>";
        }
    }
}
?>