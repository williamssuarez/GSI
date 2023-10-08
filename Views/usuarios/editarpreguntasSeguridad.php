

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?></h1>
 <p class="mb-4">Aviso: estas preguntas seran usadas para restablecer tu clave en caso de que la olvides,
                Asi que recuerdalas bien o anotalas en algun lado, si olvidas las respuestas y olvidas tu clave deberas notificarle al administrador para que cambie tu clave</p>



<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">

            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register">
                    <img class="gsi-preguntas-imagen" src="<?php echo URL; ?>Views/template/img/proteger2.png" alt="">
                </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Preguntas de seguridad</h1>
                        </div>
                            <form class="user" method="post" action="">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #932906;"></i> 
                                            Pregunta 1: Color Favorito                                      
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="respuesta1" id="respuesta1"
                                            placeholder="Respuesta..." required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #932906;"></i> 
                                            Pregunta 2: Nombre de primera mascota
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="respuesta2" id="respuesta2" 
                                            placeholder="Respuesta..." required>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #932906;"></i> 
                                            Pregunta 3: En que ciudad naciste                                    
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="respuesta3" id="respuesta3"
                                            placeholder="Respuesta..." required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #932906;"></i> 
                                            Pregunta 4: Cual es tu pelicula favorita
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="respuesta4" id="respuesta4" 
                                            placeholder="Respuesta..." required>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #932906;"></i> 
                                            Pregunta 5: Primer nombre y primer apellido de tu padre/madre                                    
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="respuesta5" id="respuesta5"
                                            placeholder="Respuesta..." required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #932906;"></i> 
                                            Pregunta 6: Primer nombre y primer apellido de tu abuelo(a)
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="respuesta6" id="respuesta6" 
                                            placeholder="Respuesta..." required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">                                    
                                    Actualizar Preguntas
                                </button>
                                <a href="<?php echo URL; ?>usuarios/profile/<?php echo $_SESSION['usuario'] ?>" class="btn btn-danger btn-user btn-block">
                                    Cancelar
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            
    </div>
</div>