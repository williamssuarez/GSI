<div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-5 d-none d-lg-block bg-register">
                                <img class="gsi-preguntas-imagen" src="<?php echo URL; ?>Views/template/img/reiniciar.png" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">¿Olvidaste tu clave?</h1>
                                        <p class="mb-4">Introduce tu cedula en el campo de abajo para
                                                        obtener las preguntas de seguridad, o si lo prefieres 
                                                        contacta al administrador para que cambie tu clave</p>
                                    </div>
                                    <form class="user" method="post" action="" >
                                        <div class="form-group">
                                            <input required type="number" class="form-control form-control-user"
                                                id="cedula_restablecer" name="cedula_restablecer"
                                                placeholder="Introduzca su cedula aqui...">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" type="submit" name="submit" id="submit">
                                            Obtener preguntas
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?php echo URL; ?>login/index">¿Ya recordaste? Inicia Sesion</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>