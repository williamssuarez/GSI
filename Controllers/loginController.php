<?php namespace Controllers;

use Models\Usuario;
use Models\Auditoria;

class loginController{

    private $usuario;
    private $auditoria;

    public function __construct(){

        $this->usuario = new Usuario();
        $this->auditoria = new Auditoria();

    }

    public function logout(){

        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
        $this->usuario->set('usuario', $_SESSION['usuario']);
        $id_user = $this->usuario->getIdUserbyUsuario();
        $user = $id_user['id_user'];

        $tipo_cambio = 7; //TIPO DE CAMBIO 7 = CIERRE DE SESION
        $tabla_afectada = "Ninguna";
        $registro_afectado = "Ninguno";
        $valor_antes = "Ninguno";
        $valor_despues = "Ninguno";
        $usuario = $user;

        //EJECUTANDO LA AUDITORIA
        $this->auditoria->auditar($tipo_cambio, $tabla_afectada, $registro_afectado, $valor_antes, $valor_despues, $usuario);


        session_unset(); // Limpia todas las variables de sesión.
        session_destroy(); // Destruye la sesión.
        
        // Redirige al usuario a la página de inicio o a donde desees
        echo '<script>
                Swal.fire({
                    title: "Sesion Cerrada",
                    text: "Hasta luego",
                    icon: "success",
                    timer: 1000,
                    showConfirmButton: false,
                }).then(() => {
                    window.location.href = "' . URL . 'login/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                });
            </script>';
        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                    
    }

    public function index(){

         //Verificando si hay sesion
        if(!isset($_SESSION['usuario'])){

            if(isset($_SESSION['pregunta1']) || isset($_SESSION['flags'])){

                session_unset();
                session_destroy();

            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                //OBTENIENDO DATOS DEL FORMULARIO Y PASANDOLOS A MINUSCULAS
                $username = strtolower($_POST['usuario']);
                $clave = strtolower($_POST['clave']);

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

                        //SI LA CUENTA ESTA DESACTIVADA, DENEGAR EL ACCESO
                        if($user['estado'] == 1){

                            echo '<script>
                                            Swal.fire({
                                                title: "Vaya...",
                                                text: "Parece que tu cuenta esta desactivada, solicitele al administrador una reactivacion",
                                                icon: "warning",
                                                showConfirmButton: true,
                                                confirmButtonColor: "#3464eb",
                                                confirmButtonText: "Aceptar",
                                                customClass: {
                                                    confirmButton: "rounded-button" // Identificador personalizado
                                                }
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "' . URL . 'login/index";
                                                }
                                            }).then(() => {
                                                window.location.href = "' . URL . 'login/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                            });
                                        </script>';
                                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        }

                        //SI EL ROL ES ADMINISTRADOR, INICIAR SESION CON ROL 1
                        $rol = $user['rol'];
                        $cedula = $user['cedula'];
                        $id_user = $user['id_user'];

                            $tipo_cambio = 6; //TIPO DE CAMBIO 6 = INICIO DE SESION
                            $tabla_afectada = "Ninguna";
                            $registro_afectado = "Ninguno";
                            $valor_antes = "Ninguno";
                            $valor_despues = "Ninguno";
                            $usuario = $id_user;

                            //EJECUTANDO LA AUDITORIA
                            $this->auditoria->auditar($tipo_cambio, $tabla_afectada, $registro_afectado, $valor_antes, $valor_despues, $usuario);

                        
                        if($rol == 1){

                            $_SESSION['id_usuario'] = $id_user;                            
                            $_SESSION['usuario'] = $username;           
                            $_SESSION['cedula_identidad'] = $cedula;
                            $_SESSION['rol'] = $rol;

    
                            echo '<script>
                                            Swal.fire({
                                                title: "Exito",
                                                text: "Bienvenido Administrador",
                                                icon: "success",
                                                timer: 1000,
                                                showConfirmButton: false,
                                            }).then(() => {
                                                window.location.href = "' . URL . 'inicio/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                            });
                                        </script>';
                                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        } 
                        //SI EL USUARIO ES OPERADOR, INICIAR SESION CON ROL 2
                        elseif($rol == 2){

                            $_SESSION['usuario'] = $username;
                            $_SESSION['rol'] = $rol;

                            $tipo_cambio = 6; //TIPO DE CAMBIO 6 = INICIO DE SESION
                            $tabla_afectada = "Ninguna";
                            $registro_afectado = "Ninguno";
                            $valor_antes = "Ninguno";
                            $valor_despues = "Ninguno";
                            $usuario = $id_user;

                            //EJECUTANDO LA AUDITORIA
                            $this->auditoria->auditar($tipo_cambio, $tabla_afectada, $registro_afectado, $valor_antes, $valor_despues, $usuario);

    
                            echo '<script>
                                            Swal.fire({
                                                title: "Exito",
                                                text: "Bienvenido Operador",
                                                icon: "success",
                                                timer: 1000,
                                                showConfirmButton: false,
                                            }).then(() => {
                                                window.location.href = "' . URL . 'inicio/index"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                                }).then(() => {
                                    window.location.href = "' . URL . 'login/index"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                                }).then(() => {
                                    window.location.href = "' . URL . 'login/index"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                title: "Ya estas logeado",
                text: "¡Bienvenido!",
                icon: "success",
                timer: 1000,
                showConfirmButton: false,
            }).then(() => {
                window.location.href = "' . URL . 'inicio/index"; // Esta línea se ejecutará cuando se cierre la alerta.
            });
            </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
        }
    }

    public function restablecer(){

        if(isset($_SESSION['usuario'])){
            
            echo '<script>
            Swal.fire({
                title: "Ya estas logeado",
                text: "¡Bienvenido!",
                icon: "success",
                timer: 1000,
                showConfirmButton: false,
            }).then(() => {
                window.location.href = "' . URL . 'inicio/index"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                        }).then(() => {
                            window.location.href = "' . URL . 'login/restablecer"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                            timer: 1000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.href = "' . URL . 'login/preguntas"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                        }).then(() => {
                            window.location.href = "' . URL . 'login/restablecer"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                            timer: 1000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.href = "' . URL . 'inicio/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                        });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
        } else {

            if(isset($_SESSION['pregunta1'])){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $idusuario = $_SESSION['id_usuario'];

                    $idpregunta1 = $_SESSION['idpregunta1'];
                    $idpregunta2 = $_SESSION['idpregunta1'];

                    //OBTENIENDO RESPUESTA Y PASANDOLO A MINUSCULAS
                    $respuesta1 = strtolower($_POST['respuesta1']);                    
                    $respuesta2 = strtolower($_POST['respuesta1']);

                    /*var_dump($idusuario, $idpregunta2, $respuesta2);
                    die();*/
                    
                    $flag1 = $this->verificarPregunta1($idusuario, $idpregunta1, $respuesta1);
                    $flag2 = $this->verificarPregunta1($idusuario, $idpregunta2, $respuesta2);
                    

                    if( $flag1 == true && $flag2 == true ){

                        $_SESSION['flags'] = 'ambas son true';
                        echo '<script>
                        Swal.fire({
                            title: "Validado",
                            text: "Redireccionando a formulario...",
                            icon: "success",
                            timer: 1000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.href = "' . URL . 'login/restablecerclave"; // Esta línea se ejecutará cuando se cierre la alerta.
                        });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                    } else {

                        session_unset();
                        session_destroy();
                        echo '<script>
                        Swal.fire({
                            title: "Error",
                            text: "Una de las respuestas no es valida, vuelve a intentar",
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
                            }).then(() => {
                                window.location.href = "' . URL . 'login/restablecer"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                        }).then(() => {
                            window.location.href = "' . URL . 'login/restablecer"; // Esta línea se ejecutará cuando se cierre la alerta.
                        });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

        }
        
    }
    

    public function restablecerclave(){

        if(isset($_SESSION['flags'])){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                $nuevo_usuario = $_POST['nuevo_usuario'];
                $nueva_clave = $_POST['nueva_clave'];
                $confirmacion_clave = $_POST['confirmacion_clave'];
                $id = $_SESSION['id_usuario'];

                if(!empty($nueva_clave) || !empty($confirmacion_clave) || !empty($nuevo_usuario)){

                    if($nueva_clave == $confirmacion_clave){

                        $claveEncriptada = $this->encriptar($nueva_clave);

                        $this->usuario->set('id_user', $id);
                        $this->usuario->set('usuario', $nuevo_usuario);
                        $this->usuario->set('clave', $claveEncriptada);

                        $this->usuario->restablecerClaveyUsuario();
                        
                        session_unset();
                        session_destroy();
                        
                        echo '<script>
                        Swal.fire({
                            title: "Exito",
                            text: "Clave y usuario restablecido exitosamente, inicia sesion",
                            icon: "success",
                            timer: 1000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.href = "' . URL . 'login/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                        });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                    } else {
                        //SI LAS CLAVES NO COINCIDEN
                        echo '<script>
                        Swal.fire({
                            title: "Error",
                            text: "Las claves no coinciden, vuelve a intentar",
                            icon: "error",
                            showConfirmButton: true,
                            confirmButtonColor: "#3464eb",
                            confirmButtonText: "Volver",
                            customClass: {
                                confirmButton: "rounded-button" // Identificador personalizado
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "' . URL . 'login/restablecerclave";
                            }
                        }).then(() => {
                            window.location.href = "' . URL . 'login/restablecerclave"; // Esta línea se ejecutará cuando se cierre la alerta.
                        });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                    }

                } else {

                    //SI UNO DE LOS CAMPOS ESTA VACIO
                    echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Parece que uno de los campos quedo vacio, vuelve a intentar",
                        icon: "error",
                        showConfirmButton: true,
                        confirmButtonColor: "#3464eb",
                        confirmButtonText: "Volver",
                        customClass: {
                            confirmButton: "rounded-button" // Identificador personalizado
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "' . URL . 'login/restablecerclave";
                        }
                    }).then(() => {
                        window.location.href = "' . URL . 'login/restablecerclave"; // Esta línea se ejecutará cuando se cierre la alerta.
                    });
                    </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                }

            }

        } else {

            //SI LAS BANDERAS NO ESTAN INICIADAS
            echo '<script>
            Swal.fire({
                title: "Error",
                text: "Tienes que iniciar las preguntas",
                icon: "error",
                showConfirmButton: true,
                confirmButtonColor: "#3464eb",
                confirmButtonText: "Volver",
                customClass: {
                    confirmButton: "rounded-button" // Identificador personalizado
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "' . URL . 'inicio/index";
                }
            }).then(() => {
                window.location.href = "' . URL . 'inicio/index"; // Esta línea se ejecutará cuando se cierre la alerta.
            });
            </script>';
        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional
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

        if(password_verify($respuestaform, $respuestadb['respuesta'])){

            $flag = true;

        } else {

            $flag = false;

        }

        return $flag;

    }

}

?>