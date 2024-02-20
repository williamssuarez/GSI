<?php


namespace Controllers;


use Models\Equipos;
use Models\Equipos_ingresados;
use Models\Usuario;

class ajaxController
{
    private $equipos;
    private $equipos_ingresados;
    private $usuarios;

    public function __construct()
    {
        $this->equipos = new Equipos();
        $this->equipos_ingresados = new Equipos_ingresados();
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

    //PIE CHART DEL INICIO PARA OPR
    public function pieChartAdmin() {

        ob_end_clean();
        ob_start();
        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO
        $this->usuarios->set('usuario', $_SESSION['usuario']);
        $id_user = $this->usuarios->getIdUserbyUsuario();
        $user = $id_user['id_user'];

        //OBTENIENDO LOS EQUIPOS RECHAZADOS DEL OPERADOR
        $this->equipos_ingresados->set('usuario', $id_user['id_user']);
        $datos = array();
        $datos[0] = $this->equipos_ingresados->getIngresosTotalesEquipos();
        $datos[1] = $this->equipos_ingresados->getIngresosTotalesEntregados();
        $datos[2] = $this->equipos_ingresados->getIngresosTotalesAprobacion();
        $datos[3] = $this->equipos_ingresados->verificarRechazosTotales();

        $test = $datos[0];

        // Simulación de datos para propósitos de ejemplo
        $data = array(
            "labels" => ["Ingresados", "Entregados", "En Revision", "Entregas Rechazadas"],
            "data" => [$datos],
            "test" => $test
        );

        // Convierte los datos a formato JSON y envíalos de vuelta
        header('Content-Type: application/json');
        ob_end_clean();
        echo json_encode($data, JSON_PRETTY_PRINT);
        //echo $data;
    }

    //PIE CHART DEL INICIO PARA ADMIN
    public function pieChartOpr()
    {
        ob_end_clean();
        ob_start();
        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO
        $this->usuarios->set('usuario', $_SESSION['usuario']);
        $id_user = $this->usuarios->getIdUserbyUsuario();
        $user = $id_user['id_user'];

        //OBTENIENDO LOS EQUIPOS RECHAZADOS DEL OPERADOR
        $this->equipos_ingresados->set('usuario', $id_user['id_user']);
        $datos = array();
        $datos[0] = $this->equipos_ingresados->getIngresosTotalesEquipos();
        $datos[1] = $this->equipos_ingresados->getIngresosTotalesEntregados();
        $datos[2] = $this->equipos_ingresados->getIngresosTotalesAprobacion();
        $datos[3] = $this->equipos_ingresados->verificarRechazosTotales();

        $test = $datos[0];

        // Simulación de datos para propósitos de ejemplo
        $data = array(
            "labels" => ["Ingresados", "Entregados", "En Revision", "Entregas Rechazadas"],
            "data" => [$datos],
            "test" => $test
        );

        // Convierte los datos a formato JSON y envíalos de vuelta
        header('Content-Type: application/json');
        ob_end_clean();
        echo json_encode($data, JSON_PRETTY_PRINT);
        //echo $data;
    }

    //COMPROBAR SI EL EQUIPO ESTA REGISTRADO ANTES DE INGRESARLO
    public function comprobarBien(){

        ob_end_clean();
        ob_start();

        if (isset($_POST['numero_bien'])) {
            // Access the value
            $numero_bien = filter_input(INPUT_POST, 'numero_bien', FILTER_SANITIZE_STRING);

            $this->equipos->set('numero_bien', $numero_bien);
            $responseAjax = $this->equipos->getEquipobyNumerodeBien();

            if(!empty($responseAjax)){
                $response = 1;
            } else {
                $response = 0;
            }

            ob_end_clean();
            echo json_encode($response);
        } else {
            echo "Missing required data: numero_bien";
        }

    }

}