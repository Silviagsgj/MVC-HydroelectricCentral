<!-- SIDEBAR -->        
<?php
$con = 0;
$con2 = 0;

if (isset($_SESSION['alma'])) {
    $con = count($_SESSION['alma']);
}

if (isset($_SESSION['alma2'])) {
    $con2 = count($_SESSION['alma2']);
}
?>   

<div class="container-fluid d-flex g-0" style="min-height: calc(100vh - 88px); height: 100%;">
    <nav id="sidebar" class="fondoSidebar sidebar">
        <div class="p-4">           
            <h1 class="sidebar_title"><a href="#" class="logo">Administración <span class="sidebar_subtitle">Centrales Hidroeléctricas</span></a></h1>
            <ul class="list-unstyled mb-5"> 
                <!-- VISTA ADMIN -->
                <?php 
                
                
                if ($_SESSION['rol'] == "Admin") {
                    ?>    
                    <li>
                        <button class="side_button btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#centrales-collapse" aria-expanded="true">
                            <i class="far fa-building me-3 fs-6"></i><span class="text-sidebar">Centrales</span>
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
                        <button class="side_button btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#empleados-collapse" aria-expanded="true">
                            <i class="fas fa-user-tie me-3 fs-6"></i><span class="text-sidebar">Empleados</span>
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
                        <button class="side_button btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#productos-collapse" aria-expanded="true">
                            <i class="fas fa-tools me-3 fs-6"></i><span class="text-sidebar">Productos</span>
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
                        <button class="side_button btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#almacenes-collapse" aria-expanded="true">
                            <i class="fas fa-warehouse me-3 fs-6"></i><span class="text-sidebar">Almacenes</span>
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
                        <button class="side_button btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#proveedores-collapse" aria-expanded="true">
                            <i class="fas fa-truck me-3 fs-6"></i><span class="text-sidebar">Proveedores</span>
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
                        <button class="side_button btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#categorias-collapse" aria-expanded="true">
                            <i class="fas fa-clipboard-list me-3 fs-6"></i><span class="text-sidebar">Categorias</span>
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
                        <button class="side_button btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#departamentos-collapse" aria-expanded="true">
                            <i class="fas fa-clipboard-list me-3 fs-6"></i><span class="text-sidebar">Departamentos</span>
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
                        <button class="side_button btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#entradas-collapse" aria-expanded="true">                  
                            <i class="fas fa-arrow-circle-right me-3 fs-6"></i><span class="text-sidebar">Entradas</span>
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
                        <button class="side_button btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#salidas-collapse" aria-expanded="true">
                            <i class="fas fa-arrow-circle-left me-3 fs-6"></i><span class="text-sidebar">Salidas</span>
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
                <?php if ($_SESSION['rol'] == "Emple" ) { ?>   
                    <li>
                        <button class="side_button btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#entradas-collapse" aria-expanded="true">
                            <i class="fas fa-arrow-circle-right me-3 fs-6"></i><span class="text-sidebar">Entradas</span>
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
                        <button class="side_button btn btn-toggle text-light mb-3 espacio" data-bs-toggle="collapse" data-bs-target="#salidas-collapse" aria-expanded="true">
                            <i class="fas fa-arrow-circle-left me-3 fs-6"></i><span class="text-sidebar">Salidas</span>
                        </button>
                        <div class="collapse" id="salidas-collapse">
                            <ul class="list-unstyled pb-2"> 
                                <?php if ($con2 == 0) { ?>
                                    <li>



                                        <form method="post" action= "<?php echo $this->url("centrales", "tarjetas"); ?>"> 
                                            <input  type="submit" class="sidebara" name="tarjetacentral" value="Sacar productos" /> 
                                        </form>
                                    </li>  
                                <?php } ?>   
                                <li>
                                    <form method="post" action= "<?php echo $this->url("salidas", "listar"); ?>"> 
                                        <input type="submit" class="sidebara" name="listarmissalidas" value="Ver mis salidas" /> 
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </li>    


                    <?php
                        $desactivar1 = "";
                        $desactivar2 = "";
                        if ($con == 0) {
                            $desactivar1 = "disabled";
                        }
                        if ($con2 == 0) {
                            $desactivar2 = "disabled";
                        }
                    ?>


                    <form action="<?php echo $this->url("productos", "ver"); ?>" method="POST">
                        <input <?php echo $desactivar1; ?> class="btn btn-sidebar shadow mb-3" type="submit" name="veralma" value="Productos añadidos: <?php echo $con; ?>" /> 
                    </form>


                    <form action="<?php echo $this->url("productos", "verproductosasacar"); ?>" method="POST">
                        <input <?php echo $desactivar2; ?> class="btn btn-sidebar shadow" type="submit" name="verprodsacar" value="Productos a sacar: <?php echo $con2; ?>" /> 
                    </form>

                    <?php } ?>
                    
                    
                    
                    
                 
            </ul>	           
        </div>
    </nav>



