<?php namespace Controllers;

use Models\Equipos_ingresados;
use Repository\Procesos1 as Repository1;

    class operadoresController{

        private $equipo_ingresado;
        private $equipo_salida;

        public function __construct()
        {
            $this->equipo_ingresado = new Equipos_ingresados();
        }

        public function index(){
            $datos['titulo'] = "Equipos Ingresados";
            $datos['equipos'] = $this->equipo_ingresado->lista();
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


      
    }

    $operadores = new operadoresController();
?>