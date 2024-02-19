
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?> edit!</h1>
 <p class="mb-4">Ingrese los datos del nuevo dispositivo en el formulario</p>

        <h1 class="h3 mb-2 text-gray-800">Formulario</h1>
        
        
<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Dispositivo <i class="fa-solid fa-print"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="<?php echo URL; ?>dispositivos/edit/<?php echo $data['dispositivos']['id_dispositivos'] ?>" method="post">


                <div>

                    <label class="form-label mt-4"><i class="fa-solid fa-user-gear" style="color: #005af5;"></i> Inserte el tipo de dispositivo a ingresar </label>
                    <input required value="<?php echo $data['dispositivos']['nombre_dispositivo'] ?>" class="form-control" type="text" name="nombre" id="nombre" placeholder="Introduzca Nombres">

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
