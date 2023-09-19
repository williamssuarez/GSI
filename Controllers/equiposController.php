<?php namespace Controllers;

use Models\Equipos_ingresados;
use Models\Equipos_salida;
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
            $this->equipo_salida = new Equipos_salida();
            $this->departamento = new Departamentos();
            $this->operadores = new Operadores();
        }

        public function index(){
            $datos['titulo'] = "Equipos Ingresados";
            $datos['equipos'] = $this->equipo_ingresado->lista();
            return $datos;
        }

        public function salida(){
            $datos['titulo'] = "Equipos Salida";
            $datos['equipos_salida'] = $this->equipo_salida->lista();
            return $datos;
        }

        public function getDataIngreso(){

            $datos['titulo'] = "Equipos Ingresados";
            $datos['departamentos'] = $this->departamento->lista();
            $datos['operadores'] = $this->operadores->getOperador();

            return $datos;
        }

        public function getDataSalida(){

            $datos['titulo'] = "Equipos Ingresados";
            $datos['departamentos'] = $this->departamento->lista();
            $datos['operadores'] = $this->operadores->getOperador();
            $datos['equipos'] = $this->equipo_ingresado->getEquipos();

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

                //INGRESANDO EQUIPO
                $this->equipo_ingresado->add();

                //OBTENIENDO EL TOTAL DE INGRESOS DE DEPARTAMENTO Y SUMANDOLE 1
                $this->totalDepartamentos($departamento);

                //OBTENIENDO EL TOTAL DE EQUIPOS INGRESADOS POR EL OPERADOR Y SUMANDOLE 1
                $this->totalOperador($recibido_por);

                if (headers_sent()) {
                    $ruta = ROOT . "Views" . DS . "error" . DS . "equipos" . ".php";
                    require_once $ruta;
                    die("Redireccion Fallida. Click para volver");
                }
                else{
                    exit(header("Location: '. URL .'equipos/index"));
                }

            }                        

        }

        //OBTENIENDO EL TOTAL DE EQUIPOS INGRESADOS POR EL OPERADOR Y SUMANDOLE 1
        private function totalOperador($id){

            $this->operadores->set('id_operador', $id);
            $this->operadores->actualizarEquiposIngresados();
        }

        //OBTENIENDO EL TOTAL DE INGRESOS DE UN DEPARTAMENTO Y SUMANDOLE 1
        private function totalDepartamentos($id){

            $this->departamento->set('id_departamento', $id);
            $this->departamento->actualizarEquiposIngresados();

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

        public function entregar(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $cedula = $_POST['cedula_identidad'];
                $correo = $_POST['correo'];

                //$this->equipo_ingresado->set('id_operador', $id);
                $this->equipo_ingresado->set('nombre', $nombre);
                $this->equipo_ingresado->set('apellido', $apellido);
                $this->equipo_ingresado->set('cedula_identidad', $cedula);
                $this->equipo_ingresado->set('correo', $correo);

                $this->equipo_ingresado->edit();

                header('Location: /gsi/equipos/index');

            }           

        }


      
    }

    $equipos = new equiposController();
?>