<?php $datos = $direcciones->index(); ?>

<h1><?php echo $datos['titulo']; ?></h1>

<a href="new">Agregar</a>

<table border="1" width="80%" id="example" class="table table-striped">
    <thead>
        <tr>            
            <th>Direccion IP</th>
            <th>Departamento</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        
    
        <?php foreach($datos['direcciones'] as $data){ ?>
        <tr>
            <td> <?php echo $data['direccion'] ?> </td>
            <td> <?php echo $data['departamento'] ?> </td>
            <td>                            
                <a href='delete/<?php echo $data['id_ip'] ?>'>Eliminar</a> 
                <a href='edit/<?php echo $data['id_ip'] ?>'>Editar</a>                    
            </td>
        </tr>
    <?php } ?>
            
        
    </tbody>
</table>

<script>
    new DataTable('#example');
</script>