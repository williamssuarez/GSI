<?php namespace Controllers;

use Models\Usuario;
use Repository\Procesos1 as Repository1;

    class usuariosController{

        private $usuario;

        public function __construct()
        {
            $this->usuario = new Usuario();
            if (!isset($_SESSION['usuario'])) {
                // El usuario no está autenticado, redirige al formulario de inicio de sesión.
                echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "Tienes que inicar sesion primero!",
                    icon: "warning",
                    showConfirmButton: true,
                    confirmButtonColor: "#3464eb",
                    confirmButtonText: "Iniciar Sesion",
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

        public function index(){

            if($_SESSION['rol'] != 1){

                // El usuario no es administrador, redirige al inicio
                echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "No tienes autoridad de administrador para hacer esto",
                    icon: "warning",
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

                $datos['titulo'] = "Usuarios del sistema";
                $datos['usuarios'] = $this->usuario->lista();
                return $datos;

            }
        }

        public function num($number){
            echo "El numero que elegiste es ".$number;
        }

        public function newuser(){
           
            if($_SESSION['rol'] != 1){

                // El usuario no es administrador, redirige al inicio
                echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "No tienes autoridad de administrador para hacer esto",
                    icon: "warning",
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
                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $nombres = $_POST['nombres'];
                    $apellidos = $_POST['apellidos'];
                    $cedula = $_POST['cedula'];
                    $correo = $_POST['correo'];
                    $telefono = $_POST['telefono'];
                    //Pasando el usuario y clave a minusculas
                    $usuario = strtolower($_POST['usuario']);
                    $clave = strtolower($_POST['clave']);
                    $clave_confirmacion = strtolower($_POST['clave_confirmacion']);
                    $rol = $_POST['rol'];
    
                    //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
                    if(empty($nombres) || 
                        empty($apellidos) || 
                        empty($cedula) || 
                        empty($correo) || 
                        empty($telefono) || 
                        empty($usuario) || 
                        empty($clave) || 
                        empty($clave_confirmacion) || 
                        empty($rol)){
    
                        echo '<script>
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Parece que uno de los campos quedo vacio.",
                                        icon: "error",
                                        showConfirmButton: true,
                                        confirmButtonColor: "#3464eb",
                                        customClass: {
                                            confirmButton: "rounded-button" // Identificador personalizado
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "' . URL . 'usuarios/newuser";
                                        }
                                    });
                                </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional
    
                    } 
                    //SI NO ESTAN VACIOS PROSEGUIR
                    else {
                    
                        $errores = array();
    
                        //Validar nombre y apellido como texto
                        if (!preg_match('/^[A-Za-z\s]+$/', $nombres) || !preg_match('/^[A-Za-z\s]+$/', $apellidos)) {
                            $errores[] = "Nombre y apellido deben contener solo letras y espacios.";
                        }
                        
                        // Validar cedula_identidad como número entero
                        if (!is_numeric($cedula)) {
                            $errores[] = "Cédula de identidad debe ser un número entero.";
                        }
                    
                        //Validar nombre y apellido como texto
                        if (!preg_match('/^[A-Za-z\s]+$/', $usuario)) {
                            $errores[] = "El nombre de usuario debe contener solo letras y espacios.";
                        }
    
                        if (empty($errores)) {
    
                            // No hay errores de validación, procesa los datos                        
                            $this->usuario->set('cedula', $cedula);
                            $this->usuario->set('usuario', $usuario);
                            $this->usuario->set('correo', $correo);
                            $this->usuario->set('telefono', $telefono);                        
    
                            //VERIFICANDO SI LA CEDULA YA EXISTE
                            $cuenta = $this->usuario->verificarCedula();
                            $cuenta_usuario = $this->usuario->verificarUsuario();
                            $cuenta_correo = $this->usuario->verificarCorreo();
                            $cuenta_telefono = $this->usuario->verificarTelefono(); 
    
                            //SI YA EXISTE, REDIRIGIR DE NUEVO AL FORMULARIO CON MENSAJE DE ERROR
                            if($cuenta['cuenta'] > 0){
    
                                echo '<script>
                                            Swal.fire({
                                                title: "Error!",
                                                text: "Esta Cedula ya existe.",
                                                icon: "error",
                                                showConfirmButton: true,
                                                confirmButtonColor: "#3464eb",
                                                customClass: {
                                                    confirmButton: "rounded-button" // Identificador personalizado
                                                }
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "' . URL . 'usuarios/newuser";
                                                }
                                            });
                                        </script>';
                                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                            } 
                            elseif($cuenta_usuario['cuenta'] > 0){
    
                                echo '<script>
                                            Swal.fire({
                                                title: "Error!",
                                                text: "Esta nombre de usuario ya existe.",
                                                icon: "error",
                                                showConfirmButton: true,
                                                confirmButtonColor: "#3464eb",
                                                customClass: {
                                                    confirmButton: "rounded-button" // Identificador personalizado
                                                }
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "' . URL . 'usuarios/newuser";
                                                }
                                            });
                                        </script>';
                                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                            }
                            elseif($cuenta_correo['cuenta'] > 0){
    
                                echo '<script>
                                            Swal.fire({
                                                title: "Error!",
                                                text: "Esta correo ya existe.",
                                                icon: "error",
                                                showConfirmButton: true,
                                                confirmButtonColor: "#3464eb",
                                                customClass: {
                                                    confirmButton: "rounded-button" // Identificador personalizado
                                                }
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "' . URL . 'usuarios/newuser";
                                                }
                                            });
                                        </script>';
                                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                            }
                            elseif($cuenta_telefono['cuenta'] > 0){
    
                                echo '<script>
                                            Swal.fire({
                                                title: "Error!",
                                                text: "Este numero de telefono ya existe.",
                                                icon: "error",
                                                showConfirmButton: true,
                                                confirmButtonColor: "#3464eb",
                                                customClass: {
                                                    confirmButton: "rounded-button" // Identificador personalizado
                                                }
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "' . URL . 'usuarios/newuser";
                                                }
                                            });
                                        </script>';
                                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                            }
                            else {
    
                                if($clave == $clave_confirmacion){
    
                                    //ENCRIPTANDO LA CLAVE
                                    $claveEncriptada = $this->encriptar($clave);
    
                                    //PREPARANDO LOS DATOS PARA INSERTAR
                                    $this->usuario->set('nombres', $nombres);
                                    $this->usuario->set('apellidos', $apellidos);
                                    $this->usuario->set('rol', $rol);
                                    $this->usuario->set('clave', $claveEncriptada);
    
    
                                        //INSERTANDO
                                        $this->usuario->add();
    
                                        //REDIRECCIONANDO
                                        echo '<script>
                                                    Swal.fire({
                                                        title: "Exito!",
                                                        text: "Usuario agregado exitosamente.",
                                                        icon: "success",
                                                        showConfirmButton: true,
                                                        confirmButtonColor: "#3464eb",
                                                        customClass: {
                                                            confirmButton: "rounded-button" // Identificador personalizado
                                                        }
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href = "' . URL . 'usuarios/index";
                                                        }
                                                    });
                                                </script>';
                                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                                } else {
                                    
                                    echo '<script>
                                            Swal.fire({
                                                title: "Error!",
                                                text: "Las claves no coinciden",
                                                icon: "error",
                                                showConfirmButton: true,
                                                confirmButtonColor: "#3464eb",
                                                customClass: {
                                                    confirmButton: "rounded-button" // Identificador personalizado
                                                }
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "' . URL . 'usuarios/newuser";
                                                }
                                            });
                                        </script>';
                                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                                    
                                }
    
                            }
                            
                            }
                        
                    }
    
                }
            }                        

        }

        private function encriptar($clave){

            $claveHasheada = password_hash($clave, PASSWORD_DEFAULT);

            return $claveHasheada;
        }

        public function editarperfilOperador($usuario){

            if($usuario != $_SESSION['usuario']){

                echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "No eres administrdor para hacer esto",
                                    icon: "warning",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
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

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $usuario = $_SESSION['usuario'];
                    $nombres = $_POST['nombres'];
                    $apellidos = $_POST['apellidos'];
                    $cedula = $_POST['cedula'];
                    $correo = $_POST['correo'];
                    $telefono = $_POST['telefono'];

                    $this->usuario->set('usuario',$usuario);
                    $this->usuario->set('nombres', $nombres);
                    $this->usuario->set('apellidos', $apellidos);
                    $this->usuario->set('cedula', $cedula);
                    $this->usuario->set('correo', $correo);
                    $this->usuario->set('telefono', $telefono);
    
                    $this->usuario->edit();
    
                    echo '<script>
                            Swal.fire({
                                title: "Exito",
                                text: "Datos editados",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                }
                            });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }  
                
                $this->usuario->set('usuario',$usuario);
                $data['titulo'] = "Editando Datos del operador";
                $data['operador'] = $this->usuario->getDataEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;


            }

        }

        public function editarperfilAdmin($usuario){

                if($_SESSION['rol'] == 1){

                    if($_SERVER['REQUEST_METHOD'] == 'POST'){

                        $usuario = $_SESSION['usuario'];
                        $nombres = $_POST['nombres'];
                        $apellidos = $_POST['apellidos'];
                        $cedula = $_POST['cedula'];
                        $correo = $_POST['correo'];
                        $telefono = $_POST['telefono'];
    
                        $this->usuario->set('usuario',$usuario);
                        $this->usuario->set('nombres', $nombres);
                        $this->usuario->set('apellidos', $apellidos);
                        $this->usuario->set('cedula', $cedula);
                        $this->usuario->set('correo', $correo);
                        $this->usuario->set('telefono', $telefono);
        
                        $this->usuario->edit();
        
                        echo '<script>
                                Swal.fire({
                                    title: "Exito",
                                    text: "Datos del usuario editados",
                                    icon: "success",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/index";
                                    }
                                });
                            </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
        
                    }  
                    
                    $this->usuario->set('usuario',$usuario);
                    $data['titulo'] = "Editando Datos del operador";
                    $data['operador'] = $this->usuario->getDataEdit();
    
                    //var_dump($data['operador']);
                    //die(); 
    
                    return $data;

                } else {

                    echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "No eres administrador",
                                    icon: "warning",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
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

        public function cambiarcredencialesAdmin($usuario){

            if($_SESSION['rol'] == 1){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $current_user = $usuario;
                    $user = $_POST['usuario'];
                    $nueva_clave = strtolower($_POST['nueva_clave']);
                    $clave_confirmacion = strtolower($_POST['clave_confirmacion']);
                    $rol = $_POST['rol'];


                    //validando que no esten vacios los datos
                    if(!empty($user) || !empty($nueva_clave) || !empty($clave_confirmacion)){

                        $this->usuario->set('usuario',$user);

                        $cuenta = $this->usuario->verificarUsuario();

                        if($cuenta['cuenta'] > 0){

                            if($user == $current_user){

                                if($nueva_clave == $clave_confirmacion){

                                    $claveHash = $this->encriptarNuevaClave($nueva_clave);

                                    if($usuario == $_SESSION['usuario']){

                                        $this->usuario->set('current_user', $current_user);
                                        $this->usuario->set('usuario', $user);
                                        $this->usuario->set('clave', $claveHash);
                                        $this->usuario->set('rol', 1);
                        
                                        $this->usuario->editCredencialesAdmin();
        
                                        session_unset();
                                        session_destroy();
                        
                                        echo '<script>
                                                Swal.fire({
                                                    title: "Exito",
                                                    text: "Credenciales editadas, vuelve a iniciar sesion",
                                                    icon: "success",
                                                    showConfirmButton: true,
                                                    confirmButtonColor: "#3464eb",
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

                                        $this->usuario->set('current_user', $current_user);
                                        $this->usuario->set('usuario', $user);
                                        $this->usuario->set('clave', $claveHash);
                                        $this->usuario->set('rol', $rol);
                        
                                        $this->usuario->editCredencialesAdmin();
                        
                                        echo '<script>
                                                Swal.fire({
                                                    title: "Exito",
                                                    text: "Credenciales editadas, notifiquele al usuario del cambio",
                                                    icon: "success",
                                                    showConfirmButton: true,
                                                    confirmButtonColor: "#3464eb",
                                                    customClass: {
                                                        confirmButton: "rounded-button" // Identificador personalizado
                                                    }
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = "' . URL . 'usuarios/index";
                                                    }
                                                });
                                            </script>';
                                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                                    }
    
                                    
    
                                } else {
    
                                    echo '<script>
                                        Swal.fire({
                                            title: "Error",
                                            text: "las claves no coinciden, vuelve a intentar",
                                            icon: "error",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                            }
                                        });
                                        </script>';
                                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                                }
                            }

                            echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Este nombre de usuario ya existe",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/cambiarcredencialesAdmin/' . $_SESSION['usuario'] . '";
                                    }
                                });
                                </script>';
                             exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.


                        } else {

                            if($nueva_clave == $clave_confirmacion){

                                $claveHash = $this->encriptarNuevaClave($nueva_clave);

                                if($usuario == $_SESSION['usuario']){

                                    $this->usuario->set('current_user', $current_user);
                                    $this->usuario->set('usuario', $user);
                                    $this->usuario->set('clave', $claveHash);
                                    $this->usuario->set('rol', 1);
                    
                                    $this->usuario->editCredencialesAdmin();
    
                                    session_unset();
                                    session_destroy();
                    
                                    echo '<script>
                                            Swal.fire({
                                                title: "Exito",
                                                text: "Credenciales editadas, vuelve a iniciar sesion",
                                                icon: "success",
                                                showConfirmButton: true,
                                                confirmButtonColor: "#3464eb",
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

                                    $this->usuario->set('current_user', $current_user);
                                    $this->usuario->set('usuario', $user);
                                    $this->usuario->set('clave', $claveHash);
                                    $this->usuario->set('rol', $rol);
                    
                                    $this->usuario->editCredencialesAdmin();
    
                                    session_unset();
                                    session_destroy();
                    
                                    echo '<script>
                                            Swal.fire({
                                                title: "Exito",
                                                text: "Credenciales editadas, vuelve a iniciar sesion",
                                                icon: "success",
                                                showConfirmButton: true,
                                                confirmButtonColor: "#3464eb",
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

                                }

                            } else {

                                echo '<script>
                                    Swal.fire({
                                        title: "Error",
                                        text: "las claves no coinciden, vuelve a intentar",
                                        icon: "error",
                                        showConfirmButton: true,
                                        confirmButtonColor: "#3464eb",
                                        customClass: {
                                            confirmButton: "rounded-button" // Identificador personalizado
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                        }
                                    });
                                    </script>';
                                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                            }
                            

                        }

                    } else {

                        //Si estan vacios, redirigir y salir del script
                        echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Parece que uno de los campos quedo vacio, vuelve a intentar",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                    }
                                });
                            </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                    }
    
                }  
                
                $this->usuario->set('usuario',$usuario);
                $data['titulo'] = "Editando Datos del operador";
                $data['operador'] = $this->usuario->getDataEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;

            } else {

                echo '<script>
                            Swal.fire({
                                title: "Error",
                                text: "No eres administrador",
                                icon: "warning",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
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

        public function cambiarcredencialesOperador($usuario){
            
            if($usuario != $_SESSION['usuario']){

                echo '<script>
                            Swal.fire({
                                title: "Error",
                                text: "No eres administrador",
                                icon: "warning",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                }
                            });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            } else {

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $current_user = $usuario;
                    $user = $_POST['usuario'];
                    $nueva_clave = strtolower($_POST['nueva_clave']);
                    $clave_confirmacion = strtolower($_POST['clave_confirmacion']);


                    //validando que no esten vacios los datos
                    if(!empty($user) || !empty($nueva_clave) || !empty($clave_confirmacion)){

                        $this->usuario->set('usuario',$user);

                        $cuenta = $this->usuario->verificarUsuario();

                        if($cuenta['cuenta'] > 0){

                            if($user == $_SESSION['usuario']){

                                if($nueva_clave == $clave_confirmacion){

                                    $claveHash = $this->encriptarNuevaClave($nueva_clave);
    
                                    $this->usuario->set('current_user', $current_user);
                                    $this->usuario->set('usuario', $user);
                                    $this->usuario->set('clave', $claveHash);
    
                                    $this->usuario->editCredencialesOperador();
    
                                    session_unset();
                                    session_destroy();
                    
                                    echo '<script>
                                            Swal.fire({
                                                title: "Exito",
                                                text: "Credenciales editadas, vuelve a iniciar sesion",
                                                icon: "success",
                                                showConfirmButton: true,
                                                confirmButtonColor: "#3464eb",
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
    
                                    echo '<script>
                                    Swal.fire({
                                        title: "Error",
                                        text: "las claves no coinciden, vuelve a intentar",
                                        icon: "error",
                                        showConfirmButton: true,
                                        confirmButtonColor: "#3464eb",
                                        customClass: {
                                            confirmButton: "rounded-button" // Identificador personalizado
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                        }
                                    });
                                </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                            }

                            }

                            echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Este nombre de usuario ya existe",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                    }
                                });
                                </script>';
                             exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.


                        } else {

                            if($nueva_clave == $clave_confirmacion){

                                $claveHash = $this->encriptarNuevaClave($nueva_clave);

                                $this->usuario->set('current_user', $current_user);
                                $this->usuario->set('usuario', $user);
                                $this->usuario->set('clave', $claveHash);

                                $this->usuario->editCredencialesOperador();

                                session_unset();
                                session_destroy();
                
                                echo '<script>
                                        Swal.fire({
                                            title: "Exito",
                                            text: "Credenciales editadas, vuelve a iniciar sesion",
                                            icon: "success",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
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

                                echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "las claves no coinciden, vuelve a intentar",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                    }
                                });
                            </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        }
                            

                    }

                    } else {

                        //Si estan vacios, redirigir y salir del script
                        echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Parece que uno de los campos quedo vacio, vuelve a intentar",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                    }
                                });
                            </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                    }
    
                }  
                
                $this->usuario->set('usuario',$usuario);
                $data['titulo'] = "Editando credenciales del usuario";
                $data['operador'] = $this->usuario->getDataEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;


            }

        }

        

        public function profile($usuario){

            $this->usuario->set('usuario', $usuario);

            $datos['titulo'] = "Datos del usuario";
            $datos['user'] = $this->usuario->view();

            if($_SESSION['rol'] == 1){

                return $datos;

            } else {

                if($usuario == $_SESSION['usuario']){

                    return $datos;
    
                } else {
    
                    echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "No eres administrador para acceder",
                                    icon: "warning",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
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
            

    }

    private function encriptarNuevaClave($clave){

        $claveHasheada = password_hash($clave, PASSWORD_DEFAULT);

        return $claveHasheada;
    }

    public function editarpreguntasSeguridad($usuario){

        if($usuario == $_SESSION['usuario']){

            //OBTENEMOS EL ID DEL USUARIO
            $this->usuario->set('usuario', $usuario);
            $id_user = $this->usuario->getIdUserbyUsuario();

            //SETEAR EL ID DE USUARIO PARA ENCONTRAR LAS PREGUNTAS QUE LE PERTENECEN
            $this->usuario->set('id_user', $id_user['id_user']);
            $cuenta = $this->usuario->verificarPreguntasExistencia();

            if($cuenta['cuenta'] > 0){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $respuesta1 = strtolower($_POST['respuesta1']);
                    $respuesta2 = strtolower($_POST['respuesta2']);
                    $respuesta3 = strtolower($_POST['respuesta3']);
                    $respuesta4 = strtolower($_POST['respuesta4']);
                    $respuesta5 = strtolower($_POST['respuesta5']);
                    $respuesta6 = strtolower($_POST['respuesta6']);

                    if(!empty($respuesta1) || !empty($respuesta2) || !empty($respuesta3) || !empty($respuesta4) || !empty($respuesta5) || !empty($respuesta6) ){

                        //Validar nombre y apellido como texto
                        if (!preg_match('/^[A-Za-z\s]+$/', $respuesta1) || 
                            !preg_match('/^[A-Za-z\s]+$/', $respuesta2) ||
                            !preg_match('/^[A-Za-z\s]+$/', $respuesta3) ||
                            !preg_match('/^[A-Za-z\s]+$/', $respuesta4) ||
                            !preg_match('/^[A-Za-z\s]+$/', $respuesta5) ||
                            !preg_match('/^[A-Za-z\s]+$/', $respuesta6) ) {
                                echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Las respuestas deben ser en letra, si escribes algo numerico escribelo en letra",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/editarpreguntasSeguridad/' . $_SESSION['usuario'] . '";
                                    }
                                });
                            </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional
                        } else {

                            $id = $id_user['id_user'];

                            //EDITANDO PREGUNTA 1
                            $id_pregunta1 = 1;
                            $resp1 = $this->encriptarNuevaClave($respuesta1);                        
                            $this->editarPreguntas1($id, $id_pregunta1, $resp1);

                            //EDITANDO PREGUNTA 2
                            $id_pregunta2 = 2;
                            $resp2 = $this->encriptarNuevaClave($respuesta2);                        
                            $this->editarPreguntas1($id, $id_pregunta2, $resp2);

                            //EDITANDO PREGUNTA 3
                            $id_pregunta3 = 3;
                            $resp3 = $this->encriptarNuevaClave($respuesta3);                        
                            $this->editarPreguntas1($id, $id_pregunta3, $resp3);

                            //EDITANDO PREGUNTA 4
                            $id_pregunta4 = 4;
                            $resp4 = $this->encriptarNuevaClave($respuesta4);                        
                            $this->editarPreguntas1($id, $id_pregunta4, $resp4);

                            //EDITANDO PREGUNTA 5
                            $id_pregunta5 = 5;
                            $resp5 = $this->encriptarNuevaClave($respuesta5);                        
                            $this->editarPreguntas1($id, $id_pregunta5, $resp5);

                            //EDITANDO PREGUNTA 6
                            $id_pregunta6 = 6;
                            $resp6 = $this->encriptarNuevaClave($respuesta6);                        
                            $this->editarPreguntas1($id, $id_pregunta6, $resp6);

                            echo '<script>
                                Swal.fire({
                                    title: "Exito",
                                    text: "Respuestas editadas exitosamente",
                                    icon: "success",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                            
                        }


                    } else {
                        echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Parece que uno de los campos quedo vacio",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                    }
                                });
                                </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional
                    }
                }

                $this->usuario->set('usuario',$usuario);
                $data['titulo'] = "Editando preguntas de seguridad del usuario";
                $data['operador'] = $this->usuario->getDataEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;
                
                 

            } else {

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $respuesta1 = strtolower($_POST['respuesta1']);
                    $respuesta2 = strtolower($_POST['respuesta2']);
                    $respuesta3 = strtolower($_POST['respuesta3']);
                    $respuesta4 = strtolower($_POST['respuesta4']);
                    $respuesta5 = strtolower($_POST['respuesta5']);
                    $respuesta6 = strtolower($_POST['respuesta6']);

                    if(!empty($respuesta1) || !empty($respuesta2) || !empty($respuesta3) || !empty($respuesta4) || !empty($respuesta5) || !empty($respuesta6) ){

                        //Validar nombre y apellido como texto
                        if (!preg_match('/^[A-Za-z\s]+$/', $respuesta1) || 
                            !preg_match('/^[A-Za-z\s]+$/', $respuesta2) ||
                            !preg_match('/^[A-Za-z\s]+$/', $respuesta3) ||
                            !preg_match('/^[A-Za-z\s]+$/', $respuesta4) ||
                            !preg_match('/^[A-Za-z\s]+$/', $respuesta5) ||
                            !preg_match('/^[A-Za-z\s]+$/', $respuesta6) ) {
                                echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Las respuestas deben ser en letra, si escribes algo numerico escribelo en letra",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/editarpreguntasSeguridad/' . $_SESSION['usuario'] . '";
                                    }
                                });
                            </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional
                        } else {

                            $id = $id_user['id_user'];

                            //CREANDO RESPUESTA 1
                            $id_pregunta1 = 1;
                            $resp1 = $this->encriptarNuevaClave($respuesta1);                        
                            $this->insertarRespuesta1($id, $id_pregunta1, $resp1);

                            //CREANDO RESPUESTA 1
                            $id_pregunta2 = 2;
                            $resp2 = $this->encriptarNuevaClave($respuesta2);                        
                            $this->insertarRespuesta1($id, $id_pregunta2, $resp2);

                            //CREANDO RESPUESTA 1
                            $id_pregunta3 = 3;
                            $resp3 = $this->encriptarNuevaClave($respuesta3);                        
                            $this->insertarRespuesta1($id, $id_pregunta3, $resp3);

                            //CREANDO RESPUESTA 1
                            $id_pregunta4 = 4;
                            $resp4 = $this->encriptarNuevaClave($respuesta4);                        
                            $this->insertarRespuesta1($id, $id_pregunta4, $resp4);

                            //CREANDO RESPUESTA 1
                            $id_pregunta5 = 5;
                            $resp5 = $this->encriptarNuevaClave($respuesta5);                        
                            $this->insertarRespuesta1($id, $id_pregunta5, $resp5);

                            //CREANDO RESPUESTA 1
                            $id_pregunta6 = 6;
                            $resp6 = $this->encriptarNuevaClave($respuesta6);                        
                            $this->insertarRespuesta1($id, $id_pregunta6, $resp6);

                            echo '<script>
                                Swal.fire({
                                    title: "Exito",
                                    text: "Respuestas editadas exitosamente",
                                    icon: "success",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                            
                        }


                    } else {
                        echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Parece que uno de los campos quedo vacio",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                                    }
                                });
                                </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional
                    }
                }

                $this->usuario->set('usuario',$usuario);
                $data['titulo'] = "Creando preguntas de seguridad del usuario";
                $data['operador'] = $this->usuario->getDataEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;
            }

        } else {

            echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Solo puedes editar tus propias preguntas de seguridad",
                        icon: "error",
                        showConfirmButton: true,
                        confirmButtonColor: "#3464eb",
                        customClass: {
                            confirmButton: "rounded-button" // Identificador personalizado
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "' . URL . 'usuarios/profile/' . $_SESSION['usuario'] . '";
                        }
                    });
                    </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

        }

    }

    public function editarPreguntas1($id_user, $id_pregunta, $respuesta){

        $this->usuario->set('id_user', $id_user);
        $this->usuario->set('id_pregunta', $id_pregunta);
        $this->usuario->set('respuesta', $respuesta);

        $this->usuario->editarPreguntas();

    }

    public function insertarRespuesta1($id_user, $id_pregunta, $respuesta){

        $this->usuario->set('id_user', $id_user);
        $this->usuario->set('id_pregunta', $id_pregunta);
        $this->usuario->set('respuesta', $respuesta);

        $this->usuario->insertarPreguntas();

    }

}
      

    $usuarios = new usuariosController();
?>