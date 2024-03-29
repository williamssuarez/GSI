<?php 

namespace Views;

$logintemplate = new loginTemplate();

class loginTemplate{

    public function __construct( ) {
        
        ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sistema GSI - Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="<?php echo URL; ?>Views/template/img/2.png">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/css/style.css">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/css/sb-admin-2.min.css">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/vendor/fontawesome-free/css/all.min.css">

         <!-- BOOTSTRAP 5.3 CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/DataTables/css/bootstrap.min.css">
        <link rel="stylesheet" href="styles.css">

        <!-- DATATABLES CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/DataTables/css/dataTables.bootstrap5.min.css">

        <!-- DATATABLES BUTTONS CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/DataTables/extensions/buttons/css/buttons.dataTables.css">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/DataTables/extensions/buttons/css/buttons.bootstrap5.css">

        <!-- DATATABLES RESPONSIVE CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/DataTables/extensions/responsive/css/responsive.bootstrap.min.css">
        
        <!-- FONTAWESOME CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/FontAwesome/font-awesome_6.4.2_css_all.min.css">

        <!-- SWEETALERT2 CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/sweetalert2/dist/sweetalert2.min.css">

        <!-- FONTAWESOME JS -->
        <script src="<?php echo URL; ?>Views/template/FontAwesome/font-awesome_6.4.2_js_all.min.js"></script>

        <!-- SWEETALERT2 JS -->
        <script src="<?php echo URL; ?>Views/template/sweetalert2/dist/sweetalert2.all.min.js"></script>

        <!--Redirigir-->
        <script src="<?php echo URL; ?>Views/template/js/scripts/redirigirTopbar.js" ></script>

        <!-- Page level plugins
        <script src="<//?php echo URL; ?>Views/template/vendor/datatables/jquery.dataTables.min.js"></script> -->

        <!-- Page level custom scripts -->
        <script src="<?php echo URL; ?>Views/template/DataTables/demo/datatables-demo.js"></script>
    </head>
    <body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div>

            <div >

                
            

    <?php 
    }

    public function __destruct(){
    ?>
    
            </div>

        </div>

    </div>

 <!-- Bootstrap core JavaScript-->
 <script src="<?php echo URL; ?>Views/template/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo URL; ?>Views/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo URL; ?>Views/template/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?php echo URL; ?>Views/template/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo URL; ?>Views/template/js/demo/chart-area-demo.js"></script>
    <script src="<?php echo URL; ?>Views/template/js/demo/chart-pie-demo.js"></script>

    <!-- JQUERY JS -->
    <script src="<?php echo URL; ?>Views/template/DataTables/js/jquery-3.7.1.js"></script>

    <!-- BOOTSTRAP 5.3 JS -->
    <script src="<?php echo URL; ?>Views/template/DataTables/js/bootstrap.bundle.min.js"></script>

    <!-- MOMENT JS -->
    <script src="<?php echo URL; ?>Views/template/js/moment/moment.min.js"></script>

    <!-- DATATABLES JS -->
    <script src="<?php echo URL; ?>Views/template/DataTables/js/jquery.dataTables.js"></script>
    <script src="<?php echo URL; ?>Views/template/DataTables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo URL; ?>Views/template/DataTables/js/dataTables.bootstrap5.min.js"></script>

    <!-- DATATABLES BUTTONS JS -->
    <script src="<?php echo URL; ?>Views/template/DataTables/extensions/buttons/js/dataTables.buttons.js"></script>
    <script src="<?php echo URL; ?>Views/template/DataTables/extensions/buttons/js/buttons.bootstrap5.js"></script>
    <script src="<?php echo URL; ?>Views/template/DataTables/extensions/buttons/js/buttons.html5.js"></script>
    <script src="<?php echo URL; ?>Views/template/DataTables/extensions/buttons/js/buttons.print.js"></script>

    <!-- DATATABLES RESPONSIVE JS -->
    <script src="<?php echo URL; ?>Views/template/DataTables/extensions/responsive/js/dataTables.responsive.js"></script>
    <script src="<?php echo URL; ?>Views/template/DataTables/extensions/responsive/js/responsive.bootstrap.min.js"></script>

    <!-- JSZIP JS -->
    <script src="<?php echo URL; ?>Views/template/DataTables/extensions/buttons/js/jszip/jszip.js"></script>

    <!-- PDFMAKE JS -->
    <script src="<?php echo URL; ?>Views/template/DataTables/extensions/buttons/js/pdfmake/pdfmake.js"></script>
    <script src="<?php echo URL; ?>Views/template/DataTables/extensions/buttons/js/pdfmake/vfs_fonts.js"></script>

    <!-- EXCEL JS DESHABILITADO POR LAS MISMAS RAZONES
    <script src="<?php echo URL; ?>node_modules/exceljs/dist/exceljs.js"></script>
    <script src="<?php echo URL; ?>node_modules/xlsx/xlsx.js"></script> -->

    <!-- INICIANDO TABLAS DATATABLE -->
    <script type="text/javascript" src="<?php echo URL; ?>Views/template/DataTables/tables/equipos_ingresados.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>Views/template/DataTables/tables/equipos_salida.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>Views/template/DataTables/tables/direcciones.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>Views/template/DataTables/tables/operadores.js"></script>
    <script type="text/javascript" src="<?php echo URL; ?>Views/template/DataTables/tables/departamentos.js"></script>
    

    </body>
    </html>
<?php        
    }

}

?>