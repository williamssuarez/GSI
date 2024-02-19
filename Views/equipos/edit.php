<?php $datos = $equipos->getDataIngreso(); ?>

<br>

<h1> <?php echo $datos['titulo']; ?> edit!</h1>

<br>

<form action="" method="post">


    <div>
        <label class="form-label mt-4">Numero de Bien</label>
        <input required class="form-control" type="number" name="numero_bien" id="numero_bien" placeholder="Introduzca Numero de Bien">
        
        <label class="form-label mt-4">Departamento</label>
        <select required class="form-select" name="departamento" id="departamento">

            <?php foreach ($datos['departamentos'] as $departamento) { ?>
                <option value="<?php echo $departamento['id_departamento']; ?>"> <?php echo $departamento['nombre_departamento'] ?> </option>
            <?php } ?>

        </select>

        <label class="form-label mt-4">Fecha Recibido</label>
        <input required class="form-control" value="<?php echo $datos['fecha_recibido'] ?>" type="datetime-local" name="fecha_recibido" id="fecha_recibido" value="" max="" min="2020-01-01T00:00"> 

        <label class="form-label mt-4">Recibido Por</label>
        <select required class="form-select" name="recibido_por" id="recibido_por">
                
                <?php foreach($datos['operadores'] as $operadores) {  ?>
                    <option value="<?php echo $operadores['id_operador']; ?>"> <?php echo $operadores['nombre'] ?> </option>
                <?php } ?>

        </select>

        <label class="form-label mt-4">Problema</label>
        <input required class="form-control" type="text" name="problema" id="problema" placeholder="Cual es el problema del equipo">

        <br>
        
        <button class="btn btn-success" type="submit">Editar</button>
    </div>
    
</form>
<?php
require_once "Views/footers/footer.php";
?>

