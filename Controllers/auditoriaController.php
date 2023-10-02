<?php namespace Controllers;

use Models\Auditoria;
use Repository\Procesos1 as Repository1;

    class auditoriaController{

        private $auditoria;

        public function __construct()
        {
            $this->auditoria = new Auditoria();

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