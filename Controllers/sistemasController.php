<?php namespace Controllers;

use Models\Sistemas_operativos;
use Models\Usuario;
use Models\Auditoria;

    class sistemasController{

        private $sistemas;
        private $usuarios;
        private $auditoria;

        public function __construct()
        {
            $this->sistemas = new Sistemas_operativos();
            $this->auditoria = new Auditoria();
            $this->usuarios = new Usuario();


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
        }

        public function index(){

            //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
            $this->usuarios->set('usuario', $_SESSION['usuario']);
            $id_user = $this->usuarios->getIdUserbyUsuario();
            $user = $id_user['id_user'];


            $tipo_cambio = 10; //TIPO DE CAMBIO 10 = Accedio a
            $tabla_afectada = "sistemas";
            $registro_afectado = "Ninguno";
            $valor_antes = "Ninguno";
            $valor_despues = "Ninguno";
            $usuario = $user;

            //EJECUTANDO LA AUDITORIA
            $this->auditoria->auditar($tipo_cambio, $tabla_afectada, $registro_afectado, $valor_antes, $valor_despues, $usuario);


            $datos['titulo'] = "Sistemas Operativos";
            $datos['sistemas'] = $this->sistemas->lista();
            return $datos;
        }

        public function num($number){
            echo "El numero que elegiste es ".$number;
        }

        public function new(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $nombre = $_POST['nombre'];
                $tipo = $_POST['tipo'];

                //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
                if(empty($nombre)){

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
                                        window.location.href = "' . URL . 'sistemas/new";
                                    }
                                }).then(() => {
                                    window.location.href = "' . URL . 'sistemas/new"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                } 
                //SI NO ESTAN VACIOS PROSEGUIR
                else {
                
                    if (empty($errores)) {
                        // No hay errores de validación, procesa los datos
                        $this->sistemas->set('nombre', $nombre);
                        $this->sistemas->set('tipo', $tipo);

                        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                        $this->usuarios->set('usuario', $_SESSION['usuario']);
                        $id_user = $this->usuarios->getIdUserbyUsuario();
                        $user = $id_user['id_user'];

                            //PREPARANDO AUDITORIA
                            $tipo_cambio = 4;
                            $tabla_afectada = 'sistemas';
                            $registro_afectado = 0;
                            
                            //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                            //$valorAntesarray = array($data['nombre'], $data['apellido'], $data['cedula_identidad'], $data['correo']);
                            $valorDespuesarray = array($nombre, $tipo);
                            
                            //CONVIRITENDOLO A JSON PARA GUARDARLO
                            $valor_antes = 'Nuevo registro';
                            $valor_despues = json_encode($valorDespuesarray);;
                            $usuario  = $user;

                            //EJECUTANDO LA AUDITORIA
                            $this->auditoria->auditar($tipo_cambio, 
                                                    $tabla_afectada, 
                                                    $registro_afectado, 
                                                    $valor_antes, 
                                                    $valor_despues, 
                                                    $usuario);

                            $this->sistemas->add();

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
                                                window.location.href = "' . URL . 'sistemas/index";
                                            }
                                        }).then(() => {
                                            window.location.href = "' . URL . 'sistemas/index"; // Esta línea se ejecutará cuando se cierre la alerta.
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
            $tabla_afectada = 'sistemas';
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
                            }).then(() => {
                                window.location.href = "' . URL . 'sistemas/index"; // Esta línea se ejecutará cuando se cierre la alerta.
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

                    //OBTENIENDO DATA PARA AUDITORIA
                    $this->sistemas->set('id_os',$id);
                    $data = $this->sistemas->getSistemaforAuditoria();

                    //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                    $this->usuarios->set('usuario', $_SESSION['usuario']);
                    $id_user = $this->usuarios->getIdUserbyUsuario();
                    $user = $id_user['id_user'];

                    //PREPARANDO AUDITORIA
                    $tipo_cambio = 3;
                    $tabla_afectada = 'sistemas';
                    $registro_afectado = $data['id_os'];
                    
                    //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                    $valorAntesarray = array($data['nombre'], $data['tipo']);
                    $valorDespuesarray = array($nombre, $tipo);
                    
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
                            }).then(() => {
                                window.location.href = "' . URL . 'sistemas/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }  

                //OBTENIENDO DATA PARA AUDITORIA
                $this->sistemas->set('id_os',$id);
                $data = $this->sistemas->getSistemaforAuditoria();

                //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                $this->usuarios->set('usuario', $_SESSION['usuario']);
                $id_user = $this->usuarios->getIdUserbyUsuario();
                $user = $id_user['id_user'];

                //PREPARANDO AUDITORIA
                $tipo_cambio = 2;
                $tabla_afectada = 'sistemas';

                $registro_afectado = $data['id_os'];
                $valorAntesarray = array($data['nombre'], $data['tipo']);
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
                
                $this->sistemas->set('id_os',$id);
                $data['titulo'] = "Editando Nombre del Sistema Operativo";
                $data['sistemas'] = $this->sistemas->getDataEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;
        }
            

        public function view($id){
        
            $this->sistemas->set('id_os', $id);

            $datos[] = $this->sistemas->view();
            return $datos;
            
        }
      
    }

    $sistemas = new sistemasController();
?>