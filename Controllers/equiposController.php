<?php namespace Controllers;

use Models\Equipos;
use Models\Equipos_ingresados;
use Models\Equipos_salida;
use Models\Departamentos;
use Models\Operadores;
use Repository\Procesos1 as Repository1;

    class equiposController{

        private $equipo;
        private $equipo_ingresado;
        private $equipo_salida;
        private $departamento;
        private $operadores;

        public function __construct()
        {
            $this->equipo = new Equipos();
            $this->equipo_ingresado = new Equipos_ingresados();
            $this->equipo_salida = new Equipos_salida();
            $this->departamento = new Departamentos();
            $this->operadores = new Operadores();
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

        //LISTANDO LOS EQUIPOS REGISTRADOS
        public function registrados(){

            $datos['titulo'] = "Equipos Registrados";
            $datos['equipos'] = $this->equipo->lista();

            return $datos;
        }

        //LISTANDO LOS EQUIPOS INGRESADOS
        public function index() {
            $datos['titulo'] = "Equipos Ingresados";
            $datos['total'] = $this->equipo_ingresado->getIngresosTotalesEquipos();
            $datos['equipos'] = $this->equipo_ingresado->lista();
            return $datos;
        }
        
        //LISTANDO LOS EQUIPOS ENTREGADOS
        public function salida(){
            $datos['titulo'] = "Equipos Salida";
            $datos['equipos_salida'] = $this->equipo_salida->lista();
            return $datos;
        }

        public function getDataIngreso(){

            $datos['titulo'] = "Equipos Ingresados";
            $datos['departamentos'] = $this->departamento->lista();
            $datos['operadores'] = $this->operadores->getOperador();

            return $datos;
        }

        public function getDataSalida(){

            $datos['titulo'] = "Entregando Equipo...";
            $datos['departamentos'] = $this->departamento->lista();
            $datos['operadores'] = $this->operadores->getOperador();
            $datos['equipos'] = $this->equipo_ingresado->getEquipos();

            return $datos;
        }

        public function new(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $numero_bien = $_POST['numero_bien'];
                $departamento = $_POST['departamento'];

                if(isset($_POST['fecha_recibido']) > 0){
                    $fecha_recibido = $_POST['fecha_recibido'];
                } else {
                    $fecha_recibido = "now()";                    
                }
                
                $recibido_por = $_POST['recibido_por'];
                $problema = $_POST['problema'];

                $this->equipo_ingresado->set('numero_bien', $numero_bien);
                $this->equipo_ingresado->set('departamento', $departamento);
                $this->equipo_ingresado->set('fecha_recibido', $fecha_recibido);
                $this->equipo_ingresado->set('recibido_por', $recibido_por);
                $this->equipo_ingresado->set('problema', $problema);

                //INGRESANDO EQUIPO
                $this->equipo_ingresado->add();

                //OBTENIENDO EL TOTAL DE INGRESOS DE DEPARTAMENTO Y SUMANDOLE 1
                $this->totalDepartamentos($departamento);

                //OBTENIENDO EL TOTAL DE EQUIPOS INGRESADOS POR EL OPERADOR Y SUMANDOLE 1
                $this->totalOperador($recibido_por);

                //REDIRECCIONANDO CON UN MENSAJE DE EXITO
                echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Equipo Ingresado Exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'equipos/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

        }

        //OBTENIENDO EL TOTAL DE EQUIPOS INGRESADOS POR EL OPERADOR Y SUMANDOLE 1
        private function totalOperador($id){

            $this->operadores->set('id_operador', $id);
            $this->operadores->actualizarEquiposIngresados();
        }

        //OBTENIENDO EL TOTAL DE INGRESOS DE UN DEPARTAMENTO Y SUMANDOLE 1
        private function totalDepartamentos($id){

            $this->departamento->set('id_departamento', $id);
            $this->departamento->actualizarEquiposIngresados();

        }

        public function delete($id){

            if($_SERVER['REQUEST_METHOD'] == 'GET'){

                $this->equipo_ingresado->set('id_equipo', $id);

                $this->equipo_ingresado->delete();

                //REDIRECCIONANDO CON UN MENSAJE DE EXITO
                echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Equipo Eliminado Exitosamente.",
                                icon: "warning",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'equipos/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

        }

        public function viewequipo($id){

            $this->equipo->set('id_equipo', $id);

            $datos['titulo'] = "Caracteristicas del equipo";
            $datos['equipo'] = $this->equipo->view();

            return $datos;

        }

        public function newregistro(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $numero_bien = $_POST['numero_bien'];
                $departamento = $_POST['departamento'];
                $usuario = $_POST['usuario'];
                $direccion_mac = $_POST['direccion_mac'];
                $direccion_ip = $_POST['usuariodireccion_ip'];
                $cpu = $_POST['cpu'];
                $almacenamiento = $_POST['almacenamiento'];
                $memoria_ram = $_POST['memoria_ram'];
                $sistema_operativo = $_POST['sistema_operativo'];

                $this->equipo->set('numero_bien', $numero_bien);
                $this->equipo->set('departamento', $departamento);
                $this->equipo->set('usuario', $usuario);
                $this->equipo->set('direccion_mac', $direccion_mac);
                $this->equipo->set('direccion_ip', $direccion_ip);
                $this->equipo->set('cpu', $cpu);
                $this->equipo->set('almacenamiento', $almacenamiento);
                $this->equipo->set('memoria_ram', $memoria_ram);
                $this->equipo->set('sistema_operativo', $sistema_operativo);

                //REGISTRANDO EQUIPO
                $this->equipo->add();

                //REDIRECCIONANDO CON UN MENSAJE DE EXITO
                echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Equipo registrado exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'equipos/registrados";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

        }

        public function edit($id){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $cedula = $_POST['cedula_identidad'];
                    $correo = $_POST['correo'];

                    $this->equipo_ingresado->set('id_operador', $id);
                    $this->equipo_ingresado->set('nombre', $nombre);
                    $this->equipo_ingresado->set('apellido', $apellido);
                    $this->equipo_ingresado->set('cedula_identidad', $cedula);
                    $this->equipo_ingresado->set('correo', $correo);
    
                    $this->equipo_ingresado->edit();
    
                    //REDIRECCIONANDO CON UN MENSAJE DE EXITO
                    echo '<script>
                    Swal.fire({
                        title: "Exito!",
                        text: "Equipo Editado Exitosamente.",
                        icon: "info",
                        showConfirmButton: true,
                        confirmButtonColor: "#3464eb",
                        customClass: {
                            confirmButton: "rounded-button" // Identificador personalizado
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "' . URL . 'equipos/index";
                        }
                    });
                    </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }            
            
        }

        public function entregar($id){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                //OBTENIENDO DATA NECESARIA DEL EQUIPO PARA ENTREGARLO, DIRECTO DE LA TABLA EQUIPOS_INGRESADOS
                $data = $this->DataForEntrega($id);

                $departamento = $data[0]['departamento'];
                $ingreso = $data[0]['id_equipo'];

                //OBTENIENDO DATA NECESARIA DEL EQUIPO PARA ENTREGARLO, DESDE EL FORMULARIO
                $fecha_entrega = $_POST['fecha_entrega'];
                $entregado_por = $_POST['entregado_por'];
                $conclusion = $_POST['conclusion'];

                //AGRUPANDO LOS DATOS
                $this->equipo_salida->set('departamento', $departamento);
                $this->equipo_salida->set('ingreso', $ingreso);
                $this->equipo_salida->set('fecha_entrega', $fecha_entrega);
                $this->equipo_salida->set('entregado_por', $entregado_por);
                $this->equipo_salida->set('conclusion', $conclusion);

                //INSERTANDO LA INFORMACION EN TABLA EQUIPOS_ENTREGADOS
                $this->equipo_salida->add();

                //SUMANDOLE +1 A EQUIPOS ENTREGADOS AL OPERADOR CORRESPONDIENTE
                $this->totalEntregaOperador($entregado_por);
 
                //CAMBIANDO EL ESTADO DEL EQUIPO EN EQUIPOS_INGRESADOS DE 0 A 1, 0 PENDIENTE, 1 ENTREGADO
                $this->cambiarEstadoEquipoIngresado($ingreso);

                //REDIRECCIONANDO CON UN MENSAJE DE EXITO
                echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Equipo Entregado Exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'equipos/salida";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

            $this->equipo_ingresado->set('id_equipo',$id);
                $data['title'] = "Entregando Equipo";
                $data['problem'] = $this->equipo_ingresado->getProblema();

                //var_dump($data['operador']);
                //die(); 
                return $data;

        }

        //OBTENIENDO DATA NECESARIA DEL EQUIPO PARA ENTREGARLO, DIRECTO DE LA TABLA EQUIPOS_INGRESADOS
        private function DataForEntrega($id){
            
            $this->equipo_ingresado->set('id_equipo', $id);

            $data = $this->equipo_ingresado->getDataForEntrega();

            return $data;
        }

        //SUMANDOLE +1 A EQUIPOS ENTREGADOS AL OPERADOR CORRESPONDIENTE
        private function totalEntregaOperador($id){

            $this->operadores->set('id_operador', $id);
            $this->operadores->actualizarEquiposEntregados();
        }

        //CAMBIANDO EL ESTADO DEL EQUIPO EN EQUIPOS_INGRESADOS DE 0 A 1, 0 PENDIENTE, 1 ENTREGADO
        private function cambiarEstadoEquipoIngresado($id){

            $this->equipo_ingresado->set('id_equipo', $id);
            $this->equipo_ingresado->actualizarEstadodeEquipo();
        }

      
    }

    $equipos = new equiposController();
?>