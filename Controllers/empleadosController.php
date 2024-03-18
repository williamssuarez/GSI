<?php namespace Controllers;

use Models\Empleados;
use Models\Auditoria;
use Models\Usuario;
USE Models\Departamentos;

class empleadosController
{
    private $empleados;
    private $auditoria;
    private $usuarios;
    private $departamentos;

    public function __construct()
    {
        $this->empleados = new Empleados();
        $this->auditoria = new Auditoria();
        $this->usuarios = new Usuario();
        $this->departamentos = new Departamentos();

        //SI EL USUARIO NO ESTA AUTENTICADO
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
        //SI EL ROL NO ES ADMIN
        if($_SESSION['rol'] != 1){

            //OBTENIENDO DATA PARA AUDITAR EL ACCESO NO AUTORIZADO

            //OBTENIENDO DATOS DEL USUARIO NO ADMIN QUE INTENTO ACCEDER
            $this->usuarios->set('usuario', $_SESSION['usuario']);
            $id_user = $this->usuarios->getIdUserbyUsuario();
            $user = $id_user['id_user'];

            //PREPARANDO AUDITORIA
            $tipo_cambio = 12; //ACCESO NO AUTORIZADO
            $tabla_afectada = 'Empleados';

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

    //OBTENIENDO DATA NECESARIA PARA EL REGISTRO DEL EMPLEADO
    public function getDataIngreso(){

        $datos['titulo'] = "Registro de Empleado";
        $datos['departamentos'] = $this->departamentos->lista();

        return $datos;
    }
    public function index(){

        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
        $this->usuarios->set('usuario', $_SESSION['usuario']);
        $id_user = $this->usuarios->getIdUserbyUsuario();
        $user = $id_user['id_user'];

        $tipo_cambio = 10; //TIPO DE CAMBIO 10 = Accedio a
        $tabla_afectada = "Empleados";
        $registro_afectado = "Ninguno";
        $valor_antes = "Ninguno";
        $valor_despues = "Ninguno";
        $usuario = $user;

        //EJECUTANDO LA AUDITORIA
        $this->auditoria->auditar($tipo_cambio, $tabla_afectada, $registro_afectado, $valor_antes, $valor_despues, $usuario);

        $datos['titulo'] = "Empleados";
        $datos['empleados'] = $this->empleados->lista();
        return $datos;
    }

    public function new(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $nombre_completo = $_POST['nombre_completo'];
            $cedula = $_POST['cedula'];
            $departamento = $_POST['departamento'];

            //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
            if(empty($nombre_completo) || empty($cedula)){

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
                                        window.location.href = "' . URL . 'empleados/new";
                                    }
                                }).then(() => {
                                    window.location.href = "' . URL . 'empleados/new"; // Esta línea se ejecutará cuando se cierre la alerta.
                                });
                            </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

            }
            //SI NO ESTAN VACIOS PROSEGUIR
            else {

                $errores = array();

                // Validar nombre
                if (!preg_match('/^[A-Za-z\s]+$/', $nombre_completo)) {
                    $errores[] = "Nombre debe contener solo letras y espacios.";
                }

                // Validar cedula_identidad como número entero
                if (!is_numeric($cedula)) {
                    $errores[] = "Cédula de identidad debe ser un número entero.";
                }

                //VALIDANDO SI LA CEDULA NO PERTENECE A ALGUN EMPLEADO
                $this->empleados->set('cedula', $cedula);
                $responseAjax = $this->empleados->getEmpleadobyCedulaforAjax();

                if(!empty($responseAjax)){
                    $errores[] = "Cédula de identidad ya registrada con un empleado.";
                }

                //VALIDANDO SI LA CEDULA NO PERTENECE A ALGUN USUARIO DEL SISTEMA
                $this->usuarios->set('cedula', $cedula);
                $responseAjax2 = $this->usuarios->getUserbyCedulaforAjax();

                if(!empty($responseAjax2)){
                    $errores[] = "Cédula de identidad ya registrada con un usuario del sistema.";
                }

                //VALIDANDO SI LA CEDULA ESTA ENTRE 6 Y 9 DIGITOS
                $numDigits = strlen(strval($cedula));

                if($numDigits <= 6 || $numDigits >= 9){
                    $errores[] = "Cédula de identidad debe ser entre 6 y 9 digitos.";
                }

                if (empty($errores)) {
                    // No hay errores de validación, procesa los datos
                    $this->empleados->set('nombre_completo', $nombre_completo);
                    $this->empleados->set('cedula', $cedula);
                    $this->empleados->set('departamento_id', $departamento);

                    //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                    $this->usuarios->set('usuario', $_SESSION['usuario']);
                    $id_user = $this->usuarios->getIdUserbyUsuario();
                    $user = $id_user['id_user'];

                    //PREPARANDO AUDITORIA
                    $tipo_cambio = 4;
                    $tabla_afectada = 'Empleados';
                    $registro_afectado = 0;

                    //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                    //$valorAntesarray = array($data['nombre'], $data['apellido'], $data['cedula_identidad'], $data['correo']);
                    $valorDespuesarray = array($nombre_completo, $cedula);

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

                    $this->empleados->add();

                    echo '<script>
                                        Swal.fire({
                                            title: "Exito",
                                            text: "Empleado agregado exitosamente.",
                                            icon: "success",
                                            timer: 1000,
                                            showConfirmButton: false,
                                        }).then(() => {
                                            window.location.href = "' . URL . 'empleados/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                        });
                                    </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                }
                else {
                    // Hubo errores de validación, muestra los mensajes de error
                    echo '<script>
                                        Swal.fire({
                                            title: "Hubo errores de validacion...",
                                            text: " Recuerda que el nombre debe ser solo texto y la cedula solo numeros enteros, ademas que la cedula no debe ser igual a otra que hayas introducido",
                                            icon: "error",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'empleados/new";
                                            }
                                        }).then(() => {
                                            window.location.href = "' . URL . 'empleados/new"; // Esta línea se ejecutará cuando se cierre la alerta.
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
        $tabla_afectada = 'Empleados';
        $registro_afectado = 0;
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

            $this->empleados->set('id_empleado', $id);
            $value = $this->empleados->getDataEdit();
            $cedulaOriginal = $value['cedula'];

            $nombre_completo = $_POST['nombre_completo'];
            $cedula = $_POST['cedula'];
            $departamento = $_POST['departamento'];

        

            if(empty($nombre_completo) || empty($cedula)){

                echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Ni el nombre ni la cedula pueden estar vacios",
                        icon: "warning",
                        showConfirmButton: true,
                        confirmButtonColor: "#3464eb",
                        customClass: {
                            confirmButton: "rounded-button" // Identificador personalizado
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "' . URL . 'empleados/edit/' . $id . '";
                        }
                    }).then(() => {
                        window.location.href = "' . URL . 'empleados/edit/' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                    });
                </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            } else {
                
                $errores = array();

                // Validar nombre
                if (!preg_match('/^[A-Za-z\s]+$/', $nombre_completo)) {
                    $errores[] = "Nombre debe contener solo letras y espacios.";
                }

                // Validar cedula_identidad como número entero
                if (!is_numeric($cedula)) {
                    $errores[] = "Cédula de identidad debe ser un número entero.";
                }

                //VALIDANDO SI LA CEDULA ESTA ENTRE 6 Y 9 DIGITOS
                $numDigits = strlen(strval($cedula));

                if($numDigits <= 6 || $numDigits >= 9){
                    $errores[] = "Cédula de identidad debe ser entre 6 y 9 digitos.";
                }

                //SI LA CEDULA DEL FORMULARIO Y LA DE LA DB SON DISTINTAS SIGNIFICA QUE SE INTENTA
                //EDITAR, VERIFICAR SI NO LE PERTENECE A ALGUIEN MAS
                if($cedula != $cedulaOriginal){
                    
                    //VALIDANDO SI LA CEDULA NO PERTENECE A ALGUN EMPLEADO
                    $this->empleados->set('cedula', $cedula);
                    $responseAjax = $this->empleados->getEmpleadobyCedulaforAjax();

                    if(!empty($responseAjax)){
                        $errores[] = "Cédula de identidad ya registrada con un empleado.";
                    }

                    //VALIDANDO SI LA CEDULA NO PERTENECE A ALGUN USUARIO DEL SISTEMA
                    $this->usuarios->set('cedula', $cedula);
                    $responseAjax2 = $this->usuarios->getUserbyCedulaforAjax();

                    if(!empty($responseAjax2)){
                        $errores[] = "Cédula de identidad ya registrada con un usuario del sistema.";
                    }
                }

                if(empty($errores)){

                    //OBTENIENDO DATA PARA AUDITORIA
                    $this->empleados->set('id_empleado',$id);
                    $data = $this->empleados->getEmpleadosforAuditoria();

                    // No hay errores de validación, procesa los datos
                    $this->empleados->set('nombre_completo', $nombre_completo);
                    $this->empleados->set('cedula', $cedula);
                    $this->empleados->set('departamento_id', $departamento);

                    //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
                    $this->usuarios->set('usuario', $_SESSION['usuario']);
                    $id_user = $this->usuarios->getIdUserbyUsuario();
                    $user = $id_user['id_user'];

                    //PREPARANDO AUDITORIA
                    $tipo_cambio = 3;
                    $tabla_afectada = 'Empleados';
                    $registro_afectado = $data['id_empleado'];
                    
                    //PREPARANDO EL VALOR ANTES Y EL VALOR DESPUES
                    $valorAntesarray = array($data['nombre_completo'], $data['cedula'], $data['departamento_id']);
                    $valorDespuesarray = array($nombre_completo, $cedula, $departamento);
                    
                    //CONVIRITENDOLO A JSON PARA GUARDARLO
                    $valor_antes = json_encode($valorAntesarray);
                    $valor_despues = json_encode($valorDespuesarray);
                    $usuario  = $user;

                    //EJECUTANDO LA AUDITORIA
                    $this->auditoria->auditar($tipo_cambio, 
                                            $tabla_afectada, 
                                            $registro_afectado, 
                                            $valor_antes, 
                                            $valor_despues, 
                                            $usuario);

                    $this->empleados->edit();

                    echo '<script>
                                        Swal.fire({
                                            title: "Exito",
                                            text: "Empleado editado exitosamente.",
                                            icon: "success",
                                            timer: 1000,
                                            showConfirmButton: false,
                                        }).then(() => {
                                            window.location.href = "' . URL . 'empleados/index"; // Esta línea se ejecutará cuando se cierre la alerta.
                                        });
                                    </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                } else {

                    // Hubo errores de validación, muestra los mensajes de error
                    echo '<script>
                                        Swal.fire({
                                            title: "Hubo errores de validacion...",
                                            text: " Recuerda que el nombre debe ser solo texto y la cedula solo numeros enteros, ademas que la cedula no debe ser igual a otra que hayas introducido",
                                            icon: "error",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'empleados/edit/' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                                            }
                                        }).then(() => {
                                            window.location.href = "' . URL . 'empleados/edit/' . $id . '"; // Esta línea se ejecutará cuando se cierre la alerta.
                                        });
                                    </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

                }

            }

        }  

        //OBTENIENDO DATA PARA AUDITORIA
        $this->empleados->set('id_empleado',$id);
        $data = $this->empleados->getEmpleadosforAuditoria();

        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO PARA LA AUDITORIA
        $this->usuarios->set('usuario', $_SESSION['usuario']);
        $id_user = $this->usuarios->getIdUserbyUsuario();
        $user = $id_user['id_user'];

        //PREPARANDO AUDITORIA
        $tipo_cambio = 2;
        $tabla_afectada = 'Empleados';

        $registro_afectado = $data['id_empleado'];
        $valorAntesarray = array($data['nombre_completo'], $data['cedula'], $data['departamento_id']);
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
        
        $this->empleados->set('id_empleado', $id);
        $data['titulo'] = "Editando datos del empleado";
        $data['empleados'] = $this->empleados->getDataEdit();
        $data['departamentos'] = $this->departamentos->getDepartamentos();

        return $data;
}
}

$empleados = new empleadosController();