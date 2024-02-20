<?php namespace Controllers;

use Models\Dispositivos;
use Models\Auditoria;
use Models\Usuario;
use Models\Categoria_dispositivos;

    class categoriaController{

        private $dispositivos;
        private $auditoria;
        private $usuarios;
        private $categoria_dispositivos;

        public function __construct()
        {
            $this->dispositivos = new Dispositivos();
            $this->auditoria = new Auditoria();
            $this->usuarios = new Usuario();
            $this->categoria_dispositivos = new Categoria_dispositivos();

            if (!isset($_SESSION['usuario'])) {
                // El usuario no está autenticado, muestra la alerta y redirige al formulario de inicio de sesión.
                echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "Tienes que iniciar sesión primero!",
                    icon: "warning",
                    showConfirmButton: true,
                    confirmButtonColor: "#3464eb",
                    confirmButtonText: "Iniciar Sesión",
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
            if($_SESSION['rol'] != 1){

                //OBTENIENDO DATA PARA AUDITAR EL ACCESO NO AUTORIZADO

                    //OBTENIENDO DATOS DEL USUARIO NO ADMIN QUE INTENTO ACCEDER 
                    $this->usuarios->set('usuario', $_SESSION['usuario']);
                    $id_user = $this->usuarios->getIdUserbyUsuario();
                    $user = $id_user['id_user'];

                    //PREPARANDO AUDITORIA
                    $tipo_cambio = 12; //ACCESO NO AUTORIZADO
                    $tabla_afectada = 'categoria';

                    $registro_afectado = "Ninguno";
                    $valor_antes = "Ninguno";
                    $valor_despues = "Ninguno";
                    $id_usuario_noAdmin  = $user;

                    //EJECUTANDO LA AUDITORIA
                    $this->auditoria->auditar($tipo_cambio, 
                                            $tabla_afectada, 
                                            $registro_afectado, 
                                            $valor_antes, 
                                            $valor_despues, 
                                            $id_usuario_noAdmin);

                // El usuario no es administrador, redirige al inicio
                echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "No tienes autoridad de administrador para acceder a esto",
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
                }).then(() => {
                    window.location.href = "' . URL . 'inicio/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                });
                </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }
        }

        public function index(){

            //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
            $this->usuarios->set('usuario', $_SESSION['usuario']);
            $id_user = $this->usuarios->getIdUserbyUsuario();
            $user = $id_user['id_user'];

            $tipo_cambio = 10; //TIPO DE CAMBIO 10 = Accedio a
            $tabla_afectada = "Categorias";
            $registro_afectado = "Ninguno";
            $valor_antes = "Ninguno";
            $valor_despues = "Ninguno";
            $usuario = $user;

            //EJECUTANDO LA AUDITORIA
            $this->auditoria->auditar($tipo_cambio, $tabla_afectada, $registro_afectado, $valor_antes, $valor_despues, $usuario);

            $datos['titulo'] = "Categorias";
            $datos['categorias'] = $this->categoria_dispositivos->lista();
            return $datos;
        }

        public function new(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $nombre_categoria = $_POST['nombre_categoria'];
                $descripcion = $_POST['descripcion'];

                $this->usuarios->set('usuario', $_SESSION['usuario']);
                $id_user = $this->usuarios->getIdUserbyUsuario();
                $creado_por = $id_user['id_user'];

                //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
                if(empty($nombre_categoria) || empty($descripcion)){

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
                                        window.location.href = "' . URL . 'categoria/new";
                                    }
                                }).then(() => {
                                    window.location.href = "' . URL . 'categoria/new"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                }
                //SI NO ESTAN VACIOS PROSEGUIR
                else {

                    $errores = array();

                    // Validar nombre
                    if (!ctype_alpha($nombre_categoria)) {
                        $errores[] = "Nombre debe contener solo letras.";
                    }
                
                    if (empty($errores)) {
                        // No hay errores de validación, procesa los datos
                        $this->categoria_dispositivos->set('nombre_categoria', $nombre_categoria);
                        $this->categoria_dispositivos->set('descripcion', $descripcion);
                        $this->categoria_dispositivos->set('creado_por', $creado_por);

                        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                        $usuario = $creado_por;

                            //PREPARANDO AUDITORIA
                            $tipo_cambio = 4;
                            $tabla_afectada = 'categoria';
                            $registro_afectado = 0;
                            
                            //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                            //$valorAntesarray = array($data['nombre'], $data['apellido'], $data['cedula_identidad'], $data['correo']);
                            $valorDespuesarray = array($nombre_categoria, $descripcion);
                            
                            //CONVIRITENDOLO A JSON PARA GUARDARLO
                            $valor_antes = 'Nuevo registro';
                            $valor_despues = json_encode($valorDespuesarray);

                            //EJECUTANDO LA AUDITORIA
                            $this->auditoria->auditar($tipo_cambio, 
                                                    $tabla_afectada, 
                                                    $registro_afectado, 
                                                    $valor_antes, 
                                                    $valor_despues, 
                                                    $usuario);

                            $this->dispositivos->add();

                            echo '<script>
                                        Swal.fire({
                                            title: "Exito!",
                                            text: "Agregado Exitosamente.",
                                            icon: "success",
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then(() => {
                                            window.location.href = "' . URL . 'categoria/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.   

                        }
                    else {
                        // Hubo errores de validación, muestra los mensajes de error
                        echo '<script>
                                        Swal.fire({
                                            title: "Hubo errores de validacion...",
                                            text: " Recuerda que el nombre no deben llevar numeros",
                                            icon: "error",
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then(() => {
                                            window.location.href = "' . URL . 'categoria/new"; // Esta línea se ejecutará cuando se cierre la alerta.
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                    }
                }

            } 
            
            //PREPARANDO AUDITORIA
            
            //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
            $this->usuarios->set('usuario', $_SESSION['usuario']);
            $id_user = $this->usuarios->getIdUserbyUsuario();
            $user = $id_user['id_user'];

            $tipo_cambio = 5;
            $tabla_afectada = 'categoria';
            $registro_afectado = 0;
            //$valorAntesarray = array($data['nombre'], $data['apellido'], $data['cedula_identidad'], $data['correo']);
            $valor_antes = 'Ninguno';
            $valor_despues = 'en proceso';
            $usuario  = $user;

            //EJECUTANDO LA AUDITORIA
            $this->auditoria->auditar($tipo_cambio, 
                                    $tabla_afectada, 
                                    $registro_afectado, 
                                    $valor_antes, 
                                    $valor_despues, 
                                    $usuario);

        }

        public function edit($id){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $this->categoria_dispositivos->set('id_categoria',$id);
                    $nombre_categoria = $_POST['nombre_categoria'];
                    $descripcion = $_POST['descripcion'];

                    if(empty($nombre_categoria) || empty($descripcion)){

                        echo '<script>
                            Swal.fire({
                                title: "Error",
                                text: "El nombre o la descripcion no pueden estar vacios",
                                icon: "warning",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'categoria/edit' . $id . '";
                                }
                            }).then(() => {
                                window.location.href = "' . URL . 'categoria/edit' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                        </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                    }

                    $this->categoria_dispositivos->set('nombre_categoria', $nombre_categoria);
                    $this->categoria_dispositivos->set('descripcion', $descripcion);

                    //OBTENIENDO DATA PARA AUDITORIA
                    $this->categoria_dispositivos->set('id_categoria',$id);
                    $data = $this->categoria_dispositivos->getCategoriaforAuditoria();

                    //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                    $this->usuarios->set('usuario', $_SESSION['usuario']);
                    $id_user = $this->usuarios->getIdUserbyUsuario();
                    $user = $id_user['id_user'];

                    //PREPARANDO AUDITORIA
                    $tipo_cambio = 3;
                    $tabla_afectada = 'categoria';
                    $registro_afectado = $data['id_categoria'];
                    
                    //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                    $valorAntesarray = array($data['nombre_categoria'], $data['descripcion']);
                    $valorDespuesarray = array($nombre_categoria, $descripcion);
                    
                    //CONVIRITENDOLO A JSON PARA GUARDARLO
                    $valor_antes = json_encode($valorAntesarray);
                    $valor_despues = json_encode($valorDespuesarray);;
                    $usuario  = $user;

                    //EJECUTANDO LA AUDITORIA
                    $this->auditoria->auditar($tipo_cambio, 
                                            $tabla_afectada, 
                                            $registro_afectado, 
                                            $valor_antes, 
                                            $valor_despues, 
                                            $usuario);
    
                    $this->dispositivos->edit();
    
                    echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Editado Exitosamente.",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = "' . URL . 'categoria/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }  

                //OBTENIENDO DATA PARA AUDITORIA
                $this->categoria_dispositivos->set('id_categoria', $id);
                $data = $this->categoria_dispositivos->getCategoriaforAuditoria();

                //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                $this->usuarios->set('usuario', $_SESSION['usuario']);
                $id_user = $this->usuarios->getIdUserbyUsuario();
                $user = $id_user['id_user'];

                //PREPARANDO AUDITORIA
                $tipo_cambio = 2;
                $tabla_afectada = 'categoria';

                $registro_afectado = $data['id_categoria'];
                $valorAntesarray = array($data['nombre_categoria']);
                $valor_antes = json_encode($valorAntesarray);
                $valor_despues = 'en proceso';
                $usuario  = $user;

                //EJECUTANDO LA AUDITORIA
                $this->auditoria->auditar($tipo_cambio, 
                                        $tabla_afectada, 
                                        $registro_afectado, 
                                        $valor_antes, 
                                        $valor_despues, 
                                        $usuario);
                
                $this->categoria_dispositivos->set('id_categoria',$id);
                $data['titulo'] = "Editando Nombre de la categoria";
                $data['categoria'] = $this->categoria_dispositivos->getDataforEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;
        }
      
    }

    $categoria = new categoriaController();
?>