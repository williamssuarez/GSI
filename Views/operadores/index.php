<?php $datos = $operadores->index(); ?>

<h1><?php echo $datos['titulo']; ?></h1>

<a class="btn btn-success" href="new">Agregar</a>

<table border="1" width="80%" class="table table-hover">
    <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Cedula</th>
            <th scope="col">Correo</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        
    
        <?php foreach($datos['operadores'] as $data){ ?>
        <tr class="table-secondary">
            <td> <?php echo $data['nombre'] ?> </td>
            <td> <?php echo $data['apellido'] ?> </td>
            <td> <?php echo $data['cedula_identidad'] ?> </td>
            <td> <?php echo $data['correo'] ?> </td>
            <td>                            
                <a class="btn btn-danger" href='delete/<?php echo $data['id_operador'] ?>'>Eliminar</a> 
                <a class="btn btn-info" href='edit/<?php echo $data['id_operador'] ?>'>Editar</a>                    
            </td>
        </tr>
    <?php } ?>
            
        
    </tbody>
</table>