<?php $ingresos = $inicio->index();
?>

<div class="px-3 py-5 bg-gradient-primary text-white">
    <h1 class="text-center">¡BIENVENIDO!</h1>
</div>

<br>

<div class="row">

    <!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Equipos Pendientes</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                
                                                <?php echo $ingresos['pendiente']['totalIngreso'] ?>

                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
