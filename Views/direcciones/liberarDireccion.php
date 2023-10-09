
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?></h1>
 <p class="mb-4">Introduzca la razon de liberacion de la direccion <?php echo $data['direccion']['direccion'] ?></p>



<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">

            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register">
                    <img class="gsi-preguntas-imagen" src="<?php echo URL; ?>Views/template/img/proteger.png" alt="">
                </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Razon de liberacion</h1>
                        </div>
                            <form class="user" method="post" action="">
                                <hr>
                                <div class="form-group row">
                                    <div class="form-group">
                                    <label class="form-label mt-4">
                                            <i class="fa-solid fa-user-gear" style="color: #005af5;"></i> 
                                            Razon                                     
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="razon" id="razon"
                                            placeholder="Introduzca Razon..." required pattern="[A-Za-z\s]+" 
                                            title="Solo se permiten letras y espacios" 
                                            >
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
                                <button type="submit" class="btn btn-danger btn-user btn-block">                                    
                                    Liberar Direccion
                                </button>
                                <a href="<?php echo URL; ?>usuarios/index" class="btn btn-primary btn-user btn-block">
                                    Cancelar
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            
    </div>
</div>