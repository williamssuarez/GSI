<?php $datos = $direcciones->getDireccionesLibresporRango();

?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?> new!</h1>
 <p class="mb-4">Defina la direccion IP que le gustaria asignar al departamento de  <?php echo $datos['rango']['nombre']?> </p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
       <h6 class="m-0 font-weight-bold text-primary">Direccion</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

        <form action="new" method="post">
            <div>
                <label class="form-label mt-4">Tipo de dispositivo</label>
                <select required class="form-select" name="dispositivo" id="dispositivo">

                    <?php foreach ($datos['dispositivos'] as $dispositivo) { ?>
                        <option value="<?php echo $dispositivo['id_dispositivos']; ?>"> <?php echo $dispositivo['nombre_dispositivo'] ?> </option>
                    <?php } ?>

                </select>

                <br>
                
                <label class="form-label mt-4">Direccion</label>
                <select required class="form-select" name="direccion" id="direccion">
                        
                        <?php foreach($datos['direcciones'] as $direcciones) {  ?>
                            <option value="<?php echo $direcciones['id_ip']; ?>"> <?php echo $direcciones['direccion'] ?> </option>
                        <?php } ?>

                </select>
                
                </br>

                <label class="form-label mt-4"><i class="fa-solid fa-tag" style="color: #279608;"></i> Numero de Bien (Obligatorio si esta disponible)</label>
                <input class="form-control" type="number" name="numero_bien" id="numero_bien" maxlength="6" minlength="6" placeholder="Introduzca Numero de Bien">

                <button class="btn btn-success" type="submit">Asignar</button>
            </div>

        </form>

        </div>
    </div>
</div>
<?php require_once "Views/footers/footer.php"; ?>