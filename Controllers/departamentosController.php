<?php namespace Controllers;

use Models\Departamentos;
use Repository\Procesos1 as Repository1;

    class departamentosController{

        private $departamento;

        public function __construct()
        {
            $this->departamento = new Departamentos();
        }

        public function index(){
            $datos['titulo'] = "Departamentos";
            $datos['departamentos'] = $this->departamento->lista();
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

                $this->departamento->set('nombre', $nombre);
                $this->departamento->set('apellido', $apellido);
                $this->departamento->set('cedula_identidad', $cedula);
                $this->departamento->set('correo', $correo);

                $this->departamento->add();

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

                $this->departamento->set('id_operador', $id);

                $this->departamento->delete();

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
                exit;

            }

        }

        public function edit($id){

            //var_dump($data);
            //die(); 

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $cedula = $_POST['cedula_identidad'];
                    $correo = $_POST['correo'];

                    $this->departamento->set('id_operador', $id);
                    $this->departamento->set('nombre', $nombre);
                    $this->departamento->set('apellido', $apellido);
                    $this->departamento->set('cedula_identidad', $cedula);
                    $this->departamento->set('correo', $correo);
    
                    $this->departamento->edit();
    
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
        
            $this->departamento->set('id_operador', $id);

            $datos[] = $this->departamento->view();
            return $datos;
            
        }
      
    }

    $departamentos = new departamentosController();
?>