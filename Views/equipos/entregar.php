<?php $datos = $equipos->getDataSalida(); ?>

<h1> <?php echo $datos['titulo']; ?> edit!</h1>

<form action="" method="post">

    Departamento: 
        <select required name="departamento" id="departamento">

            <?php foreach ($datos['departamentos'] as $departamento) { ?>
                <option value="<?php echo $departamento['id_departamento']; ?>"> <?php echo $departamento['nombre_departamento'] ?> </option>
            <?php } ?>

        </select> <br>
    Equipo: 
        <select required name="equipo" id="equipo">

            <?php foreach ($datos['equipos'] as $equipo) { ?>
                <option value="<?php echo $equipo['id_equipo']; ?>"> <?php echo $equipo['numero_bien'] ?> </option>
            <?php } ?>

        </select> <br>
    Fecha Entrega: <input type="datetime-local" name="fecha_recibido" id="fecha_recibido" value=""> <br>
    Entregado Por: 
        <select required name="recibido_por" id="recibido_por">
                
                <?php foreach($datos['operadores'] as $operadores) {  ?>
                    <option value="<?php echo $operadores['id_operador']; ?>"> <?php echo $operadores['nombre'] ?> </option>
                <?php } ?>

        </select> <br>
    Conclusion: <input required type="text" name="problema" id="problema"><br>
     <br>
    <button type="submit">Registrar</button>
</form>