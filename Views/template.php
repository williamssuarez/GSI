<?php namespace Views;

    $template = new Template();

class Template{

    public function __construct()
    {
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sistema GSI</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="<?php echo URL; ?>Views/template/img/2.png">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/css/style.css">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/css/sb-admin-2.min.css">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/vendor/fontawesome-free/css/all.min.css">
        <!--DataTables-->
        <link href="<?php echo URL; ?>Views/template/DataTables/datatables.min.css">
        <link href="<?php echo URL; ?>Views/template/DataTables/Responsive/css/responsive.dataTables.min.css">
        <link href="<?php echo URL; ?>Views/template/DataTables/responsive.dataTables.min.css">
        <link href="<?php echo URL; ?>Views/template/DataTables/js_responsive.dataTables.min.css">
        <script>
                function redirigir(){
                    var ir = document.getElementById("ir").value;
                    
                    document.location.href="/GSI/" + ir +"/index";
                    return false;
                }            
        </script>
    </head>
    <body>

    <!-- Page Wrapper -->
 <div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo URL; ?>inicio/index">
        <div class="sidebar-brand-icon rotate-n-15">
            <img src="<?php echo URL; ?>Views/template/img/3.png" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">GSI</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo URL; ?>inicio/index">
            <img src="<?php echo URL; ?>Views/template/img/assets/inicio/inicio1.png" alt="">
            <span> Inicio</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <img src="<?php echo URL; ?>Views/template/img/assets/equipo/equipo1.png" alt="">
                    <span>Equipos</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Administrar Equipos:</h6>
                        <a class="collapse-item" href="<?php echo URL; ?>equipos/index">Equipos Ingresados</a>
                        <a class="collapse-item" href="<?php echo URL; ?>equipos/salida">Equipos Entregados</a>
                    </div>
                </div>
            </li>

    

    <!-- Divider -->
    <hr class="sidebar-divider"> 

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo URL; ?>operadores/index">
            <img src="<?php echo URL; ?>Views/template/img/assets/operador/operador1.png" alt="">
            <span>Operadores</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo URL; ?>direcciones/index">
            <img src="<?php echo URL; ?>Views/template/img/assets/direccion/direccion1.png" alt="">
            <span>Direcciones</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?php echo URL; ?>soportes/index">
            <img src="<?php echo URL; ?>Views/template/img/assets/soporte/soporte1.png" alt="">
            <span>Soportes</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link" href="#">
            <img src="<?php echo URL; ?>Views/template/img/assets/logout/logout1.png" alt="">
            <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle">
                
        </button>
    </div>
</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form onsubmit="return redirigir()" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input id="ir" type="text" class="form-control bg-light border-0 small" placeholder="Buscar..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <img src="<?php echo URL; ?>Views/template/img/lupa2.png" alt="">
                </button>
            </div>
        </div>
    </form>

   

        <div class="topbar-divider d-none d-sm-block"></div>
        

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Usuario 1</span>
                <img class="img-profile rounded-circle"
                    src="<?php echo URL; ?>Views/template/img/profile.png">
            </a>
            
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->


<div class="container-fluid">
    <div class="row">
   
    
</div>
<?php
    }


    public function __destruct()
    {
?>

    </div>
</div>
</div>
    
 <!-- Bootstrap core JavaScript-->
 <script src="<?php echo URL; ?>Views/template/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo URL; ?>Views/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo URL; ?>Views/template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?php echo URL; ?>Views/template/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?php echo URL; ?>Views/template/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?php echo URL; ?>Views/template/js/demo/chart-area-demo.js"></script>
    <script src="<?php echo URL; ?>Views/template/js/demo/chart-pie-demo.js"></script>

    <!-- DataTables Jquery -->
    <script src="<?php echo URL; ?>Views/template/DataTables/datatables.min.js"></script>
    <script src="<?php echo URL; ?>Views/template/DataTables/Responsive/js/dataTables.responsive.min.js"></script>

    </body>
    </html>
<?php        
    }
}

?>