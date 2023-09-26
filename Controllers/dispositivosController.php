<?php namespace Controllers;

use Models\Dispositivos;
use Repository\Procesos1 as Repository1;

    class dispositivosController{

        private $dispositivos;

        public function __construct()
        {
            $this->dispositivos = new Dispositivos();
        }

        public function index(){
            $datos['titulo'] = "Dispositivos";
            $datos['dispositivos'] = $this->dispositivos->lista();
            return $datos;
        }

        public function num($number){
            echo "El numero que elegiste es ".$number;
        }

        public function new(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $nombre = $_POST['nombre'];

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
                                        window.location.href = "' . URL . 'dispositivos/new";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional

                } 
                //SI NO ESTAN VACIOS PROSEGUIR
                else {

                    $errores = array();

                    // Validar nombre y apellido como texto
                    if (!ctype_alpha($nombre)) {
                        $errores[] = "Nombre debe contener solo letras.";
                    }
                
                    if (empty($errores)) {
                        // No hay errores de validación, procesa los datos
                        $this->dispositivos->set('nombre_dispositivo', $nombre);

                            $this->dispositivos->add();

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
                                                window.location.href = "' . URL . 'dispositivos/index";
                                            }
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.   

                        }
                    else {
                        // Hubo errores de validación, muestra los mensajes de error
                        echo '<script>
                                        Swal.fire({
                                            title: "Hubo errores de validacion...",
                                            text: " Recuerda que el nombre no deben llevar numeros",
                                            icon: "error",
                                            showConfirmButton: true,
                                            confirmButtonColor: "#3464eb",
                                            customClass: {
                                                confirmButton: "rounded-button" // Identificador personalizado
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "' . URL . 'dispositivos/new";
                                            }
                                        });
                                    </script>';
                            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                    }
                }

            }                        

        }

        public function edit($id){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $this->dispositivos->set('id_dispositivos',$id);
                    $nombre_dispositivo = $_POST['nombre'];

                    $this->dispositivos->set('nombre_dispositivo', $nombre_dispositivo);
    
                    $this->dispositivos->edit();
    
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
                                    window.location.href = "' . URL . 'dispositivos/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }  
                
                $this->dispositivos->set('id_dispositivos',$id);
                $data['titulo'] = "Editando Nombre del Dispositivo";
                $data['dispositivos'] = $this->dispositivos->getDataEdit();

                //var_dump($data['operador']);
                //die(); 

                return $data;
        }
            

        public function view($id){
        
            $this->dispositivos->set('id_operador', $id);

            $datos[] = $this->dispositivos->view();
            return $datos;
            
        }
      
    }

    $dispositivos = new dispositivosController();
?>