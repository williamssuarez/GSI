<?php $datos = $equipos->getDataRegistro() ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?> new!</h1>
 <p class="mb-4">Ingrese los datos del nuevo equipo en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" >Registrar Equipo <i class="fa-solid fa-desktop"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="" method="post">


            <div>
                <label class="form-label mt-4"><i class="fa-solid fa-tag" style="color: #279608;"></i> Numero de Bien</label>
                <input required class="form-control" type="number" name="numero_bien" id="numero_bien" maxlength="6" minlength="6" placeholder="Introduzca Numero de Bien">
                <div id="mensajeBienValidacion" class="form-text"></div>    
                
                <label class="form-label mt-4"><i class="fa-solid fa-building" style="color: #913080;"></i> Departamento</label>
                <select required class="form-select Select2" name="departamento" id="departamento">

                    <?php foreach ($datos['departamentos'] as $departamento) { ?>
                        <option value="<?php echo $departamento['id_departamento']; ?>"> <?php echo $departamento['nombre_departamento'] ?> </option>
                    <?php } ?>

                </select>
                
                <label class="form-label mt-4"><i class="fa-solid fa-person" style="color: #00040a;"></i> Usuario</label>
                <select required class="form-select Select2" name="usuario" id="usuario">

                        <option> Seleccione un departamento </option>

                </select>

                <label class="form-label mt-4"><i class="fa-solid fa-receipt" style="color: #545454;"></i>Direccion MAC</label>
                <input class="form-control" required type="text" name="direccion_mac" id="direccion_mac" placeholder="Introduzca la direccion Mac del equipo">
                <div id="mensajeMACValidacion" class="form-text"></div>

                <label class="form-label mt-4"><i class="fa-solid fa-microchip" style="color: #701ab7;"></i>CPU (Opcional)</label>
                <input required class="form-control" type="text" name="cpu" id="cpu" placeholder="Introduzca el CPU del equipo, 'Pentium 4' o 'Dual Core' por ejemplo">

                <label class="form-label mt-4"><i class="fa-solid fa-hard-drive" style="color: #545454;"></i>Almacenamiento (Opcional)</label>
                <input required class="form-control" type="number" name="almacenamiento" id="almacenamiento" placeholder="Almacenamiento total del equipo, en GB">

                <label class="form-label mt-4"><i class="fa-solid fa-memory" style="color: #298a00;"></i>Memoria RAM (Opcional)</label>
                <input required class="form-control" type="number" name="memoria_ram" id="memoria_ram" placeholder="Memoria total del equipo, en GB">

                <label class="form-label mt-4"><i class="fa-brands fa-linux" style="color: #e08910;"></i> Sistema Operativo</label>
                <select required class="form-select Select2" name="sistema" id="sistema">

                    <?php foreach ($datos['sistemas'] as $sistemas) { ?>
                        <option value="<?php echo $sistemas['id_os']; ?>"> <?php echo $sistemas['nombre'] ?> </option>
                    <?php } ?>

                </select>
                
                <br>
                <br>
            
                <button id="btnSubmit" class="btn btn-success" type="submit" disabled>
                <i class="fa-solid fa-truck-arrow-right fa-flip-horizontal"></i>
                    Registrar
                </button>

            </div>

            </form>

        </div>
    </div>
</div>

<?php
if($_SESSION['rol'] == 1) { //es admin
    require_once "Views/footers/footer.php";
} else {
    require_once "Views/footers/footerOpr.php";
}
?>


