<?php namespace Controllers;

use Models\Usuario;

class loginController{

    private $usuario;

    public function __construct(){

        $this->usuario = new Usuario();

    }

    public function logout(){

        session_unset(); // Limpia todas las variables de sesión.
        session_destroy(); // Destruye la sesión.
        
        // Redirige al usuario a la página de inicio o a donde desees
        echo '<script>
                Swal.fire({
                    title: "Sesion Cerrada",
                    text: "Hasta luego!",
                    icon: "success",
                    showConfirmButton: true,
                    confirmButtonColor: "#3464eb",
                    confirmButtonText: "Continuar",
                    customClass: {
                        confirmButton: "rounded-button" // Identificador personalizado
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . URL . 'login/index";
                    }
                });
            </script>';
        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                    
    }

    public function index(){

         //Verificando si hay sesion
        if(!isset($_SESSION['usuario'])){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $username = $_POST['usuario'];
                $clave = $_POST['clave'];
    
                $this->usuario->set('usuario', $username);
                $this->usuario->set('clave', $clave);
    
                $user = $this->usuario->getUser();
    
               // var_dump($user['clave']);
                //die();
    
                if($user && isset($user['clave'])){
    
                    $flag = $this->verificar($user['clave'],$clave);
    
                    if($flag == true){
    
                        $_SESSION['usuario'] = $username;
    
                        echo '<script>
                                        Swal.fire({
                                            title: "Exito!",
                                            text: "Bienvenido!",
                                            icon: "success",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            confirmButtonText: "Continuar",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'inicio/index";
                                            }
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                    } else {
    
                        echo '<script>
                                Swal.fire({
                                    title: "Error...",
                                    text: "Clave invalida",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    confirmButtonText: "Continuar",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'login/index";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                    }
    
                    /*$success = "<h3>Las credenciales son correctas, Bienvenido</h3>";
                    print $success;
                    print "<br> Clave ingresada: ".$clave ;
                    print "<br> Clave de DB: ".$user[0]['clave'] ;*/
    
                } else {

                    echo '<script>
                                Swal.fire({
                                    title: "Error...",
                                    text: "Usuario invalido",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    confirmButtonText: "Continuar",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'login/index";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                } 
            }
        } else {
            echo '<script>
            Swal.fire({
                title: "Ya estas logeado!",
                text: "Bienvenido!",
                icon: "success",
                showConfirmButton: true,
                confirmButtonColor: "#3464eb",
                confirmButtonText: "Continuar",
                customClass: {
                    confirmButton: "rounded-button" // Identificador personalizado
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "' . URL . 'inicio/index";
                }
            });
            </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
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