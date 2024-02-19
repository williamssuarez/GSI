
<!-- Page Heading -->
<h1 class="h1 mb-2 text-gray-800"><?php echo $data['titulo']; ?></h1>


<div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img class="gsi-view-imagen-inicio" src="<?php echo URL; ?>Views/template/img/1.png" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h1 text-primary mb-4">Detalles</h1>
                                    </div>
                                    <hr>
                                        <h1 class="h5 text-gray-900 mb-4"> ID: <?php echo $data['auditoria']['id_auditoria'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4">Tipo de Cambio: <?php echo $data['equipo']['numero_bien'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4">Tabla Afectada: <?php echo $data['equipo']['departamento'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4">Registro Afectado: <?php echo $data['equipo']['usuario'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4">Valor Antes: <?php echo $data['equipo']['direccion_mac'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4">Valor Despues: <?php echo $data['equipo']['direccion_ip'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4">Usuario: <?php echo $data['equipo']['fecha_registro'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4">Fecha: <?php echo $data['equipo']['ingresos'] ?>  </h1>
                            
                                        <div class="btn-group btn-user btn-block">
                                            <a href="<?php echo URL; ?>auditoria/index" class="btn btn-primary" aria-current="page">Volver</a>
                                        </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php require_once "Views/footers/footer.php"; ?>