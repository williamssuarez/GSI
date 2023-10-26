<?php namespace Controllers;

use Models\Departamentos;
use Repository\Procesos1 as Repository1;
use Models\Usuario;
use Models\Auditoria;

    class departamentosController{

        private $departamento;
        private $usuarios;
        private $auditoria;

        public function __construct()
        {
            $this->departamento = new Departamentos();
            $this->usuarios = new Usuario();
            $this->auditoria = new Auditoria();
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

                //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                $this->usuarios->set('usuario', $_SESSION['usuario']);
                $id_user = $this->usuarios->getIdUserbyUsuario();
                $user = $id_user['id_user'];


                $tipo_cambio = 12; //TIPO DE CAMBIO 12 = ACCESO NO AUTORIZADO
                $tabla_afectada = "Departamentos";
                $registro_afectado = "Ninguno";
                $valor_antes = "Ninguno";
                $valor_despues = "Ninguno";
                $usuario = $user;

                //EJECUTANDO LA AUDITORIA
                $this->auditoria->auditar($tipo_cambio, $tabla_afectada, $registro_afectado, $valor_antes, $valor_despues, $usuario);

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
            $tabla_afectada = "Departamentos";
            $registro_afectado = "Ninguno";
            $valor_antes = "Ninguno";
            $valor_despues = "Ninguno";
            $usuario = $user;

            //EJECUTANDO LA AUDITORIA
            $this->auditoria->auditar($tipo_cambio, $tabla_afectada, $registro_afectado, $valor_antes, $valor_despues, $usuario);

            $datos['titulo'] = "Departamentos";
            $datos['departamentos'] = $this->departamento->lista();
            return $datos;
        }

        public function edit($id){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $this->departamento->set('id_departamento',$id);
                    $nombre_departamento = $_POST['nombre'];
                    $piso = $_POST['piso'];

                    //OBTENIENDO DATA PARA AUDITORIA
                    $this->departamento->set('id_departamento', $id);
                    $data = $this->departamento->getDepartamentoforAuditoria();

                    //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                    $this->usuarios->set('usuario', $_SESSION['usuario']);
                    $id_user = $this->usuarios->getIdUserbyUsuario();
                    $user = $id_user['id_user'];

                    //PREPARANDO AUDITORIA
                    $tipo_cambio = 3;
                    $tabla_afectada = 'departamentos';
                    $registro_afectado = $data['id_departamento'];
                    
                    //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                    $valorAntesarray = array($data['nombre_departamento'], $data['piso']);
                    $valorDespuesarray = array($nombre_departamento, $piso);
                    
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

                    $this->departamento->set('nombre_departamento', $nombre_departamento);
                    $this->departamento->set('piso', $piso);
    
                    $this->departamento->edit();

    
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
                                    window.location.href = "' . URL . 'departamentos/index";
                                }
                            }).then(() => {
                                window.location.href = "' . URL . 'departamentos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }  

                //OBTENIENDO DATA PARA AUDITORIA
                $this->departamento->set('id_departamento',$id);
                $data = $this->departamento->getDepartamentoforAuditoria();

                //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                $this->usuarios->set('usuario', $_SESSION['usuario']);
                $id_user = $this->usuarios->getIdUserbyUsuario();
                $user = $id_user['id_user'];

                //PREPARANDO AUDITORIA
                $tipo_cambio = 2;
                $tabla_afectada = 'departamentos';

                $registro_afectado = $data['id_departamento'];
                $valorAntesarray = array($data['nombre_departamento'], $data['piso']);
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
                
                $data['titulo'] = "Editando Nombre de Departamento";
                $data['departamento'] = $this->departamento->getDataEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;
        }
            

        public function view($id){
        
            $this->departamento->set('id_operador', $id);

            $datos[] = $this->departamento->view();
            return $datos;
            
        }
      
    }

    $departamentos = new departamentosController();
?>