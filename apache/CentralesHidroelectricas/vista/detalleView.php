<div class="col d-flex flex-column justify-content-start align-items-center">              
    <!-- Contenido -->

        <?php if($_SESSION['login']=="admin"){ ?> <!-- Permisos administrador -->
        <form class="d-flex w-100 justify-content-end pe-2 pt-2"  id="identificarusuario" action="<?php echo $this->url("empleados", "empleadologin"); ?>" method="POST">    
          
            
          
             <input id="cambiovista" class="btn btn-vista" type="submit" value="">
            
       
        </form>      <?php } ?>                              

    

    <!-- Alert mensaje -->
    <br>  
        <?php
            if (isset($mensaje)) {
                $uno = 'Success';
                $dos = 'check-circle-fill';
                $tres = '4191CC';

                if (isset($errores)) {
                    $uno = 'Danger';
                    $dos = 'exclamation-triangle-fill';
                    $tres = 'CD4A38';
                }

                echo "<div id='alert' class='alert  d-flex align-items-center alert-dismissible fade show' style='background-color:#$tres;' role='alert'>
                        <svg class='bi flex-shrink-0 me-2 text-light' width='24' height='24' role='img' aria-label='$uno:'><use xlink:href='#$dos'/></svg>
                        <div class='text-light'>" . $mensaje . "</div>                       
                        </div>"; 
            }
        ?>      


        <?php
        //LISTADO DE detalle ------------------------------------------------------------------------------------------------------------------------
        $objetoproducto = new ProductosModel();
        $num = count($elementos);
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        } else{
            echo "<div class='table-responsive'>";
            echo "<table id='table' data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true'  data-pagination-pre-text='Anterior'
                    data-pagination-next-text='Siguiente' class='table-light table-striped custom-table'>";
            echo "<caption class='caption'>$titulo / Total: $num</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th data-field='Foto' data-sortable='false' scope='col'></th><th data-field='Nombre' data-sortable='true' scope='col'>Nombre</th><th data-field='Unidades' data-sortable='true' scope='col'>Unidades</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elementos as $fila){
                echo "<tr scope='row'>";
                echo '<td><img class="detalle_img" src="data:image/jpeg;base64, ' . base64_encode(($objetoproducto->getUnProducto($fila['CodProd'])->getFoto())) . '"></td>';
                echo "<td>" . $objetoproducto->getUnProducto($fila['CodProd'])->getNombre() . "</td>";
                echo "<td>" . $fila['Unidades'] . "</td>";
                echo "</tr>";
            }   //fin foreach
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }  
        ?>    

        <?php     
           if (isset($_POST['valores'])) {
               switch ($_POST['valores']) {
                   case 'todas':
                       $val = $this->url($cambio, "listartodas");
                       $nombre = "listartodas";
                       break;
                   case 'emplealma':
                       $val = $this->url($cambio, "verporempleadoyalmacen");
                       $em = $_POST['numemple'];
                       $al = $_POST['codalma'];
                       $nombre = "listar" . $cambio . "porempleadoyalmacen";
                       break;
                   case 'almacen':
                       $val = $this->url($cambio, "verporalmacen");
                       $al = $_POST['codalma'];
                       $nombre = "listar" . $cambio . "poralmacen";
                       break;
                   case 'empleado':
                       $val = $this->url($cambio, "verporempleado");
                       $em = $_POST['numemple'];
                       $nombre = "listar" . $cambio . "porempleado";
                       break;
               }
           }
           ?>
        
        <?php if ($_SESSION['rol'] == 'Admin') { ?>
                <form class="w-75 p-3" action="<?php echo $val ?>" method="post">                   
                    <input type="submit" name="<?php echo $nombre; ?>" class="btn btn-previous" value="" />
                    <input type="hidden" name="empleados" value="<?php echo $em; ?>" />
                    <input type="hidden" name="almacenes"  value="<?php echo $al; ?>" />
                </form>
        <?php } else { ?> 
                <form class="w-75 p-3" action="<?php echo $this->url($cambio, "listar") ?>" method="post">                   
                    <input type="submit" name="<?php echo "listarmis" . $cambio ?>" class="btn btn-previous" value="" />            
                </form>
        <?php } ?>           
        <br>
               
<!------------------------------------------> 
</div>
</div>
<!-- FIN SIDEBAR -->
</div>           




   

       



            

