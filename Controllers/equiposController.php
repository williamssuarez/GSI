<?php namespace Controllers;

use Models\Equipos;
use Models\Equipos_ingresados;
use Models\Equipos_salida;
use Models\Departamentos;
use Models\Operadores;
use Models\Sistemas_operativos;
use Repository\Procesos1 as Repository1;

    class equiposController{

        private $equipo;
        private $equipo_ingresado;
        private $equipo_salida;
        private $departamento;
        private $operadores;
        private $sistema_operativo;

        public function __construct()
        {
            $this->equipo = new Equipos();
            $this->equipo_ingresado = new Equipos_ingresados();
            $this->equipo_salida = new Equipos_salida();
            $this->departamento = new Departamentos();
            $this->operadores = new Operadores();
            $this->sistema_operativo = new Sistemas_operativos();
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

        //OBTENIENDO DATA NECESARIA PARA EL REGISTRO
        public function getDataRegistro(){

            $datos['titulo'] = "Registrar equipo nuevo";
            $datos['departamentos'] = $this->departamento->getDepartamentos();
            $datos['sistemas'] = $this->sistema_operativo->getSistemas();

            return $datos;
        }

        //OBTENIENDO DATA NECESARIA PARA EL INGRESO
        public function getDataIngreso(){

            $datos['titulo'] = "Equipos Ingresados";
            $datos['departamentos'] = $this->departamento->lista();
            $datos['operadores'] = $this->operadores->getOperador();

            return $datos;
        }

        //OBTENIENDO DATA NECESARIA PARA LA SALIDA
        public function getDataSalida(){

            $datos['titulo'] = "Entregando Equipo...";
            $datos['operadores'] = $this->operadores->getOperador();
            $datos['equipos'] = $this->equipo_ingresado->getEquipos();

            return $datos;
        }

        //INGRESANDO EQUIPO NUEVO
        public function new(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $numero_bien = $_POST['numero_bien'];

                if(isset($_POST['fecha_recibido']) > 0){
                    $fecha_recibido = $_POST['fecha_recibido'];
                } else {
                    $fecha_recibido = "now()";                    
                }
                
                $recibido_por = $_POST['recibido_por'];
                $problema = $_POST['problema'];

                //VERIFICANDO SI EL EQUIPO ESTA REGISTRADO
                $this->equipo->set('numero_bien', $numero_bien);
                $cuenta = $this->equipo->verificarEquipoBien();

                //SI LA CUENTA ES MENOR A UNO ES QUE EL EQUIPO NO ESTA REGISTRADO
                if($cuenta['cuenta'] < 1){ 
                    
                    //REDIRECCIONANDO CON UN MENSAJE DE ERROR
                    echo '<script>
                                Swal.fire({
                                    title: "Equipo no registrado!",
                                    text: "Este equipo no esta registrado, registrelo antes de ingresarlo.",
                                    icon: "warning",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    confirmButtonText: "Registrar",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'equipos/newregistro";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                } else {

                    //OBTENIENDO EL ID DEL EQUIPO PARA INSERTARLO
                    $id_equipo = $this->equipo->getEquipobyNumerodeBien();
                    //UNA VEZ OBTENIDO LO SETEAMOS PARA CAMBIARLE EL ESTADO, OBTENER EL DEPARTAMENTO E INCREMENTARLE EL INGRESO
                    $this->equipo->set('id_equipo', $id_equipo['id_equipo']);

                    //PREPARANDO DATOS A INSERTAR
                    $this->equipo_ingresado->set('id_equipo', $id_equipo['id_equipo']);
                    $this->equipo_ingresado->set('fecha_recibido', $fecha_recibido);
                    $this->equipo_ingresado->set('recibido_por', $recibido_por);
                    $this->equipo_ingresado->set('problema', $problema);

                    //INGRESANDO EQUIPO
                    $this->equipo_ingresado->add();

                    //OBTENIENDO EL TOTAL DE INGRESOS DE DEPARTAMENTO Y SUMANDOLE 1
                    $datos = $this->equipo->actualizarIngresosdeEquipoDepartamento();
                    $departamento = $datos['departamento'];
                    $this->totalDepartamentos($departamento);

                    //OBTENIENDO EL TOTAL DE EQUIPOS INGRESADOS POR EL OPERADOR Y SUMANDOLE 1
                    $this->totalOperador($recibido_por);

                    //CAMBIANDO EL ESTADO DEL EQUIPO REGISTRADO DE ACTIVO A EN PROCESO, DE 0 A 2
                    $this->equipo->cambiarEstadoAenProceso();

                    //CAMBIANDO EL NUMERO DE INGRESOS DEL EQUIPO REGISTRADO A +1
                    $this->equipo->incrementarIngresosdeEquipo();

                    //PROCESO TERMINADO, REDIRECCIONANDO CON UN MENSAJE DE EXITO
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

        }

        //REGISTRANDO NUEVO EQUIPO
        public function newregistro(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $numero_bien = $_POST['numero_bien'];
                $departamento = $_POST['departamento'];
                $usuario = $_POST['usuario'];
                $direccion_mac = $_POST['direccion_mac'];
                $cpu = $_POST['cpu'];
                $almacenamiento = $_POST['almacenamiento'];
                $memoria_ram = $_POST['memoria_ram'];
                $sistema_operativo = $_POST['sistema'];

                //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
                if(empty($numero_bien) || empty($usuario) || empty($direccion_mac)){

                    echo '<script>
                                Swal.fire({
                                    title: "Error!",
                                    text: "Parece que uno de los campos quedo vacio",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'equipos/newregistro";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                } 
                //SI NO ESTAN VACIOS PROSEGUIR
                else {

                    $errores = array();

                    //Validar usuario como texto
                    if (!preg_match('/^[A-Za-z\s]+$/', $usuario)) {
                        $errores[] = "El nombre del usuario debe contener solo letras y espacios.";
                    }
                    
                    // Validar numero de bien como número entero
                    if (!is_numeric($numero_bien) || !is_numeric($memoria_ram) || !is_numeric($almacenamiento)) {
                        $errores[] = "Cédula de identidad debe ser un número.";
                    }
                
                    if (empty($errores)) {
                        // No hay errores de validación, procesa los datos
                        $this->equipo->set('numero_bien', $numero_bien);
                        $this->equipo->set('departamento', $departamento);
                        $this->equipo->set('usuario', $usuario);
                        $this->equipo->set('direccion_mac', $direccion_mac);
                        $this->equipo->set('cpu', $cpu);
                        $this->equipo->set('almacenamiento', $almacenamiento);
                        $this->equipo->set('memoria_ram', $memoria_ram);
                        $this->equipo->set('sistema_operativo', $sistema_operativo);

                        

                        //VERIFICANDO SI EL NUMERO DE BIEN Y LA MAC YA EXISTEN
                        $cuenta = $this->equipo->verificarEquipoBien();
                        $cuenta_mac = $this->equipo->verificarEquipoMac(); 

                        //SI YA EXISTE, REDIRIGIR DE NUEVO AL FORMULARIO CON MENSAJE DE ERROR
                        if($cuenta['cuenta'] > 0){

                            echo '<script>
                                        Swal.fire({
                                            title: "Error!",
                                            text: "Esta Numero de bien ya existe",
                                            icon: "error",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'equipos/newregistro";
                                            }
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        }
                        if ($cuenta_mac['cuenta'] > 0) {
                            
                            echo '<script>
                                        Swal.fire({
                                            title: "Error!",
                                            text: "Esta direccion ya existe",
                                            icon: "error",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'equipos/newregistro";
                                            }
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        } 
                        //CASO CONTRARIO, PROSEGUIR
                        else {

                            $this->equipo->add();

                            echo '<script>
                                        Swal.fire({
                                            title: "Exito!",
                                            text: "Equipo registrado exitosamente",
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
                    } else {
                        // Hubo errores de validación, muestra los mensajes de error
                        echo '<script>
                                        Swal.fire({
                                            title: "Hubo errores de validacion...",
                                            text: " Recuerda que el numero de bien deben ser solo los numeros, y los nombres y apellidos no deben llevar numeros",
                                            icon: "error",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'equipos/newregistro";
                                            }
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                    }
                }

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

        //ELIMINANDO INGRESO
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

        //VER EQUIPO REGISTRADO
        public function viewequipo($id){

            $this->equipo->set('id_equipo', $id);

            $datos['titulo'] = "Caracteristicas del equipo";
            $datos['equipo'] = $this->equipo->view();

            return $datos;

        }

        //EDITAR EQUIPO REGISTRADO
        public function editregistro($id){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $this->equipo->set('id_equipo',$id);
                $numero_bien = $_POST['numero_bien'];
                $departamento = $_POST['departamento'];
                $usuario = $_POST['usuario'];
                $direccion_mac = $_POST['direccion_mac'];
                $cpu = $_POST['cpu'];
                $almacenamiento = $_POST['almacenamiento'];
                $memoria_ram = $_POST['memoria_ram'];
                $sistema_operativo = $_POST['sistema'];

                $this->equipo->set('numero_bien', $numero_bien);
                $this->equipo->set('departamento', $departamento);
                $this->equipo->set('usuario', $usuario);
                $this->equipo->set('direccion_mac', $direccion_mac);
                $this->equipo->set('cpu', $cpu);
                $this->equipo->set('almacenamiento', $almacenamiento);
                $this->equipo->set('memoria_ram', $memoria_ram);
                $this->equipo->set('sistema_operativo', $sistema_operativo);


                $this->equipo->edit();

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
                                window.location.href = "' . URL . 'equipos/registrados";
                            }
                        });
                    </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }  
            
            $this->equipo->set('id_equipo',$id);
            $data['titulo'] = "Editando Datos del Equipo";
            $data['equipo'] = $this->equipo->getDataEdit();
            $data['departamentos'] = $this->departamento->getDepartamentos();
            $data['sistemas'] = $this->sistema_operativo->getSistemas();

            //var_dump($data['operador']);
            //die(); 

            return $data;

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

                //OBTENIENDO DATA NECESARIA PARA INSERTAR
                $data = $this->DataForEntrega($id);
                $id_equipo = $data['id_equipo'];

                //OBTENIENDO DATA NECESARIA DEL EQUIPO PARA ENTREGARLO, DESDE EL FORMULARIO
                $ingreso = $id;
                $fecha_entrega = $_POST['fecha_entrega'];
                $entregado_por = $_POST['entregado_por'];
                $conclusion = $_POST['conclusion'];

                //AGRUPANDO LOS DATOS
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

                //CAMBIANDO EL ESTADO DEL EQUIPO REGISTRADO DE EN PROCESO A ACTIVO
                $this->cambiarEstadoEquipoRegistrado($id_equipo);

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

                $this->equipo_ingresado->set('id_ingreso',$id);
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

            $this->equipo_ingresado->set('ingreso', $id);
            $this->equipo_ingresado->actualizarEstadodeEquipo();
        }

        //CAMBIANDO EL ESTADO DEL EQUIPO REGISTRADO DE EN PROCESO A ACTIVO
        private function cambiarEstadoEquipoRegistrado($id){

            $this->equipo->set('id_equipo', $id);
            $this->equipo->cambiarEstadoaActivo();
        }

      
    }

    $equipos = new equiposController();
?>