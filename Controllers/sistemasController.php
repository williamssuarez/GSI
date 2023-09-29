<?php namespace Controllers;

use Models\Sistemas_operativos;
use Repository\Procesos1 as Repository1;

    class sistemasController{

        private $sistemas;

        public function __construct()
        {
            $this->sistemas = new Sistemas_operativos();
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
            $datos['titulo'] = "Sistemas Operativos";
            $datos['sistemas'] = $this->sistemas->lista();
            return $datos;
        }

        public function num($number){
            echo "El numero que elegiste es ".$number;
        }

        public function new(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $nombre = $_POST['nombre'];
                $tipo = $_POST['tipo'];

                //VERIFICANDO SI LOS CAMPOS ESTAN VACIOS
                if(empty($nombre)){

                    echo '<script>
                                Swal.fire({
                                    title: "Error!",
                                    text: "Parece que uno de los campos quedo vacio.",
                                    icon: "error",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'sistemas/new";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                } 
                //SI NO ESTAN VACIOS PROSEGUIR
                else {
                
                    if (empty($errores)) {
                        // No hay errores de validación, procesa los datos
                        $this->sistemas->set('nombre', $nombre);
                        $this->sistemas->set('tipo', $tipo);

                            $this->sistemas->add();

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
                                                window.location.href = "' . URL . 'sistemas/index";
                                            }
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.   

                        }
                    
                }

            }                        

        }

        public function delete($id){

            if($_SERVER['REQUEST_METHOD'] == 'GET'){

                $this->sistemas->set('id_os', $id);

                $this->sistemas->delete();

                echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Eliminado Exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'sistemas/index";
                                }
                            });
                        </script>';
                exit;
            }
        }

        public function edit($id){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $this->sistemas->set('id_os',$id);
                    $nombre = $_POST['nombre'];
                    $tipo = $_POST['tipo'];

                    $this->sistemas->set('nombre', $nombre);
                    $this->sistemas->set('tipo', $tipo);
    
                    $this->sistemas->edit();
    
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
                                    window.location.href = "' . URL . 'sistemas/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }  
                
                $this->sistemas->set('id_os',$id);
                $data['titulo'] = "Editando Nombre del Sistema Operativo";
                $data['sistemas'] = $this->sistemas->getDataEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;
        }
            

        public function view($id){
        
            $this->sistemas->set('id_os', $id);

            $datos[] = $this->sistemas->view();
            return $datos;
            
        }
      
    }

    $sistemas = new sistemasController();
?>