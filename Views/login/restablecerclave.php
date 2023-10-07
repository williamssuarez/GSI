
<div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Restablecer clave</h1>
                                    </div>
                                    <p class="mb-4">Introduce el nuevo usuario y clave, algo simple como tu cedula o tu numero de telefono                                         
                                                    para que sea mas facil de recordar, igual recuerda que puedes cambiar tus credenciales
                                                    de inicio de sesion una vez dentro del sistema</p>
                                    <form class="user" method="post" action="">

                                    <label class="h5 form-label mt-4">Introduzca el nuevo usuario</label>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="nuevo_usuario" name="nuevo_usuario"
                                                placeholder="Usuario..." required>
                                        </div>
                                        <hr>
                                        <label class="h5 form-label mt-4">Introduzca la nueva clave</label>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="nueva_clave" name="nueva_clave"
                                                placeholder="Clave..." required>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                        <label class="h5 form-label mt-4">Confirme la nueva clave</label>
                                            <input type="password" class="form-control form-control-user"
                                                id="confirmacion_clave" name="confirmacion_clave"
                                                placeholder="Clave..." required>
                                        </div>
                                        <hr>
                                        <button class="btn btn-primary btn-user btn-block" type="submit" name="submit" id="submit">
                                            Restablecer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>