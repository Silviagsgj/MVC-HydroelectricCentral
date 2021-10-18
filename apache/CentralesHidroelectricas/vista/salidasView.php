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
    if(isset($_POST['tarjetacentral'])){
    ?>
        <div class="d-flex flex-wrap justify-content-around  w-100 h-100 align-items-center">
        <?php
        $objetoalmacen = new AlmacenesModel();
        foreach ($elementos as $fila){
        ?>
            <div class="card mb-3 tarjeta">
            <?php
                echo '<img class="tarjeta_img" src = "data:image/jpeg;base64, ' . base64_encode(($fila->getFoto())) . '" alt = "">';
            ?>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $fila->getNombre(); ?></h5>
                    <?php
                        $elementosal = $objetoalmacen->getAlmacenesCentral($fila->getIdCentral());
                    ?>
                        <form class="d-flex justify-content-around align-items-center" method="post" action= "<?php echo $this->url("salidas", "verproductosalmacen"); ?>"> 
                            <select  onChange="activa_boton(this,this.form.boton)" class="" name="CodAlmacen" id="">
                                <?php
                                echo '<option selected disabled value="">Selecciona un almacen</option>';
                                foreach ($elementosal as $fila2) {
                                    $selec = "";
                                    echo '<option ' . $selec . ' value="' . $fila2->getCodAlmacen() . '">' . $fila2->getTipo() . '</option>';
                                } //foreach
                                ?>
                            </select>
                            <input id="boton" disabled class="btn btn-look" name="productosdelalmacen" type="submit" value="">
                        </form>
                </div>
            </div>    
        <?php  
    }
    echo "</div>";
    }  
    ?>
    <div class="d-flex flex-column align-items-center w-100 h-100">
    <?php
        if(isset($_POST['productosdelalmacen']) or isset($_POST['saca'])){
            if(count($elementos) == 0){
                echo "<h3 class='nodata'>El almacen seleccionado no tiene ningun producto</h3>";
            }else{
                $objetoproducto = new ProductosModel();  
                echo "<div class='table-responsive'>";
                echo "<table  data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true'  data-pagination-pre-text='Anterior'
                    data-pagination-next-text='Siguiente' class='table-light table-striped custom-table '>";           
                echo "<caption class='caption'>$titulo</caption>";
                echo "<thead>";
                echo "<tr>";
                echo "<th data-field='Codigo' data-sortable='true'  scope='col'>Cod Prod</th><th data-field='Nombre' data-sortable='true'  scope='col'>Nombre</th><th data-field='Unidades' data-sortable='true'  scope='col'>Stock en almacen</th><th class='anchocelda' scope='col'></th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($elementos as $item){    
                    echo "<tr scope='row'>";
                    echo "<td>" . $item['CodProd']. "</td>";
                    echo "<td>" . $objetoproducto->getUnProducto($item['CodProd'])->getNombre(). "</td>";
                    echo "<td>" . $item['Uniact']. "</td>";
                    echo "<td>";
    ?>
                    <form action="<?php echo $this->url("productos", "sacardelalmacen");?>" method="POST">                
                        <input  type="hidden" name="id"  value="<?php  echo $item['CodProd']; ?>" >
                        <input  type="hidden" name="cdalma"  value="<?php  echo $item['CodAlmacen']; ?>" >
                        <input  onChange="activa_boton(this,this.form.boton)"  type="number" name="unidades"  value="0" min=0 max=<?php echo $item['Uniact']; ?>>
                        <input id="boton" disabled class="btn  btn-sacar"  name="saca" type="submit"  value="">
                        <input  name="entrada" type="hidden" value="<?php echo $item['NumEntrada']; ?>">
                        <input  name="stockalmacen" type="hidden" value="<?php echo $item['Uniact']; ?>">
                    </form>
    <?php
                    echo "</td>";
                    echo "</tr>";
                }   //fin foreach
                echo "</tbody>";     
                echo "</table>";   
    ?>
                <form action="<?php echo $this->url("productos", "verproductosasacar");?>" method="POST">
    <?php
                    if($con2==0){
                        $disabled = "disabled";
                    }else{
                        $disabled="";
                    }
    ?>
                    <input class="nav-item btn btn-theme" <?php echo $disabled; ?> type="submit" name="verprodsacar" value="Revisar productos" /> 
                </form>
    <?php   
                echo "</div>";       
            }
            $desactivar = "";
            if($con2!=0){
                $desactivar = "disabled";
            }    
    ?>
            <form class="w-75 p-3" action="<?php echo $this->url("centrales", "tarjetas") ?>" method="post">                   
                <input <?php echo $desactivar; ?> type="submit" name="tarjetacentral" class="btn btn-previous" value="" />
            </form>
    <?php
        }
    ?>
           
    <?php
    //LISTADO DE SALIDAS------------------------------------------------------------------------------------------------------------------------
    if(isset($_POST['listarmissalidas']) or isset($_POST['deletesal']) ){
        $objetoalmacen = new AlmacenesModel();
        $objetocentral = new CentralesModel();
        $num= count($elementos);            
            if($num==0){
                echo "<h3 class='nodata'>No hay datos</h3>";
            }else{
                echo "<div class='table-responsive'>";
                echo "<table  data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true'  data-pagination-pre-text='Anterior'
                      data-pagination-next-text='Siguiente' class='table-light table-striped custom-table '>";           
                echo "<caption class='caption'>$titulo</caption>";
                echo "<thead>";
                echo "<tr>";
                echo "<th data-field='NumSalida' data-sortable='true'  scope='col'>Num Salida</th><th data-field='Almacen' data-sortable='true' scope='col'>Almacen</th><th data-field='Central' data-sortable='true'  scope='col'>Central</th><th data-field='FechaSalida' data-sortable='true' scope='col'>Fecha de salida</th><th data-field='Motivo' data-sortable='true'  scope='col'>Motivo</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($elementos as $fila){    
                    echo "<tr scope='row'>";
    ?>
                    <td>
                    <a href="<?php echo $this->url("detsalidas", "mostrardetalle", $fila['NumSalida']); ?>"><?php echo $fila['NumSalida'] ?> </a>
                    </td>
    <?php   
                    echo "<td>" . $objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getTipo() . "</td>";
                    echo "<td>".$objetocentral->getUnaCentral($objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre()."</td>"; 
                    echo "<td>" . $fila['FechaSalida'] . "</td>";
                    echo "<td>" . $fila['Motivo'] . "</td>";
                    echo "</tr>";
                }   //fin foreach
                echo "</tbody>";  
                echo "</table>";   
                echo "</div>";   
            }}
    ?>    
             
    
                    
    <?php   if(isset($_POST['listarsalidasporempleado']) ){
        $objetoalmacen = new AlmacenesModel();
        $objetocentral = new CentralesModel();
        $num= count($elementos);            
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        }else{
            echo "<div class='table-responsive'>";
            echo "<table  data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true'  data-pagination-pre-text='Anterior'
                data-pagination-next-text='Siguiente' class='table-light table-striped custom-table '>";           
            echo "<caption class='caption'>$titulo</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th data-field='NumSalida' data-sortable='true'  scope='col'>Num Salida</th><th data-field='Almacen' data-sortable='true'  scope='col'>Almacen</th><th data-field='Central' data-sortable='true' scope='col'>Central</th><th data-field='FechaSalida' data-sortable='true' scope='col'>Fecha de salida</th><th data-field='Motivo' data-sortable='true'  scope='col'>Motivo</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elementos as $fila){    
                echo "<tr scope='row'>";
    ?>
                <td>         
                <form  action="<?php echo $this->url("detsalidas", "mostrardetalle", $fila['NumSalida']); ?>" method="POST"> 
                    <input class="fichaest" type="submit" value="<?php echo $fila['NumSalida'] ?>" />
                    <input type="hidden" name="valores" value="empleado" />
                 <input name="numemple" type="hidden" value="<?php echo $id; ?>">
                </form>
                </td>
    <?php
                echo "<td>" . $objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getTipo() . "</td>";
                echo "<td>".$objetocentral->getUnaCentral($objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre()."</td>"; 
                echo "<td>" . $fila['FechaSalida'] . "</td>";
                echo "<td>" . $fila['Motivo'] . "</td>";
                echo "</tr>";
            }   //fin foreach
            echo "</tbody>";    
            echo "</table>";  
    ?>
                
                                                <div class="d-flex align-items-end">                      
    <form class="mt-3 pe-3" action="<?php echo $this->url("salidas", "generaexcell"); ?>" method="POST" id="formdoc">    
        <input id="export_data" name="export_data" class="btn btn-excel" id="submit" type="submit" value=""> 
              <input name="tipo" type="hidden" value="empleado">
                <input name="numemple" type="hidden" value="<?php echo $id; ?>">
    </form>     
                            
    <form class="mt-3" action="<?php echo $this->url("salidas", "generapdf"); ?>" method="POST" id="formdoc">    
        <input id="export_data" name="export_data" class="btn btn-pdf" id="submit" type="submit" value=""> 
            <input name="tipo" type="hidden" value="empleado">
                <input name="numemple" type="hidden" value="<?php echo $id; ?>">
    </form>     
     </div>  
                
                
                
                
                <!--
                
            <form class="mt-3" action="" method="POST" id="formdoc">    
                <input id="export_data" name="export_data" class="btn btn-theme" id="submit" type="submit" value="Generar Documentos"> 
                <input name="tipo" type="hidden" value="empleado">
                <input name="numemple" type="hidden" value="<?php //echo $id; ?>">
                <select name="documentos" id="seldoc"> 
                    <?php //$documentos = $_POST['documentos']; ?>
                    <option selected disabled value="">Selecciona una opcion</option>
                    <option value="<?php //echo $this->url("salidas", "generaexcell"); ?>" >Excell</option>
                    <option value="<?php //echo $this->url("salidas", "generapdf"); ?>" >Pdf</option>
                </select>
            </form> 
      
            <script>
                document.getElementById('seldoc').onchange = function(){
                    document.getElementById('formdoc').action = '/'+this.value;
                }
            </script> 
             -->      
    <?php
        echo "</div>";   
        }
    ?>
        <form class="w-75 p-3" action="<?php echo $this->url("salidas", "gestion") ?>" method="post">                   
            <input type="submit" name="consultassalidas" class="btn btn-previous" value="" />
        </form>
    <?php } ?>    
    
    <?php   
    if(isset($_POST['listarsalidasporempleadoyalmacen']) ){
        $objetoalmacen = new AlmacenesModel();
        $objetocentral = new CentralesModel();
        $num= count($elementos);            
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        }else{
            echo "<div class='table-responsive'>";
            echo "<table  data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true'  data-pagination-pre-text='Anterior'
                data-pagination-next-text='Siguiente' class='table-light table-striped custom-table '>";           
            echo "<caption class='caption'>$titulo</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th data-field='NumSalida' data-sortable='true'  scope='col'>Num Salida</th><th data-field='FechaSalida' data-sortable='true' scope='col'>Fecha de salida</th><th data-field='Motivo' data-sortable='true'  scope='col'>Motivo</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
                foreach ($elementos as $fila){    
                    echo "<tr scope='row'>";
    ?>
                    <td>
                    <form  action="<?php echo $this->url("detsalidas", "mostrardetalle", $fila['NumSalida']); ?>" method="POST"> 
                        <input class="fichaest" type="submit" value="<?php echo $fila['NumSalida'] ?>" />
                        <input type="hidden" name="valores" value="emplealma" />
                        <input name="numemple" type="hidden" value="<?php echo $id; ?>">
                        <input name="codalma" type="hidden" value="<?php echo $idal; ?>">
                    </form>
                    </td>
    <?php
                    echo "<td>" . $fila['FechaSalida'] . "</td>";
                    echo "<td>" . $fila['Motivo'] . "</td>";
                    echo "</tr>";
                }   //fin foreach
                echo "</tbody>";    
                echo "</table>";  
    ?>
                    
                    
                                                                    <div class="d-flex align-items-end">                      
    <form class="mt-3 pe-3" action="<?php echo $this->url("salidas", "generaexcell"); ?>" method="POST" id="formdoc">    
        <input id="export_data" name="export_data" class="btn btn-excel" id="submit" type="submit" value=""> 
         <input name="tipo" type="hidden" value="empleadoalma">
                    <input name="numemple" type="hidden" value="<?php echo $id; ?>">
                    <input name="codalma" type="hidden" value="<?php echo $idal; ?>">
    </form>     
                            
    <form class="mt-3" action="<?php echo $this->url("salidas", "generapdf"); ?>" method="POST" id="formdoc">    
        <input id="export_data" name="export_data" class="btn btn-pdf" id="submit" type="submit" value=""> 
     <input name="tipo" type="hidden" value="empleadoalma">
                    <input name="numemple" type="hidden" value="<?php echo $id; ?>">
                    <input name="codalma" type="hidden" value="<?php echo $idal; ?>">
    </form>     
     </div>  
                    
                    
                <!--    
                <form class="mt-3" action="" method="POST" id="formdoc">    
                    <input id="export_data" name="export_data" class="btn btn-theme" id="submit" type="submit" value="Generar Documentos"> 
                    <input name="tipo" type="hidden" value="empleadoalma">
                    <input name="numemple" type="hidden" value="<?php echo $id; ?>">
                    <input name="codalma" type="hidden" value="<?php echo $idal; ?>">
                    <select name="documentos" id="seldoc"> 
                        <?php $documentos = $_POST['documentos']; ?>
                            <option selected disabled value="">Selecciona una opcion</option>
                            <option value="<?php echo $this->url("salidas", "generaexcell"); ?>" >Excell</option>
                            <option value="<?php echo $this->url("salidas", "generapdf"); ?>" >Pdf</option>
                    </select>
                </form> 
      
                <script>
                    document.getElementById('seldoc').onchange = function(){
                    document.getElementById('formdoc').action = '/'+this.value;
                    }
                </script> -->
    <?php
            echo "</div>";   
        }
    ?>
        <form class="w-75 p-3" action="<?php echo $this->url("salidas", "gestion") ?>" method="post">                   
             <input type="submit" name="consultassalidas" class="btn btn-previous" value="" />
        </form>
    <?php } ?>    
    
    <?php
    //LISTADO DE salidas ------------------------------------------------------------------------------------------------------------------------
    if(isset($_POST['listartodas']) ){
        $objetoempleado = new EmpleadosModel();
        $objetoalmacen = new AlmacenesModel();
        $objetocentral = new CentralesModel();
        $num= count($elementos);            
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        }else{
            echo "<div class='table-responsive'>";
            echo "<table  data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true'  data-pagination-pre-text='Anterior'
                    data-pagination-next-text='Siguiente' class='table-light table-striped custom-table '>";           
            echo "<caption class='caption'>$titulo</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th data-field='NumSalida' data-sortable='true'  scope='col'>Num Salida</th><th data-field='Nombre' data-sortable='true'  scope='col'>Nombre empleado</th><th data-field='DNI' data-sortable='true'  scope='col'>DNI</th><th data-field='Almacen' data-sortable='true' scope='col'>Almacen</th><th data-field='Central' data-sortable='true'  scope='col'>Central</th><th data-field='FechaSalida' data-sortable='true'  scope='col'>Fecha de salida</th><th data-field='Motivo' data-sortable='true' scope='col'>Motivo</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elementos as $fila){    
                echo "<tr scope='row'>";
    ?>
                <td>          
                <form  action="<?php echo $this->url("detsalidas", "mostrardetalle", $fila['NumSalida']); ?>" method="POST"> 
                    <input class="fichaest" type="submit" value="<?php echo $fila['NumSalida'] ?>" />
                    <input type="hidden" name="valores" value="todas" />
                </form>
                </td>
    <?php
                echo "<td>" .$objetoempleado->getEmpleado($fila['NumEmple'])->getNombre()." ".$objetoempleado->getEmpleado($fila['NumEmple'])->getApellidos()."</td>";
                echo "<td>" .$objetoempleado->getEmpleado($fila['NumEmple'])->getDNI()."</td>"; 
                echo "<td>" . $objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getTipo() . "</td>";
                echo "<td>".$objetocentral->getUnaCentral($objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre()."</td>"; 
                echo "<td>" . $fila['FechaSalida'] . "</td>";
                echo "<td>" . $fila['Motivo'] . "</td>";
                echo "</tr>";
            }   //fin foreach
            echo "</tbody>";    
            echo "</table>";   
    ?>
                
                
                                                                           <div class="d-flex align-items-end">                      
    <form class="mt-3 pe-3" action="<?php echo $this->url("salidas", "generaexcell"); ?>" method="POST" id="formdoc">    
        <input id="export_data" name="export_data" class="btn btn-excel" id="submit" type="submit" value=""> 
       <input name="tipo" type="hidden" value="todas">
    </form>     
                            
    <form class="mt-3" action="<?php echo $this->url("salidas", "generapdf"); ?>" method="POST" id="formdoc">    
        <input id="export_data" name="export_data" class="btn btn-pdf" id="submit" type="submit" value=""> 
        <input name="tipo" type="hidden" value="todas">
    </form>     
     </div>        
                
                
            <!--    
            <form class="mt-3" action="" method="POST" id="formdoc">    
                <input id="export_data" name="export_data" class="btn btn-theme" id="submit" type="submit" value="Generar Documentos"> 
                <input name="tipo" type="hidden" value="todas">
                <select name="documentos" id="seldoc"> 
                    <?php //$documentos = $_POST['documentos']; ?>
                    <option selected disabled value="">Selecciona una opcion</option>
                    <option value="<?php //echo $this->url("salidas", "generaexcell"); ?>" >Excell</option>
                    <option value="<?php //echo $this->url("salidas", "generapdf"); ?>" >Pdf</option>
                </select>
            </form> 
      
            <script>
                document.getElementById('seldoc').onchange = function(){
                    document.getElementById('formdoc').action = '/'+this.value;
                }
            </script> -->
                
    <?php
            echo "</div>";   
        }
    ?>
        <form class="w-75 p-3" action="<?php echo $this->url("salidas", "gestion") ?>" method="post">                   
            <input type="submit" name="consultassalidas" class="btn btn-previous" value="" />
        </form>
    <?php } ?>    
       
    <?php
    if(isset($_POST['listarsalidasporalmacen'])){
        $objetoempleado = new EmpleadosModel();
        $num= count($elementos);            
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        }else{
            echo "<div class='table-responsive'>";
            echo "<table  data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true'  data-pagination-pre-text='Anterior'
                  data-pagination-next-text='Siguiente' class='table-light table-striped custom-table '>";           
            echo "<caption class='caption'>$titulo</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th data-field='NumSalida' data-sortable='true' scope='col'>Num Salida</th><th data-field='Nombre' data-sortable='true' scope='col'>Nombre empleado</th><th data-field='DNI' data-sortable='true'  scope='col'>DNI</th><th data-field='FechaSalida' data-sortable='true'  scope='col'>Fecha de salida</th><th data-field='Motivo' data-sortable='true'  scope='col'>Motivo</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elementos as $fila){    
                echo "<tr scope='row'>";
    ?>
                <td>
                <form  action="<?php echo $this->url("detsalidas", "mostrardetalle", $fila['NumSalida']); ?>" method="POST"> 
                    <input class="fichaest" type="submit" value="<?php echo $fila['NumSalida'] ?>" />
                    <input type="hidden" name="valores" value="almacen" />
                    <input name="codalma" type="hidden" value="<?php echo $id; ?>">
                </form>
                </td>
    <?php
                echo "<td>" .$objetoempleado->getEmpleado($fila['NumEmple'])->getNombre()." ".$objetoempleado->getEmpleado($fila['NumEmple'])->getApellidos()."</td>";
                echo "<td>" .$objetoempleado->getEmpleado($fila['NumEmple'])->getDNI()."</td>";
                echo "<td>" . $fila['FechaSalida'] . "</td>";
                echo "<td>" . $fila['Motivo'] . "</td>";
                echo "</tr>";
            }   //fin foreach
            echo "</tbody>";   
            echo "</table>";   
    ?>
                
                
                                                                                          <div class="d-flex align-items-end">                      
    <form class="mt-3 pe-3" action="<?php echo $this->url("salidas", "generaexcell"); ?>" method="POST" id="formdoc">    
        <input id="export_data" name="export_data" class="btn btn-excel" id="submit" type="submit" value=""> 
          <input name="tipo" type="hidden" value="almacen">
                <input name="codalma" type="hidden" value="<?php echo $id; ?>">
    </form>     
                            
    <form class="mt-3" action="<?php echo $this->url("salidas", "generapdf"); ?>" method="POST" id="formdoc">    
        <input id="export_data" name="export_data" class="btn btn-pdf" id="submit" type="submit" value=""> 
           <input name="tipo" type="hidden" value="almacen">
                <input name="codalma" type="hidden" value="<?php echo $id; ?>">
    </form>     
     </div>       
                
             <!--   
            <form class="mt-3" action="" method="POST" id="formdoc">    
                <input id="export_data" name="export_data" class="btn btn-theme" id="submit" type="submit" value="Generar Documentos">
                <input name="tipo" type="hidden" value="almacen">
                <input name="codalma" type="hidden" value="<?php echo $id; ?>">
                <select name="documentos" id="seldoc"> 
                    <?php //$documentos = $_POST['documentos']; ?>
                    <option selected disabled value="">Selecciona una opcion</option>
                    <option value="<?php //echo $this->url("salidas", "generaexcell"); ?>" >Excell</option>
                    <option value="<?php //echo $this->url("salidas", "generapdf"); ?>" >Pdf</option>
                </select>
            </form> 
      
            <script>
                document.getElementById('seldoc').onchange = function(){
                document.getElementById('formdoc').action = '/'+this.value;
                }
            </script> -->
    
    <?php
        echo "</div>";   
        }
    ?>
        <form class="w-75 p-3" action="<?php echo $this->url("salidas", "gestion") ?>" method="post">                   
            <input type="submit" name="consultassalidas" class="btn btn-previous" value="" />
        </form>
    <?php } ?>    
      
    <?php
        if(isset($_POST['consultassalidas'])){
            $objetocentral = new CentralesModel();
    ?>
            <div class="row w-100 d-flex justify-content-center align-items-center h-100">
                <div class="col-md-6 col-12 text-center mb-4">
                    <form class="d-flex flex-column justify-content-center align-items-center  p-3 gestiontarjeta"  method="post" action= "<?php echo $this->url("salidas", "verporempleado"); ?>">
                    <div class="d-flex flex-wrap justify-content-center align-items-center">
                        <select onChange="activa_boton(this,this.form.boton)" name="empleados">
                            <option selected disabled>Empleado</option>
                            <?php
                            foreach ($empleados as $fila){ 
                                $selec = "";
                                echo '<option ' . $selec . ' value="'.$fila->getNumEmple().'">'.$fila->getDni().'</option>';
                            } //foreach
                            ?>
                        </select>
                    </div>
                    <img class="p-3 mt-2 mb-2 gestiontarjeta_img" src="../recursos/img/gestion1.png">    
                    <input id="boton" class="btn btn-theme" disabled="disabled" type="submit" name="listarsalidasporempleado" value ="Salidas por empleado"/> 
                    </form>                 
                </div>
                <div class="col-md-6 col-12 text-center mb-4">
                    <form class="d-flex flex-column justify-content-center align-items-center  p-3 gestiontarjeta"  method="post" action= "<?php echo $this->url("salidas", "verporalmacen"); ?>">
                        <div class="d-flex flex-wrap justify-content-center align-items-center">
                            <select onChange="activa_boton(this,this.form.boton)"name="almacenes">
                                <option selected disabled>Almacen</option>
                                <?php
                                foreach ($almacenes as $fila){ 
                                    $selec = "";
                                    echo '<option ' . $selec . ' value="'.$fila->getCodAlmacen().'">'.$fila->getTipo().' / '.$objetocentral->getUnaCentral($fila->getIdCentral())->getNombre().'</option>';
                                } //foreach
                                ?>
                            </select>
                        </div>
                        <img class="p-3 mt-2 mb-2 gestiontarjeta_img" src="../recursos/img/gestion2.png">    
                        <input id="boton" class="btn btn-theme" disabled="disabled" type="submit" name="listarsalidasporalmacen" value ="Salidas por almacen"/> 
                    </form>                 
                </div>
                <div class="col-md-6 col-12 text-center mb-4">
                    <form class="d-flex flex-column justify-content-center align-items-center  p-3 gestiontarjeta"  method="post" action= "<?php echo $this->url("salidas", "verporempleadoyalmacen"); ?>">
                        <div class="d-flex flex-wrap justify-content-center align-items-center">
                            <select name="empleados">                          
                                <?php
                                foreach ($empleados as $fila){ 
                                    $selec = "";
                                    echo '<option ' . $selec . ' value="'.$fila->getNumEmple().'">'.$fila->getDni().'</option>';
                                } //foreach
                                ?>
                            </select> 
                            <select name="almacenes">                          
                            <?php
                            foreach ($almacenes as $fila){ 
                                $selec = "";
                                echo '<option ' . $selec . ' value="'.$fila->getCodAlmacen().'">'.$fila->getTipo().' / '.$objetocentral->getUnaCentral($fila->getIdCentral())->getNombre().'</option>';
                            } //foreach
                            ?>
                            </select>
                        </div>
                        <img class="p-3 mt-2 mb-2 gestiontarjeta_img" src="../recursos/img/gestion3.png">    
                        <input id="boton" class="btn btn-theme" type="submit" name="listarsalidasporempleadoyalmacen" value ="Salidas por empleado y almacen"/> 
                    </form>                 
                </div>
                <div class="col-md-6 col-12 text-center mb-4">
                    <form class="d-flex flex-column justify-content-center align-items-center  p-3 gestiontarjeta"  method="post" action= "<?php echo $this->url("salidas", "listartodas"); ?>">
                    <img class="p-3 mt-2 mb-2 gestiontarjeta_img" src="../recursos/img/gestion4.png">
                    <input type="submit" class="btn btn-theme" name="listartodas" value ="Ver todas las salidas"/> 
                    </form>
                </div>
            </div>
    <?php } ?>
    </div>       
    <br>
    <!------------------------------------------> 
        </div>
        </div>
        <!-- FIN SIDEBAR -->
    </div>


                
               

            

         