<?php  namespace Controllers;

use Repository\Procesos1;
use Models\Equipos_ingresados;

class inicioController{

    private $proceso1;
    private $equipos_ingresados;

    public function __construct()
    {
        $this->proceso1 = new Procesos1();
        $this->equipos_ingresados = new Equipos_ingresados();

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

        $datos['pendiente'] = $this->equipos_ingresados->getIngresosTotalesEquipos();
        $datos['entregado'] = $this->equipos_ingresados->getIngresosTotalesEntregados();

        return $datos;
    }

}

$inicio = new inicioController();

?>