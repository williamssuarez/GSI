<?php namespace Controllers;

use Models\Equipos_ingresados;
use Models\Departamentos;
use Models\Operadores;
use Repository\Procesos1 as Repository1;

    class equiposController{

        private $equipo_ingresado;
        private $equipo_salida;
        private $departamento;
        private $operadores;

        public function __construct()
        {
            $this->equipo_ingresado = new Equipos_ingresados();
            $this->departamento = new Departamentos();
            $this->operadores = new Operadores();
        }

        public function index(){
            $datos['titulo'] = "Equipos Ingresados";
            $datos['equipos'] = $this->equipo_ingresado->lista();
            return $datos;
        }

        public function num($number){
            echo "El numero que elegiste es ".$number;
        }

        public function getData(){

            $datos['titulo'] = "Equipos Ingresados";
            $datos['departamentos'] = $this->departamento->lista();
            $datos['operadores'] = $this->operadores->getOperador();

            return $datos;
        }

        public function new(){
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $numero_bien = $_POST['numero_bien'];
                $departamento = $_POST['departamento'];
                if(isset($_POST['fecha_recibido']) > 0){
                    $fecha_recibido = $_POST['fecha_recibido'];
                } else {
                    $fecha_recibido = "now()";                    
                }
                
                $recibido_por = $_POST['recibido_por'];
                $problema = $_POST['problema'];

                $this->equipo_ingresado->set('numero_bien', $numero_bien);
                $this->equipo_ingresado->set('departamento', $departamento);
                $this->equipo_ingresado->set('fecha_recibido', $fecha_recibido);
                $this->equipo_ingresado->set('recibido_por', $recibido_por);
                $this->equipo_ingresado->set('problema', $problema);

                $this->equipo_ingresado->add();

                header('Location: index');

            }                        

        }

        public function delete($id){

            if($_SERVER['REQUEST_METHOD'] == 'GET'){

                $this->equipo_ingresado->set('id_equipo', $id);

                $this->equipo_ingresado->delete();

                header('Location: /gsi/equipos/index');
                exit;

            }

        }

        public function edit($id){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $cedula = $_POST['cedula_identidad'];
                    $correo = $_POST['correo'];

                    $this->equipo_ingresado->set('id_operador', $id);
                    $this->equipo_ingresado->set('nombre', $nombre);
                    $this->equipo_ingresado->set('apellido', $apellido);
                    $this->equipo_ingresado->set('cedula_identidad', $cedula);
                    $this->equipo_ingresado->set('correo', $correo);
    
                    $this->equipo_ingresado->edit();
    
                    header('Location: /gsi/operadores/index');
    
                }            
            
        }


      
    }

    $equipos = new equiposController();
?>