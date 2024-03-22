<?php namespace Controllers;

use Models\Direcciones;
use Models\Departamentos;
use Models\Dispositivos;
use Models\Direcciones_ip;
use Models\setRango;
use Models\Equipos;
use Models\Usuario;
use Models\Auditoria;

    class direccionesController{

        private $direccion;
        private $departamento;
        private $dispositivo;
        private $direccion_ip;
        private $setRangoIp;
        private $equipo;
        private $usuario;
        private $auditoria;

        public function __construct()
        {
            $this->direccion = new Direcciones();
            $this->departamento = new Departamentos();
            $this->dispositivo = new Dispositivos();
            $this->direccion_ip = new Direcciones_ip();
            $this->setRangoIp = new setRango();
            $this->equipo = new Equipos();
            $this->usuario = new Usuario();
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

                // El usuario no es administrador, redirige al inicio


                //OBTENIENDO DATA PARA AUDITAR EL ACCESO NO AUTORIZADO

                    //OBTENIENDO DATOS DEL USUARIO NO ADMIN QUE INTENTO ACCEDER 
                    $this->usuario->set('usuario', $_SESSION['usuario']);
                    $id_user = $this->usuario->getIdUserbyUsuario();
                    $user = $id_user['id_user'];

                    //PREPARANDO AUDITORIA
                    $tipo_cambio = 12; //ACCESO NO AUTORIZADO
                    $tabla_afectada = 'direcciones';

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
            $datos['titulo'] = "Direcciones";
            $datos['direcciones'] = $this->direccion->listar();
            return $datos;
        }

        public function getDireccionesLibresporRango(){

                $datos['titulo'] = "Direcciones IP";
                $datos['rango'] = $this->setRangoIp->getRango();
                $datos['direcciones'] = $this->direccion_ip->getDireccionesporRango();
                $datos['dispositivos'] = $this->dispositivo->lista();

                return $datos;
            
        }

        public function rango(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $departamento = $_POST['departamento'];
    
                $this->setRangoIp->set('id_departamento',$departamento);

                //VERIFICANDO SI HAY UN RANGO NO ELIMINADO CORRECTAMENTE
                $cuenta = $this->setRangoIp->validarRango();

                //SI YA EXISTE, ELIMINAR Y LUEGO INSERTAR
                if($cuenta['cuenta'] > 0){

                    $this->setRangoIp->liberarRangoForIp();
                    $this->setRangoIp->setRangoForIp();

                }
                //CASO CONTRARIO, SOLO INSERTAR
                else {

                    $this->setRangoIp->setRangoForIp();

                }
    
                echo '<script>
                                Swal.fire({
                                    title: "Redireccionando...",
                                    text: "Rango de direcciones obtenido!",
                                    icon: "success",
                                    timer: 1000,
                                    showConfirmButton: false,
                                }).then(() => {
                                    window.location.href = "' . URL . 'direcciones/new"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                }

            $datos['titulo'] = "Seleccione el departamento";
            $datos['departamentos'] = $this->departamento->lista();
            return $datos;
        }

        public function new(){            
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $dispositivo = $_POST['dispositivo'];
                $direccion = $_POST['direccion'];
                $numero_bien = $_POST['numero_bien'];

                //SI EL DISPOSITIVO ES UNA COMPUTADORA
                if($dispositivo == 2){
                    
                    //VERIFICANDO SI EL EQUIPO ESTA REGISTRADO
                    $this->equipo->set('numero_bien', $numero_bien);
                    $cuenta = $this->equipo->verificarEquipoBien(); 

                    //SI LA CUENTA ES MAYOR A 0 ENTONCES ESTA REGISTRADO
                    if($cuenta['cuenta'] > 0){

                        //OBTENIENDO EL ID DEL EQUIPO PARA INSERTARLO
                        $id_equipo = $this->equipo->getEquipobyNumerodeBien();

                        //VERIFICANDO SI EL RANGO DE IP OBTENIDO COINCIDE CON EL DEPARTAMENTO DEL EQUIPO
                        $flag = $this->verificarEquipoyRango($id_equipo['departamento']);

                        if($flag == true){

                            //OBTENIENDO EL ID DEL ADMINISTRADOR
                            $this->usuario->set('usuario', $_SESSION['usuario']);
                            $id_admin = $this->usuario->getIdUserbyUsuario();

                            //UNA VEZ OBTENIDO LO SETEAMOS        
                            $this->direccion->set('id_administrador', $id_admin['id_user']);                
                            $this->direccion->set('equipo', $id_equipo['id_equipo']);
                            $this->direccion->set('tipo_dispositivo', $dispositivo);
                            $this->direccion->set('id_direccion', $direccion);
                            $this->direccion->set('numero_bien', $numero_bien);

                            //Agregando la nueva direccion a la base de datos
                            $this->direccion->add();

                            //OBTENIENDO LA ID DE ASIGNACION PARA INSERTARLA EN LA TABLA EQUIPOS
                            $this->direccion->set('numero_bien', $numero_bien);
                            $id_asignacion = $this->direccion->getAsignacionIDbyNumeroBien();

                            //INSERTANDO EL ID DE ASIGNACION AL EQUIPO CORRESPONDIENTE
                            $this->equipo->set('id_equipo', $id_equipo['id_equipo']);
                            $this->equipo->set('direccion_ip', $id_asignacion['id_asignacion']);
                            $this->equipo->AsignarDireccionEquipo();

                            //Cambiando estado de 0 libre a 1 ocupado
                            $this->changeEstado($direccion);

                            //Sumando el numero de direcciones asignadas al departamento
                            //El departamento no requiere pasar ninguna variable porque se usa el especificado en el rango
                            $this->actualizarDireccionesenDepartamento();

                            //Sumando el numero de direcciones asignadas al dispositivo
                            $this->actualizarDireccionesenDispositivos($dispositivo);

                            //Liberando el rango en la tabla setrango en la base de datos
                            $this->liberarRango();

                            //OBTENIENDO LA DATA PARA INSERTAR EN EL HISTORIAL
                            $this->direccion->set('id_direccion', $direccion);
                            $id_asignacion = $this->direccion->getIdAsignacionByDireccion();
                            $this->direccion->set('id_asignacion', $id_asignacion['id_asignacion']);
                            $id_ip = $direccion;
                            $this->usuario->set('usuario', $_SESSION['usuario']);
                            $id_user = $this->usuario->getIdUserbyUsuario(); 
                            $data = $this->direccion->getDataForLiberation();
                            

                            //PREPARANDO LA DATA A INSERTAR EN EL HISTORIAL
                            $usuario_administrador = $id_user['id_user'];
                            $id_direccionIP = $id_ip;
                            $tipo_dispositivo = $data['tipo_dispositivo'];
                            //SI EL DISPOSITIVO TIENE UN NUMERO DE BIEN SE ASIGNA ESE
                            if($data['numero_bien'] > 0){

                                $numero_bien_dispositivo = $data['numero_bien'];

                            } else {
                                //CASO CONTRARIO, SE INSERTA, SIN NUMERO DE BIEN
                                $numero_bien_dispositivo = "Dispositivo sin numero de bien";
                            }
                            
                            $accion = 0;
                            $razon = "Asignacion de direccion";
                        

                            $this->direccion_ip->set('usuario_administrador', $usuario_administrador);
                            $this->direccion_ip->set('id_ip', $id_direccionIP);
                            $this->direccion_ip->set('tipo_dispositivo', $tipo_dispositivo);
                            $this->direccion_ip->set('numero_bien_dispositivo', $numero_bien_dispositivo);
                            $this->direccion_ip->set('accion', $accion);
                            $this->direccion_ip->set('razon', $razon);

                            //INSERTANDO EN EL HISTORIAL
                            $this->direccion_ip->asignarDireccionHistorial();

                            //PROCESO TERMINADO, REDIRECCIONANDO
                            echo '<script>
                                        Swal.fire({
                                            title: "Redireccionando...",
                                            text: "Asignacion a equipo exitosa",
                                            icon: "success",
                                            timer: 1500,
                                            showConfirmButton: false,
                                        }).then(() => {
                                            window.location.href = "' . URL . 'direcciones/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        } else {

                                //Liberando el rango en la tabla setrango en la base de datos
                                $this->liberarRango();
                                //REDIRECCIONANDO CON UN MENSAJE DE ERROR
                                echo '<script>
                                Swal.fire({
                                    title: "Equipo invalido",
                                    text: "El rango de ip que solicitaste y el departamento al que pertenece el equipo no coinciden",
                                    icon: "warning",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    confirmButtonText: "Aceptar",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'direcciones/index";
                                    }
                                }).then(() => {
                                    window.location.href = "' . URL . 'direcciones/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                            </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                        }
                        
                    } 
                    //SI LA CUENTA ES INFERIOR A 0 ENTONCES NO ESTA REGISTRADO
                    else {

                        //REDIRECCIONANDO CON UN MENSAJE DE ERROR
                        echo '<script>
                        Swal.fire({
                            title: "Equipo no registrado!",
                            text: "Este equipo no esta registrado, registrelo para terminar la asignacion de la direccion.",
                            icon: "warning",
                            timer: 1500,
                            showConfirmButton: false,
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

                $this->direccion->set('tipo_dispositivo', $dispositivo);
                $this->direccion->set('id_direccion', $direccion);
                $this->direccion->set('numero_bien', $numero_bien);

                //Agregando la nueva direccion a la base de datos
                $this->direccion->add();

                //Cambiando estado de 0 libre a 1 ocupado
                $this->changeEstado($direccion);

                //Sumando el numero de direcciones asignadas al departamento
                //El departamento no requiere pasar ninguna variable porque se usa el especificado en el rango
                //$this->actualizarDireccionesenDepartamento();

                //Sumando el numero de direcciones asignadas al dispositivo
                //$this->actualizarDireccionesenDispositivos($dispositivo);

                //Liberando el rango en la tabla setrango en la base de datos
                $this->liberarRango();

                echo '<script>
                            Swal.fire({
                                title: "Redireccionando...",
                                text: "Asignacion Exitosa!",
                                icon: "success",
                                timer: 1500
                                showConfirmButton: false,
                                }).then(() => {
                                    window.location.href = "' . URL . 'direcciones/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

        }

        private function verificarEquipoyRango($id_departamento_equipo){

            $rango = $this->setRangoIp->getRangoIdDepartamento();

            $flag = false;

            if($rango['id_departamento'] == $id_departamento_equipo){

                $flag = true;

            } else {

                $flag = false;
            }

            return $flag;

        }

        //Liberando el rango en la tabla setrango en la base de datos
        private function liberarRango(){

            $this->setRangoIp->liberarRangoForIp();

        }

        //Sumando el numero de direcciones asignadas al departamento
        private function actualizarDireccionesenDepartamento(){

            $this->departamento->actualizarDireccionesAsignadas();
        }

        //Cambiando estado de 0 libre a 1 ocupado
        private function changeEstado($id){

            $this->direccion_ip->set('id_ip', $id);

            $this->direccion_ip->ocupar();
        }


        //Sumandole +1 al dispositivo asignadoS
        private function actualizarDireccionesenDispositivos($id_dispositivos){

            $this->dispositivo->set('id_dispositivos', $id_dispositivos);

            $this->dispositivo->actualizarDireccionesAsignadas();
        }

        private function verificarClaveAdminLiberation($usuario_admin, $claveform){

            $this->usuario->set('id_user', $usuario_admin);
            $user = $this->usuario->getUserbyId();
            $clavedb = $user['clave'];
    
            $flag = false;
    
            if(password_verify($claveform, $clavedb)){
    
                $flag = true;
    
            } else {
    
                $flag = false;
    
            }
    
            return $flag;
    
        }

        public function liberarDireccion($id){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                //OBTENIENDO LA DATA PARA INSERTAR EN EL HISTORIAL
                $this->direccion->set('id_asignacion', $id);
                $id_ip = $this->direccion->getIdDireccionByIdAsignacion();
                $this->usuario->set('usuario', $_SESSION['usuario']);
                $id_user = $this->usuario->getIdUserbyUsuario();                
                $data = $this->direccion->getDataForLiberation();
                

                //PREPARANDO LA DATA A INSERTAR EN EL HISTORIAL
                $usuario_administrador = $id_user['id_user'];
                $id_direccionIP = $id_ip['id_direccion'];
                $tipo_dispositivo = $data['tipo_dispositivo'];
                //SI EL DISPOSITIVO TIENE UN NUMERO DE BIEN SE ASIGNA ESE
                if($data['numero_bien'] > 0){

                    $numero_bien_dispositivo = $data['numero_bien'];

                } else {
                    //CASO CONTRARIO, SE INSERTA, SIN NUMERO DE BIEN
                    $numero_bien_dispositivo = "Dispositivo sin numero de bien";
                }
                
                $accion = 1;
                $razon = $_POST['razon'];
                $clave_admin = $_POST['clave_admin'];
                $clave_confirmacion = $_POST['clave_confirmacion'];

                if(!empty($razon)){

                    if($clave_admin == $clave_confirmacion){
                        //VALIDANDO CLAVES

                        $flag = $this->verificarClaveAdminLiberation($usuario_administrador, $clave_admin);

                        if($flag == true){

                            $this->direccion_ip->set('usuario_administrador', $usuario_administrador);
                            $this->direccion_ip->set('id_ip', $id_direccionIP);
                            $this->direccion_ip->set('tipo_dispositivo', $tipo_dispositivo);
                            $this->direccion_ip->set('numero_bien_dispositivo', $numero_bien_dispositivo);
                            $this->direccion_ip->set('accion', $accion);
                            $this->direccion_ip->set('razon', $razon);

                            //INSERTANDO EN EL HISTORIAL
                            $this->direccion_ip->liberarDireccionHistorial();

                            //Obteniendo la data necesaria antes de eliminar
                            $data = $this->direccion->getDataForLiberation();

                            //guardando la direccion
                            $id_direccion = $data['id_direccion'];

                            //guardando el dispositivo
                            $id_dispositivo = $data['tipo_dispositivo'];

                            //guardando el equipo
                            $id_equipo = $data['equipo'];

                            if(empty($id_equipo)){

                                $this->liberarSinEquipo($id_direccion, $id_dispositivo);

                            } else {

                                //funcion que cambia el estado de la ip, y reduce el total en el departamento y el dispositivo
                                $this->liberar($id_direccion, $id_dispositivo, $id_equipo);

                            }

                            echo '<script>
                                        Swal.fire({
                                            title: "Exito",
                                            text: "Eliminado Exitosamente.",
                                            icon: "warning",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'direcciones/index";
                                            }
                                        }).then(() => {
                                            window.location.href = "' . URL . 'direcciones/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                        });
                                    </script>';
                            exit;

                        } else {
                            //CLAVE INVALIDA
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
                                                window.location.href = "' . URL . 'direcciones/liberarDireccion/' . $id . '";
                                            }
                                        }).then(() => {
                                            window.location.href = "' . URL . 'direcciones/liberarDireccion/' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                                        });
                                    </script>';
                            exit;
                        }


                    } else {
                        //CLAVES NO COINCIDEN
                        echo '<script>
                                    Swal.fire({
                                        title: "Error",
                                        text: "Las claves no coinciden, vuelve a intentar",
                                        icon: "error",
                                        showConfirmButton: true,
                                        confirmButtonColor: "#3464eb",
                                        customClass: {
                                            confirmButton: "rounded-button" // Identificador personalizado
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "' . URL . 'direcciones/liberarDireccion/' . $id . '";
                                        }
                                    }).then(() => {
                                        window.location.href = "' . URL . 'direcciones/liberarDireccion/' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                                    });
                                </script>';
                        exit;
                    }

                } else {

                    //FORMULARIO VACIO
                    echo '<script>
                                Swal.fire({
                                    title: "Error",
                                    text: "Debes ingresar la razon de liberacion",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'direcciones/liberarDireccion/' . $id . '";
                                    }
                                }).then(() => {
                                    window.location.href = "' . URL . 'direcciones/liberarDireccion/' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                            </script>';
                    exit;


                }

            }

            $this->direccion->set('id_asignacion', $id);
            $id_ip = $this->direccion->getIdDireccionByIdAsignacion();
            $this->direccion_ip->set('id_ip', $id_ip['id_direccion']);
            $data['direccion'] = $this->direccion_ip->getDireccionIpById();
            $data['titulo'] = "Liberando direccion";

            return $data;
        }

        //funcion que cambia el estado de la ip, y reduce el total en el departamento y el dispositivo
        public function liberar($id_direccion, $id_dispositivo, $id_equipo){

                //Fijando el dispositivo
                $this->dispositivo->set('id_dispositivos', $id_dispositivo);

                //Fijando la direccion ip
                $this->direccion_ip->set('id_ip', $id_direccion);

                //Fijando el id del equipo
                $this->equipo->set('id_equipo', $id_equipo);

                //Reduciendole uno en asignaciones totales
                $this->dispositivo->reducirDireccionesenAsignadas();

                //Cambiandole el estado de ocupado a libre y reduciendole 1 al departamento correspondiente
                $this->direccion_ip->release();

                //Eliminando la id de asignacion del equipo
                $this->equipo->liberarDireccionEquipo();

                //Eliminando de la DB
                $this->direccion->delete();

                echo '<script>
                            Swal.fire({
                                title: "Redireccionando...",
                                text: "Direccion Liberada Exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'direcciones/index";
                                }
                            }).then(() => {
                                window.location.href = "' . URL . 'direcciones/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

        }

        //funcion que cambia el estado de la ip, y reduce el total en el departamento y el dispositivo
        public function liberarSinEquipo($id_direccion, $id_dispositivo){

            //Fijando el dispositivo
            $this->dispositivo->set('id_dispositivos', $id_dispositivo);

            //Fijando la direccion ip
            $this->direccion_ip->set('id_ip', $id_direccion);

            //Reduciendole uno en asignaciones totales
            $this->dispositivo->reducirDireccionesenAsignadas();

            //Cambiandole el estado de ocupado a libre y reduciendole 1 al departamento correspondiente
            $this->direccion_ip->release();

            //Eliminando de la DB
            $this->direccion->delete();

            echo '<script>
                        Swal.fire({
                            title: "Redireccionando...",
                            text: "Direccion Liberada Exitosamente.",
                            icon: "success",
                            showConfirmButton: true,
                            confirmButtonColor: "#3464eb",
                            customClass: {
                                confirmButton: "rounded-button" // Identificador personalizado
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "' . URL . 'direcciones/index";
                            }
                        }).then(() => {
                            window.location.href = "' . URL . 'direcciones/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                        });
                    </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

    }

        public function edit($id){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];

                    $this->direccion->set('id_operador', $id);
                    $this->direccion->set('nombre', $nombre);
                    $this->direccion->set('apellido', $apellido);
    
                    $this->direccion->edit();
    
                    echo '<script>window.location.href = "' . URL . 'direcciones/index";</script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }            
            
        }

        public function liberarDireccionHistorial(){

            
        }
      
    }

    $direcciones = new direccionesController();
?>