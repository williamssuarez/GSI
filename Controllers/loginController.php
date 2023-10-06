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

            if(isset($_SESSION['pregunta1'])){

                session_unset();
                session_destroy();

            }

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

                    $preguntas = $this->usuario->getPreguntasSeguridad();

                    // Crear un array con números del 0 al 5
                    $numeros = range(0, 5);

                    // Mezclar los números
                    shuffle($numeros);

                    // Obtener los dos primeros números mezclados
                    $numerosAleatorios = array_slice($numeros, 0, 2);

                    // Asignando los numeros en variables separadas
                    $numerosAleatorio1 = $numerosAleatorios[0];
                    $numerosAleatorio2 = $numerosAleatorios[1];

                    // Usando los numeros anteriores para determinar las preguntas para el usuario
                    $pregunta1 = $preguntas[$numerosAleatorio1]['pregunta'];
                    $idpregunta1 = $preguntas[$numerosAleatorio1]['id_pregunta'];
                    $pregunta2 = $preguntas[$numerosAleatorio2]['pregunta'];
                    $idpregunta2 = $preguntas[$numerosAleatorio2]['id_pregunta'];


                    $_SESSION['idpregunta1'] = $idpregunta1;
                    $_SESSION['idpregunta2'] = $idpregunta2;
                    $_SESSION['pregunta1'] = $pregunta1;
                    $_SESSION['pregunta2'] = $pregunta2;
                    $_SESSION['id_usuario'] = $id_usuario;

                    echo '<script>
                        Swal.fire({
                            title: "Redireccionando",
                            text: "Obteniendo preguntas...",
                            icon: "success",
                            showConfirmButton: true,
                            confirmButtonColor: "#3464eb",
                            confirmButtonText: "Aceptar",
                            customClass: {
                                confirmButton: "rounded-button" // Identificador personalizado
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "' . URL . 'login/preguntas";
                            }
                        });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

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

    public function preguntas(){

        if(isset($_SESSION['usuario'])){
            echo '<script>
                        Swal.fire({
                            title: "Ya estas logeado",
                            text: "Bienvenido",
                            icon: "success",
                            showConfirmButton: true,
                            confirmButtonColor: "#3464eb",
                            confirmButtonText: "Aceptar",
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

            if(isset($_SESSION['pregunta1'])){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $idusuario = $_SESSION['id_usuario'];

                    $idpregunta1 = $_SESSION['pregunta1'];
                    $idpregunta2 = $_SESSION['pregunta2'];

                    $respuesta1 = $_POST['respuesta1'];                    
                    $respuesta2 = $_POST['respuesta1'];

                    var_dump($idusuario, $idpregunta2, $respuesta2);
                    die();
                    
                    $flag1 = $this->verificarPregunta1($idusuario, $idpregunta1, $respuesta1);
                    $flag2 = $this->verificarPregunta1($idusuario, $idpregunta2, $respuesta2);

                    

                    if( $flag1 == true && $flag2 == true ){

                        echo '<script>
                        Swal.fire({
                            title: "Validado",
                            text: "Redireccionando a formulario...",
                            icon: "success",
                            showConfirmButton: true,
                            confirmButtonColor: "#3464eb",
                            confirmButtonText: "Aceptar",
                            customClass: {
                                confirmButton: "rounded-button" // Identificador personalizado
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "' . URL . 'login/restablecerclave";
                            }
                        });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                    } else {

                        session_unset();
                        session_destroy();
                        echo '<script>
                        Swal.fire({
                            title: "Error",
                            text: "Una de las preguntas no es valida, vuelve a intentar",
                            icon: "error",
                            showConfirmButton: true,
                            confirmButtonColor: "#3464eb",
                            confirmButtonText: "Restablecer",
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
                

            } else {

                echo '<script>
                        Swal.fire({
                            title: "Error",
                            text: "No has introducido tu cedula",
                            icon: "error",
                            showConfirmButton: true,
                            confirmButtonColor: "#3464eb",
                            confirmButtonText: "Insertar",
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
    

    public function restablecerclave(){

        if(isset($_SESSION['pregunta1'])){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                $nueva_clave = $_POST['nueva_clave'];
                $confirmacion_clave = $_POST['confirmacion_clave'];
                $id = $_SESSION['id_usuario'];

                if(!empty($nueva_clave) || !empty($confirmacion_clave)){

                    if($nueva_clave == $confirmacion_clave){

                        $claveEncriptada = $this->encriptar($nueva_clave);

                        $this->usuario->set('id_user', $id);
                        $this->usuario->set('clave', $claveEncriptada);

                        $this->usuario->restablecerClave();

                        session_unset();
                        session_destroy();
                        
                        echo '<script>
                        Swal.fire({
                            title: "Exito",
                            text: "Clave restablecida exitosamente, inicia sesion",
                            icon: "success",
                            showConfirmButton: true,
                            confirmButtonColor: "#3464eb",
                            confirmButtonText: "Insertar",
                            customClass: {
                                confirmButton: "rounded-button" // Identificador personalizado
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "' . URL . 'login/index";
                            }
                        });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional



                    } else {

                    }

                } else {

                }

            }

        }

    }

    private function encriptar($clave){

        $claveHasheada = password_hash($clave, PASSWORD_DEFAULT);

        return $claveHasheada;
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

    public function verificarPregunta1($id_user, $id_pregunta, $respuestaform){

        $flag = false;

        $this->usuario->set('id_user', $id_user);
        $this->usuario->set('id_pregunta', $id_pregunta);

        $respuestadb = $this->usuario->getRespuestaPregunta();

        if(password_verify($respuestaform, $respuestadb)){

            $flag = true;

        } else {

            $flag = false;

        }

        return $flag;

    }

}

?>