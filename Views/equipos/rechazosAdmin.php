<?php $rechazos = $equipos->rechazosAdmin(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $rechazos['titulo']; ?></h1>
 <p class="mb-4">Una tabla para administrar a los equipos rechazados</p>

         <h1 class="h3 mb-2 text-gray-800">Tabla</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Equipos Rechazados <i class="fa-solid fa-truck-fast"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover responsive nowrap" id="tablaequipos_rechazados" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Equipo <i class="fa-solid fa-tag" style="color: #279608;"></i></th>
                        <th>Administrador <i class="fa-solid fa-building" style="color: #913080;"></i></th>
                        <th>Operador <i class="fa-solid fa-user-gear" style="color: #005af5;"></i></th>
                        <th>Razon <i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i></th>
                        <th>Fecha Rechazo <i class="fa-solid fa-calendar-days"></i></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($rechazos['equipos_rechazados'] as $data){ ?>
                        <tr>            
                            <td> <?php echo $data['numero_bien'] ?> </td>
                            <td> <?php echo $data['admin'] ?> </td>
                            <td> <?php echo $data['operador'] ?> </td>
                            <td> <?php echo $data['razon'] ?> </td>
                            <td> <?php echo $data['fecha_rechazo'] ?> </td>

                        </tr>
                    <?php } ?>

                </tbody>
            </table>
            <a class="btn btn-warning" href="<?php echo URL; ?>equipos/index">
                <i class="fa-solid fa-arrow-left"></i>
                Ir a Equipos Pendientes
            </a>
        </div>
    </div>