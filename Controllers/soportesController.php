<?php 

namespace Controllers;

use Models\Soportes_abiertos;
use Models\Soportes_pendientes;
use Models\Soportes_cerrados;

class soportesController{

    private $soportes_abiertos;
    private $soportes_pendientes;
    private $soportes_cerrados;

    public function __construct(){

            $this->soportes_abiertos = new Soportes_abiertos();
            $this->soportes_cerrados = new Soportes_cerrados();
            $this->soportes_pendientes = new Soportes_pendientes();

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

         //LISTANDO LOS EQUIPOS INGRESADOS
         public function index() {
            $datos['titulo'] = "Todos los Soportes Abiertos";
            $datos['abiertos'] = $this->soportes_abiertos->lista();
            
            return $datos;
        }

}

$soportes = new soportesController();

?>