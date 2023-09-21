<?php namespace Controllers;

use Models\Operadores as Operadores;
use Repository\Procesos1 as Repository1;

    class operadoresController{

        private $operador;

        public function __construct()
        {
            $this->operador = new Operadores();
        }

        public function index(){
            $datos['titulo'] = "Operadores";
            $datos['operadores'] = $this->operador->lista();
            return $datos;
        }

        public function num($number){
            echo "El numero que elegiste es ".$number;
        }

        public function new(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $cedula = $_POST['cedula_identidad'];
                $correo = $_POST['correo'];

                $this->operador->set('nombre', $nombre);
                $this->operador->set('apellido', $apellido);
                $this->operador->set('cedula_identidad', $cedula);
                $this->operador->set('correo', $correo);

                $this->operador->add();

                echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Agregado Exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'operadores/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }                        

        }

        public function delete($id){

            if($_SERVER['REQUEST_METHOD'] == 'GET'){

                $this->operador->set('id_operador', $id);

                $this->operador->delete();

                echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Eliminado Exitosamente.",
                                icon: "warning",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'operadores/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

        }

        public function edit($id){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $cedula = $_POST['cedula_identidad'];
                    $correo = $_POST['correo'];

                    $this->operador->set('id_operador', $id);
                    $this->operador->set('nombre', $nombre);
                    $this->operador->set('apellido', $apellido);
                    $this->operador->set('cedula_identidad', $cedula);
                    $this->operador->set('correo', $correo);
    
                    $this->operador->edit();
    
                    echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Editado Exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'operadores/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }            
            
        }

        public function view($id){
        
            $this->operador->set('id_operador', $id);

            $datos[] = $this->operador->view();
            return $datos;
            
        }

        public function historial($id){

            $this->operador->set('id_operador', $id);

            $datos[] = $this->operador->historial();
            return $datos;
        }

        public function suspend($id){

            $this->operador->set('id_operador', $id);

            $this->operador->suspend();

            echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Suspendido Exitosamente.",
                                icon: "warning",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'operadores/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
        }

        public function activate($id){

            $this->activar($id);

            echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Reactivado Exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'operadores/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
        }

        private function activar($id){

            $this->operador->set('id_operador', $id);
            $this->operador->activando();
        }
      
    }

    $operadores = new operadoresController();
?>