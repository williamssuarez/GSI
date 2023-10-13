<?php $ingresos = $inicio->index();
?>

<br>

<div class="row">


<a href="<?php echo URL; ?>reportes/generarPdf" class="btn btn-success">Generar PDF</a>

    <!-- TOTAL EQUIPO PENDIENTES, SI ES MAYOR A 0 SIGNIFICA QUE HAY PENDIENTES -->
<?php if($ingresos['pendiente']['totalIngreso'] > 0) { ?>

<div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">                            
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Equipos Pendientes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                
                                                <?php echo $ingresos['pendiente']['totalIngreso']; ?>

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

                                                <?php echo $ingresos['entregado']['totalEntrega'] ?>

                                            </div>
                                            <a class="btn btn-outline-success" href="<?php echo URL; ?>equipos/salida"> 
                                                    <i class="fa-solid fa-truck-arrow-right fa-flip-horizontal" style="color: #3aa413;"></i>                                               
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
<?php if($ingresos['asignados']['totalAsignaciones'] > 0)  { ?>

    <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Equipos Asignados a ti</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                <?php echo $ingresos['asignados']['totalAsignaciones'] ?>

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

<div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Entregas Rechazadas</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                <?php echo $ingresos['rechazos']['cuenta'] ?>

                                            </div>
                                            <a class="btn btn-outline-danger" href="<?php echo URL; ?>equipos/index">
                                                <i class="fa-solid fa-arrow-left"></i>
                                                    Ver rechazos
                                            </a>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fa-solid fa-triangle-exclamation fa-2x" style="color: #ca1c1c;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h1 class="hola-inicio">Sistema GSI </h1>

        <div class="card card-body">


            <img class="gsi-imagen-inicio" src="<?php echo URL; ?>Views/template/img/1.png" alt="">
        

            <div class="flex-container">

                <div class="flex-child magenta">
                    <a class="btn btn-lg btn-outline-primary boton-inicio" href="<?php echo URL; ?>operadores/index">Pulsa aca para ir a los operadores</a>
                </div>

                <div class="flex-child green">
                    <a class="btn btn-lg btn-outline-primary boton-inicio" href="<?php echo URL; ?>equipos/index">Pulsa aca para ir a los Equipos</a>
                </div>

                <div class="flex-child blue">
                    <a class="btn btn-lg btn-outline-primary boton-inicio" href="<?php echo URL; ?>direcciones/index">Pulsa aca para administrar las direcciones IP</a>
                </div>

                <div class="flex-child red">
                    <a class="btn btn-lg btn-outline-primary boton-inicio" href="<?php echo URL; ?>soportes/index">Pulsa aca para administrar los soportes</a>
                </div>

            </div>

        </div>
    </div>
</div>