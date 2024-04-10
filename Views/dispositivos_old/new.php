<?php $datos = $dispositivos->index() ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?> new!</h1>
 <p class="mb-4">Ingrese los datos del nuevo dispositivo en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Dispositivo <i class="fa-solid fa-print"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="new" method="post">


                <div>

                    <label class="form-label mt-4"> Inserte el tipo de dispositivo a ingresar </label>
                    <input required class="form-control" type="text" name="nombre" id="nombre" placeholder="Introduzca Nombre">

                    <label class="form-label mt-4"> Inserte el tipo de dispositivo a ingresar </label>
                    <input required class="form-control" type="text" name="nombre" id="nombre" placeholder="Introduzca Nombre">

                    <br>
                    
                    <button class="btn btn-success" type="submit">
                        Registrar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<?php require_once "Views/footers/footer.php"; ?>