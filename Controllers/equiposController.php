<?php namespace Controllers;

use Models\Equipos;
use Models\Equipos_ingresados;
use Models\Equipos_salida;
use Models\Equipos_rechazados;
use Models\Departamentos;
use Models\Operadores;
use Models\Sistemas_operativos;
use Models\Usuario;
use Repository\Procesos1 as Repository1;

    class equiposController{

        private $equipo;
        private $equipo_ingresado;
        private $equipo_salida;
        private $equipos_rechazados;
        private $departamento;
        private $operadores;
        private $sistema_operativo;
        private $usuarios;

        public function __construct()
        {
            $this->equipo = new Equipos();
            $this->equipo_ingresado = new Equipos_ingresados();
            $this->equipo_salida = new Equipos_salida();
            $this->equipos_rechazados = new Equipos_rechazados();
            $this->departamento = new Departamentos();
            $this->operadores = new Operadores();
            $this->sistema_operativo = new Sistemas_operativos();
            $this->usuarios = new Usuario();
            if (!isset($_SESSION['usuario'])) {
                // El usuario no está autenticado, muestra la alerta y redirige al formulario de inicio de sesión.
                echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "Tienes que iniciar sesión primero",
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

            //OBTENIENDO EL ID POR EL USUARIO
            $this->usuarios->set('usuario', $_SESSION['usuario']);
            $id_user = $this->usuarios->getIdUserbyUsuario();

            $datos['id_user'] = $id_user['id_user'];
            
            return $datos;
        }
        
        //LISTANDO LOS EQUIPOS ENTREGADOS
        public function salida(){
            $datos['titulo'] = "Equipos Salida";
            $datos['equipos_salida'] = $this->equipo_salida->lista();
            return $datos;
        }

        public function rechazosAdmin(){

            if($_SESSION['rol'] != 1){

                //REDIRECCIONANDO CON UN MENSAJE DE ERROR
                echo '<script>
                            Swal.fire({
                                title: "Error",
                                text: "No tienes privilegios de administrador",
                                icon: "error",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'equipos/index";
                                }
                            }).then(() => {
                                window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

            $datos['titulo'] = "Entregas Rechazadas";
            $datos['equipos_rechazados'] = $this->equipos_rechazados->listaAdmin();
            return $datos;

        }

        public function rechazosOperador(){

            //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO
            $this->usuarios->set('usuario', $_SESSION['usuario']);
            $user = $this->usuarios->getIdUserbyUsuario();
            $id_user = $user['id_user'];

            $datos['titulo'] = "Entregas Rechazadas";

            $this->equipos_rechazados->set('id_usuario', $id_user);
            $datos['equipos_rechazados'] = $this->equipos_rechazados->listaOperador();
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
            $datos['operadores'] = $this->usuarios->getUsuarios();

            return $datos;
        }

        //OBTENIENDO DATA NECESARIA PARA LA SALIDA
        public function getDataSalida(){

            $datos['titulo'] = "Entregando Equipo...";
            $datos['operadores'] = $this->usuarios->getUsuarios();

            return $datos;
        }

        //INGRESANDO EQUIPO NUEVO ADMIN
        public function new(){
           
            if($_SESSION['rol'] == 1){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $numero_bien = $_POST['numero_bien'];
    
                    if(isset($_POST['fecha_recibido']) > 0){
                        $fecha_recibido = $_POST['fecha_recibido'];
                    } else {
                        $fecha_recibido = "now()";                    
                    }
                    
                    //OBTENIENDO EL ID DEL USUARIO
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
                                        title: "Equipo no registrado",
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
                                    }).then(() => {
                                        window.location.href = "' . URL . 'equipos/newregistro"; // Esta línea se ejecutará cuando se cierre la alerta.
                                    });
                                </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                    } else {
    
                        //OBTENIENDO EL ID DEL EQUIPO PARA INSERTARLO
                        $id_equipo = $this->equipo->getEquipobyNumerodeBien();

                        //OBTENIENDO EL ID DEL EQUIPO PARA INSERTARLO
                        $id_equipo = $this->equipo->getEquipobyNumerodeBien();

                        //VERIFICANDO SI ESE EQUIPO SE ENCUENTRA INGRESADO
                        $this->equipo_ingresado->set('id_equipo', $id_equipo['id_equipo']);

                        $existencia = $this->equipo_ingresado->verificarExistencia();

                        if($existencia['existencia'] > 0){

                             //REDIRECCIONANDO CON UN MENSAJE DE ERROR
                            echo '<script>
                            Swal.fire({
                                title: "Equipo ya en soporte",
                                text: "Este equipo se encuentra todavia ingresado en soporte, cierre el caso para poder ingresar de nuevo",
                                icon: "warning",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                confirmButtonText: "Registrar",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'equipos/index";
                                }
                            }).then(() => {
                                window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                            </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.   


                        }

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
    
                        //PREPARANDO HISTORIAL
                        $usuario = $_SESSION['usuario'];
                        $this->usuarios->set('usuario', $usuario);
                        $id_user = $this->usuarios->getIdUserbyUsuario();
    
                        //OBTENIENDO EL ID DEL EQUIPO PARA INSERTARLO
                        $this->equipo->set('numero_bien', $numero_bien);
                        $id_equipo = $this->equipo->getEquipobyNumerodeBien();
    
                        $accion = "Ingreso";
                        $razon = $problema;
    
                        $this->equipo_ingresado->set('id_admin', $id_user['id_user']);
                        $this->equipo_ingresado->set('usuario', $id_user['id_user']);
                        $this->equipo_ingresado->set('id_equipo', $id_equipo['id_equipo']);
                        $this->equipo_ingresado->set('accion', $accion);
                        $this->equipo_ingresado->set('razon', $razon);

                        $this->equipo_ingresado->ingresarEquipoHistorial();
    
                        //PROCESO TERMINADO, REDIRECCIONANDO CON UN MENSAJE DE EXITO
                        echo '<script>
                                    Swal.fire({
                                        title: "Exito",
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
                                    }).then(() => {
                                        window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                    });
                                </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                }
    

        }
                


            } else {

                echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "No eres administrador",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'equipos/index";
                                    }
                                }).then(() => {
                                    window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

            
        }

    } 


        public function newOperador(){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $numero_bien = $_POST['numero_bien'];
    
                    if(isset($_POST['fecha_recibido']) > 0){
                        $fecha_recibido = $_POST['fecha_recibido'];
                    } else {
                        $fecha_recibido = "now()";                    
                    }
                    
                    //OBTENIENDO EL ID DEL USUARIO
                    $user = $_SESSION['usuario'];
                    $this->usuarios->set('usuario', $user);
                    $id_user = $this->usuarios->getIdUserbyUsuario();
                    $recibido_por = $id_user['id_user'];
                    
                    $problema = $_POST['problema'];
    
                    //VERIFICANDO SI EL EQUIPO ESTA REGISTRADO
                    $this->equipo->set('numero_bien', $numero_bien);
                    $cuenta = $this->equipo->verificarEquipoBien();
    
                    //SI LA CUENTA ES MENOR A UNO ES QUE EL EQUIPO NO ESTA REGISTRADO
                    if($cuenta['cuenta'] < 1){ 
                        
                        //REDIRECCIONANDO CON UN MENSAJE DE ERROR
                        echo '<script>
                                    Swal.fire({
                                        title: "Equipo no registrado",
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
                                            window.location.href = "' . URL . 'equipos/index";
                                        }
                                    }).then(() => {
                                        window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                    });
                                </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                    } else {
    
                        //OBTENIENDO EL ID DEL EQUIPO PARA INSERTARLO
                        $id_equipo = $this->equipo->getEquipobyNumerodeBien();

                        //VERIFICANDO SI ESE EQUIPO SE ENCUENTRA INGRESADO
                        $this->equipo_ingresado->set('id_equipo', $id_equipo['id_equipo']);

                        $existencia = $this->equipo_ingresado->verificarExistencia();

                        if($existencia['existencia'] > 0){

                             //REDIRECCIONANDO CON UN MENSAJE DE ERROR
                            echo '<script>
                            Swal.fire({
                                title: "Equipo ya en soporte",
                                text: "Este equipo se encuentra todavia ingresado en soporte, cierre el caso para poder ingresar de nuevo",
                                icon: "warning",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                confirmButtonText: "Registrar",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'equipos/index";
                                }
                            }).then(() => {
                                window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                            </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.   


                        }

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
    
                        //PREPARANDO HISTORIAL
                        $usuario = $_SESSION['usuario'];
                        $this->usuarios->set('usuario', $usuario);
                        $id_user = $this->usuarios->getIdUserbyUsuario();
    
                        //OBTENIENDO EL ID DEL EQUIPO PARA INSERTARLO
                        $this->equipo->set('numero_bien', $numero_bien);
                        $id_equipo = $this->equipo->getEquipobyNumerodeBien();
    
                        $accion = "Ingreso";
                        $razon = $problema;
    
                        $this->equipo_ingresado->set('usuario', $id_user['id_user']);
                        $this->equipo_ingresado->set('id_equipo', $id_equipo['id_equipo']);
                        $this->equipo_ingresado->set('accion', $accion);
                        $this->equipo_ingresado->set('razon', $razon);
    
                        //INSERTANDO EN EL HISTORIAL
                        $this->equipo_ingresado->ingresarEquipoHistorial();
    
                        //PROCESO TERMINADO, REDIRECCIONANDO CON UN MENSAJE DE EXITO
                        echo '<script>
                                    Swal.fire({
                                        title: "Exito",
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
                                    }).then(() => {
                                        window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                //ENCONTRANDO EL ID DEL USUARIO POR EL NOMBRE DE USUARIO
                $user = $_SESSION['usuario'];
                $this->usuarios->set('usuario', $user);
                $id_user = $this->usuarios->getIdUserbyUsuario();
                $registrado_por = $id_user['id_user'];


                //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
                if(empty($numero_bien) || empty($usuario) || empty($direccion_mac)){

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
                                        window.location.href = "' . URL . 'equipos/newregistro";
                                    }
                                }).then(() => {
                                    window.location.href = "' . URL . 'equipos/newregistro"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                        $this->equipo->set('registrado_por', $registrado_por);
                        

                        //VERIFICANDO SI EL NUMERO DE BIEN Y LA MAC YA EXISTEN
                        $cuenta = $this->equipo->verificarEquipoBien();
                        $cuenta_mac = $this->equipo->verificarEquipoMac(); 

                        //SI YA EXISTE, REDIRIGIR DE NUEVO AL FORMULARIO CON MENSAJE DE ERROR
                        if($cuenta['cuenta'] > 0){

                            echo '<script>
                                        Swal.fire({
                                            title: "Error",
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
                                        }).then(() => {
                                            window.location.href = "' . URL . 'equipos/newregistro"; // Esta línea se ejecutará cuando se cierre la alerta.
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        }
                        if ($cuenta_mac['cuenta'] > 0) {
                            
                            echo '<script>
                                        Swal.fire({
                                            title: "Error",
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
                                        }).then(() => {
                                            window.location.href = "' . URL . 'equipos/newregistro"; // Esta línea se ejecutará cuando se cierre la alerta.
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        } 
                        //CASO CONTRARIO, PROSEGUIR
                        else {

                            $this->equipo->add();

                            echo '<script>
                                        Swal.fire({
                                            title: "Exito",
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
                                        }).then(() => {
                                            window.location.href = "' . URL . 'equipos/registrados"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                                        }).then(() => {
                                            window.location.href = "' . URL . 'equipos/newregistro"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                                title: "Exito",
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
                            }).then(() => {
                                window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
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

            if($_SESSION['rol'] == 1){

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
                                title: "Exito",
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
                            }).then(() => {
                                window.location.href = "' . URL . 'equipos/registrados"; // Esta línea se ejecutará cuando se cierre la alerta.
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

            } else {
                 // El usuario no es administrador, redirige al index
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
                         window.location.href = "' . URL . 'equipos/registrados";
                     }
                 }).then(() => {
                    window.location.href = "' . URL . 'equipos/registrados"; // Esta línea se ejecutará cuando se cierre la alerta.
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
                        title: "Exito",
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
                    }).then(() => {
                        window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                    });
                    </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }            
            
        }

        public function entregarAdmin($id){

            if($_SESSION['rol'] == 1){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    //OBTENIENDO DATA NECESARIA PARA INSERTAR
                    $data = $this->DataForEntrega($id);
                    /*var_dump($data['id_equipo']);
                    die();*/
                    $id_equipo = $data['id_equipo'];
    
                    //OBTENIENDO DATA NECESARIA DEL EQUIPO PARA ENTREGARLO, DESDE EL FORMULARIO
                    $ingreso = $id;
                    $fecha_entrega = $_POST['fecha_entrega'];
                    $entregado_por = $_POST['entregado_por'];
                    $conclusion = $_POST['conclusion'];

                    //USUARIO
                    $usuario = $_SESSION['usuario'];
                    $this->usuarios->set('usuario', $usuario);
                    $id_user = $this->usuarios->getIdUserbyUsuario();
    
                    //AGRUPANDO LOS DATOS
                    $this->equipo_salida->set('ingreso', $ingreso);
                    $this->equipo_salida->set('id_administrador', $id_user['id_user']);
                    $this->equipo_salida->set('fecha_entrega', $fecha_entrega);
                    $this->equipo_salida->set('entregado_por', $entregado_por);
                    $this->equipo_salida->set('conclusion', $conclusion);
    
                    //INSERTANDO LA INFORMACION EN TABLA EQUIPOS_ENTREGADOS
                    $this->equipo_salida->addAdmin();
    
                    //CAMBIANDO EL ESTADO DEL EQUIPO EN EQUIPOS_INGRESADOS DE 0 A 1, 0 PENDIENTE, 1 ENTREGADO
                    $this->cambiarEstadoEquipoIngresado($id);

                    //SUMANDOLE +1 A EQUIPOS ENTREGADOS AL OPERADOR CORRESPONDIENTE
                    $this->totalEntregaOperador($entregado_por);
    
                    //CAMBIANDO EL ESTADO DEL EQUIPO REGISTRADO DE EN PROCESO A ACTIVO
                    $this->cambiarEstadoEquipoRegistrado($id_equipo);

                    //PREPARANDO HISTORIAL
                    //USUARIO
                    $usuario = $_SESSION['usuario'];
                    $this->usuarios->set('usuario', $usuario);
                    $id_user = $this->usuarios->getIdUserbyUsuario();
                    
                    //EQUIPO
                    $id_equipo_registrado = $id_equipo;
                    
                    //ACCION Y RAZON
                    $accion = "Entrega";
                    $razon = $conclusion;

                    //PREPARANDO LOS DATOS
                    $this->equipo_salida->set('id_admin', $id_user['id_user']);
                    $this->equipo_salida->set('usuario', $id_user['id_user']);
                    $this->equipo_salida->set('id_equipo', $id_equipo_registrado);
                    $this->equipo_salida->set('accion', $accion);
                    $this->equipo_salida->set('razon', $razon);

                    //INSERTANDO EN EL HISTORIAL
                    $this->equipo_salida->entregarEquipoHistorial();

                    //ELIMINAR ENTREGAS RECHAZADOS CON ESE INGRESO
                    $this->equipos_rechazados->set('ingreso', $ingreso);
                    $this->equipos_rechazados->delete();
    
                    //REDIRECCIONANDO CON UN MENSAJE DE EXITO
                    echo '<script>
                                Swal.fire({
                                    title: "Exito",
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
                                }).then(() => {
                                    window.location.href = "' . URL . 'equipos/salida"; // Esta línea se ejecutará cuando se cierre la alerta.
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

            } else {
                //NO ES ADMIN
                //REDIRECCIONANDO CON UN MENSAJE DE EXITO
                echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "No eres administrador.",
                        icon: "error",
                        showConfirmButton: true,
                        confirmButtonColor: "#3464eb",
                        customClass: {
                            confirmButton: "rounded-button" // Identificador personalizado
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "' . URL . 'equipos/index";
                        }
                    }).then(() => {
                        window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                    });
                </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
            }

        }

        public function entregarOperador($id){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                //OBTENIENDO DATA NECESARIA PARA INSERTAR
                $data = $this->DataForEntrega($id);
                /*var_dump($data['id_equipo']);
                die();*/
                $id_equipo = $data['id_equipo'];

                //OBTENIENDO DATA NECESARIA DEL EQUIPO PARA ENTREGARLO, DESDE EL FORMULARIO
                $ingreso = $id;
                $fecha_entrega = $_POST['fecha_entrega'];

                //OBTENIENDO ID DE USUARIO
                $user = $_SESSION['usuario'];
                $this->usuarios->set('usuario', $user);
                $id_user = $this->usuarios->getIdUserbyUsuario();
                $entregado_por = $id_user['id_user'];

                $conclusion = $_POST['conclusion'];

                //AGRUPANDO LOS DATOS
                $this->equipo_salida->set('ingreso', $ingreso);
                $this->equipo_salida->set('id_equipo', $id_equipo);
                $this->equipo_salida->set('fecha_entrega', $fecha_entrega);
                $this->equipo_salida->set('entregado_por', $entregado_por);
                $this->equipo_salida->set('conclusion', $conclusion);

                //INSERTANDO LA INFORMACION EN TABLA EQUIPOS_ENTREGADOS
                $this->equipo_salida->addEsperandoAprobacion();

                //CAMBIANDO EL ESTADO DE PENDIENTE A EN ESPERA DE APROBACION
                $this->equipo_ingresado->set('id_ingreso', $ingreso);
                $this->equipo_ingresado->cambiarEstadoEquipoAprobacion();

                //REDIRECCIONANDO CON UN MENSAJE DE EXITO
                echo '<script>
                            Swal.fire({
                                title: "Exito",
                                text: "Esperando aprobacion del administrador",
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
                            }).then(() => {
                                window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
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

        //LA TABLA DE EQUIPOS ESPERANDO APROBACION POR EL ADMIN
        public function esperandoAprobacion(){

            $datos['titulo'] = "Equipos Esperando Aprobacion";
            $datos['equipos_salida'] = $this->equipo_salida->listaAprobacion();
            return $datos;

        }

        //RECHAZADO POR ADMIN
        public function rechazarEntrega($id){

            if($_SESSION['rol'] != 1){

                //REDIRECCIONANDO CON UN MENSAJE DE ERROR
                echo '<script>
                            Swal.fire({
                                title: "Error",
                                text: "No tienes privilegios de administrador",
                                icon: "error",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'equipos/index";
                                }
                            }).then(() => {
                                window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

            //SI ES POST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

            //OBTENIENDO LA RAZON DEL FORMULARIO DE RECHAZO
            $razon_rechazo = $_POST['razon_rechazo'];
            $clave_admin = $_POST['clave_admin'];
            $clave_confirmacion = $_POST['clave_confirmacion'];

            

                //CASO DE QUE LA RAZON ESTE VACIA
                if(empty($razon_rechazo)){

                    //REDIRECCIONAR CON MENSAJE DE ERROR
                    echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Debes introducir una razon para procesar el rechazo",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'equipos/rechazarEntrega/' . $id . '";
                                    }
                                }).then(() => {
                                    window.location.href = "' . URL . 'equipos/equipos/rechazarEntrega/' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                        </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.


                } else {

                    //EL CAMPO NO ESTA VACIO, PROSEGUIR
                    //EVALUAR SI LAS CLAVES COINCIDEN
                    if($clave_admin != $clave_confirmacion){
                        //NO COINCIDEN, REDIRECCIONAR CON MENSAJE DE ERROR
                        echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Las claves no coinciden",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'equipos/rechazarEntrega/' . $id . '";
                                    }
                                }).then(() => {
                                    window.location.href = "' . URL . 'equipos/rechazarEntrega/' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                        </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.   

                    } else {
                        //COINCIDEN, PROSEGUIR

                        //VERIFICAR CLAVE ADMINISTRADOR
                        $this->usuarios->set('usuario', $_SESSION['usuario']);
                        $id_user = $this->usuarios->getIdUserbyUsuario();

                        $flag = $this->verificarClaveAdminRechazo($id_user['id_user'], $clave_admin);

                        if($flag == false){

                            //LAS CLAVES NO COINCIDEN CON LAS DE LA BASE DE DATOS, REDIRECCIONAR CON MENSAJE DE ERROR
                            echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Clave invalida",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'equipos/rechazarEntrega/' . $id . '";
                                    }
                                }).then(() => {
                                    window.location.href = "' . URL . 'equipos/rechazarEntrega/' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                        </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional. 

                        } else {
                            //LA CLAVE ES VALIDA, PROSEGUIR
                            //OBTENIENDO LA DATA DEL EQUIPO PARA REVERTIRLO
                            $this->equipo_salida->set('id_aprobacion', $id);
                            $equipo = $this->equipo_salida->getDataAprobacion();
                            $entregado_por = $equipo['entregado_por'];
                            $ingreso = $equipo['ingreso'];
                            $id_equipo = $equipo['id_equipo'];
                            $fecha_entrega = $equipo['fecha_entrega'];
                            $conclusion = $equipo['conclusion'];

                            //AGRUPANDO LOS DATOS PARA ELIMINAR (SOLO NECESITAMOS EL ID DEL INGRESO)
                            $this->equipo_ingresado->set('id_ingreso', $ingreso);

                            //REVIRTIENDO LA INFORMACION EN TABLA EQUIPOS_ENTREGADOS
                            $this->equipo_ingresado->rechazarAdmin();

                            //USUARIO ADMIN
                            $usuario = $_SESSION['usuario'];
                            $this->usuarios->set('usuario', $usuario);
                            $id_admin = $this->usuarios->getIdUserbyUsuario();

                            //RAZON PARA EL RECHAZO
                            $razon_rechazo;

                            //INSERTAR EN ENTREGAS EQUIPOS RECHAZADOS
                            $this->equipos_rechazados->set('ingreso', $ingreso);
                            $this->equipos_rechazados->set('id_equipo', $id_equipo);
                            $this->equipos_rechazados->set('id_administrador', $id_admin['id_user']);
                            $this->equipos_rechazados->set('id_usuario', $entregado_por);
                            $this->equipos_rechazados->set('razon_rechazo', $razon_rechazo);
                            $this->equipos_rechazados->add();


                            //PREPARANDO HISTORIAL
                            //USUARIO ADMIN
                            $usuario = $_SESSION['usuario'];
                            $this->usuarios->set('usuario', $usuario);
                            $id_admin = $this->usuarios->getIdUserbyUsuario();
                            
                            //EQUIPO
                            $id_equipo_registrado = $id_equipo;
                            
                            //ACCION Y RAZON
                            $accion = "Rechazo entrega";
                            $razon = $razon_rechazo;

                            //PREPARANDO LOS DATOS
                            $this->equipo_salida->set('id_admin', $id_admin['id_user']);
                            $this->equipo_salida->set('usuario', $entregado_por);
                            $this->equipo_salida->set('id_equipo', $id_equipo_registrado);
                            $this->equipo_salida->set('accion', $accion);
                            $this->equipo_salida->set('razon', $razon);

                            //INSERTANDO EN EL HISTORIAL
                            $this->equipo_salida->entregarEquipoHistorial();

                            ////ELIMINANDO DE LA TABLA EQUIPOS APROBACION (SOLO SE NECESITA LA ID DE APROBACION)
                            $id_aprobacion = $id;
                            $this->equipo_ingresado->set('id_aprobacion', $id_aprobacion);
                            //PODEMOS ELIMINAR AL YA HABER OBTENIDO LA DATA NECESARIA MAS ARRIBA
                            $this->equipo_ingresado->eliminarDeEsperandoAprobacion();

                            //REDIRECCIONANDO CON UN MENSAJE DE EXITO
                            echo '<script>
                                        Swal.fire({
                                            title: "Exito",
                                            text: "Entrega rechazada exitosamente, notifiquele al operador asignado",
                                            icon: "success",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'equipos/rechazosAdmin";
                                            }
                                        }).then(() => {
                                            window.location.href = "' . URL . 'equipos/rechazosAdmin"; // Esta línea se ejecutará cuando se cierre la alerta.
                                        });
                                    </script>';
                                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        }
                    }

                }

            }

            $data['titulo'] = "Rechazando entrega";

            return $data;

        }

        //APROBADO POR ADMIN
        public function aprobarEntrega($id){

            if($_SESSION['rol'] != 1){

                //REDIRECCIONANDO CON UN MENSAJE DE ERROR
                echo '<script>
                            Swal.fire({
                                title: "Error",
                                text: "No tienes privilegios de administrador",
                                icon: "error",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'equipos/index";
                                }
                            }).then(() => {
                                window.location.href = "' . URL . 'equipos/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

            //OBTENIENDO LA DATA DEL EQUIPO PARA ENTREGARLO
            $this->equipo_salida->set('id_aprobacion', $id);
            $equipo = $this->equipo_salida->getDataAprobacion();
            $entregado_por = $equipo['entregado_por'];
            $ingreso = $equipo['ingreso'];
            $id_equipo = $equipo['id_equipo'];
            $fecha_entrega = $equipo['fecha_entrega'];
            $conclusion = $equipo['conclusion'];

            //USUARIO ADMIN
            $usuario = $_SESSION['usuario'];
            $this->usuarios->set('usuario', $usuario);
            $id_admin = $this->usuarios->getIdUserbyUsuario();

            //AGRUPANDO LOS DATOS
            $this->equipo_salida->set('ingreso', $ingreso);
            $this->equipo_salida->set('fecha_entrega', $fecha_entrega);
            $this->equipo_salida->set('id_administrador', $id_admin['id_user']);
            $this->equipo_salida->set('entregado_por', $entregado_por);
            $this->equipo_salida->set('conclusion', $conclusion);

            //INSERTANDO LA INFORMACION EN TABLA EQUIPOS_ENTREGADOS
            $this->equipo_salida->addAdmin();

            //CAMBIANDO EL ESTADO DEL EQUIPO EN EQUIPOS_INGRESADOS DE 0 A 1, 0 PENDIENTE, 1 ENTREGADO
            $this->equipo_ingresado->set('id_ingreso', $ingreso);
            $this->equipo_ingresado->actualizarEstadodeEquipo();


            //CAMBIANDO EL ESTADO DEL EQUIPO REGISTRADO DE EN PROCESO A ACTIVO
            $this->cambiarEstadoEquipoRegistrado($id_equipo);

            //PREPARANDO HISTORIAL
            //USUARIO ADMIN
            $usuario = $_SESSION['usuario'];
            $this->usuarios->set('usuario', $usuario);
            $id_admin = $this->usuarios->getIdUserbyUsuario();
            
            //EQUIPO
            $id_equipo_registrado = $id_equipo;
            
            //ACCION Y RAZON
            $accion = "Entrega";
            $razon = $conclusion;

            //PREPARANDO LOS DATOS
            $this->equipo_salida->set('id_admin', $id_admin['id_user']);
            $this->equipo_salida->set('usuario', $entregado_por);
            $this->equipo_salida->set('id_equipo', $id_equipo_registrado);
            $this->equipo_salida->set('accion', $accion);
            $this->equipo_salida->set('razon', $razon);

            //INSERTANDO EN EL HISTORIAL
            $this->equipo_salida->entregarEquipoHistorial();

            //ELIMINAR DE LA APROBACION
            $this->equipo_salida->set('id_aprobacion', $id);
            $this->equipo_salida->eliminarAprobacion();

            //ELIMINAR ENTREGAS RECHAZADOS CON ESE INGRESO
            $this->equipos_rechazados->set('ingreso', $ingreso);
            $this->equipos_rechazados->delete();

             //REDIRECCIONANDO CON UN MENSAJE DE EXITO
             echo '<script>
                        Swal.fire({
                            title: "Exito",
                            text: "Entrega aprobada",
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
                        }).then(() => {
                            window.location.href = "' . URL . 'equipos/salida"; // Esta línea se ejecutará cuando se cierre la alerta.
                        });
                    </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

        }

        //OBTENIENDO DATA NECESARIA DEL EQUIPO PARA ENTREGARLO, DIRECTO DE LA TABLA EQUIPOS_INGRESADOS
        private function DataForEntrega($id){
            
            $this->equipo_ingresado->set('id_ingreso', $id);
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

        //EN CASO DE ENTREGA RECHAZADA
        private function revertirEquipo($id){

            $this->equipo_ingresado->set('ingreso', $id);
            $this->equipo_ingresado->rechazarAprobacionyCambiarestado();

        }

        public function desactivar($id){

            $this->equipo->set('id_equipo', $id);
            $this->equipo->desactivarEquipo();

            //REDIRECCIONANDO CON UN MENSAJE DE EXITO
            echo '<script>
            Swal.fire({
                title: "Exito",
                text: "Equipo desactivado exitosamente",
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
            }).then(() => {
                window.location.href = "' . URL . 'equipos/registrados"; // Esta línea se ejecutará cuando se cierre la alerta.
            });
            </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

        }

        public function reactivar($id){

            $this->equipo->set('id_equipo', $id);
            $this->equipo->reactivarEquipo();

            //REDIRECCIONANDO CON UN MENSAJE DE EXITO
            echo '<script>
            Swal.fire({
                title: "Exito",
                text: "Equipo reactivado exitosamente",
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
            }).then(() => {
                window.location.href = "' . URL . 'equipos/registrados"; // Esta línea se ejecutará cuando se cierre la alerta.
            });
            </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

        }

        //VALIDAR CLAVES DE ADMINISTRADOR
        private function verificarClaveAdminRechazo($usuario_admin, $claveform){

            $this->usuarios->set('id_user', $usuario_admin);
            $user = $this->usuarios->getUserbyId();
            $clavedb = $user['clave'];
    
            $flag = false;
    
            if(password_verify($claveform, $clavedb)){
    
                $flag = true;
    
            } else {
    
                $flag = false;
    
            }
    
            return $flag;
    
        }

      
    }

    $equipos = new equiposController();
?>