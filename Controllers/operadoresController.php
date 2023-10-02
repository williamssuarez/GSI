<?php namespace Controllers;

use Models\Operadores;
use Models\Auditoria;
use Repository\Procesos1 as Repository1;

    class operadoresController{

        private $operador;
        private $auditoria;

        public function __construct()
        {
            $this->operador = new Operadores();
            $this->auditoria = new Auditoria();
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
            $datos['titulo'] = "Operadores";
            $datos['operadores'] = $this->operador->lista();
            return $datos;
        }

        public function num($number){
            echo "El numero que elegiste es ".$number;
        }

        public function new(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $cedula = $_POST['cedula_identidad'];
                $correo = $_POST['correo'];

                //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
                if(empty($nombre) || empty($apellido) || empty($apellido) || empty($cedula)){

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
                                        window.location.href = "' . URL . 'operadores/new";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                } 
                //SI NO ESTAN VACIOS PROSEGUIR
                else {

                    $errores = array();

                    //Validar nombre y apellido como texto
                    if (!preg_match('/^[A-Za-z\s]+$/', $nombre) || !preg_match('/^[A-Za-z\s]+$/', $apellido)) {
                        $errores[] = "Nombre y apellido deben contener solo letras y espacios.";
                    }
                    
                
                    // Validar cedula_identidad como número entero
                    if (!is_numeric($cedula)) {
                        $errores[] = "Cédula de identidad debe ser un número.";
                    }
                
                    // Validar formato de correo electrónico
                    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                        $errores[] = "Correo electrónico no válido.";
                    }
                
                    if (empty($errores)) {
                        // No hay errores de validación, procesa los datos
                        $this->operador->set('nombre', $nombre);
                        $this->operador->set('apellido', $apellido);
                        $this->operador->set('cedula_identidad', $cedula);
                        $this->operador->set('correo', $correo);

                        //VERIFICANDO SI LA CEDULA YA EXISTE
                        $cuenta = $this->operador->verificarCedula();
                        $cuenta_correo = $this->operador->verificarCorreo(); 

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
                                                window.location.href = "' . URL . 'operadores/new";
                                            }
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        }
                        elseif ($cuenta_correo['cuenta'] > 0) {
                            
                            echo '<script>
                                        Swal.fire({
                                            title: "Error!",
                                            text: "Este correo ya existe.",
                                            icon: "error",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'operadores/new";
                                            }
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        } 
                        //CASO CONTRARIO, PROSEGUIR
                        else {

                            //PREPARANDO AUDITORIA
                            $tipo_cambio = 'Nuevo operador agregado';
                            $tabla_afectada = 'operadores';
                            $registro_afectado = 0;
                            
                            //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                            //$valorAntesarray = array($data['nombre'], $data['apellido'], $data['cedula_identidad'], $data['correo']);
                            $valorDespuesarray = array($nombre, $apellido, $cedula, $correo);
                            
                            //CONVIRITENDOLO A JSON PARA GUARDARLO
                            $valor_antes = 'Nuevo registro';
                            $valor_despues = json_encode($valorDespuesarray);;
                            $usuario  = $_SESSION['usuario'];

                            //EJECUTANDO LA AUDITORIA
                            $this->auditoria->auditar($tipo_cambio, 
                                                    $tabla_afectada, 
                                                    $registro_afectado, 
                                                    $valor_antes, 
                                                    $valor_despues, 
                                                    $usuario);

                            $this->operador->add();

                            echo '<script>
                                        Swal.fire({
                                            title: "Exito!",
                                            text: "Agregado Exitosamente.",
                                            icon: "success",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'operadores/index";
                                            }
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.   

                        }
                    } else {
                        // Hubo errores de validación, muestra los mensajes de error
                        echo '<script>
                                        Swal.fire({
                                            title: "Hubo errores de validacion...",
                                            text: " Recuerda que la cedula debe ser numerica, y los nombres y apellidos no deben llevar numeros",
                                            icon: "error",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'operadores/new";
                                            }
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                    }
                }

            }
            
            //PREPARANDO AUDITORIA
            $tipo_cambio = 'Agregando nuevo operador';
            $tabla_afectada = 'operadores';
            $registro_afectado = 0;
            //$valorAntesarray = array($data['nombre'], $data['apellido'], $data['cedula_identidad'], $data['correo']);
            $valor_antes = 'Ninguno';
            $valor_despues = 'en proceso';
            $usuario  = $_SESSION['usuario'];

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

                    //OBTENIENDO DATA PARA AUDITORIA
                    $this->operador->set('id_operador', $id);
                    $data = $this->operador->getOperadorforAuditoria();

                    //RECIBIENDO DATA DEL FORMULARIO
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $cedula = $_POST['cedula_identidad'];
                    $correo = $_POST['correo'];

                    //PREPARANDO AUDITORIA
                    $tipo_cambio = 'edicion completada';
                    $tabla_afectada = 'operadores';
                    $registro_afectado = $data['id_operador'];
                    
                    //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                    $valorAntesarray = array($data['nombre'], $data['apellido'], $data['cedula_identidad'], $data['correo']);
                    $valorDespuesarray = array($nombre, $apellido, $cedula, $correo);
                    
                    //CONVIRITENDOLO A JSON PARA GUARDARLO
                    $valor_antes = json_encode($valorAntesarray);
                    $valor_despues = json_encode($valorDespuesarray);;
                    $usuario  = $_SESSION['usuario'];

                    //EJECUTANDO LA AUDITORIA
                    $this->auditoria->auditar($tipo_cambio, 
                                            $tabla_afectada, 
                                            $registro_afectado, 
                                            $valor_antes, 
                                            $valor_despues, 
                                            $usuario);
                    

                    //PREPARANDO LA EDICION
                    $this->operador->set('nombre', $nombre);
                    $this->operador->set('apellido', $apellido);
                    $this->operador->set('cedula_identidad', $cedula);
                    $this->operador->set('correo', $correo);
    
                    //EJECUTANDO LA EDICION
                    $this->operador->edit();
    
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
                                    window.location.href = "' . URL . 'operadores/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }  

                //OBTENIENDO DATA PARA AUDITORIA
                $this->operador->set('id_operador', $id);
                $data = $this->operador->getOperadorforAuditoria();

                //PREPARANDO AUDITORIA
                $tipo_cambio = 'edicion iniciada';
                $tabla_afectada = 'operadores';
                $registro_afectado = $data['id_operador'];
                $valorAntesarray = array($data['nombre'], $data['apellido'], $data['cedula_identidad'], $data['correo']);
                $valor_antes = json_encode($valorAntesarray);
                $valor_despues = 'en proceso';
                $usuario  = $_SESSION['usuario'];

                //EJECUTANDO LA AUDITORIA
                $this->auditoria->auditar($tipo_cambio, 
                                        $tabla_afectada, 
                                        $registro_afectado, 
                                        $valor_antes, 
                                        $valor_despues, 
                                        $usuario);
                $data['titulo'] = "Editando Operador";
                $data['operador'] = $this->operador->getDataEdit();

                //var_dump($data['operador']);
                //die(); 
                return $data;
        }

        public function getDataForEdit($id){

            //OBTENIENDO DATA PARA AUDITORIA
            $this->operador->set('id_operador', $id);
            $data = $this->operador->getOperadorforAuditoria();

            //OBTENIENDO DATA PARA AUDITORIA
            $this->operador->set('id_operador', $id);
            $data = $this->operador->getOperadorforAuditoria();

            //PREPARANDO AUDITORIA
            $tipo_cambio = 'edicion iniciada';
            $tabla_afectada = 'operadores';
            $registro_afectado = $data['id_operador'];
            $valorAntesarray = array($data['nombre'], $data['apellido'], $data['cedula_identidad'], $data['correo']);
            $valor_antes = json_encode($valorAntesarray);
            $valor_despues = 'en proceso';
            $usuario  = $_SESSION['usuario'];

            //EJECUTANDO LA AUDITORIA
            $this->auditoria->auditar($tipo_cambio, 
                                    $tabla_afectada, 
                                    $registro_afectado, 
                                    $valor_antes, 
                                    $valor_despues, 
                                    $usuario);

            return $this->operador->getDataEdit();
            
        }

        //VER INFORMACION DE OPERADOR
        public function view($id){
        
            $this->operador->set('id_operador', $id);

            $datos['titulo'] = "Detalles del Operador";
            $datos['operador'] = $this->operador->view();
            return $datos;
            
        }

        public function historial($id){

            $this->operador->set('id_operador', $id);

            $datos[] = $this->operador->historial();
            return $datos;
        }

        public function delete($id){

            if($_SERVER['REQUEST_METHOD'] == 'GET'){

                //OBTENIENDO DATA PARA AUDITORIA
                $this->operador->set('id_operador', $id);
                $data = $this->operador->getOperadorforAuditoria();

                //PREPARANDO AUDITORIA
                $tipo_cambio = 'delete';
                $tabla_afectada = 'operadores';
                $registro_afectado = $data['id_operador'];
                $valorAntesarray = array($data['nombre'], $data['apellido'], $data['cedula_identidad']);
                $valor_antes = json_encode($valorAntesarray);
                $valor_despues = 'eliminado';
                $usuario  = $_SESSION['usuario'];

                //EJECUTANDO AUDITORIA
                $this->auditoria->auditar($tipo_cambio, 
                                        $tabla_afectada, 
                                        $registro_afectado, 
                                        $valor_antes, 
                                        $valor_despues, 
                                        $usuario);

                //ELIMINANDO
                $this->operador->delete();

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
                                    window.location.href = "' . URL . 'operadores/index";
                                }
                            });
                        </script>';
                exit;
            }
        }

        public function suspend($id){

        if($_SERVER['REQUEST_METHOD'] == 'GET'){

            $this->operador->set('id_operador', $id);

            $this->operador->suspender();

            echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Suspendido Exitosamente.",
                                icon: "warning",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'operadores/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }
        }

        public function activate($id){

            if($_SERVER['REQUEST_METHOD'] == 'GET'){ 

                $this->operador->set('id_operador', $id);
                $this->operador->activando();

                echo '<script>
                                Swal.fire({
                                    title: "Exito!",
                                    text: "Reactivado Exitosamente.",
                                    icon: "success",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'operadores/index";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
            }
        }
      
    }

    $operadores = new operadoresController();
?>