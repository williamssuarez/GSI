<?php $ingreso = $equipos->index(); ?>



<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $ingreso['titulo']; ?></h1>
 <p class="mb-4">Una tabla para administrar a los equipos ingresados</p>

<?php if($ingreso['total']['totalIngreso'] > 0) { ?>

    <h3 class="h3 mb-2 text-gray-800">
        <i class="fa-solid fa-circle-exclamation fa-1x" style="color: #d4ac40;"></i>    
        Hay un total de <?php echo $ingreso['total']['totalIngreso'] ?> equipos pendientes
    </h3>

<?php } else { ?>

    <h3 class="h3 mb-2 text-gray-800">
    <i class="fa-solid fa-circle-check fa-1x" style="color: #3aa413;"></i>  
        No hay equipos pendientes!
    </h3>

<?php } ?>


         <h1 class="h3 mb-2 text-gray-800">Tabla</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Equipos Ingresados <i class="fa-solid fa-computer"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover responsive" id="tablaequipos_ingresados" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Numero de Bien <i class="fa-solid fa-tag" style="color: #279608;"></i></th>
                        <th>Departamento <i class="fa-solid fa-building" style="color: #913080;"></i></th>
                        <th>Fecha Recibido <i class="fa-solid fa-calendar-days"></i></th>
                        <th>Recibido Por <i class="fa-solid fa-user-gear" style="color: #005af5;"></i></th>
                        <th>Problema <i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i></th>
                        <th>Estado <i class="fa-solid fa-question" style="color: #5b0d9b;"></i></th>
                        <th>Acciones <i class="fa-solid fa-gears"></i></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($ingreso['equipos'] as $data) { ?>
                        <tr>
                            <td> <?php echo isset($data['numero_bien']) ? $data['numero_bien'] : ''; ?> </td>
                            <td> <?php echo isset($data['departamento']) ? $data['departamento'] : ''; ?> </td>
                            <td> <?php echo isset($data['fecha_recibido']) ? $data['fecha_recibido'] : ''; ?> </td>
                            <td> <?php echo isset($data['nombre_operador']) ? $data['nombre_operador'] : ''; ?> </td>
                            <td> <?php echo isset($data['problema']) ? $data['problema'] : ''; ?> </td>
                            <td>
                                <?php
                                if ($data['estado'] == 0) { ?>

                                    <span class=" font-weight-bold" >
                                        Pendiente <i class="fa-solid fa-circle-exclamation" style="color: #d4ac40;"></i>
                                    </span>

                                <?php } else { ?>

                                    <span class=" font-weight-bold" >
                                        Entregado <i class="fa-solid fa-circle-check" style="color: #3aa413;"></i>
                                    </span>

                                <?php }  ?>
                            </td>
                            <td>                            
                                <?php if(isset($data['estado']) && $data['estado'] == 0) { ?>    
                                <a class="btn btn-success btn-icon-split" href='entregar/<?php echo $data['id_equipo'] ?>'>                                
                                    <i class="fa-solid fa-truck-fast"></i>                                
                                    Entregar    
                                </a>
                                <?php } else { ?>

                                <a class="btn btn-info btn-icon-split" href='edit/<?php echo $data['id_equipo'] ?>'>
                                <i class="fa-solid fa-pen-to-square"></i>
                                Editar
                                </a> 

                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>

    <a class="btn btn-success" href="new">
        <i class="fa-solid fa-truck-arrow-right"></i>
        Ingresar
    </a>


