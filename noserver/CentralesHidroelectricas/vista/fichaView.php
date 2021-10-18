<!-- Contenido -->
<div class="d-flex flex-column justify-content-start align-items-center w-100 fondoform ">      
    
        <?php if($_SESSION['login']=="admin"){ ?> <!-- Permisos administrador -->
        <form class="d-flex w-100 justify-content-end pe-2 pt-2"  id="identificarusuario" action="<?php echo $this->url("empleados", "empleadologin"); ?>" method="POST">    
          
            
          
             <input id="cambiovista" class="btn btn-vista" type="submit" value="">
            
       
        </form>      <?php } ?>                              

    <br>
    
    <?php
    if (isset($mensaje)) {
        echo "<h3>" . $mensaje . "</h3>";
    }
    ?>
    <!-- Fichas -->
    <?php
    if (isset($elementoemple)) {
        $objetocentral = new CentralesModel();
        $objetodepartamento = new DepartamentosModel();
        $objetocategoria = new CategoriasModel();
        $objetousuario = new UsuariosModel();
        $objetoentrada = new EntradasModel();
        $objetosalida = new SalidasModel();
    ?>
    <?php if ($_SESSION['rol'] == "Admin") { ?>    

        <?php          
            if (isset($_POST['valores'])) {
                switch ($_POST['valores']) {
                    case 'todas':
                        $val = $this->url("empleados", "listar");
                        $nombre = "listaremplestodos";
                        break;
                    case 'central':
                        $val = $this->url("empleados", "verporcentral");
                        $cen = $_POST['idcent'];
                        $nombre = "listarporcentralemple";
                        break;
                }
            }
        ?>     
    
        <?php          
            if (isset($_POST['valores'])) {
                switch ($_POST['valores']) {
                    case 'todas':
                        $val = $this->url("empleados", "listar");
                        $nombre = "listaremplestodos";
                        break;
                    case 'central':
                        $val = $this->url("empleados", "verporcentral");
                        $cen = $_POST['idcent'];
                        $nombre = "listarporcentralemple";
                        break;
                }
            }
        ?>

            <form class="w-75 p-3" action="<?php echo $val ?>" method="post">                   
                <input type="submit" name="<?php echo $nombre; ?>" class="btn btn-previous" value="" />
                <input type="hidden" name="centrales" value="<?php echo $cen; ?>" />
                <input type="hidden" name="val" value="<?php echo $_POST['valores']; ?>" />
            </form>
    
    <?php } ?>   

    <div class="row mt-1 g-0" >
        <div class="d-none d-lg-block col-lg-2 text-center">
        <?php
            echo '<img class="pe-3 ficha_img" src = "data:image/jpeg;base64, ' . base64_encode(($elementoemple->getFoto())) . '" alt = "">';
        ?>
        </div>
        <div class="col-lg-8  pt-2 pb-2">
            <div class="">
                <h5 class="pt-3 title">
                <?php echo $elementoemple->getNombre(); ?>   <?php echo $elementoemple->getApellidos(); ?> 
                </h5>
                <br><br>
                <ul class="nav nav-tabs" >
                    <li class="nav-item">
                        <button class="nav-link active text-dark espacio" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Datos personales</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link text-dark espacio" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Datos trabajador</button>
                    </li>
                    <li class="nav-item" >
                        <button class="nav-link text-dark espacio" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Datos usuario</button>
                    </li>    
                </ul>    
                <div class="tab-content bg-trabajador" id="myTabContent">
                    <div class="tab-pane p-5 fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row ">
                            <div class="col-md-6">
                                <label>DNI</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $elementoemple->getDNI(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Nombre y apellidos</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $elementoemple->getNombre(); ?> <?php echo $elementoemple->getApellidos(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $elementoemple->getEmail(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Teléfono</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $elementoemple->getTelefono(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Fecha de nacimiento</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $elementoemple->getFechaNac(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Dirección</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $elementoemple->getDireccion(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Provincia</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $elementoemple->getProvincia(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Población</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $elementoemple->getPoblacion(); ?></p>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-6">
                                <label>CP</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $elementoemple->getCP(); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-5 fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Central</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $objetocentral->getUnaCentral($elementoemple->getIdCentral())->getNombre(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Departamento</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $objetodepartamento->getUnDepart($elementoemple->getCodDepart())->getNombre(); ?></p>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-6">
                                <label>Salario mensual</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $objetocategoria->getUnaCategoria($elementoemple->getIdCategoria())->getSalarioBase(); ?>€</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Entradas realizadas</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo count($objetoentrada->getEntradasempleado($elementoemple->getNumEmple())); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Salidas realizadas</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo count($objetosalida->getSalidasempleado($elementoemple->getNumEmple())); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-5 fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">                                 
                        <div class="row">
                            <div class="col-md-6">
                                <label>Rol</label>
                            </div>
                            <div class="col-md-6">
                                <p><?php echo $objetousuario->getUnUsuario($elementoemple->getIdUsuario())->getRol(); ?></p>
                            </div>
                        </div> 
                            <?php if($_SESSION['rol']=="Emple"){ ?>
                           <div class="row">
                                 <div class="col-md-6">
                                     <label>Cambio de contraseña</label>
                            </div>
                               <div class="col-md-6">
                          
                         <form class=""   action="<?php echo $this->url("usuarios", "modificar"); ?>" method="POST">    
                        
            
       
             <input name="cambioclave" class="btn btn-pass2" type="submit" value="">
        </div> </div>
          
        </form> <?php } ?>       
                    </div>
                </div>
                </ul>
            </div>
        </div>
        <div class="col-lg-2 d-flex flex-wrap flex-lg-column justify-content-start align-items-center">
            <form action="<?php echo $this->url("empleados", "modificar", $elementoemple->getNumEmple()); ?>" method="POST">
                <input class="btn btn-modificar2 mb-2" name="delete7" type="submit" value="">                       
                <input  name="centrales" type="hidden" value="<?php echo $cen ?>">
                <input type="hidden" name="val" value="<?php echo $_POST['valores']; ?>" />    
            </form>      
                 
            <!-- ESTO SOLO APARECE SI ES ADMIN -->
            <?php if ($_SESSION['rol'] == "Admin") { ?>      
                <a href="#delete_<?php echo $elementoemple->getNumEmple(); ?>" class="btn btn-borrar2" data-bs-toggle="modal" data-bs-target="#modalBorrar<?php echo $elementoemple->getNumEmple() ?>"></a>
                <!-- Modal borrar -->
                    <div class="modal fade" id="modalBorrar<?php echo $elementoemple->getNumEmple(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalBorrar" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form  method="POST" action="<?php echo $this->url("empleados", "borrar", $elementoemple->getNumEmple()); ?>">
                                    <div class="modal-body">
                                        <center><h5 class="modal-title" id="myModalLabel">¿Estas seguro de eliminar el registro?</h5></center>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"></button>
                                        <?php
                                        $disabled = "";
                                        if ($_SESSION['rol'] == "Admin" and $_SESSION['idemple'] == $elementoemple->getNumEmple()) {
                                            $disabled = "disabled";
                                        }
                                        ?>
                                        <button  <?php echo $disabled; ?> type="submit" name="delete7" class="btn btn-accept" ></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>   
    </div>
    <?php } ?>             


    
    
<!-- FICHA UNICA CENTRALES -->
<?php
if (isset($elementocentral)) {
    ?>
    <form class="w-75" action="<?php echo $this->url("centrales", "listar") ?>" method="post">                   
        <input type="submit" name="listarcentrales" class="btn btn-previous" value="" />
    </form>
    <div class="row mt-5 g-0">
        <!-- izquierda --> 
        <div class="col-md-5 col-12 d-none d-md-flex">
            <?php
            echo '<img class="ficha_img" src = "data:image/jpeg;base64, ' . base64_encode(($elementocentral->getFoto())) . '" alt = "">';
            ?>
        </div>
        <!-- derecha -->
        <div class="col-md-7 ps-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fichaunica_titulo"><?php echo $elementocentral->getNombre(); ?></h2>
                <div class="d-flex justify-content-center align-items-center">
                    <form action="<?php echo $this->url("centrales", "modificar", $elementocentral->getIdCentral()); ?>" method="POST">
                        <input class="btn btn-modificar2 me-3" type="submit" value="">
                    </form>
                    <a href="#delete_<?php echo $elementocentral->getIdCentral(); ?>" class="btn btn-borrar2" data-bs-toggle="modal" data-bs-target="#modalBorrar<?php echo $elementocentral->getIdCentral() ?>"></a>
                </div> 
            </div>   
            <!-- Modal borrar -->
            <div class="modal fade" id="modalBorrar<?php echo $elementocentral->getIdCentral(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalBorrar" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form  method="POST" action="<?php echo $this->url("centrales", "borrar", $elementocentral->getIdCentral()); ?>">
                            <div class="modal-body">
                                <center><h5 class="modal-title" id="myModalLabel">¿Estas seguro de eliminar el registro?</h5></center>
                            </div>
                            <div class="modal-footer d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"></button>
                                    <?php
                                    $disabled = "";
                                    $objempleado = new EmpleadosModel();

                                    if ($_SESSION['rol'] == "Admin" and $objempleado->getEmpleado($_SESSION['idemple'])->getIdCentral() == $elementocentral->getIdCentral()) {
                                        $disabled = "disabled";
                                    }
                                    ?>
                                <button <?php echo $disabled; ?> type="submit" name="delete" class="btn btn-accept" ></button>                                
                        </form>
                    </div>
                </div>
            </div>
        </div>                       

        <hr>                               
        <p class="card-text"><strong>Teléfono: </strong><span><?php echo $elementocentral->getTelefono(); ?></span></p>
        <p class="card-text"><strong>Dirección: </strong><span><?php echo $elementocentral->getConstructor(); ?></span></p>
        <p class="card-text"><strong>Provincia: </strong><span><?php echo $elementocentral->getProvincia(); ?></span></p>
        <p class="card-text"><strong>Población: </strong><span><?php echo $elementocentral->getPoblacion(); ?></span></p>
        <p class="card-text"><strong>CP: </strong><span><?php echo $elementocentral->getCP(); ?></span></p>
        <h3 class="card-title fichaunica_titulo pt-3 pb-1">Caracteristicas técnicas</h3>                               
        <ul class="lista">
            <li class="pb-2"><strong>Tipo de turbina: </strong> <span><?php echo $elementocentral->getTipoTurbina(); ?></span></li>
            <li class="pb-2"><strong>Salto Bruto: </strong> <span><?php echo $elementocentral->getSaltoBruto(); ?></span></li>
            <li class="pb-2"><strong>Número de generadores: </strong> <span ><?php echo $elementocentral->getNumGeneradores(); ?></span></li>
            <li class="pb-2"><strong>Potencia: </strong> <span ><?php echo $elementocentral->getPotencia(); ?></span></li> 
        </ul>
    </div>
    </div>
<?php } ?>  



<!-- FICHA UNICA PRODUCTO -->
<?php
if (isset($elementoproducto)) {
?>
    <form class="w-75" action="<?php echo $this->url("productos", "listar") ?>" method="post">                   
        <input type="submit" name="listarproductos" class="btn btn-previous" value="" />
    </form>
    <div class="row mt-5 g-0">
        <!-- izquierda --> 
        <div class="col-md-5 col-12 d-none d-md-flex">
            <?php
            echo '<img class="ficha_img2" src = "data:image/jpeg;base64, ' . base64_encode(($elementoproducto->getFoto())) . '" alt = "">';
            ?>
        </div>
        <!-- derecha -->
        <div class="col-md-7 col-12 p-3 bg-light shadow rounded-2">
            <div class="d-flex justify-content-between align-items-center"> 
                <h2 class="fichaunica_titulo"><?php echo $elementoproducto->getNombre(); ?></h2>
                    <?php if ($_SESSION['rol'] == 'Admin') { ?>
                    <div class="d-flex justify-content-center align-items-center">
                        <form action="<?php echo $this->url("productos", "modificar", $elementoproducto->getCodProd()); ?>" method="POST">
                            <input class="btn btn-modificar2 me-3" type="submit" value="">
                        </form>
                        <a href="#delete_<?php echo $elementoproducto->getCodProd(); ?>" class="btn btn-borrar2" data-bs-toggle="modal" data-bs-target="#modalBorrar<?php echo $elementoproducto->getCodProd() ?>"></a>
                    </div>
                    <?php } ?>
            </div>                                
            <!-- Modal borrar -->
            <div class="modal fade" id="modalBorrar<?php echo $elementoproducto->getCodProd(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalBorrar" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form  method="POST" action="<?php echo $this->url("productos", "borrar", $elementoproducto->getCodProd()); ?>">
                            <div class="modal-body">
                                <center><h5 class="modal-title" id="myModalLabel">¿Estas seguro de eliminar el registro?</h5></center>
                            </div>
                            <div class="modal-footer d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"></button>
                                <button type="submit" name="delete4" class="btn btn-accept" ></button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <p class=""><strong>Stock: </strong><span class="stock"><?php echo $elementoproducto->getStock(); ?></span></p>
            <h3 class="fichaunica_titulo pt-3 pb-1">Sobre este producto</h3>
            <p class=""><strong>Descripcion: </strong><br><span class="ficha_text"><?php echo $elementoproducto->getDescripcion(); ?></span></p>
            <ul class="lista">
                <li class="pb-2"><strong>Marca: </strong><span class="ficha_text"><?php echo $elementoproducto->getMarca(); ?></span></li>          
            </ul>
        </div>
    </div>
    <?php } ?>           
</div>
<!-- FIN CONTENIDO -->         
</div>
<!-- FIN SIDEBAR -->
</div>





                    
               

            

         