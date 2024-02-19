

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $data['titulo']; ?></h1>
 <p class="mb-4">Ingrese las nuevas credenciales del  usuario en el formulario</p>



<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">

            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register">
                    <img class="gsi-preguntas-imagen" src="<?php echo URL; ?>Views/template/img/proteger.png" alt="">
                </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Actualizar credenciales de usuario</h1>
                        </div>
                            <form class="user" method="post" action="">
                                <div class="form-group row">
                                    <div class="form-group">
                                    <label class="form-label mt-4">
                                            <i class="fa-solid fa-user-gear" style="color: #005af5;"></i> 
                                            Usuario                                     
                                        </label>
                                        <input type="text" class="form-control form-control-user" name="usuario" id="usuario"
                                            placeholder="Introduzca Nombres"  required pattern="[A-Za-z\s]+" 
                                            title="Solo se permiten letras y espacios" 
                                            value="<?php echo $data['operador']['usuario'] ?>">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #932906;"></i> 
                                            Nueva Clave                                     
                                        </label>
                                        <input type="password" class="form-control form-control-user" name="nueva_clave" id="nueva_clave"
                                            placeholder="Introduzca Nombres" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label mt-4">
                                            <i class="fa-solid fa-lock" style="color: #932906;"></i> 
                                            Confirmar Clave
                                        </label>
                                        <input type="password" class="form-control form-control-user" name="clave_confirmacion" id="clave_confirmacion" 
                                            placeholder="Introduzca Apellido" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">                                    
                                    Actualizar Credenciales
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
<?php
if($_SESSION['rol'] == 1) { //es admin
    require_once "Views/footers/footer.php";
} else {
    require_once "Views/footers/footerOpr.php";
}
?>


