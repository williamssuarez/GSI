<?php namespace Controllers;

use Models\Auditoria;
use Models\Usuario;
use Repository\Procesos1 as Repository1;

    class auditoriaController{

        private $auditoria;
        private $usuario;

        public function __construct()
        {
            $this->auditoria = new Auditoria();
            $this->usuario = new Usuario();

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

        public function filtroporFecha(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $fecha_incio = $_POST['fecha_inicio'];
                $fecha_final = $_POST['fecha_final'];

                $this->auditoria->set('fecha_inicio', $fecha_incio);
                $this->auditoria->set('fecha_final', $fecha_final);

                $datos['titulo'] = "Filtrado por fecha";
                $datos['auditoria'] = $this->auditoria->auditarFiltrosRangoFecha();

                if(isset($_SESSION['filtrofecha'])){

                    unset($_SESSION['filtrofecha']);

                }

                $_SESSION['filtrofecha'] = $datos;

                // El usuario no es administrador, redirige al inicio
                echo '<script>
                Swal.fire({
                    title: "Filtro aplicado",
                    text: "Redireccinando",
                    icon: "success",
                    showConfirmButton: true,
                    confirmButtonColor: "#3464eb",
                    confirmButtonText: "Aceptar",
                    customClass: {
                        confirmButton: "rounded-button" // Identificador personalizado
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . URL . 'auditoria/filtrarRangoFecha";
                    }
                }).then(() => {
                    window.location.href = "' . URL . 'auditoria/filtrarRangoFecha"; // Esta línea se ejecutará cuando se cierre la alerta.
                });
                </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
            }

            $data['title'] = "Filtro Cambios";
            $data['cambios'] = $this->auditoria->listaCambios();

            return $data;

        }

        public function filtrarporTipoCambio(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $cambio = $_POST['cambio'];

                $this->auditoria->set('tipo_cambio', $cambio);

                $datos['titulo'] = "Filtrado por cambios";
                $datos['auditoria'] = $this->auditoria->auditarFiltrosCambios();

                if(isset($_SESSION['filtrocambios'])){

                    unset($_SESSION['filtrocambios']);

                }

                $_SESSION['filtrocambios'] = $datos;

                // El usuario no es administrador, redirige al inicio
                echo '<script>
                Swal.fire({
                    title: "Filtro aplicado",
                    text: "Redireccinando",
                    icon: "success",
                    showConfirmButton: true,
                    confirmButtonColor: "#3464eb",
                    confirmButtonText: "Aceptar",
                    customClass: {
                        confirmButton: "rounded-button" // Identificador personalizado
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . URL . 'auditoria/filtroCambio";
                    }
                }).then(() => {
                    window.location.href = "' . URL . 'auditoria/filtroCambio"; // Esta línea se ejecutará cuando se cierre la alerta.
                });
                </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
            }

            $data['title'] = "Filtro Cambios";
            $data['cambios'] = $this->auditoria->listaCambios();

            return $data;

        }


        public function filtrarporUsuario(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $usuario = $_POST['usuario'];

                $this->auditoria->set('usuario', $usuario);

                $datos['titulo'] = "Filtrado por usuario";
                $datos['auditoria'] = $this->auditoria->auditarFiltrosUsuario();

                if(isset($_SESSION['filtrousuario'])){

                    unset($_SESSION['filtrousuario']);

                }

                $_SESSION['filtrousuario'] = $datos;

                // El usuario no es administrador, redirige al inicio
                echo '<script>
                Swal.fire({
                    title: "Filtro aplicado",
                    text: "Redireccinando",
                    icon: "success",
                    showConfirmButton: true,
                    confirmButtonColor: "#3464eb",
                    confirmButtonText: "Aceptar",
                    customClass: {
                        confirmButton: "rounded-button" // Identificador personalizado
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . URL . 'auditoria/filtroUsuario";
                    }
                }).then(() => {
                    window.location.href = "' . URL . 'auditoria/filtroUsuario"; // Esta línea se ejecutará cuando se cierre la alerta.
                });
                </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
            }

            $data['title'] = "Filtro";
            $data['users'] = $this->usuario->lista();

            return $data;

        }

        public function filtroCambio(){ 

            if(!isset($_SESSION['filtrocambios'])){

                // El usuario no es administrador, redirige al inicio
                echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "No se ha aplicado ningun filtro",
                    icon: "error",
                    showConfirmButton: true,
                    confirmButtonColor: "#3464eb",
                    confirmButtonText: "Aceptar",
                    customClass: {
                        confirmButton: "rounded-button" // Identificador personalizado
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . URL . 'auditoria/filtrarporTipoCambio";
                    }
                }).then(() => {
                    window.location.href = "' . URL . 'auditoria/filtrarporTipoCambio"; // Esta línea se ejecutará cuando se cierre la alerta.
                });
                </script>';
                exit;

            } else {
                //SI NO SE HA APLICADO EL FILTRO
                $data['title'] = "Filtro por Cambios";

                return $data;
            }

        }

        public function filtrarRangoFecha(){

            if(!isset($_SESSION['filtrofecha'])){

                // El usuario no es administrador, redirige al inicio
                echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "No se ha aplicado ningun filtro",
                    icon: "error",
                    showConfirmButton: true,
                    confirmButtonColor: "#3464eb",
                    confirmButtonText: "Aceptar",
                    customClass: {
                        confirmButton: "rounded-button" // Identificador personalizado
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . URL . 'auditoria/filtroporFecha";
                    }
                }).then(() => {
                    window.location.href = "' . URL . 'auditoria/filtroporFecha"; // Esta línea se ejecutará cuando se cierre la alerta.
                });
                </script>';
                exit;

            } else {
                //SI NO SE HA APLICADO EL FILTRO
                $data['title'] = "Filtro por fecha";

                return $data;
            }

        }

        public function filtroUsuario(){

            if(!isset($_SESSION['filtrousuario'])){

                // El usuario no es administrador, redirige al inicio
                echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "No se ha aplicado ningun filtro",
                    icon: "error",
                    showConfirmButton: true,
                    confirmButtonColor: "#3464eb",
                    confirmButtonText: "Aceptar",
                    customClass: {
                        confirmButton: "rounded-button" // Identificador personalizado
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . URL . 'auditoria/filtrarporUsuario";
                    }
                }).then(() => {
                    window.location.href = "' . URL . 'auditoria/filtrarporUsuario"; // Esta línea se ejecutará cuando se cierre la alerta.
                });
                </script>';
                exit;

            } else {
                //SI NO SE HA APLICADO EL FILTRO
                $data['title'] = "Filtro por Usuarios";

                return $data;
            }

            

        }


        //SALIENDO DE LOS FILTROS
        public function salirFiltroUsuario(){

            unset($_SESSION['filtrousuario']);

            // El usuario no es administrador, redirige al inicio
            echo '<script>
            Swal.fire({
                title: "Deshaciendo filtro",
                text: "Redireccinando",
                icon: "success",
                showConfirmButton: true,
                confirmButtonColor: "#3464eb",
                confirmButtonText: "Aceptar",
                customClass: {
                    confirmButton: "rounded-button" // Identificador personalizado
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "' . URL . 'auditoria/index";
                }
            }).then(() => {
                window.location.href = "' . URL . 'auditoria/index"; // Esta línea se ejecutará cuando se cierre la alerta.
            });
            </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

        }

        public function salirFiltroCambio(){

            unset($_SESSION['filtrocambios']);

            // El usuario no es administrador, redirige al inicio
            echo '<script>
            Swal.fire({
                title: "Deshaciendo filtro",
                text: "Redireccinando",
                icon: "success",
                showConfirmButton: true,
                confirmButtonColor: "#3464eb",
                confirmButtonText: "Aceptar",
                customClass: {
                    confirmButton: "rounded-button" // Identificador personalizado
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "' . URL . 'auditoria/index";
                }
            }).then(() => {
                window.location.href = "' . URL . 'auditoria/index"; // Esta línea se ejecutará cuando se cierre la alerta.
            });
            </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

        }

        public function salirFiltroFecha(){

            unset($_SESSION['filtrofecha']);

            // El usuario no es administrador, redirige al inicio
            echo '<script>
            Swal.fire({
                title: "Deshaciendo filtro",
                text: "Redireccinando",
                icon: "success",
                showConfirmButton: true,
                confirmButtonColor: "#3464eb",
                confirmButtonText: "Aceptar",
                customClass: {
                    confirmButton: "rounded-button" // Identificador personalizado
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "' . URL . 'auditoria/index";
                }
            }).then(() => {
                window.location.href = "' . URL . 'auditoria/index"; // Esta línea se ejecutará cuando se cierre la alerta.
            });
            </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

        }


    }

    $auditoria = new auditoriaController();
?>