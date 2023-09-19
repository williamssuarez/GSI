<?php $ingreso = $equipos->index(); ?>



<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $ingreso['titulo']; ?></h1>
 <p class="mb-4">Una tabla para administrar a los equipos ingresados</p>

         <h1 class="h3 mb-2 text-gray-800">Tabla</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Equipos Ingresados</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover responsive" id="tablaequipos" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Numero de Bien</th>
                        <th>Departamento</th>
                        <th>Fecha Recibido</th>
                        <th>Recibido Por</th>
                        <th>Problema</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach($ingreso['equipos'] as $data){ ?>
                    <tr>
                        <td> <?php echo $data['numero_bien'] ?> </td>
                        <td> <?php echo $data['departamento'] ?> </td>
                        <td> <?php echo $data['fecha_recibido'] ?> </td>
                        <td> <?php echo $data['nombre_operador'] ?> </td>
                        <td> <?php echo $data['problema'] ?> </td>
                        <td>                            
                            <a class="btn btn-danger" href='delete/<?php echo $data['id_equipo'] ?>'>Eliminar</a> 
                            <a class="btn btn-info" href='edit/<?php echo $data['id_equipo'] ?>'>Editar</a>     
                            <a class="btn btn-success" href='entregar/<?php echo $data['id_equipo'] ?>'>Entregar</a>                
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>

    <a class="btn btn-success" href="new">Agregar</a>





    <script>
    $(document).ready(function () {
        $('#tablaequipos').DataTable( {
            select: true           
        } );
    });
</script>