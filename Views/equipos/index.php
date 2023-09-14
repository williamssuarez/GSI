<?php $ingreso = $equipos->index(); ?>

<h1><?php echo $ingreso['titulo']; ?></h1>

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
        
    
        <?php foreach($ingreso['equipos'] as $data){ ?>
        <tr>
            <td> <?php echo $data['numero_bien'] ?> </td>
            <td> <?php echo $data['departamento'] ?> </td>
            <td> <?php echo $data['fecha_recibido'] ?> </td>
            <td> <?php echo $data['nombre_operador'] ?> </td>
            <td> <?php echo $data['problema'] ?> </td>
            <td>                            
                <a href='delete/<?php echo $data['id_equipo'] ?>'>Eliminar</a> 
                <a href='edit/<?php echo $data['id_equipo'] ?>'>Editar</a>     
                <a href='entregar/<?php echo $data['id_equipo'] ?>'>Entregar</a>                
            </td>
        </tr>
    <?php } ?>
            
        
    </tbody>
</table>

<br>
<br>
<br>

<?php $salida = $equipos->salida(); ?>

<h1><?php echo $salida['titulo']; ?></h1>

<table border="1" width="80%" >
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
        <tr>            
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