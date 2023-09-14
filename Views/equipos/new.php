<?php $datos = $equipos->getDataIngreso() ?>

<h1> <?php echo $datos['titulo']; ?> new!</h1>

<form action="new" method="post">

    Numero de Bien: <input required type="text" name="numero_bien" id="numero_bien"> <br>
    Departamento: 
        <select required name="departamento" id="departamento">

            <?php foreach ($datos['departamentos'] as $departamento) { ?>
                <option value="<?php echo $departamento['id_departamento']; ?>"> <?php echo $departamento['nombre_departamento'] ?> </option>
            <?php } ?>

        </select> <br>
    Fecha Recibido: <input type="datetime-local" name="fecha_recibido" id="fecha_recibido" value=""> <br>
    Recibido Por: 
        <select required name="recibido_por" id="recibido_por">
                
                <?php foreach($datos['operadores'] as $operadores) {  ?>
                    <option value="<?php echo $operadores['id_operador']; ?>"> <?php echo $operadores['nombre'] ?> </option>
                <?php } ?>

        </select> <br>
    Problema: <input required type="text" name="problema" id="problema"><br>
     <br>
    <button type="submit">Registrar</button>
</form>
