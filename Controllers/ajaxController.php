<?php


namespace Controllers;

//AUTOLOAD DE COMPOSER
require __DIR__.'/../vendor/autoload.php';

//HTML2PDF
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

//PLANTILLA MPDF
use Controllers\plantillasController;

use Models\Equipos;
use Models\Equipos_ingresados;
use Models\Equipos_rechazados;
use Models\Usuario;
use Models\Empleados;
use Models\Dispositivos_general;
use Models\Conexion;

class ajaxController
{
    private $equipos;
    private $equipos_ingresados;
    private $equipos_rechazados;
    private $usuarios;
    private $empleados;
    private $dispositivos_general;
    private $conexion;
    private $plantilla;

    public function __construct()
    {
        $this->equipos = new Equipos();
        $this->equipos_ingresados = new Equipos_ingresados();
        $this->equipos_rechazados = new Equipos_rechazados();
        $this->usuarios = new Usuario();
        $this->empleados = new Empleados();
        $this->dispositivos_general = new Dispositivos_general();
        $this->conexion = new Conexion();
        $this->plantilla = new plantillasController();

        if (!isset($_SESSION['usuario'])) {
            // El usuario no está autenticado, muestra la alerta y redirige al formulario de inicio de sesión.
            echo '<script>
            Swal.fire({
                title: "Error",
                text: "Tienes que iniciar sesión primero!",
                icon: "warning",
                showConfirmButton: true,
                confirmButtonColor: "#3464eb",
                confirmButtonText: "Iniciar Sesión",
                customClass: {
                    confirmButton: "rounded-button" // Identificador personalizado
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "' . URL . 'login/index";
                }
            }).then(() => {
                window.location.href = "' . URL . 'login/index"; // Esta línea se ejecutará cuando se cierre la alerta.
            });
            </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
        }
    }

    /* INICIO */
    //PIE CHART DEL INICIO PARA ADMINISRTADOR
    public function pieChartAdmin() {

        ob_end_clean();
        ob_start();
        //OBTENIENDO TODOS LOS INGRESOS, ENTREGAS, RECHAZOS, Y APROBACIONES DEL DEPARTAMENTO
        
        $datos = array();
        $datos[0] = $this->equipos_ingresados->getIngresosTotalesEquiposAllTime();
        $datos[1] = $this->equipos_ingresados->getIngresosTotalesEntregados();
        $datos[2] = $this->equipos_ingresados->getIngresosTotalesAprobacion();
        $datos[3] = $this->equipos_rechazados->verificarRechazosTotalesDelDepartamentoAllTime();

        $test = $datos[0];

        // Simulación de datos para propósitos de ejemplo
        $data = array(
            "labels" => ["Ingresos", "Entregas", "En Revision", "Entregas Rechazadas"],
            "data" => [$datos],
            "test" => $test
        );

        // Convierte los datos a formato JSON y envíalos de vuelta
        header('Content-Type: application/json');
        ob_end_clean();
        echo json_encode($data, JSON_PRETTY_PRINT);
        //echo $data;
    }

    /* INICIO */
    //PIE CHART DEL INICIO PARA OPERADOR
    public function pieChartOpr()
    {
        ob_end_clean();
        ob_start();
        //OBTENIENDO TODOS LOS INGRESOS, ENTREGAS, RECHAZOS, Y APROBACIONES DEL OPERADOR
        $this->usuarios->set('usuario', $_SESSION['usuario']);
        $id_user = $this->usuarios->getIdUserbyUsuario();
        $user = $id_user['id_user'];

        //OBTENIENDO LOS EQUIPOS RELACIONADOS AL OPERADOR
        $this->equipos_ingresados->set('recibido_por', $id_user['id_user']);
        $this->equipos_rechazados->set('id_usuario', $id_user['id_user']);
        
        $datos = array();
        $datos[0] = $this->equipos_ingresados->getIngresosTotalesEquiposByOperador();
        $datos[1] = $this->equipos_ingresados->getIngresosTotalesEntregadosByOperador();
        $datos[2] = $this->equipos_ingresados->getIngresosTotalesAprobacionByOperador();
        $datos[3] = $this->equipos_rechazados->getHistorialRechazosByUser();

        $test = $datos[0];

        // Simulación de datos para propósitos de ejemplo
        $data = array(
            "labels" => ["Ingresos", "Entregas", "En Revision", "Entregas Rechazadas"],
            "data" => [$datos],
            "test" => $test
        );

        // Convierte los datos a formato JSON y envíalos de vuelta
        header('Content-Type: application/json');
        ob_end_clean();
        echo json_encode($data, JSON_PRETTY_PRINT);
        //echo $data;
    }

    /* INICIO */
    //PIE CHART DE INICIO PARA OPERADOR EN ESPECIFICO (SOLO PARA ADMINS)
    public function pieChartByOpr($username){
        ob_end_clean();
        ob_start();
        //OBTENIENDO TODOS LOS INGRESOS, ENTREGAS, RECHAZOS, Y APROBACIONES DEL OPERADOR
        $this->usuarios->set('usuario', $username);
        $id_user = $this->usuarios->getIdUserbyUsuario();
        $user = $id_user['id_user'];

        //OBTENIENDO LOS EQUIPOS RECHAZADOS DEL OPERADOR
        $this->equipos_ingresados->set('recibido_por', $id_user['id_user']);
        $this->equipos_rechazados->set('id_usuario', $id_user['id_user']);

        $datos = array();
        $datos[0] = $this->equipos_ingresados->getIngresosTotalesEquiposByOperador();
        $datos[1] = $this->equipos_ingresados->getIngresosTotalesEntregadosByOperador();
        $datos[2] = $this->equipos_ingresados->getIngresosTotalesAprobacionByOperador();
        $datos[3] = $this->equipos_rechazados->getHistorialRechazosByUser();

        $test = $datos[0];

        // Simulación de datos para propósitos de ejemplo
        $data = array(
            "labels" => ["Ingresos", "Entregas", "En Revision", "Entregas Rechazadas"],
            "data" => [$datos],
            "test" => $test
        );

        // Convierte los datos a formato JSON y envíalos de vuelta
        header('Content-Type: application/json');
        ob_end_clean();
        echo json_encode($data, JSON_PRETTY_PRINT);
        //echo $data;
    }

    /* INICIO*/
    public function manualAdministrador(){
        $route = __DIR__ . '/../pdf/Manual_Administrador.pdf';
        // Set headers for PDF download
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=".basename($route));

        
        // Read the PDF file content
        $pdf_data = file_get_contents($route);

        // Check if file was read successfully
        if ($pdf_data === false) {
        die('Error reading PDF file!');
        }

        // Output the PDF data
        ob_end_clean();
        readfile($route);
        //echo $pdf_data;
    }

    /* INICIO*/
    public function manualOperador(){
        $route = __DIR__ . '/../pdf/Manual_Operador.pdf';
        // Set headers for PDF download
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=".basename($route));

        
        // Read the PDF file content
        $pdf_data = file_get_contents($route);

        // Check if file was read successfully
        if ($pdf_data === false) {
        die('Error reading PDF file!');
        }

        // Output the PDF data
        ob_end_clean();
        readfile($route);
        //echo $pdf_data;
    }

    /* INICIO */
    //REPORTE PDF EN INICIO
    public function reportehtml2() {
        ob_clean(); // Clear output buffer
    
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
        ]);
        //require __DIR__.'/../pdf/plantilla.php';
        //$plantilla = require_once "plantilla.php";

        $imagePath = __DIR__ . '/../pdf/img/LogoAlc.png';
        $imagePath2 = __DIR__ . '/../pdf/img/22.png'; // Adjust path as needed
        $templateContent = $this->plantilla->getPlantilla();
        $stylesheet = file_get_contents(__DIR__ . '/../pdf/styles/style.css');
        $imagePathArray = [$imagePath, $imagePath2];
        $replaceStringArray = ['[logo_path]', '[logo_path2]'];

        $html = str_replace($replaceStringArray, $imagePathArray, $templateContent);


        $mpdf->writeHTML($stylesheet, HTMLParserMode::HEADER_CSS);
        $mpdf->writeHTML($html);
    
        header('Content-type: application/pdf');
        return $mpdf->output();
    }

    /* INICIO */
    //METODO DE RESPALDO OFICIAL POR MYSQLDUMP Y PHP, METODO EN EL MODELO DE CONEXION
    public function backup(){
        ob_end_clean(); //Limpiando el buffer
        ob_start(); //Capturando de nuevo

        $response = $this->conexion->respaldo();
        //$dumpRoute = ROOT . "..\..\mysql\bin\mysqldump";

        header('Content-Type: application/json');
        ob_end_clean();

        /*echo $dumpRoute;
        die();*/

        echo json_encode($response);
    }

    /* INICIO */
    //METODO DE RESPALDO PROVISIONAL CON EL SCRIPT DE WINDOWS
    public function backupWindowsBat(){

        //EL QUE FUNCIONA
        $batch = ROOT . "mysqlbackup.bat";

        $output = shell_exec("C:\\xampp\\htdocs\\GSI\\mysqlbackup.bat"); // Capture errors
        if (strpos($output, "Backup failed") !== false) {
            echo "Backup failed: " . $output;
            echo $batch;
        } else {
            echo "Backup successful";
            echo $batch;
        }

    }

    /* EMPLEADOS */
    //COMPROBAR SI EL EMPLEADO ESTA REGISTRADO ANTES DE INGRESARLO
    public function comprobarCedula(){

        ob_end_clean();
        ob_start();

        if (isset($_POST['cedula'])) {
            //ACCEDIENDO AL VALOR
            $cedula = filter_input(INPUT_POST, 'cedula', FILTER_SANITIZE_STRING);

            //VALIDANDO SI LA CEDULA NO PERTENECE A ALGUN EMPLEADO
            $this->empleados->set('cedula', $cedula);
            $responseAjax = $this->empleados->getEmpleadobyCedulaforAjax();

            //VALIDANDO SI LA CEDULA NO PERTENECE A ALGUN USUARIO DEL SISTEMA
            $this->usuarios->set('cedula', $cedula);
            $responseAjax2 = $this->usuarios->getUserbyCedulaforAjax();

            if(empty($responseAjax) && empty($responseAjax2)){
                //VACIO, CEDULA VALIDA
                $response = 1;
            } else {
                //NO VACIO, CEDULA YA REGISTRADA
                $response = 0;
            }

            ob_end_clean();
            echo json_encode($response);
        } else {
            echo "Falta dato: cedula";
        }

    }

    /* EQUIPOS */
    //COMPROBAR SI EL EQUIPO ESTA REGISTRADO ANTES DE INGRESARLO
    public function comprobarBien(){

        ob_end_clean();
        ob_start();

        if (isset($_POST['numero_bien'])) {
            // Access the value
            $numero_bien = filter_input(INPUT_POST, 'numero_bien', FILTER_SANITIZE_STRING);

            $this->equipos->set('numero_bien', $numero_bien);
            $responseAjax = $this->equipos->getEquipobyNumerodeBien();

            if(!empty($responseAjax)){
                $response = 1;
            } else {
                $response = 0;
            }

            ob_end_clean();
            echo json_encode($response);
        } else {
            echo "Missing required data: numero_bien";
        }

    }

    /* EQUIPOS */
    //GET EMPLEADOS POR DEPARTAMENTO ID PARA PROCESO 3
    public function getEmpleadosByDpto($departamento_id){
        ob_end_clean();
        ob_start();

        if (!empty($departamento_id)) {
            

            $this->empleados->set('departamento_id', $departamento_id);
            $responseAjax = $this->empleados->getEmpleadosByDpto();

            ob_end_clean();
            //return json_encode($responseAjax);
            echo json_encode($responseAjax);
            //var_dump($responseAjax);
        } else {
            echo "Missing required data: departamento_id";
        }

    }

    public function checkBMforRegistro($numero_bien){

        ob_end_clean();
        ob_start();

        if (!empty($numero_bien)) {

            $this->equipos->set('numero_bien', $numero_bien);
            $responseAjax = $this->equipos->getEquipobyNumerodeBien();

            if(!empty($responseAjax)){
                //NO ESTA VACIO, EQUIPO YA REGISTRADO, DESHABILITAR BOTON
                $response = false;
            } else {
                //VACIO, EQUIPO NO REGISTRADO, HABILITAR BOTON
                $response = true;
            }

            ob_end_clean();
            echo json_encode($response);
        } else {
            echo "Missing required data: numero_bien";
        }

    }

    public function checkMACforRegistro($direccion_mac){

        ob_end_clean();
        ob_start();

        if (!empty($direccion_mac)) {

            $this->equipos->set('direccion_mac', $direccion_mac);
            $responseAjax = $this->equipos->getEquipobyDireccionMac();

            if(!empty($responseAjax)){
                //NO ESTA VACIO, EQUIPO YA REGISTRADO, DESHABILITAR BOTON
                $response = false;
            } else {
                //VACIO, EQUIPO NO REGISTRADO, HABILITAR BOTON
                $response = true;
            }

            ob_end_clean();
            echo json_encode($response);
        }

    }

    public function checkBMforDispositivo($numero_bien){

        ob_end_clean();
        ob_start();

        if (!empty($numero_bien)) {

            $this->dispositivos_general->set('numero_bien', $numero_bien);
            $responseAjax = $this->dispositivos_general->getDispositivobyNumerodeBien();

            $this->equipos->set('numero_bien', $numero_bien);
            $responseAjax2 = $this->equipos->getEquipobyNumerodeBien();

            if(!empty($responseAjax)){
                //NO ESTA VACIO, NUMERO DE BIEN YA REGISTRADO CON OTRO DISPOSITIVO, DESHABILITAR BOTON
                $response = 2;
            } elseif(!empty($responseAjax2)){
                //NO ESTA VACIO, NUMERO DE BIEN YA REGISTRADO CON OTRO EQUIPO, DESHABILITAR BOTON
                $response = 3;
            } else {
                //VACIO, EQUIPO NO REGISTRADO, HABILITAR BOTON
                $response = 1;
            }

            ob_end_clean();
            echo json_encode($response);
        } else {
            echo "Missing required data: numero_bien";
        }

    }

}