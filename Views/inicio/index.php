<?php $ingresos = $inicio->index();
?>

<div class="px-3 py-5 bg-gradient-primary text-white">
    <h1 class="text-center">¡BIENVENIDO!</h1>
</div>

<br>

<div class="row">

    <!-- Earnings (Monthly) Card Example -->
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
                                            <i class="fa-solid fa-circle-check fa-2x" style="color: #3aa413;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<?php }?>

<!-- Earnings (Annual) Card Example -->
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
