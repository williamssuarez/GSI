
<div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-5 d-none d-lg-block bg-register">
                                <img class="gsi-preguntas-imagen" src="<?php echo URL; ?>Views/template/img/proteger2.png" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Preguntas de Seguridad</h1>
                                    </div>
                                    <form class="user" method="post" action="">
                                        <hr>

                                        <label class="h5 form-label mt-4"> <?php echo $_SESSION['pregunta1']; ?> </label>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="respuesta1" name="respuesta1"
                                                placeholder="Respuesta..." required>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                        <label class="h5 form-label mt-4"> <?php echo $_SESSION['pregunta2']; ?> </label>
                                            <input type="text" class="form-control form-control-user"
                                                id="respuesta2" name="respuesta2"
                                                placeholder="Respuesta..." required>
                                        </div>
                                        <hr>
                                        <button class="btn btn-primary btn-user btn-block" type="submit" name="submit" id="submit">
                                            Validar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>