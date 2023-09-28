<?php $datos = $equipos->getDataIngreso() ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $datos['titulo']; ?> new!</h1>
 <p class="mb-4">Ingrese los datos del nuevo equipo en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" >Registrar Equipo <i class="fa-solid fa-computer"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="new" method="post">


            <div>
                <label class="form-label mt-4"><i class="fa-solid fa-tag" style="color: #279608;"></i> Numero de Bien</label>
                <input required class="form-control" type="number" name="numero_bien" id="numero_bien" maxlength="6" minlength="6" placeholder="Introduzca Numero de Bien">
                
                <label class="form-label mt-4"><i class="fa-solid fa-building" style="color: #913080;"></i> Departamento</label>
                <select required class="form-select" name="departamento" id="departamento">

                    <?php foreach ($datos['departamentos'] as $departamento) { ?>
                        <option value="<?php echo $departamento['id_departamento']; ?>"> <?php echo $departamento['nombre_departamento'] ?> </option>
                    <?php } ?>

                </select>
                
                <label class="form-label mt-4"><i class="fa-solid fa-tag" style="color: #279608;"></i> Usuario</label>
                <input required class="form-control" type="text" name="usuario" id="usuario" placeholder="Introduzca El nombre del Usuario">

                <label class="form-label mt-4"><i class="fa-solid fa-calendar-days"></i>Direccion MAC</label>
                <input class="form-control" required type="text" name="direccion_mac" id="direccion_mac" placeholder="Introduzca la direccion Mac del equipo">

                <label class="form-label mt-4"><i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i>CPU (Opcional)</label>
                <input required class="form-control" type="text" name="cpu" id="cpu" placeholder="Introduzca el CPU del equipo, 'Pentium 4' o 'Dual Core' por ejemplo">

                <label class="form-label mt-4"><i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i>Almacenamiento (Opcional)</label>
                <input required class="form-control" type="number" name="almacenamiento" id="almacenamiento" placeholder="Almacenamiento total del equipo, en GB">

                <label class="form-label mt-4"><i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i>Memoria RAM (Opcional)</label>
                <input required class="form-control" type="number" name="memoria_ram" id="memoria_ram" placeholder="Memoria total del equipo, en GB">

                <label class="form-label mt-4"><i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i>Sistema Operativo</label>
                <input required class="form-control" type="text" name="sistema_operativo" id="sistema_operativo">
                <select required class="form-select" name="sistema_operativo" id="sistema_operativo">
                    <option value="Windows 10 Home">Windows 10 Home</option>
                    <option value="Windows 10 Pro">Windows 10 Pro</option>
                    <option value="Windows 10 MiniOS">Windows 10 MiniOS</option>
                </select>
                
                <br>
            
                <button class="btn btn-success" type="submit">
                <i class="fa-solid fa-truck-arrow-right fa-flip-horizontal"></i>
                    Ingresar
                </button>

            </div>

            </form>

        </div>
    </div>
</div>


<script src="<?php echo URL; ?>Views/template/js/scripts/getFechaActual.js" ></script>


