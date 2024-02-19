
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['departamento']['id_departamento']; ?> edit!</h1>
 <p class="mb-4">Ingrese los datos del nuevo operador en el formulario</p>

        <h1 class="h3 mb-2 text-gray-800">Formulario</h1>

        
        
        
<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Departamentos <i class="fa-solid fa-users-gear"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="<?php echo URL; ?>departamentos/edit/<?php echo $data['departamento']['id_departamento'] ?>" method="post">


                <div>
                    <label class="form-label mt-4"><i class="fa-solid fa-user-gear" style="color: #005af5;"></i> Nombre del Departamento </label>
                    <input required value="<?php echo $data['departamento']['nombre_departamento'] ?>" class="form-control" type="text" name="nombre" id="nombre" placeholder="Introduzca Nombres">
                    
                    <label class="form-label mt-4"><i class="fa-solid fa-person"></i> Piso localizado</label>
                    <input required value="<?php echo $data['departamento']['piso'] ?>" class="form-control" type="text" name="piso" id="piso" placeholder="Introduzca Apellido">

                    <br>
                    
                    <button class="btn btn-success" type="submit">
                        <i class="fa-solid fa-user-plus"></i>
                        Editar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<?php require_once "Views/footers/footer.php"; ?>
