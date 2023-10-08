<?php namespace Controllers;

use Models\Auditoria;
use Repository\Procesos1 as Repository1;

    class auditoriaController{

        private $auditoria;

        public function __construct()
        {
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
            $datos['titulo'] = "Auditoria";
            $datos['auditoria'] = $this->auditoria->lista();
            return $datos;
        }

        public function num($number){
            echo "El numero que elegiste es ".$number;
        }
            

        public function view($id){
        
            $this->auditoria->set('id_auditoria', $id);

            $datos['titulo'] = 'Detalles de la auditoria';
            $datos['auditoria'] = $this->auditoria->view();

            return $datos;
            
        }
    }

    $auditoria = new auditoriaController();
?>