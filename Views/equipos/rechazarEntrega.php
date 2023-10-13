
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?></h1>
 <p class="mb-4">Introduzca la razon para el rechazo de la entrega</p>



<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">

            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register">
                    <img class="gsi-preguntas-imagen" src="<?php echo URL; ?>Views/template/img/proteger.png" alt="">
                </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Razon de rechazo</h1>
                        </div>
                            <form class="user" method="post" action="">
                                <hr>
                                <div class="form-group row">
                                    <div class="form-group">
                                    <label class="form-label mt-4">
                                            <i class="fa-solid fa-user-gear" style="color: #005af5;"></i> 
                                            Razon                                     
                                        </label>
                                        <textarea required class="form-control" type="text" name="razon_rechazo" id="razon_rechazo" 
                                        placeholder="Introduzca Razon..." rows="3"></textarea>
                                    <div id="mensajeValidacion2" class="form-text"></div>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #932906;"></i> 
                                            Introduzca Clave de administrador                                     
                                        </label>
                                        <input type="password" class="form-control form-control-user" name="clave_admin" id="clave_admin"
                                            placeholder="Introduzca Clave..." required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #932906;"></i> 
                                            Confirmar Clave de administrador
                                        </label>
                                        <input type="password" class="form-control form-control-user" name="clave_confirmacion" id="clave_confirmacion" 
                                            placeholder="Introduzca Clave..." required>
                                    </div>
                                </div>
                                <hr>
                                <button id="btnSubmit2" type="submit" class="btn btn-danger btn-user btn-block">                                    
                                    Rechazar Entrega
                                </button>
                                <a href="<?php echo URL; ?>equipos/esperandoAprobacion" class="btn btn-primary btn-user btn-block">
                                    Cancelar
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<script>

    // Obtén el elemento del textarea y el botón submit
    const inputTexto = document.getElementById('razon_rechazo');
    const btnSubmit = document.getElementById('btnSubmit2');
    const mensajeValidacion = document.getElementById('mensajeValidacion2');

    // Agrega un evento de entrada al textarea para validar en tiempo real
    inputTexto.addEventListener('input', function () {
        // Obtiene el valor del textarea y cuenta la longitud
        const valor = razon_rechazo.value.trim();
        const longitud = valor.length;
        
        // Validación: no más de 200 caracteres
        if (longitud <= 200) {
            // Cambia el estilo y habilita el botón submit
            inputTexto.classList.remove('is-invalid');
            inputTexto.classList.add('is-valid');
            mensajeValidacion.textContent = '';
            btnSubmit.disabled = false;
        } else if(longitud <= 0){

            // Cambia el estilo y deshabilita el botón submit
            inputTexto.classList.remove('is-valid');
            inputTexto.classList.add('is-invalid');
            mensajeValidacion.textContent = 'El texto no puede estar vacio.';
            btnSubmit.disabled = true;

        } else {
            // Cambia el estilo y deshabilita el botón submit
            inputTexto.classList.remove('is-valid');
            inputTexto.classList.add('is-invalid');
            mensajeValidacion.textContent = 'El texto no debe exceder los 200 caracteres.';
            btnSubmit.disabled = true;
        }
    });


</script>