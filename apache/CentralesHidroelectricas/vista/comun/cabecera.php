
<?php $errorconexion = 0;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- ESTILOS -->       
        <link rel="stylesheet" href="http://localhost/CentralesHidroelectricas/recursos/fontawesome/css/all.css">   
        <link rel="stylesheet" href="http://localhost/CentralesHidroelectricas/recursos/bootstrap/css/bootstrap.css">  
        <link rel="stylesheet" href="http://localhost/CentralesHidroelectricas/recursos/bootstrap/css/bootstrap-table.css">  
        <link rel="stylesheet" href="http://localhost/CentralesHidroelectricas/recursos/css/estilos.css">    
        <title>Panel administracion</title>
        <!-- JS Estadisticas -->    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.0/chart.js"></script>
    </head>
    <body>    
        <!-- NAV -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-ppal">
            <div class="container-fluid d-flex justify-content-between align-items-center g-0 ps-3 pe-3">
                <?php
                if(isset($_SESSION['idemple'])){
                    $ruta = "index";
                }else{
                   $ruta = "login"; 
                }               
                
                ?>
                <a href="<?php echo $this->url("centrales", $ruta); ?>">
                    <img src="http://localhost/CentralesHidroelectricas/recursos/img/logo.png"/>
                </a>

                <ul class="list-unstyled m-0 nomostrar">
                    <li class="nav-item dropdown ">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="text-light espacio sombreado">Usuario conectado: 
                            <?php
                                if (isset($_SESSION['idemple']) && $errorconexion == 0) {
                                    $objetoempleado = new EmpleadosModel();
                                    echo $objetoempleado->getEmpleado($_SESSION['idemple'])->getDNI();
                                } else {
                                    echo $_SESSION['usuario'];
                                }
                            ?>
                            </span>

                            <?php
                                if (isset($_SESSION['idemple']) && $errorconexion == 0) {
                                    $objetoempleado = new EmpleadosModel();
                                    echo '<img style="height:40px;" class="rounded-circle" src = "data:image/jpeg;base64, ' . base64_encode($objetoempleado->getEmpleado($_SESSION['idemple'])->getFoto()) . '" alt = "">';
                                } else {
                            ?>
                                <img class="rounded-circle" style="height: 40px;"
                                     src="recursos/img/undraw_profile.svg">
                                     <?php } ?>                               
                        </a>        
                        
                        <!-- Dropdown  -->
                        <ul class="dropdown-menu submenu" aria-labelledby="navbarDropdown">
                            <?php if ($_SESSION['rol'] == 'Emple') { ?>    
                                <li><a class="dropdown-item submenu_item" href="<?php echo $this->url("empleados", "verficha", $_SESSION['idemple']); ?>">Perfil</a></li> 
                                <li><hr class="dropdown-divider"></li>
                            <?php } ?>                      
                            <li><a class="dropdown-item submenu_item" href="<?php echo $this->url("centrales", "cerrarsesion"); ?>">Cerrar sesion</a></li>
                        </ul>
                    </li>    
                </ul>  

                <button onclick="navbarScroll.classList.toggle('muestra');"class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="muestra" style="flex-basis:100%;"  id="navbarScroll">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 pt-3">

                        <?php if ($_SESSION['rol'] == "Admin") { ?>  
                            <li>
                                <button class="btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#centrales-collapse" aria-expanded="true">
                                    <i class="far fa-building me-3 fs-6"></i>Centrales
                                </button>
                                <div class="collapse" id="centrales-collapse">
                                    <ul class="list-unstyled pb-2">  
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("centrales", "listar"); ?>"> 
                                                <input type="submit" class="sidebara" name="listarcentrales" value="Listado" /> 
                                            </form>
                                        </li>
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("centrales", "insertar"); ?>"> 
                                                <input type="submit" class="sidebara" name="insertarcentrales" value="Dar alta" /> 
                                            </form>
                                        </li>
                                    </ul> 
                                </div>
                            </li>
                            <li>
                                <button class="btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#empleados-collapse" aria-expanded="true">
                                    <i class="fas fa-user-tie me-3 fs-6"></i>Empleados
                                </button>
                                <div class="collapse" id="empleados-collapse">
                                    <ul class="list-unstyled pb-2">  
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("empleados", "gestion"); ?>"> 
                                                <input type="submit" class="sidebara"  name="consultasempleados" value="Gestion empleados" /> 
                                            </form>
                                        </li>
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("empleados", "insertar"); ?>"> 
                                                <input type="submit" class="sidebara" name="insertarempleados" value="Dar alta" /> 
                                            </form>
                                        </li>
                                    </ul> 
                                </div>
                            </li>

                            <li>
                                <button class="btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#productos-collapse" aria-expanded="true">
                                    <i class="fas fa-tools me-3 fs-6"></i>Productos
                                </button>
                                <div class="collapse" id="productos-collapse">
                                    <ul class="list-unstyled pb-2">  
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("productos", "listar"); ?>"> 
                                                <input type="submit" class="sidebara" name="listarproductos" value="Listado" /> 
                                            </form>
                                        </li>
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("productos", "insertar"); ?>"> 
                                                <input type="submit" class="sidebara" name="insertarproductos" value="Dar alta" /> 
                                            </form>
                                        </li>
                                    </ul>   
                                </div>
                            </li>

                            <li>
                                <button class="btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#almacenes-collapse" aria-expanded="true">
                                    <i class="fas fa-warehouse me-3 fs-6"></i>Almacenes
                                </button>
                                <div class="collapse" id="almacenes-collapse">
                                    <ul class="list-unstyled pb-2">  
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("almacenes", "gestion"); ?>"> 
                                                <input type="submit" class="sidebara" name="consultasalmacenes" value="Gestion almacenes" /> 
                                            </form>
                                        </li>
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("almacenes", "insertar"); ?>"> 
                                                <input type="submit" class="sidebara" name="insertaralmacenes" value="Dar alta" /> 
                                            </form>
                                        </li>
                                    </ul>   
                                </div>
                            </li>

                            <li>
                                <button class="btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#proveedores-collapse" aria-expanded="true">
                                    <i class="fas fa-truck me-3 fs-6"></i>Proveedores
                                </button>
                                <div class="collapse" id="proveedores-collapse">
                                    <ul class="list-unstyled pb-2">  
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("proveedores", "listar"); ?>"> 
                                                <input type="submit" class="sidebara"  name="listarproveedores" value="Listado" /> 
                                            </form>
                                        </li>
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("proveedores", "insertar"); ?>"> 
                                                <input type="submit" class="sidebara" name="insertarproveedores" value="Dar alta" /> 
                                            </form>
                                        </li>
                                    </ul>   
                                </div>
                            </li>

                            <li>
                                <button class="btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#categorias-collapse" aria-expanded="true">
                                    <i class="fas fa-clipboard-list me-3 fs-6"></i>Categorias
                                </button>
                                <div class="collapse" id="categorias-collapse">
                                    <ul class="list-unstyled pb-2">  
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("categorias", "listar"); ?>"> 
                                                <input type="submit" class="sidebara" name="listarcategorias" value="Listado" /> 
                                            </form>
                                        </li>
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("categorias", "insertar"); ?>"> 
                                                <input type="submit" class="sidebara" name="insertarcategorias" value="Dar alta" /> 
                                            </form>
                                        </li>
                                    </ul>   
                                </div>
                            </li>

                            <li>
                                <button class="btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#departamentos-collapse" aria-expanded="true">
                                    <i class="fas fa-clipboard-list me-3 fs-6"></i>Departamentos
                                </button>
                                <div class="collapse" id="departamentos-collapse">

                                    <ul class="list-unstyled pb-2">  
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("departamentos", "listar"); ?>"> 
                                                <input type="submit" class="sidebara" name="listardepartamentos" value="Listado" /> 
                                            </form>
                                        </li>
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("departamentos", "insertar"); ?>"> 
                                                <input type="submit" class="sidebara" name="insertardepartamentos" value="Dar alta" /> 
                                            </form>
                                        </li>
                                    </ul>   
                                </div>
                            </li>

                            <li>
                                <button class="btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#entradas-collapse" aria-expanded="true">                  
                                    <i class="fas fa-arrow-circle-right me-3 fs-6"></i>Entradas
                                </button>
                                <div class="collapse" id="entradas-collapse">
                                    <ul class="list-unstyled pb-2">
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("entradas", "gestion"); ?>"> 
                                                <input type="submit" class="sidebara"  name="consultasentradas" value="Gestion entradas" /> 
                                            </form>
                                        </li>
                                    </ul>  
                                </div>
                            </li>

                            <li>
                                <button class="btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#salidas-collapse" aria-expanded="true">
                                    <i class="fas fa-arrow-circle-left me-3 fs-6"></i>Salidas
                                </button>
                                <div class="collapse" id="salidas-collapse">
                                    <ul class="list-unstyled pb-2"> 
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("salidas", "gestion"); ?>"> 
                                                <input type="submit" class="sidebara"  name="consultassalidas" value="Gestion salidas" /> 
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        <?php } ?>
                        <!-- VISTA EMPLEADO -->
                        <?php if ($_SESSION['rol'] == "Emple") { ?>    
                            <li>
                                <button class="btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#entradas-collapse" aria-expanded="true">
                                    <i class="fas fa-arrow-circle-right me-3 fs-6"></i>Entradas
                                </button>
                                <div class="collapse" id="entradas-collapse">
                                    <ul class="list-unstyled pb-2">
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("productos", "listar"); ?>"> 
                                                <input type="submit" class="sidebara" name="listarproductos" value="Añadir productos" /> 
                                            </form>
                                        </li>
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("entradas", "listar"); ?>"> 
                                                <input type="submit" class="sidebara" name="listarmisentradas" value="Ver mis entradas" /> 
                                            </form>
                                        </li>
                                    </ul>  
                                </div>
                            </li>

                            <li>
                                <button class="btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#salidas-collapse" aria-expanded="true">
                                    <i class="fas fa-arrow-circle-left me-3 fs-6"></i>Salidas
                                </button>
                                <div class="collapse" id="salidas-collapse">
                                    <ul class="list-unstyled pb-2"> 
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("centrales", "tarjetas"); ?>"> 
                                                <input type="submit" class="sidebara" name="tarjetacentral" value="Sacar productos" /> 
                                            </form>
                                        </li>
                                        <li>
                                            <form method="post" action= "<?php echo $this->url("salidas", "listar"); ?>"> 
                                                <input type="submit" class="sidebara" name="listarmissalidas" value="Ver mis salidas" /> 
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>             

                        <?php } ?>
                        <li><a  class="text-light"  href="<?php echo $this->url("centrales", "cerrarsesion"); ?>">Cerrar sesion</a></li>
                </div>
            </div>
        </nav>
        <!-- FIN NAV -->   

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>




