<?php namespace Controllers;

use Models\Usuario;

class loginController{

    private $usuario;

    public function __construct(){

        $this->usuario = new Usuario();

    }

    public function logout(){

        //echo "<h1>logout exitoso</h1>";
        
        //session_start();

        //session_unset();
        unset($_SESSION['nombre_usuario']);
        // Destruye la sesión
        session_destroy();
        
        // Redirige al usuario a la página de inicio o a donde desees
        header('Location: /CursoPHPPOO/EjercicioFinal/');
        exit;
                    
    }

    public function index(){

         //Verificando si hay sesion
        if(!isset($_SESSION['nombre_usuario'])){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $username = $_POST['nombre_usuario'];
                $clave = $_POST['clave'];
    
                $this->usuario->set('nombre_usuario', $username);
                $this->usuario->set('clave', $clave);
    
                $user = $this->usuario->getUser();
    
                //var_dump($user);
    
                if($user && isset($user[0]['clave'])){
    
                    $flag = $this->verificar($user[0]['clave'],$clave);
    
                    if($flag == true){
    
                        $_SESSION['nombre_usuario'] = $username;
    
                        header('Location: /CursoPHPPOO/EjercicioFinal/inicio/ahorasiarreglao');
                        exit;
    
                    } else {
    
                        $error = "Nombre de usuario o clave incorrectos";
                        print $error;
                    }
    
                    /*$success = "<h3>Las credenciales son correctas, Bienvenido</h3>";
                    print $success;
                    print "<br> Clave ingresada: ".$clave ;
                    print "<br> Clave de DB: ".$user[0]['clave'] ;*/
    
                } 
            }
        } else {
            header('Location: /CursoPHPPOO/EjercicioFinal/inicio/redireccionencasodeestarlogeado');
            exit;
        }
    }

    public function verificar($clavedb, $claveform){

        $flag = false;

        if($clavedb == $claveform){

            $flag = true;

        } else {

            $flag = false;

        }

        return $flag;

    }

}

?>