<?php namespace Controllers;

use Models\Auditoria;
use Models\Equipos;
use Models\Equipos_ingresados;
use Models\Equipos_salida;
use Models\Equipos_rechazados;
use Models\Departamentos;
use Models\Operadores;
use Models\Sistemas_operativos;
use Models\Usuario;
use Models\Empleados;
use Models\Direcciones_ip;
use Models\Direcciones;
use Repository\Procesos1 as Repository1;

//CONTROLADORES
use Controllers\direccionesController;

    class equiposController{

        private $auditoria;
        private $equipo;
        private $equipo_ingresado;
        private $equipo_salida;
        private $equipos_rechazados;
        private $departamento;
        private $operadores;
        private $sistema_operativo;
        private $usuarios;
        private $empleados;
        private $direcciones_ip;
        private $direcciones_asignacion;

        public function __construct()
        {
            $this->auditoria = new Auditoria();
            $this->equipo = new Equipos();
            $this->equipo_ingresado = new Equipos_ingresados();
            $this->equipo_salida = new Equipos_salida();
            $this->equipos_rechazados = new Equipos_rechazados();
            $this->departamento = new Departamentos();
            $this->operadores = new Operadores();
            $this->sistema_operativo = new Sistemas_operativos();
            $this->usuarios = new Usuario();
            $this->empleados = new Empleados();
            $this->direcciones_ip = new Direcciones_ip();
            $this->direcciones_asignacion = new Direcciones();

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
            $datos['empleados'] = $this->empleados->getEmpleados();
            $datos['sistemas'] = $this->sistema_operativo->getSistemas();

            return $datos;
        }

        //OBTENIENDO DATA NECESARIA PARA EL INGRESO
        public function getDataIngreso(){

            $datos['titulo'] = "Equipos Ingresados";
            $datos['departamentos'] = $this->departamento->lista();
            $datos['operadores'] = $this->usuarios->getUsuariosActivos();

            return $datos;
        }

        //OBTENIENDO DATA NECESARIA PARA LA SALIDA
        public function getDataSalida(){

            $datos['titulo'] = "Entregando Equipo...";
            $datos['operadores'] = $this->usuarios->getUsuariosActivos();

            return $datos;
        }

        //INGRESANDO EQUIPO NUEVO ADMIN
        public function new(){
           
            if($_SESSION['rol'] == 1){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $numero_bien = $_POST['numero_bien2'];
    
                    if(isset($_POST['fecha_recibido']) > 0){
                        $fecha_recibido = $_POST['fecha_recibido'];
                    } else {
                        $fecha_recibido = "now()";                    
                    }
                    
                    //OBTENIENDO EL ID DEL USUARIO
                    $recibido_por = $_POST['recibido_por'];
                    
                    $problema = trim($_POST['problema']);
    
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

                        if($id_equipo['estado'] == 4){
                            
                            //REDIRECCIONANDO CON UN MENSAJE DE ERROR
                            echo '<script>
                                    Swal.fire({
                                        title: "Equipo no Aprobado",
                                        text: "El registro de este equipo no esta aprobado, apruebelo, o rechazelo y vuelva a cargarlo con los datos correctos para hacerlo parte de los proceso del sistema.",
                                        icon: "warning",
                                        showConfirmButton: true,
                                        confirmButtonColor: "#3464eb",
                                        confirmButtonText: "OK",
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
                                timer: 1000,
                                showConfirmButton: false,
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
                                        timer: 1000,
                                        showConfirmButton: false,
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
                $direccion_ip = $_POST['direccion_ip'];
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
                if(empty($numero_bien)){

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

                    if(!empty($direccion_mac)){
                        function validateMacAddress($direccion_mac) {
                            $pattern = '/^([0-9A-F]{2}:){5}[0-9A-F]{2}$/i';
                            return preg_match($pattern, $direccion_mac);
                        }
                        
                        if (!validateMacAddress($direccion_mac)) {
                            $errores[] = "La direccion MAC debe tener un formato MAC válido (XX:XX:XX:XX:XX:XX).";
                        }
                    }

                    if(empty($direccion_ip)){
                        //SIN IP
                        $direccion_ip = 66050;
                    } else {

                        $direccion_ip = trim($direccion_ip);
                        $pattern = $this->validateIpAddress($direccion_ip);

                        if($pattern == true){

                            $this->direcciones_ip->set('direccion', $direccion_ip);

                            //OBTENER ID POR DIRECCION (SI ESTA LIBRE)
                            $id_ip = $this->direcciones_ip->getIdByDireccion();

                            if(!$id_ip){
                                $errores[] = "Parece que esta direccion ya se encuentra asignada a otro equipo.";
                            } else {
                                //SI ENCONTRO ENTONCES ESTA LIBRE
                                $direccion_ip = $id_ip;
                            }

                        } else {
                            $errores[] = "La direccion IP debe tener un formato válido, por ejemplo (192.9.100.16).";
                        }
                    }
                    
                    // Validar numero de bien como número entero
                    if(!empty($memoria_ram)){
                        if(!is_numeric($memoria_ram)){
                            $errores[] = "La memoria ram debe ser un valor entero numerico.";
                        }
                    }
                    if(!empty($almacenamiento)){
                        if(!is_numeric($almacenamiento)){
                            $errores[] = "La memoria de almacenamiento debe ser un valor entero numerico.";
                        }
                    }
                
                    if (empty($errores)) {
                        // No hay errores de validación, procesa los datos

                        $this->equipo->set('numero_bien', $numero_bien);
                        $this->equipo->set('departamento', $departamento);
                        $this->equipo->set('usuario', $usuario);
                        //$this->equipo->set('direccion_ip', $direccion_ip);
                        $this->equipo->set('direccion_mac', $direccion_mac);
                        $this->equipo->set('cpu', $cpu);
                        $this->equipo->set('almacenamiento', $almacenamiento);
                        $this->equipo->set('memoria_ram', $memoria_ram);
                        $this->equipo->set('sistema_operativo', $sistema_operativo);
                        $this->equipo->set('registrado_por', $registrado_por);
                        

                        //VERIFICANDO SI EL NUMERO DE BIEN Y LA MAC YA EXISTEN
                        $cuenta = $this->equipo->verificarEquipoBien();
                        
                        if(!empty($mac)){
                            $cuenta_mac = $this->equipo->verificarEquipoMac(); 

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
                        }

                        //SI YA EXISTE, REDIRIGIR DE NUEVO AL FORMULARIO CON MENSAJE DE ERROR
                        if($cuenta['cuenta'] > 0){

                            echo '<script>
                                        Swal.fire({
                                            title: "Error",
                                            text: "Este Numero de bien ya existe",
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

                            if($direccion_ip != 66050){
                                
                                $this->direcciones_ip->set('id_ip', $direccion_ip['id_ip']);

                                //OCUPAR
                                $this->direcciones_ip->ocupar();

                                //ENCONTRAR DATOS DEL EQUIPO POR EL NUMERO DEL BIEN PARA LA ASIGNACION
                                $this->equipo->set('numero_bien', $numero_bien);
                                $equipo_data = $this->equipo->getEquipobyNumerodeBien();
                                
                                //PREPARAR DATA PARA INSERTAR EN ASIGNACIONES
                                $this->usuarios->set('usuario', $_SESSION['usuario']);
                                $id_user = $this->usuarios->getIdUserbyUsuario();

                                /*var_dump($equipo_data['numero_bien']);
                                die();*/

                                $this->direcciones_asignacion->set('id_administrador', $id_user['id_user']);
                                $this->direcciones_asignacion->set('id_direccion', $direccion_ip['id_ip']);
                                $this->direcciones_asignacion->set('tipo_dispositivo', 2);
                                $this->direcciones_asignacion->set('numero_bien', $equipo_data['numero_bien']);
                                $this->direcciones_asignacion->set('equipo', $equipo_data['id_equipo']);

                                $this->direcciones_asignacion->add();

                                //OBTENIENDO LA ID DE ASIGNACION PARA INSERTARLA EN LA TABLA EQUIPOS
                                $this->direcciones_asignacion->set('numero_bien', $equipo_data['numero_bien']);
                                $id_asignacion = $this->direcciones_asignacion->getAsignacionIDbyNumeroBien();

                                //INSERTANDO EL ID DE ASIGNACION AL EQUIPO CORRESPONDIENTE
                                $this->equipo->set('id_equipo', $equipo_data['id_equipo']);
                                $this->equipo->set('direccion_ip', $id_asignacion['id_asignacion']);
                                $this->equipo->AsignarDireccionEquipo();

                                $accion = 0;
                                $razon = "Asignacion de direccion";
                            
                                $this->direcciones_ip->set('usuario_administrador', $id_user['id_user']);
                                $this->direcciones_ip->set('id_ip', $direccion_ip['id_ip']);
                                $this->direcciones_ip->set('tipo_dispositivo', 2);
                                $this->direcciones_ip->set('numero_bien_dispositivo', $equipo_data['numero_bien']);
                                $this->direcciones_ip->set('accion', $accion);
                                $this->direcciones_ip->set('razon', $razon);

                                //INSERTANDO EN EL HISTORIAL
                                $this->direcciones_ip->asignarDireccionHistorial();
                                
                            }

                            //SI EL USUARIO NO ES ADMIN INSERTAR CON ESTADO 4 DE PENDIENTE DE APROBAR EL REGISTRO
                            if($_SESSION['rol'] != 1){
                                $this->equipo->set('numero_bien', $numero_bien);
                                $equipo_data = $this->equipo->getEquipobyNumerodeBien();

                                $this->equipo->set('id_equipo', $equipo_data['id_equipo']);
                                $this->equipo->cambiarEstadoaPendienteAprobacion();
                            }

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

                        $errorMessage = "";
                        foreach ($errores as $error) {
                        $errorMessage .= "<li>$error</li>";
                        }

                        // Hubo errores de validación, muestra los mensajes de error
                        echo '<script>
                                        Swal.fire({
                                            title: "Hubo errores de validacion...",
                                            html: "<ul>' . $errorMessage . '</ul>",
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

    public function aprobarregistro($id){

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

        } else {

            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                
                $this->equipo->set('id_equipo', $id);
                $this->equipo->aprobarRegistro();

                echo '<script>
                            Swal.fire({
                                title: "Registro Aprobado Exitosamente",
                                text: "El registro ahora es considerado activo y forma parte de los proceso del sistema",
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
                    exit; 
            }

        }

    }

    public function rechazarregistro($id){

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

        } else {

            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                
                $this->equipo->set('id_equipo', $id);
                //VERIFICAR SI TIENE UNA DIRECCION ASIGNADA
                $equipo_data = $this->equipo->getEquipoForAuditoria();//USAR LA FUNCION DE LA AUDITORIA YA QUE TRAE TODOS LOS DATOS DEL EQUIPO POR EL ID

                if($equipo_data['direccion_ip'] != NULL){

                    //SI LA DIRECCION IP NO ESTA VACIA ES DECIR QUE HAY UNA ASIGNACION, ELIMINAR DICHA ASIGNACION ANTES DE PROSEGUIR

                    $this->direcciones_asignacion->set('id_asignacion', $equipo_data['direccion_ip']);

                    $id_ip = $this->direcciones_asignacion->getDataForLiberation();

                    //LIBERANDO LA DIRECCION DEL EQUIPO
                    //$this->equipo->set('id_equipo', $id_ip['id_equipo']);
                    $this->equipo->liberarDireccionEquipo();

                    //CAMBIANDO EL ESTADO DE LA DIRECCION DE OCUPADO A LIBRE
                    $this->direcciones_ip->set('id_ip', $id_ip['id_direccion']);
                    $this->direcciones_ip->release();

                    //ELIMINAR ASIGNACION
                    $this->direcciones_asignacion->delete();
                }

                //SI NO, PROSEGUIR CON LA ELIMINACION
                $this->equipo->delete();

                echo '<script>
                            Swal.fire({
                                title: "Registro eliminado Exitosamente",
                                text: "El registro ha sido rechazado y eliminado, notifiquele al operador para que vuelva a cargar los datos correctos",
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
                    exit; 
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

                    //OBTENIENDO DATA ACTUAL PARA COMPARAR CON LA DEL FORM
                    $current_data = $this->equipo->getDataEdit();

                    /*var_dump($current_data['numero_bien']);
                    die();*/

                    $numero_bien = $_POST['numero_bien'];
                    $departamento = $_POST['departamento'];
                    $usuario = $_POST['usuario'];
                    $direccion_ip = $_POST['direccion_ip'];
                    $direccion_mac = $_POST['direccion_mac'];
                    $cpu = $_POST['cpu'];
                    $almacenamiento = $_POST['almacenamiento'];
                    $memoria_ram = $_POST['memoria_ram'];
                    $sistema_operativo = $_POST['sistema'];

                    var_dump($direccion_ip);
                    die();

                    //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
                    if(empty($numero_bien)){

                        echo '<script>
                                    Swal.fire({
                                        title: "Error",
                                        text: "Parece que el numero de bien quedo vacio",
                                        icon: "error",
                                        showConfirmButton: true,
                                        confirmButtonColor: "#3464eb",
                                        customClass: {
                                            confirmButton: "rounded-button" // Identificador personalizado
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "' . URL . 'equipos/editregistro/' . $id . '";
                                        }
                                    }).then(() => {
                                        window.location.href = "' . URL . 'equipos/editregistro/' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                                    });
                                </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                    }

                    $errores = array();
                    
                    if(!empty($direccion_mac)){
                        function validateMacAddress($direccion_mac) {
                            $pattern = '/^([0-9A-F]{2}(?:[:-])){5}[0-9A-F]{2}$/i';
                            return preg_match($pattern, $direccion_mac);
                          }
                        
                        if (!validateMacAddress($direccion_mac)) {
                            $errores[] = "La direccion MAC debe tener un formato MAC válido (XX-XX-XX-XX-XX-XX).";
                        }
                    }

                    if(empty($direccion_ip)){
                        //SIN IP
                        $direccion_ip = 66050;
                    } else {

                        $direccion_ip = trim($direccion_ip);
                        $pattern = $this->validateIpAddress($direccion_ip);

                        if($pattern == true){

                            $this->direcciones_ip->set('direccion', $direccion_ip);

                            //OBTENER ID POR DIRECCION (SI ESTA LIBRE)
                            $id_ip = $this->direcciones_ip->getIdByDireccion();

                            if(!$id_ip){
                                $errores[] = "Parece que esta direccion ya se encuentra asignada a otro equipo.";
                            } else {
                                //SI ENCONTRO ENTONCES ESTA LIBRE
                                $direccion_ip = $id_ip;
                            }

                        } else {
                            $errores[] = "La direccion IP debe tener un formato válido, por ejemplo (192.9.100.16).";
                        }
                    }
                    
                    // Validar numero de bien como número entero
                    if(!empty($memoria_ram)){
                        if(!is_numeric($memoria_ram)){
                            $errores[] = "La memoria ram debe ser un valor entero numerico.";
                        }
                    }
                    if(!empty($almacenamiento)){
                        if(!is_numeric($almacenamiento)){
                            $errores[] = "La memoria de almacenamiento debe ser un valor entero numerico.";
                        }
                    }
    
                    if(empty($errores)){
                        $this->equipo->set('numero_bien', $numero_bien);
                        $this->equipo->set('departamento', $departamento);
                        $this->equipo->set('usuario', $usuario);
                        $this->equipo->set('direccion_mac', $direccion_mac);
                        $this->equipo->set('cpu', $cpu);
                        $this->equipo->set('almacenamiento', $almacenamiento);
                        $this->equipo->set('memoria_ram', $memoria_ram);
                        $this->equipo->set('sistema_operativo', $sistema_operativo);

                        //VERIFICANDO SI EL NUMERO DE BIEN Y LA MAC YA EXISTEN
                        /*$cuenta = $this->equipo->verificarEquipoBien();
                        $cuenta_mac = $this->equipo->verificarEquipoMac(); */

                        //SI EL NUMERO DE BIEN DEL FORM ES DIFERENTE AL ACTUAL ENTONCES CAMBIO
                        if($current_data['numero_bien'] != $numero_bien){

                            $cuenta = $this->equipo->verificarEquipoBien();

                            //SI YA EXISTE, REDIRIGIR DE NUEVO AL FORMULARIO CON MENSAJE DE ERROR
                            if($cuenta['cuenta'] > 0){

                                echo '<script>
                                            Swal.fire({
                                                title: "Error",
                                                text: "Este Numero de bien ya existe",
                                                icon: "error",
                                                showConfirmButton: true,
                                                confirmButtonColor: "#3464eb",
                                                customClass: {
                                                    confirmButton: "rounded-button" // Identificador personalizado
                                                }
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "' . URL . 'equipos/editregistro/' . $id . '";
                                                }
                                            }).then(() => {
                                                window.location.href = "' . URL . 'equipos/editregistro/' . $id . '";
                                            });
                                        </script>';
                                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                            } 
                        }

                        //SI LA MAC DEL FORM ES DIFERENTE A LA ACTUAL ENTONCES CAMBIO TAMBIEN
                        if($current_data['direccion_mac'] != $direccion_mac){

                            if(!empty($direccion_mac)){
                                $cuenta_mac = $this->equipo->verificarEquipoMac(); 
    
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
                                                        window.location.href = "' . URL . 'equipos/editregistro/' . $id . '";
                                                    }
                                                }).then(() => {
                                                    window.location.href = "' . URL . 'equipos/editregistro/' . $id . '";
                                                });
                                            </script>';
                                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
        
                                }
                            }
                        }



                        //OBTENIENDO DATA PARA AUDITORIA
                        $this->equipo->set('id_equipo',$id);
                        $data = $this->equipo->getEquipoForAuditoria();

                        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                        $this->usuarios->set('usuario', $_SESSION['usuario']);
                        $id_user = $this->usuarios->getIdUserbyUsuario();
                        $user = $id_user['id_user'];

                        //PREPARANDO AUDITORIA
                        $tipo_cambio = 3;
                        $tabla_afectada = 'Equipos';
                        $registro_afectado = $data['id_equipo'];
                        
                        //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                        $valorAntesarray = array(
                            $data['numero_bien'], 
                            $data['departamento'], 
                            $data['usuario'],
                            $data['direccion_mac'],
                            $data['cpu'],
                            $data['memoria_ram'],
                            $data['almacenamiento'],
                            $data['sistema_operativo'],
                        );

                        $valorDespuesarray = array(
                            $numero_bien, 
                            $departamento, 
                            $usuario,
                            $direccion_mac,
                            $cpu,
                            $memoria_ram,
                            $almacenamiento,
                            $sistema_operativo
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

                }  
                
                $this->equipo->set('id_equipo',$id);
                $data['titulo'] = "Editando Datos del Equipo";
                $data['equipo'] = $this->equipo->getDataEdit();

                if($data['equipo']['direccion_ip'] != NULL){

                    //OBTENER DIRECCION POR ASIGNACION
                    $this->direcciones_asignacion->set('id_asignacion', $data['equipo']['direccion_ip']);
                    $id_ip = $this->direcciones_asignacion->getIdDireccionByIdAsignacion();

                    $this->direcciones_ip->set('id_ip', $id_ip['id_direccion']);
                    $ip = $this->direcciones_ip->getDireccionIpById();
                    $data['equipo']['direccion_ip'] = $ip['direccion'];

                }


                $data['departamentos'] = $this->departamento->getDepartamentos();
                $data['empleados'] = $this->empleados->getEmpleados();
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

        //EDITAR EQUIPO INGRESADO
        public function edit($id){

                if($_SESSION['rol'] == 10){

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
                    
                    $this->equipo_ingresado->set('id_equipo',$id);

                    $data['titulo'] = "Editando Datos del Equipo";
                    $data['equipo'] = $this->equipo->getDataEdit();
        
                    //var_dump($data['operador']);
                    //die(); 
        
                    return $data;

                } else {
                    //NO ES ADMIN, REDIRIGIR
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
                                    timer: 1500,
                                    showConfirmButton: false,
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
                                timer: 1000,
                                showConfirmButton: false,
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
                                            timer: 1500,
                                            showConfirmButton: false,
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
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.href = "' . URL . 'equipos/salida"; // Esta línea se ejecutará cuando se cierre la alerta.
                        });
                    </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

        }

        public function DeterminarCambiosdeEquipo(){

            echo '<script>
                    Swal.fire({
                        title: "Defina la solucion",
                        text: "¿La solucion que se le dio al equipo involucra un cambio de O.S o hardware?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Sí, se tuvieron que hacer cambios",
                        cancelButtonText: "No, esta igual como ingreso",
                        customClass: {
                            confirmButton: "rounded-button",
                            cancelButton: "rounded-button"
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirigir si se hace clic en "Sí"
                            window.location.href = "' . URL . 'equipos/new";
                        } else {
                            // Redirigir a otra ruta si se hace clic en "No"
                            window.location.href = "' . URL . 'equipos/index";
                        }
                    });
                </script>';
        exit;


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

        private function validateIpAddress($ipAddress) {
            $pattern = '/^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$/';
        
            /* Ensure each segment is within the valid range (0-255) */
            if (preg_match($pattern, $ipAddress)) {
               $segments = explode('.', $ipAddress);
               foreach ($segments as $segment) {
                   if ($segment < 0 || $segment > 255) {
                       return false;
                   }
               }
               return true;
            } else {
                return false;
            }
        }
        

        //NOTAS DEL OPERADOR POR INCIDENCIA
        public function ReportarAvances(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $titulo = $_POST['titulo'];
                
                //OBTENIENDO EL ID DEL USUARIO
                $recibido_por = $_POST['recibido_por'];
                
                $problema = $_POST['problema'];

                //VERIFICANDO SI EL EQUIPO ESTA REGISTRADO
                $this->equipo->set('numero_bien', $titulo);
                $cuenta = $this->equipo->verificarEquipoBien();
                    
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

                    $datos['titulo'] = "Nuevo reporte";
                    return $datos;

                }

        }

      
    }

    $equipos = new equiposController();
?>