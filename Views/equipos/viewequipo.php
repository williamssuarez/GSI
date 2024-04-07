
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
                                        <h1 class="h1 text-primary mb-4">Datos del equipo</h1>
                                    </div>
                                    <hr>
                                        <h1 class="h5 text-gray-900 mb-4"> ID: <?php echo $data['equipo']['id_equipo'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4"> 
                                            Estado:<?php if ($data['equipo']['estado'] == 0){ ?>

                                                <span class="font-weight-bold" >
                                                    Activo <i class="fa-solid fa-circle-check" style="color: #3aa413;"></i>
                                                </span>

                                                    <?php } elseif($data['equipo']['estado'] == 4) { ?>

                                                        <span class=" font-weight-bold" >
                                                            Registro por Aprobar <i class="fa-solid fa-circle-info" style="color: #0045bd;"></i>
                                                        </span> 

                                                    <?php } elseif($data['equipo']['estado'] == 1) { ?>

                                                        <span class=" font-weight-bold" >
                                                            Inactivo <i class="fa-solid fa-circle-exclamation" style="color: #d4ac40;"></i>
                                                        </span>

                                                    <?php } else { ?>

                                                        <span class=" font-weight-bold" >
                                                            En Soporte <i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i>
                                                        </span> 
                                                        
                                                    <?php } ?>
                                        </h1>
                                        <h1 class="h5 text-gray-900 mb-4"><i class="fa-solid fa-tag" style="color: #279608;"></i> Numero de Bien: <?php echo $data['equipo']['numero_bien'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4"><i class="fa-solid fa-building" style="color: #913080;"></i> Departamento: <?php echo $data['equipo']['departamento'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4"><i class="fa-solid fa-person" style="color: #00040a;"></i> Usuario: <?php echo $data['equipo']['usuario'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4"><i class="fa-solid fa-receipt" style="color: #545454;"></i> Direccion MAC: <?php echo $data['equipo']['direccion_mac'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4"><i class="fa-solid fa-globe" style="color: #1049ad;"></i> Direccion IP: <?php echo $data['equipo']['direccion_ip'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4"><i class="fa-solid fa-calendar-days"></i> Fecha Registro: <?php echo $data['equipo']['fecha_registro'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4"><i class="fa-solid fa-user" style="color: #054cc7;"></i> Registrado Por: <?php echo $data['equipo']['nombres'] ?> <?php echo $data['equipo']['apellidos'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4"><i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i> Ingresos: <?php echo $data['equipo']['ingresos'] ?>  </h1>
                                        <hr>
                                        <h1 class="h5 text-gray-900 mb-4"><i class="fa-solid fa-microchip" style="color: #701ab7;"></i> CPU: <?php echo $data['equipo']['cpu'] ?>  </h1>
                                        <h1 class="h5 text-gray-900 mb-4"><i class="fa-solid fa-memory" style="color: #298a00;"></i> Memoria RAM: <?php echo $data['equipo']['memoria_ram'] ?>  GB</h1>
                                        <h1 class="h5 text-gray-900 mb-4"><i class="fa-solid fa-hard-drive" style="color: #545454;"></i> Almacenamiento: <?php echo $data['equipo']['almacenamiento'] ?>  GB</h1>
                                        <h1 class="h5 text-gray-900 mb-4"> 
                                        <?php if ($data['equipo']['tipo'] == 0){ ?>  
                                                                    <i class="fa-brands fa-windows" style="color: #105ada;"></i>
                                                                <?php } else { ?>
                                                                    <i class="fa-brands fa-linux" style="color: #e08910;"></i>
                                                                <?php } ?>
                                            Sistema Operativo: <?php echo $data['equipo']['sistema_operativo'] ?>
                                        </h1>
                                        <div class="btn-group btn-user btn-block">
                                            <a href="<?php echo URL; ?>equipos/registrados" class="btn btn-primary" aria-current="page">Volver</a>

                                            <?php if($_SESSION['rol'] == 1){ ?>    
                                                <a href="<?php echo URL; ?>equipos/editregistro/<?php echo $data['equipo']['id_equipo'] ?>" class="btn btn-info">Editar</a>
                                                <?php if($data['equipo']['estado'] == 0) { ?>

                                                    <a id="desactivandoequipo" href="<?php echo URL; ?>equipos/desactivar/<?php echo $data['equipo']['id_equipo'] ?>" class="btn btn-danger">Desactivar</a>

                                                <?php } elseif($data['equipo']['estado'] == 4) { ?>

                                                    <a id="aprobarRegistroEquipo" class="btn btn-success" href='aprobarregistro/<?php echo $data['equipo']['id_equipo'] ?>'>Aprobar</a>

                                                    <a id="rechazarRegistroEquipo" class="btn btn-danger" href='rechazarregistro/<?php echo $data['equipo']['id_equipo'] ?>'>Rechazar</a>

                                                <?php } elseif($data['equipo']['estado'] == 1) { ?>

                                                    <a id="reactivandoequipo" href="<?php echo URL; ?>equipos/reactivar/<?php echo $data['equipo']['id_equipo'] ?>" class="btn btn-success">Reactivar</a>

                                                <?php } else { ?>

                                                    <a href="<?php echo URL; ?>equipos/index" class="btn btn-secondary">Ir a equipos ingresados</a>

                                                <?php } ?>
                                            <?php } ?>
                                            
                                        </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<?php if($_SESSION['rol'] == 1) { //es admin
    require_once "Views/footers/footer.php";
} else {
    require_once "Views/footers/footerOpr.php";
}
?>