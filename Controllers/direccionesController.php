<?php namespace Controllers;

use Models\Direcciones;
use Models\Departamentos;
use Models\Dispositivos;
use Models\Direcciones_ip;
use Models\setRango;
use Repository\Procesos1 as Repository1;

    class direccionesController{

        private $direccion;
        private $departamento;
        private $dispositivo;
        private $direccion_ip;
        private $setRangoIp;

        public function __construct()
        {
            $this->direccion = new Direcciones();
            $this->departamento = new Departamentos();
            $this->dispositivo = new Dispositivos();
            $this->direccion_ip = new Direcciones_ip();
            $this->setRangoIp = new setRango();
        }

        public function index(){
            $datos['titulo'] = "Direcciones";
            $datos['direcciones'] = $this->direccion->listar();
            return $datos;
        }

        public function getDireccionesLibresporRango(){

                $datos['titulo'] = "Direcciones IP";
                $datos['direcciones'] = $this->direccion_ip->getDireccionesporRango();
                $datos['dispositivos'] = $this->dispositivo->lista();

                return $datos;
            
        }

        public function rango(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $departamento = $_POST['departamento'];
    
                $this->setRangoIp->set('id_departamento',$departamento);
    
                $this->setRangoIp->setRangoForIp();
    
                echo '<script>
                                Swal.fire({
                                    title: "Redireccionando...",
                                    text: "Rango de direcciones obtenido!",
                                    icon: "success",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'direcciones/new";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                }

            $datos['titulo'] = "Seleccione el departamento";
            $datos['departamentos'] = $this->departamento->lista();
            return $datos;
        }

        public function setrango(){

            
        }

        public function new(){            
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $dispositivo = $_POST['dispositivo'];
                $direccion = $_POST['direccion'];
                $numero_bien = $_POST['numero_bien'];

                $this->direccion->set('tipo_dispositivo', $dispositivo);
                $this->direccion->set('id_direccion', $direccion);
                $this->direccion->set('numero_bien', $numero_bien);

                //Agregando la nueva direccion a la base de datos
                $this->direccion->add();

                //Cambiando estado de 0 libre a 1 ocupado
                $this->changeEstado($direccion);

                //Sumando el numero de direcciones asignadas al departamento
                $this->actualizarDireccionesenDepartamento();

                //Liberando el rango en la tabla setrango en la base de datos
                $this->liberarRango();

                echo '<script>
                            Swal.fire({
                                title: "Redireccionando...",
                                text: "Asignacion Exitosa!",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'direcciones/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

        }

        public function liberarRango(){

            $this->setRangoIp->liberarRangoForIp();

        }

        public function actualizarDireccionesenDepartamento(){

            $this->departamento->actualizarDireccionesAsignadas();
        }

        public function changeEstado($id){

            $this->direccion_ip->set('id_ip', $id);

            $this->direccion_ip->ocupar();
        }

        public function delete($id){

            if($_SERVER['REQUEST_METHOD'] == 'GET'){

                $this->direccion->set('id_ip', $id);

                $this->direccion->delete();

                echo '<script>
                            Swal.fire({
                                title: "Redireccionando...",
                                text: "Eliminado Exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'direcciones/index";
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

                    $this->direccion->set('id_operador', $id);
                    $this->direccion->set('nombre', $nombre);
                    $this->direccion->set('apellido', $apellido);
    
                    $this->direccion->edit();
    
                    echo '<script>window.location.href = "' . URL . 'direcciones/index";</script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }            
            
        }
      
    }

    $direcciones = new direccionesController();
?>