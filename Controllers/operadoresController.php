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

                header('Location: index');

            }                        

        }

        public function delete($id){

            if($_SERVER['REQUEST_METHOD'] == 'GET'){

                $this->operador->set('id_operador', $id);

                $this->operador->delete();

                header('Location: /gsi/operadores/index');
                exit;

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
    
                    header('Location: /gsi/operadores/index');
    
                }            
            
        }

        public function view($id){
        
            $this->operador->set('id_operador', $id);

            $datos[] = $this->operador->view();
            return $datos;
            
        }

        public function suspend($id){

            $this->operador->set('id_operador', $id);

            $this->operador->suspend();

                header('Location: /gsi/operadores/index');
                exit;
        }
      
    }

    $operadores = new operadoresController();
?>