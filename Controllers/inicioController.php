<?php  namespace Controllers;

use Repository\Procesos1;
use Models\Equipos_ingresados;
use Models\Usuario;
use Models\Auditoria;

class inicioController{

    private $proceso1;
    private $equipos_ingresados;
    private $usuarios;
    private $auditoria;

    public function __construct()
    {
        $this->proceso1 = new Procesos1();
        $this->equipos_ingresados = new Equipos_ingresados();
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
        

    }

    public function index(){

        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO
        $this->usuarios->set('usuario', $_SESSION['usuario']);
        $id_user = $this->usuarios->getIdUserbyUsuario();
        $user = $id_user['id_user'];


        $tipo_cambio = 10;
        $tabla_afectada = "Inicio";
        $registro_afectado = "Ninguno";
        $valor_antes = "Ninguno";
        $valor_despues = "Ninguno";
        $usuario = $user;

        //EJECUTANDO LA AUDITORIA
        $this->auditoria->auditar($tipo_cambio, $tabla_afectada, $registro_afectado, $valor_antes, $valor_despues, $usuario);

        $datos['pendiente'] = $this->equipos_ingresados->getIngresosTotalesEquipos();
        $datos['entregado'] = $this->equipos_ingresados->getIngresosTotalesEntregados();
        $datos['aprobacion'] = $this->equipos_ingresados->getIngresosTotalesAprobacion();

        //OBTENIENDO LOS EQUIPOS RECHAZADOS DEL OPERADOR
        $this->equipos_ingresados->set('usuario', $id_user['id_user']);
        $datos['rechazos'] = $this->equipos_ingresados->verificarRechazosTotales();

        // PARA OBTENER LOS EQUIPOS ASIGNADOS A EL
        $this->equipos_ingresados->set('recibido_por', $user);
        $datos['asignados'] = $this->equipos_ingresados->getAsignacionesTotalesaUsuario();

        return $datos;
    }

    public function pieChart(){

        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO
        $this->usuarios->set('usuario', $_SESSION['usuario']);
        $id_user = $this->usuarios->getIdUserbyUsuario();
        $user = $id_user['id_user'];

        //OBTENIENDO LOS EQUIPOS RECHAZADOS DEL OPERADOR
        $this->equipos_ingresados->set('usuario', $id_user['id_user']);
        $datos['rechazos'] = $this->equipos_ingresados->verificarRechazosTotales();
        $datos['pendiente'] = $this->equipos_ingresados->getIngresosTotalesEquipos();
        $datos['entregado'] = $this->equipos_ingresados->getIngresosTotalesEntregados();
        $datos['aprobacion'] = $this->equipos_ingresados->getIngresosTotalesAprobacion();
        

        // Simulación de datos para propósitos de ejemplo
        $data = array(
            "labels" => ["Ingresados", "Entregados", "En Revision", "Entregas Rechazadas"],
            "data" => [$datos['pendiente'], $datos['entregado'], $datos['aprobacion'], $datos['rechazos']]
        );

        // Convierte los datos a formato JSON y envíalos de vuelta
        echo json_encode($data);


    }

}

$inicio = new inicioController();

?>