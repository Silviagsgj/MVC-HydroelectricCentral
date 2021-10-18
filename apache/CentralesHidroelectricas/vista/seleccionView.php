<div class="col d-flex flex-column justify-content-start align-items-center">              
<!-- Contenido -->
   
         <?php if($_SESSION['login']=="admin"){ ?> <!-- Permisos administrador -->
        <form class="d-flex w-100 justify-content-end pe-2 pt-2"  id="identificarusuario" action="<?php echo $this->url("empleados", "empleadologin"); ?>" method="POST">    
          
            
          
             <input id="cambiovista" class="btn btn-vista" type="submit" value="">
            
       
        </form>      <?php } ?>                              

           
    <!-- Alert mensajes -->
    <br>
    <?php
    if(isset($mensaje)){
        $uno='Success';
        $dos='check-circle-fill';
        $tres='4191CC';
        if(isset($errores)){
            $uno='Danger';
            $dos='exclamation-triangle-fill';
            $tres='CD4A38';
        }
        echo "<div id='alert' class='alert  d-flex align-items-center alert-dismissible fade show' style='background-color:#$tres;' role='alert'>
              <svg class='bi flex-shrink-0 me-2 text-light' width='24' height='24' role='img' aria-label='$uno:'><use xlink:href='#$dos'/></svg>
              <div class='text-light'>".$mensaje."</div>             
            </div>";  
        }
    ?>
           
    <?php
    if (isset($_POST['veralma']) or isset($_POST['borraprod'])) {
    ?>
        <form class="w-75 p-2" action="<?php echo $this->url("productos", "listar") ?>" method="post">                   
            <input type="submit" name="listarproductos" class="btn btn-previous" value="" />
        </form>
    <?php
        if (isset($_SESSION['alma'])) {
            $cont = count($_SESSION['alma']);
            if($cont == 0){
                echo "<h3 class='nodata'>No hay productos seleccionados</h3>";
            }else{           
                echo "<div class='table-responsive'>";
                echo "<table class='table table-striped custom-table caption-top'>";           
                echo "<caption class='caption'>".$titulo . count($_SESSION['alma']) . "</caption>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Código</th><th scope='col'>Nombre</th><th scope='col'>Unidades a añadir</th><th scope='col'>Stock restante</th><th scope='col'></th>";
                echo "</tr>";
                echo "</thead>";
                foreach ($_SESSION['alma'] as $reg){     
                    $id = $reg[0];
                    $uni = $reg[1];
                    $objetoproducto = new ProductosModel();
                    $produ = $objetoproducto->getUnProducto($id);           
                    echo "<tbody>";
                    echo "<tr scope='row'>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $produ->getNombre() . "</td>";
                    echo "<td>" . $uni . "</td>";
                    echo "<td>" . ($produ->getStock() - $uni) . "</td>";
                    echo "<td class='d-flex flex-wrap justify-content-around align-items-center'>";
    ?>       
                    <form action="<?php echo $this->url("productos", "borrardelcarrito", $id); ?>" method="POST">
                        <input class="btn  btn-borrar" name="borraprod" type="submit" value="">
                    </form>
    <?php
                    echo "</td>";
                    echo "</tr>";
                    echo "</tbody>";
                }   //fin foreach
                echo "</table>";
                echo "<br>";
    ?>
                <form action="<?php echo $this->url("entradas", "entradaalma");?>" method="post"  enctype="multipart/form-data">
                    <p>Motivo: <input required  type="text" name="Motivo"  value=""></p>
                    Selecciona almacen donde quieres añadir los productos:
                    <?php $objetocentral = new CentralesModel; ?>
                    <select  class="mt-1 mb-3 p-2 d-block"  name="CodAlmacen"  >
                        <?php                         
                        foreach ($almacenes as $fila) {
                            $sel = "";
                            echo "<option value='" . $fila->getCodAlmacen() . "'" . 
                            $sel . " >" . $objetocentral->getUnaCentral($fila->getIdCentral())->getNombre() . " / " . $fila->getTipo()."</option>";
                        }//foreach                     
                        ?>
                    </select> 
                    <input class="btn btn-add" type="submit" name="" value="" /> 
                </form>
    <?php
            }//fin else
        }//fin existe carrito
    else {
        echo "<h3 class='nodata'>No hay ningun producto añadido</h3>";
    }
    }//fin ver carrito
    ?>
                
    <?php
    if (isset($_POST['verprodsacar']) or isset($_POST['borraprod2']) ) {
        ?>
        <form class="w-75 p-2" action="<?php echo $this->url("salidas", "verproductosalmacen2") ?>" method="post">                   
            <input type="submit" name="productosdelalmacen" class="btn btn-previous" value="" />
        </form>
        <?php
        if (isset($_SESSION['alma2'])) {
            $cont = count($_SESSION['alma2']);
            if($cont == 0){
                echo "<h3 class='nodata'>No hay productos seleccionados</h3>";
            }else{
                echo "<div class='table-responsive'>";
                echo "<table class='table table-striped custom-table caption-top'>";           
                echo "<caption class='caption'>".$titulo . count($_SESSION['alma2']) . "</caption>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Código</th><th scope='col'>Nombre</th><th scope='col'>Unidades a sacar</th><th scope='col'>Stock restante en almacen</th><th scope='col'></th>";
                echo "</tr>";
                echo "</thead>";           
                foreach ($_SESSION['alma2'] as $reg){  
                    $id = $reg[0];
                    $uni = $reg[1];
                    $objetoproducto = new ProductosModel();
                    $objetodetalle = new DetEntradasModel();
                    $produ = $objetoproducto->getUnProducto($id);
                    echo "<tbody>";
                    echo "<tr scope='row'>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $produ->getNombre() . "</td>";
                    echo "<td>" . $uni . "</td>";
                    $det = $objetodetalle->dameunidades($_SESSION['almacen'], $id);
                    $resto = ($det - $uni);
                    echo "<td>" .$resto. "</td>";
                    echo "<td class='d-flex flex-wrap justify-content-around align-items-center'>";
            ?>       
                    <form action="<?php echo $this->url("productos", "borrardelcarrito2", $id); ?>" method="POST">
                        <input class="btn  btn-borrar" name="borraprod2" type="submit" value="">
                    </form>
            <?php
                    echo "</td>";
                    echo "</tr>";
                    echo "</tbody>";
                }  //fin foreach
                echo "</table>";
                echo "<br>";
        ?>
        <form action="<?php echo $this->url("salidas", "salidaalma");?>" method="post"  enctype="multipart/form-data">         
            <p>Motivo: <input required class="" type="text" name="Motivo"  value=""></p>
            <input class="btn btn-theme" type="submit" name="realizarcompra" value="Sacar del almacen" /> 
        </form>
        <?php
            }//fin else
        }//fin existe carrito
        else {
            echo "no hay ningun producto añadido";
        }
    }//fin ver carrito
    ?>            
    <br>
    <!------------------------------------------> 
    </div>
    </div>
    <!-- FIN SIDEBAR -->
</div>


                
               

            

         