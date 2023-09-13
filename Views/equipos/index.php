<?php $datos = $equipos->index(); ?>

<h1><?php echo $datos['titulo']; ?></h1>

<a href="new">Agregar</a>

<table border="1" width="80%" >
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
        
    
        <?php foreach($datos['equipos'] as $data){ ?>
        <tr>
            <td> <?php echo $data['numero_bien'] ?> </td>
            <td> <?php echo $data['departamento'] ?> </td>
            <td> <?php echo $data['fecha_recibido'] ?> </td>
            <td> <?php echo $data['nombre_operador'] ?> </td>
            <td> <?php echo $data['problema'] ?> </td>
            <td>                            
                <a href='delete/<?php echo $data['id_equipo'] ?>'>Eliminar</a> 
                <a href='edit/<?php echo $data['id_equipo'] ?>'>Editar</a>                    
            </td>
        </tr>
    <?php } ?>
            
        
    </tbody>
</table>