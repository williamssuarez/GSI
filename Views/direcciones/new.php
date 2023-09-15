<?php $datos = $direcciones->getDireccionesLibres() ?>

<h1> <?php echo $datos['titulo']; ?> new!</h1>

<form action="new" method="post">
    
    Departamento: 
        <select required name="departamento" id="departamento">

            <?php foreach ($datos['departamentos'] as $departamento) { ?>
                <option value="<?php echo $departamento['id_departamento']; ?>"> <?php echo $departamento['nombre_departamento'] ?> </option>
            <?php } ?>

        </select> <br>    
    Direccion: 
        <select required name="direccion" id="direccion">
                
                <?php foreach($datos['direcciones'] as $direcciones) {  ?>
                    <option value="<?php echo $direcciones['id']; ?>"> <?php echo $direcciones['direccion'] ?> </option>
                <?php } ?>

        </select> <br>
     <br>
    <button type="submit">Registrar</button>
</form>
