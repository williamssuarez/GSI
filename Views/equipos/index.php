<?php $ingreso = $equipos->index(); ?>

<br>

<h1><?php echo $ingreso['titulo']; ?></h1>

<br>

<table border="1" width="80%" class="table table-hover">
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
        <tr class="table-secondary">
            <td> <?php echo $data['numero_bien'] ?> </td>
            <td> <?php echo $data['departamento'] ?> </td>
            <td> <?php echo $data['fecha_recibido'] ?> </td>
            <td> <?php echo $data['nombre_operador'] ?> </td>
            <td> <?php echo $data['problema'] ?> </td>
            <td>                            
                <a class="btn btn-outline-danger" href='delete/<?php echo $data['id_equipo'] ?>'>Eliminar</a> 
                <a class="btn btn-outline-info" href='edit/<?php echo $data['id_equipo'] ?>'>Editar</a>     
                <a class="btn btn-outline-success" href='entregar/<?php echo $data['id_equipo'] ?>'>Entregar</a>                
            </td>
        </tr>
    <?php } ?>
            
        
    </tbody>
</table>

<br>

<a class="btn btn-success" href="new">Agregar</a>

<br>
<br>
<br>

<?php $salida = $equipos->salida(); ?>

<h1><?php echo $salida['titulo']; ?></h1>

<br>

<table border="1" width="80%" class="table table-hover">
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
                <a href='delete/<?php echo $data['id_entrega'] ?>'>Eliminar</a> 
                <a href='edit/<?php echo $data['id_entrega'] ?>'>Editar</a>
            </td>
        </tr>
    <?php } ?>
            
        
    </tbody>
</table>