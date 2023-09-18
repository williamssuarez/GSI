<?php $datos = $operadores->index(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?></h1>
 <p class="mb-4">Una tabla para administrar a los operadores</p>

         <h1 class="h3 mb-2 text-gray-800">Tabla</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6>Operadores</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover responsive nowrap" id="example" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cedula</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($datos['operadores'] as $data){ ?>
                        <tr class="table">
                            <td> <?php echo $data['nombre'] ?> </td>
                            <td> <?php echo $data['apellido'] ?> </td>
                            <td> <?php echo $data['cedula_identidad'] ?> </td>
                            <td> <?php echo $data['correo'] ?> </td>
                            <td>                            
                                <a class="btn btn-danger" href='delete/<?php echo $data['id_operador'] ?>'>Eliminar</a> 
                                <a class="btn btn-primary" href='edit/<?php echo $data['id_operador'] ?>'>Editar</a>                    
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>

    <a class="btn btn-success" href="new">Agregar</a>