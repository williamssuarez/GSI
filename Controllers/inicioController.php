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

    public function index(){

        $datos['pendiente'] = $this->equipos_ingresados->getIngresosTotalesEquipos();
        $datos['entregado'] = $this->equipos_ingresados->getIngresosTotalesEntregados();

        return $datos;
    }

}

$inicio = new inicioController();

?>