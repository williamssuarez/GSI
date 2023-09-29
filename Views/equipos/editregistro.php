
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?> new!</h1>
 <p class="mb-4">Ingrese los datos a editar del equipo en el formulario</p>

         <h1 class="h3 mb-2 text-gray-800">Formulario</h1>


<div class="card border-left-primary shadow h-100 mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Registrar Equipo <i class="fa-solid fa-desktop"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <form action="<?php echo URL; ?>equipos/editregistro/<?php echo $data['equipo']['id_equipo'] ?>" method="post">


                <div>

                    <label class="form-label mt-4"><i class="fa-solid fa-tag" style="color: #279608;"></i> Numero de Bien</label>
                    <input required value="<?php echo $data['equipo']['numero_bien'] ?>" class="form-control" type="number" name="numero_bien" id="numero_bien" maxlength="6" minlength="6" placeholder="Introduzca Numero de Bien">

                    <label class="form-label mt-4"><i class="fa-brands fa-linux" style="color: #e08910;"></i> Sistema Operativo</label>
                    <select required class="form-select" name="departamento" id="departamento">

                        <?php foreach ($data['departamentos'] as $departamentos) { 
                            $selected = ($departamentos['id_departamento'] == $data['equipo']['departamento']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $departamentos['id_departamento']; ?>" <?php echo $selected; ?>> <?php echo $departamentos['nombre_departamento'] ?> </option>
                        <?php } ?>

                    </select>
                    
                    <label class="form-label mt-4"><i class="fa-solid fa-person" style="color: #00040a;"></i> Usuario</label>
                    <input required value="<?php echo $data['equipo']['usuario'] ?>" class="form-control" type="text" name="usuario" id="usuario" placeholder="Introduzca El nombre del Usuario">

                    <label class="form-label mt-4"><i class="fa-solid fa-receipt" style="color: #545454;"></i>Direccion MAC</label>
                    <input required value="<?php echo $data['equipo']['direccion_mac'] ?>"class="form-control" type="text" name="direccion_mac" id="direccion_mac" placeholder="Introduzca la direccion Mac del equipo">

                    <label class="form-label mt-4"><i class="fa-solid fa-microchip" style="color: #701ab7;"></i>CPU (Opcional)</label>
                    <input required value="<?php echo $data['equipo']['cpu'] ?>" class="form-control" type="text" name="cpu" id="cpu" placeholder="Introduzca el CPU del equipo, 'Pentium 4' o 'Dual Core' por ejemplo">

                    <label class="form-label mt-4"><i class="fa-solid fa-hard-drive" style="color: #545454;"></i>Almacenamiento (Opcional)</label>
                    <input required value="<?php echo $data['equipo']['almacenamiento'] ?>" class="form-control" type="number" name="almacenamiento" id="almacenamiento" placeholder="Almacenamiento total del equipo, en GB">

                    <label class="form-label mt-4"><i class="fa-solid fa-memory" style="color: #298a00;"></i>Memoria RAM (Opcional)</label>
                    <input required value="<?php echo $data['equipo']['memoria_ram'] ?>" class="form-control" type="number" name="memoria_ram" id="memoria_ram" placeholder="Memoria total del equipo, en GB">

                    <label class="form-label mt-4"><i class="fa-brands fa-linux" style="color: #e08910;"></i> Sistema Operativo</label>
                    <select required class="form-select" name="sistema" id="sistema">

                        <?php foreach ($data['sistemas'] as $sistemas) { 
                            $selected = ($sistemas['id_os'] == $data['equipo']['sistema_operativo']) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $sistemas['id_os']; ?>" <?php echo $selected; ?>> <?php echo $sistemas['nombre'] ?> </option>
                        <?php } ?>

                    </select>

                    <br>
                    
                    <button class="btn btn-success" type="submit">
                        Editar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>



