
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['title']; ?> new!</h1>
 <p class="mb-4">Defina el usuario para el filtro</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
       <h6 class="m-0 font-weight-bold text-primary">Filtro</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

        <form action="" method="post">
            <div>

            <label class="form-label mt-4"><i class="fa-solid fa-calendar-days"></i> Desde: </label>
                <input class="form-control" required type="datetime-local" name="fecha_inicio" id="fecha_inicio" value="" max="" min="2023-01-01T00:00"> 

            <br></br>

            <label class="form-label mt-4"><i class="fa-solid fa-calendar-days"></i> Hasta: </label>
                <input class="form-control" required type="datetime-local" name="fecha_final" id="fecha_final"> 
                
            </div>

            <br></br>

            <button class="btn btn-primary" type="submit">Filtrar</button>
        </form>

        </div>
    </div>
</div>