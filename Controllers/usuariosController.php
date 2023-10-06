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
                    $usuario = $_POST['usuario'];
                    $clave = $_POST['clave'];
                    $clave_confirmacion = $_POST['clave_confirmacion'];
                    $rol = $_POST['rol'];
    
                    //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
                    if(empty($nombres) || empty($apellidos) || empty($cedula) || empty($usuario) || empty($clave) || empty($clave_confirmacion) || empty($rol)){
    
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
    
                            //VERIFICANDO SI LA CEDULA YA EXISTE
                            $cuenta = $this->usuario->verificarCedula();
                            $cuenta_usuario = $this->usuario->verificarUsuario(); 
    
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

        public function delete($id){

            if($_SERVER['REQUEST_METHOD'] == 'GET'){

                $this->sistemas->set('id_os', $id);

                $this->sistemas->delete();

                echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Eliminado Exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'sistemas/index";
                                }
                            });
                        </script>';
                exit;
            }
        }

        public function edit($id){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $this->sistemas->set('id_os',$id);
                    $nombre = $_POST['nombre'];
                    $tipo = $_POST['tipo'];

                    $this->sistemas->set('nombre', $nombre);
                    $this->sistemas->set('tipo', $tipo);
    
                    $this->sistemas->edit();
    
                    echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Editado Exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'sistemas/index";
                                }
                            });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }  
                
                $this->sistemas->set('id_os',$id);
                $data['titulo'] = "Editando Nombre del Sistema Operativo";
                $data['sistemas'] = $this->sistemas->getDataEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;
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
      
}

    $usuarios = new usuariosController();
?>