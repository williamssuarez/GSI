<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?> edit!</h1>
 <p class="mb-4">Ingrese los datos del empleado en el formulario</p>

        <h1 class="h3 mb-2 text-gray-800">Formulario</h1>
        
        
<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tipo <i class="fa-solid fa-table-cells"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="<?php echo URL; ?>empleados/edit/<?php echo $data['empleados']['id_empleado'] ?>" method="post">

                <div>

                    <label class="form-label mt-4"> Inserte el Nombre completo del empleado </label>
                    <input required value="<?php echo $data['empleados']['nombre_completo'] ?>" class="form-control" type="text" name="nombre_completo" id="nombre_completo" placeholder="Introduzca Nombre completo">

                    <label class="form-label mt-4"> Inserte la cedula del empleado </label>
                    <input required class="form-control" type="number" value="<?php echo $data['empleados']['cedula'] ?>" name="cedula" id="cedula" maxlength="9" minlength="6" placeholder="Introduzca Cedula">
                    <div id="mensajeCedulaValidacion" class="form-text"></div>

                    <label class="form-label mt-4"><i class="fa-solid fa-table" style="color: #005cfa;"></i> Departamento</label>
                    <select required class="form-select Select2" name="departamento" id="departamento">

                        <?php foreach ($data['departamentos'] as $departamento) { 
                            $selected = ($departamento['id_departamento'] == $data['empleados']['departamento_id']) ? 'selected' : '';    
                        ?>
                            <option value="<?php echo $departamento['id_departamento']; ?>" <?php echo $selected; ?> > <?php echo $departamento['nombre_departamento'] ?> </option>
                        <?php } ?>

                    </select>

                    <br>
                    <br>
                    
                    <button id="btnSubmit" class="btn btn-success" type="submit">
                        <i class="fa-solid fa-user-plus"></i>
                        Editar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="<?php echo URL; ?>Views/template/js/scripts/forms/empleados.js" ></script>

<?php require_once "Views/footers/footer.php"; ?>