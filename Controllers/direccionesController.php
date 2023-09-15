<?php namespace Controllers;

use Models\Direcciones;
use Models\Departamentos;
use Repository\Procesos1 as Repository1;

    class direccionesController{

        private $direccion;
        private $departamento;

        public function __construct()
        {
            $this->direccion = new Direcciones();
            $this->departamento = new Departamentos();
        }

        public function index(){
            $datos['titulo'] = "Direcciones";
            $datos['direcciones'] = $this->direccion->listar();
            return $datos;
        }

        public function getDireccionesLibres(){

                $datos['titulo'] = "Direcciones IP";
                $datos['departamentos'] = $this->departamento->lista();
                $datos['direcciones'] = $this->direccion->getDireccionesRandom();
    
                return $datos;
            
        }

        public function new(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $direccion = $_POST['direccion'];
                $departamento = $_POST['departamento'];

                $this->direccion->set('ip', $direccion);
                $this->direccion->set('departamento', $departamento);

                $this->direccion->add();

                header('Location: index');

            }                        

        }

        public function delete($id){

            if($_SERVER['REQUEST_METHOD'] == 'GET'){

                $this->direccion->set('id_ip', $id);

                $this->direccion->delete();

                header('Location: /gsi/direcciones/index');
                exit;

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
    
                    header('Location: /gsi/operadores/index');
    
                }            
            
        }

        public function view($id){
        
            $this->direccion->set('id_operador', $id);

            $datos[] = $this->direccion->view();
            return $datos;
            
        }


      
    }

    $direcciones = new direccionesController();
?>