<?php $datos = $operadores->index(); ?>

<h1><?php echo $datos['titulo']; ?></h1>

<a href="new">Agregar</a>

<table border="1" width="80%" >
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
        <tr>
            <td> <?php echo $data['nombre'] ?> </td>
            <td> <?php echo $data['apellido'] ?> </td>
            <td> <?php echo $data['cedula_identidad'] ?> </td>
            <td> <?php echo $data['correo'] ?> </td>
            <td>                            
                <a href='delete/<?php echo $data['id_operador'] ?>'>Eliminar</a> 
                <a href='edit/<?php echo $data['id_operador'] ?>'>Editar</a>                    
            </td>
        </tr>
    <?php } ?>
            
        
    </tbody>
</table>