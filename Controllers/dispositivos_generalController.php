<?php namespace Controllers;

use Models\Dispositivos_general;
use Models\Auditoria;
use Models\Usuario;
use Models\Categoria_dispositivos;
use Models\Tipo_dispositivos;
use Models\Departamentos;

    class dispositivos_generalController{

        private $dispositivos;
        private $auditoria;
        private $usuarios;
        private $categoria_dispositivos;
        private $tipo_dispositivos;
        private $departamentos;

        public function __construct()
        {
            $this->dispositivos = new Dispositivos_general();
            $this->auditoria = new Auditoria();
            $this->usuarios = new Usuario();
            $this->categoria_dispositivos = new Categoria_dispositivos();
            $this->tipo_dispositivos = new Tipo_dispositivos();
            $this->departamentos = new Departamentos();

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
                    $tabla_afectada = 'dispositivos';

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

        public function getDataForRegistro(){

            $datos['titulo'] = "Registrar nuevo dispositivo";
            $datos['categorias'] = $this->categoria_dispositivos->getCategorias();
            $datos['tipos'] = $this->tipo_dispositivos->getTiposDispositivos();
            $datos['departamentos'] = $this->departamentos->getDepartamentos();

            return $datos;
        }

        public function index(){

            //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
            $this->usuarios->set('usuario', $_SESSION['usuario']);
            $id_user = $this->usuarios->getIdUserbyUsuario();
            $user = $id_user['id_user'];

            $tipo_cambio = 10; //TIPO DE CAMBIO 10 = Accedio a
            $tabla_afectada = "dispositivos";
            $registro_afectado = "Ninguno";
            $valor_antes = "Ninguno";
            $valor_despues = "Ninguno";
            $usuario = $user;

            //EJECUTANDO LA AUDITORIA
            $this->auditoria->auditar($tipo_cambio, $tabla_afectada, $registro_afectado, $valor_antes, $valor_despues, $usuario);

            $datos['titulo'] = "Dispositivos";
            $datos['dispositivos'] = $this->dispositivos->lista();
            return $datos;
        }

        public function new(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $numero_bien = $_POST['numero_bien'];
                $marca = $_POST['marca'];
                $serial = $_POST['serial'];
                $modelo = $_POST['modelo'];
                $departamento = $_POST['departamento'];
                $caracteristicas = trim($_POST['caracteristicas']);
                $tipo = $_POST['tipo'];

                $this->usuarios->set('usuario', $_SESSION['usuario']);
                $id_user = $this->usuarios->getIdUserbyUsuario();
                $creado_por = $id_user['id_user'];

                $tipo = $_POST['tipo'];

                //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
                if(empty($departamento) || 
                empty($caracteristicas) || 
                empty($tipo) || 
                empty($numero_bien)){

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
                                        window.location.href = "' . URL . 'dispositivos-general/new";
                                    }
                                }).then(() => {
                                    window.location.href = "' . URL . 'dispositivos_general/new"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                }
                //SI NO ESTAN VACIOS PROSEGUIR
                else {

                    $errores = array();

                    // Validar nombre
                    /*if (!ctype_alpha($)) {
                        $errores[] = "Nombre debe contener solo letras.";
                    }*/
                
                    if (empty($errores)) {
                        // No hay errores de validación, procesa los datos
                        $this->dispositivos->set('numero_bien', $numero_bien);
                        $this->dispositivos->set('marca', $marca);
                        $this->dispositivos->set('serial', $serial);
                        $this->dispositivos->set('modelo', $modelo);
                        $this->dispositivos->set('departamento', $departamento);
                        $this->dispositivos->set('caracteristicas', $caracteristicas);
                        $this->dispositivos->set('creado_por', $creado_por);
                        $this->dispositivos->set('tipo', $tipo);

                        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                        $usuario = $creado_por;

                            //PREPARANDO AUDITORIA
                            $tipo_cambio = 4;
                            $tabla_afectada = 'dispositivos';
                            $registro_afectado = 0;
                            
                            //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                            //$valorAntesarray = array($data['nombre'], $data['apellido'], $data['cedula_identidad'], $data['correo']);
                            $valorDespuesarray = array($marca, 
                                                    $serial, 
                                                    $modelo, 
                                                    $departamento, 
                                                    $caracteristicas, 
                                                    $tipo);
                            
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

                            //UNA VEZ AUDITADO GUARDAMOS TODO
                            $this->dispositivos->add();

                            echo '<script>
                                        Swal.fire({
                                            title: "Exito!",
                                            text: "Agregado Exitosamente.",
                                            icon: "success",
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then(() => {
                                            window.location.href = "' . URL . 'dispositivos_general/index"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                                            window.location.href = "' . URL . 'dispositivos_general/new"; // Esta línea se ejecutará cuando se cierre la alerta.
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
            $tabla_afectada = 'dispositivos';
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

                    $numero_bien = $_POST['numero_bien'];
                    $marca = $_POST['marca'];
                    $serial = $_POST['serial'];
                    $modelo = $_POST['modelo'];
                    $departamento = $_POST['departamento'];
                    $caracteristicas = $_POST['caracteristicas'];
                    $tipo = $_POST['tipo'];

                    //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
                    if(empty($marca) || 
                    empty($serial) || 
                    empty($modelo) || 
                    empty($departamento) || 
                    empty($caracteristicas) || 
                    empty($tipo)){

                        echo '<script>
                            Swal.fire({
                                title: "Error",
                                text: "Parece que uno de los campos quedo vacio",
                                icon: "warning",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = "' . URL . 'dispositivos_general/edit' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                        </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                    }

                    $this->dispositivos->set('marca', $marca);
                    $this->dispositivos->set('serial', $serial);
                    $this->dispositivos->set('modelo', $modelo);
                    $this->dispositivos->set('departamento', $departamento);
                    $this->dispositivos->set('caracteristicas', $caracteristicas);
                    $this->dispositivos->set('tipo', $tipo);

                    //OBTENIENDO DATA PARA AUDITORIA
                    $this->dispositivos->set('id_dispositivo',$id);
                    $data = $this->dispositivos->getDispositivosGeneralesforAuditoria();

                    //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                    $this->usuarios->set('usuario', $_SESSION['usuario']);
                    $id_user = $this->usuarios->getIdUserbyUsuario();
                    $user = $id_user['id_user'];

                    //PREPARANDO AUDITORIA
                    $tipo_cambio = 3;
                    $tabla_afectada = 'dispositivos';
                    $registro_afectado = $data['id_dispositivo'];
                    
                    //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                    $valorAntesarray = array(
                        $data['marca'], 
                        $data['serial'],
                        $data['modelo'],
                        $data['departamento'],
                        $data['caracteristicas'],
                        $data['tipo'],
                    );
                    $valorDespuesarray = array(
                        $marca,
                        $serial,
                        $modelo,
                        $departamento,
                        $caracteristicas,
                        $tipo
                    );
                    
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
    
                    //UNA VEZ AUDITADO TODO, EDITAMOS
                    $this->dispositivos->edit();
    
                    echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Editado Exitosamente.",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = "' . URL . 'dispositivos_general/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }  

                //OBTENIENDO DATA PARA AUDITORIA
                $this->dispositivos->set('id_dispositivo', $id);
                $data = $this->dispositivos->getDispositivosGeneralesforAuditoria();

                //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                $this->usuarios->set('usuario', $_SESSION['usuario']);
                $id_user = $this->usuarios->getIdUserbyUsuario();
                $user = $id_user['id_user'];

                //PREPARANDO AUDITORIA
                $tipo_cambio = 2;
                $tabla_afectada = 'dispositivos';

                $registro_afectado = $data['id_dispositivo'];
                $valorAntesarray = array($data['dispositivo']);
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
                
                $this->dispositivos->set('id_dispositivo',$id);
                $data['titulo'] = "Editando datos del dispositivo";
                $data['tipo'] = $this->dispositivos->getDataforEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;
        }
      
    }

    $dispositivos_general = new dispositivos_generalController();
?>