

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1>Bienvenido</h1>

        <button id="generate-pdf-btn" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i>
                Manual PDF
        </button>

    <?php if($_SESSION['rol'] == 1){ //es admin, puede ejecutar el respaldo ?>

        <button id="backup-button" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-solid fa-database fa-sm text-white-50"></i>
            Respaldar Base de Datos
        </button>

    <?php } ?>

</div>


<div class="row">

    <!-- TOTAL EQUIPO PENDIENTES, SI ES MAYOR A 0 SIGNIFICA QUE HAY PENDIENTES -->
<?php if($data['pendiente']['totalIngreso'] > 0) { ?>

<div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">                            
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Equipos Pendientes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                
                                                <?php echo $data['pendiente']['totalIngreso']; ?>

                                            </div>
                                            <a class="btn btn-outline-warning" href="<?php echo URL; ?>equipos/index">
                                                <i class="fa-solid fa-arrow-left"></i>
                                                    Ir a Equipos
                                            </a>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-circle-exclamation fa-2x" style="color: #d4ac40;"></i>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>

<?php } else {  ?>

    <!-- CASO CONTRARIO, NO HAY EQUIPOS PENDIENTES -->
    <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Equipos Pendientes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                No hay equipos pendientes
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fa-solid fa-circle-check fa-3x" style="color: #3aa413;"></i>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

<?php }?>

<!-- EQUIPOS ENTREGADOS -->
<div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Equipos Entregados</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                <?php echo $data['entregado']['totalEntrega'] ?>

                                            </div>
                                            <a class="btn btn-outline-success" href="<?php echo URL; ?>equipos/salida"> 
                                                <i class="fa-solid fa-arrow-left"></i>                                               
                                                    Ir a Equipos Entregados
                                            </a>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-truck-fast fa-2x" style="color: #2bc021;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


<!-- EQUIPOS ASIGNADOS AL USUARIO -->
<?php if($data['asignados']['totalAsignaciones'] > 0)  { ?>

    <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Equipos Asignados a ti</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                <?php echo $data['asignados']['totalAsignaciones'] ?>

                                            </div>
                                            <a class="btn btn-outline-primary" href="<?php echo URL; ?>equipos/index">
                                                <i class="fa-solid fa-arrow-left"></i>
                                                    Ir a Equipos
                                            </a>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fa-solid fa-circle-exclamation fa-2x" style="color: #1860dc;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<?php } else { ?>

    <!-- CASO CONTRARIO, NO HAY EQUIPOS PENDIENTES -->
    <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Equipos Asignados a ti</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                No tienes equipos asignados
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fa-solid fa-circle-check fa-3x" style="color: #3aa413;"></i>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

<?php } ?>

<?php if($_SESSION['rol'] == 1){ //es admin ?>

    <?php if($data['aprobacion']['totalAprobacion'] > 0){ ?>
    <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                    Entregas esperando aprobacion de salida</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                    <?php echo $data['aprobacion']['totalAprobacion'] ?>

                                                </div>
                                                <a class="btn btn-outline-danger" href="<?php echo URL; ?>equipos/esperandoAprobacion">
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                        Ir a entregas en revision
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa-solid fa-triangle-exclamation fa-2x" style="color: #ca1c1c;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    <?php } else {  ?>

        <!-- CASO CONTRARIO, NO HAY ENTREGAS POR REVISAR -->
        <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Entregas esperando aprobacion de salida</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    No tienes entregas por revisar
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa-solid fa-circle-check fa-3x" style="color: #3aa413;"></i>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

    <?php } ?>

<?php } else { //no es admin?>

    <?php if($data['rechazos']['rechazos'] > 0){ ?>
    <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                    Entregas Rechazadas</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                    <?php echo $data['rechazos']['rechazos'] ?>

                                                </div>
                                                <a class="btn btn-outline-danger" href="<?php echo URL; ?>equipos/rechazosOperador">
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                        Ir a mis rechazos
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa-solid fa-triangle-exclamation fa-2x" style="color: #ca1c1c;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    <?php } else {  ?>

        <!-- CASO CONTRARIO, NO HAY ENTREGAS RECHAZADAS -->
        <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Entregas Rechazadas</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    No tienes entregas rechazadas
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fa-solid fa-circle-check fa-3x" style="color: #3aa413;"></i>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

    <?php } ?>

<?php } ?>

<!-- Content Row -->

<div class="row">

<!-- Area Chart -->
<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Incidencia de Equipos</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Pie Chart -->
<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Equipos Soporte</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Dropdown Header:</div>
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
                <!--<div id="piechart-container"></div>-->
                <canvas id="piechart-container"></canvas>
            </div>
        </div>
    </div>
</div>
</div> 


<script>

    document.getElementById("backup-button").addEventListener("click", function() {

        // Use SweetAlert to prompt for storage location
        Swal.fire({
            title: "Iniciar respaldo",
            text: "NOTA: El respaldo sera generado dentro de la carpeta del proyecto, la ruta es: C:/xampp/htdocs/GSI/backup",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Iniciar Backup",
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true,
            preConfirm: (location) => {
                return new Promise((resolve) => {
                    // Send AJAX request with the provided location
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "<?php echo URL; ?>ajax/backup", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            resolve(xhr.responseText); // Resolve with server response
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ha ocurrido un error durante la generacion del backup',
                            });
                        }
                    };

                    xhr.onerror = function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de red',
                            text: 'Ha ocurrido un error de al enviar la solicitud de respaldo, intente de nuevo',
                        });
                    };

                    xhr.send("location=" + encodeURIComponent(location));
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                // Handle successful backup response from server
                Swal.fire({
                    icon: 'success',
                    title: 'Backup Exitoso',
                    text: 'Se ha generado el respaldo de la db exitosamente',
                    timer: 1500,
                    showConfirmButton: false,
                });
            } else {
                // Handle cancelled backup
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al intentar generar el backup',
                    timer: 1500,
                    showConfirmButton: false,
                });
            }
        });
    });



    document.getElementById('generate-pdf-btn').addEventListener('click', function () {
        
        $.ajax({
            url: '<?php echo URL; ?>ajax/reportehtml2',
            //url: 'http://localhost/pdf/download_pdf.php',
            type: 'GET',
            xhrFields: {
                responseType: 'blob' // Important for blob response
            },
            success: function(data) {
                console.log('Exitoso el ajax');
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(data);
                link.download = 'manual.pdf';
                link.click();
            },
            error: function (jqXHR, textStatus, errorThrown) {
            console.error('AJAX error:', textStatus, errorThrown);
            }
        });
    });
</script>

    <?php
        if($_SESSION['rol'] == 1) { //es admin
            require_once "Views/footers/footer.php";
        } else {
            require_once "Views/footers/footerOpr.php";
        }
    ?>
