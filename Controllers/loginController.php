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

                //OBTENIENDO DATOS DEL FORMULARIO
                $username = $_POST['usuario'];
                $clave = $_POST['clave'];

                //SETEANDOLOS
                $this->usuario->set('usuario', $username);
                $this->usuario->set('clave', $clave);
    
                //OBTENIENDO USUARIO
                $user = $this->usuario->getUser();
    
               // var_dump($user['clave']);
                //die();
    
                //SI EL USUARIO EXISTE
                if($user && isset($user['clave'])){
    
                    //VERIFICANDO LA CLAVE
                    $flag = $this->verificar($user['clave'],$clave);
    
                    //SI ES CORRECTA, CONTINUAR
                    if($flag == true){

                        //SI EL ROL ES ADMINISTRADOR, INICIAR SESION CON ROL 1
                        $rol = $user['rol'];
                        $cedula = $user['cedula'];
                        $id_user = $user['id_user'];
                        
                        if($rol == 1){

                            $_SESSION['id_usuario'] = $id_user;                            
                            $_SESSION['usuario'] = $username;           
                            $_SESSION['cedula_identidad'] = $cedula;
                            $_SESSION['rol'] = $rol;
    
                            echo '<script>
                                            Swal.fire({
                                                title: "Exito!",
                                                text: "Bienvenido Administrador",
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
                        //SI EL USUARIO ES OPERADOR, INICIAR SESION CON ROL 2
                        elseif($rol == 2){

                            $_SESSION['usuario'] = $username;
                            $_SESSION['rol'] = $rol;
    
                            echo '<script>
                                            Swal.fire({
                                                title: "Exito!",
                                                text: "Bienvenido Operador",
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
                    //SI LA CLAVE NO ES CORRECTA
                    else {
    
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
    
                } 
                //SI EL USUARIO NO EXISTE
                else {

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
        } 
        //SI YA HAY SESION INICIADA
        else {
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

    public function restablecer(){

        if(isset($_SESSION['usuario'])){
            
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
        //SI NO HAY SESION INICIADA
        else {
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                //OBTENIENDO DATOS DEL FORMULARIO
                $cedula = $_POST['cedula_restablecer'];

                // Validar cedula_identidad como número entero
                if (!is_numeric($cedula)) {
                    echo '<script>
                        Swal.fire({
                            title: "Error",
                            text: "La cedula debe ser numerica",
                            icon: "error",
                            showConfirmButton: true,
                            confirmButtonColor: "#3464eb",
                            confirmButtonText: "Volver",
                            customClass: {
                                confirmButton: "rounded-button" // Identificador personalizado
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "' . URL . 'login/restablecer";
                            }
                        });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                }

                //VERIFICANDO SI LA CEDULA EXISTE
                $this->usuario->set('cedula', $cedula);
                $cuenta = $this->usuario->verificarCedula();
                
                //VERIFICANDO SI LA CEDULA EXISTE
                if($cuenta['cuenta'] > 0){

                    

                    $usuario = $this->usuario->obtenerUserByCedula();

                    $id_usuario = $usuario['id_user'];

                    $this->usuario->set('id_user', $id_usuario);

                    // Crear un array con números del 1 al 6
                    $numeros = range(1, 6);

                    // Mezclar los números
                    shuffle($numeros);

                    // Obtener los dos primeros números mezclados
                    $numerosAleatorios = array_slice($numeros, 0, 2);

                    $pregunta1 = $numerosAleatorios[0];
                    $pregunta2 = $numerosAleatorios[1];

                    $this->usuario->getPreguntas();
                }
                //LA CEDULA NO EXISTE
                else{
                    echo '<script>
                        Swal.fire({
                            title: "Error",
                            text: "Esta cedula no existe",
                            icon: "error",
                            showConfirmButton: true,
                            confirmButtonColor: "#3464eb",
                            confirmButtonText: "Volver",
                            customClass: {
                                confirmButton: "rounded-button" // Identificador personalizado
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "' . URL . 'login/restablecer";
                            }
                        });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                }
        }

    }

}
    

    //VERIFICANDO CLAVE
    public function verificar($clavedb, $claveform){

        $flag = false;

        if(password_verify($claveform, $clavedb)){

            $flag = true;

        } else {

            $flag = false;

        }

        return $flag;

    }

}

?>