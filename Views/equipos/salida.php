<?php $salida = $equipos->salida(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $salida['titulo']; ?></h1>
 <p class="mb-4">Una tabla para administrar a los equipos entregados</p>

         <h1 class="h3 mb-2 text-gray-800">Tabla</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6>Equipos Entregados</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover responsive nowrap" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Equipo</th>
                        <th>Departamento</th>
                        <th>Fecha Entrega</th>
                        <th>Entregado Por</th>
                        <th>Conclusion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($salida['equipos_salida'] as $data){ ?>
                        <tr class="table-secondary">            
                            <td> <?php echo $data['equipo'] ?> </td>
                            <td> <?php echo $data['departamento'] ?> </td>
                            <td> <?php echo $data['fecha_entrega'] ?> </td>
                            <td> <?php echo $data['entregado_por'] ?> </td>
                            <td> <?php echo $data['conclusion'] ?> </td>
                            <td>                            
                                <a class="btn btn-danger" href='delete/<?php echo $data['id_entrega'] ?>'>Eliminar</a> 
                                <a class="btn btn-" href='edit/<?php echo $data['id_entrega'] ?>'>Editar</a>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>