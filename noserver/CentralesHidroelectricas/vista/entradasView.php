<div class="col d-flex flex-column justify-content-start align-items-center">              
    <!-- Contenido -->

        <?php if($_SESSION['login']=="admin"){ ?> <!-- Permisos administrador -->
        <form class="d-flex w-100 justify-content-end pe-2 pt-2"  id="identificarusuario" action="<?php echo $this->url("empleados", "empleadologin"); ?>" method="POST">    
          
            
          
             <input id="cambiovista" class="btn btn-vista" type="submit" value="">
            
       
        </form>      <?php } ?>                              

    

    <!-- Alert mensajes -->    
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
    //LISTADO DE ENTRADAS ------------------------------------------------------------------------------------------------------------------------
        if(isset($_POST['listarmisentradas']) or isset($_POST['deleteent']) ){  
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
            echo "<th data-field='NumEntrada' data-sortable='true'  scope='col'>Num Entrada</th><th data-field='Almacen' data-sortable='true'  scope='col'>Almacen</th><th data-field='Central' data-sortable='true'  scope='col'>Central</th><th data-field='FechaEntrada' data-sortable='true'  scope='col'>Fecha de entrada</th><th data-field='Motivo' data-sortable='true'  scope='col'>Motivo</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elementos as $fila){    
                echo "<tr scope='row'>";
    ?>  
                <td>
                    <a href="<?php echo $this->url("detentradas", "mostrardetalle", $fila['NumEntrada']); ?>"><?php echo $fila['NumEntrada'] ?> </a>
                </td>   
    <?php     
                echo "<td>" . $objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getTipo() . "</td>";
                echo "<td>".$objetocentral->getUnaCentral($objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre()."</td>"; 
                echo "<td>" . $fila['FechaEntrada'] . "</td>";
                echo "<td>" . $fila['Motivo'] . "</td>";         
                //Aqui botones de modificar borrar
                echo "</tr>";         
            }   //fin foreach
            echo "</tbody>";  
            echo "</table>";   
            echo "</div>";   
          }}
    ?>    
 
  

                   
    <?php   if(isset($_POST['listarentradasporempleado']) ){
                $objetoalmacen = new AlmacenesModel();
                $objetocentral = new CentralesModel();     
                $num= count($elementos);            
                   if($num==0){
                       echo "<h3 class='nodata' >No hay datos</h3>";
                   }else{      
                      echo "<div class='table-responsive'>";        
                      echo "<table  data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true'  data-pagination-pre-text='Anterior'
                            data-pagination-next-text='Siguiente' class='table-light table-striped custom-table '>";           
                      echo "<caption class='caption'>$titulo</caption>";
                      echo "<thead>";
                      echo "<tr>";
                      echo "<th data-field='NumEntrada' data-sortable='true'  scope='col'>Num Entrada</th><th data-field='Almacen' data-sortable='true'  scope='col'>Almacen</th><th data-field='Central' data-sortable='true'  scope='col'>Central</th><th data-field='FechaEntrada' data-sortable='true'  scope='col'>Fecha de entrada</th><th data-field='Motivo' data-sortable='true'  scope='col'>Motivo</th>";
                      echo "</tr>";
                      echo "</thead>";
                      echo "<tbody>";
                      foreach ($elementos as $fila){    
                            echo "<tr scope='row'>";
    ?>
                            <td>
                            <!-- aqui llevar hidden -->
                            <form  action="<?php echo $this->url("detentradas", "mostrardetalle", $fila['NumEntrada']); ?>" method="POST"> 
                                <input class="fichaest" type="submit" value="<?php echo $fila['NumEntrada'] ?>" />
                                <input type="hidden" name="valores" value="empleado" />
                                <input name="numemple" type="hidden" value="<?php echo $id; ?>">
                            </form>
                            </td>
    <?php  
                            echo "<td>" . $objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getTipo() . "</td>";
                            echo "<td>".$objetocentral->getUnaCentral($objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre()."</td>"; 
                            echo "<td>" . $fila['FechaEntrada'] . "</td>";
                            echo "<td>" . $fila['Motivo'] . "</td>";
                            echo "</tr>";
                        }   //fin foreach
                        echo "</tbody>";  
                        echo "</table>";
    ?>
            
    <form class="mt-3" action="" method="POST" id="formdoc">    
        <input id="export_data" name="export_data" class="btn btn-theme" id="submit" type="submit" value="Generar Documentos"> 
        <input name="tipo" type="hidden" value="empleado">
        <input name="numemple" type="hidden" value="<?php echo $id; ?>">
        <select name="documentos" id="seldoc"> 
            <option selected disabled value="">Selecciona una opcion</option>
            <option value="<?php echo $this->url("entradas", "generaexcell"); ?>">Excell</option>
            <option value="<?php echo $this->url("entradas", "generapdf"); ?>">Pdf</option>
        </select>              
     </form>     
            
    <script>
        document.getElementById('seldoc').onchange = function(){
            document.getElementById('formdoc').action = '/'+this.value;
        }
    </script>

    <?php
        echo "</div>";   
        }
    ?>

        <form class="w-75 p-3" action="<?php echo $this->url("entradas", "gestion") ?>" method="post">                   
            <input type="submit" name="consultasentradas" class="btn btn-previous" value="" />
        </form>
    <?php } ?> 
 
 
    <?php   
    if(isset($_POST['listarentradasporempleadoyalmacen']) ){
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
                echo "<th data-field='NumEntrada' data-sortable='true'  scope='col'>Num Entrada</th><th data-field='FechaEntrada' data-sortable='true'  scope='col'>Fecha de entrada</th><th data-field='Motivo' data-sortable='true'  scope='col'>Motivo</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($elementos as $fila){    
                    echo "<tr scope='row'>";
    ?>
                <td> 
                <!-- aqui llevar hidden -->
                <form  action="<?php echo $this->url("detentradas", "mostrardetalle", $fila['NumEntrada']); ?>" method="POST"> 
                    <input class="fichaest" type="submit" value="<?php echo $fila['NumEntrada'] ?>" />
                    <input type="hidden" name="valores" value="emplealma" />
                    <input name="numemple" type="hidden" value="<?php echo $id; ?>">
                    <input name="codalma" type="hidden" value="<?php echo $idal; ?>">
                </form>
                </td>
    <?php   
                    echo "<td>" . $fila['FechaEntrada'] . "</td>";
                    echo "<td>" . $fila['Motivo'] . "</td>"; 
                    echo "</tr>";            
               }   //fin foreach
                echo "</tbody>";  
                echo "</table>";
    ?>
               
        <form class="mt-3" action="" method="POST" id="formdoc">    
            <input id="export_data" name="export_data" class="btn btn-theme" id="submit" type="submit" value="Generar Documentos"> 
            <input name="tipo" type="hidden" value="empleadoalma">
            <input name="numemple" type="hidden" value="<?php echo $id; ?>">
            <input name="codalma" type="hidden" value="<?php echo $idal; ?>">
            <select name="documentos" id="seldoc"> 
                <option selected disabled value="">Selecciona una opcion</option>
                <option value="<?php echo $this->url("entradas", "generaexcell"); ?>">Excell</option>
                <option value="<?php echo $this->url("entradas", "generapdf"); ?>">Pdf</option>
            </select>              
        </form> 
            
    <script>
    document.getElementById('seldoc').onchange = function(){
        document.getElementById('formdoc').action = '/'+this.value;
    }
    </script>
 
    <?php
        echo "</div>";   
    }
    
    ?>
        <form class="w-75 p-3" action="<?php echo $this->url("entradas", "gestion") ?>" method="post">                   
            <input type="submit" name="consultasentradas" class="btn btn-previous" value="" />
        </form>       
    <?php   } ?>  
                
          
    <?php
        //LISTADO DE ENTRADAS ------------------------------------------------------------------------------------------------------------------------
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
               echo "<th data-field='NumEntrada' data-sortable='true'  scope='col'>Num Entrada</th><th data-field='NombreEmple' data-sortable='true'  scope='col'>Nombre empleado</th><th data-field='DNI' data-sortable='true'  scope='col'>DNI</th><th data-field='Almacen' data-sortable='true'  scope='col'>Almacen</th><th data-field='Central' data-sortable='true'  scope='col'>Central</th><th data-field='FechaEntrada' data-sortable='true'  scope='col'>Fecha de entrada</th><th data-field='Motivo' data-sortable='true'  scope='col'>Motivo</th>";
               echo "</tr>";
               echo "</thead>";
               echo "<tbody>";
               foreach ($elementos as $fila){ 
                    echo "<tr scope='row'>";
    ?>
                    <td> 
                    <!-- aqui llevar hidden -->
                    <form  action="<?php echo $this->url("detentradas", "mostrardetalle", $fila['NumEntrada']); ?>" method="POST"> 
                        <input class="fichaest" type="submit" value="<?php echo $fila['NumEntrada'] ?>" />
                        <input type="hidden" name="valores" value="todas" />
                    </form>
                    </td>
    <?php
                    echo "<td>" .$objetoempleado->getEmpleado($fila['NumEmple'])->getNombre()." ".$objetoempleado->getEmpleado($fila['NumEmple'])->getApellidos()."</td>";
                    echo "<td>" .$objetoempleado->getEmpleado($fila['NumEmple'])->getDNI()."</td>"; 
                    echo "<td>" . $objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getTipo() . "</td>";
                    echo "<td>".$objetocentral->getUnaCentral($objetoalmacen->getUnAlmacen($fila['CodAlmacen'])->getIdCentral())->getNombre()."</td>"; 
                    echo "<td>" . $fila['FechaEntrada'] . "</td>";
                    echo "<td>" . $fila['Motivo'] . "</td>";   
                    echo "</tr>";
                }   //fin foreach
                echo "</tbody>";  
                echo "</table>";             
    ?>  
    <form class="mt-3" action="" method="POST" id="formdoc">    
        <input id="export_data" name="export_data" class="btn btn-theme" id="submit" type="submit" value="Generar Documentos"> 
        <input name="tipo" type="hidden" value="todas">
        <select name="documentos" id="seldoc">           
            <option selected disabled value="">Selecciona una opcion</option>
            <option value="<?php echo $this->url("entradas", "generaexcell"); ?>">Excell</option>
            <option value="<?php echo $this->url("entradas", "generapdf"); ?>">Pdf</option>    
        </select>              
    </form> 
            
    <script>
        document.getElementById('seldoc').onchange = function(){
            document.getElementById('formdoc').action = '/'+this.value;
        }
    </script> 

         
      
    <?php
        echo "</div>";   
    }
    ?>
    <form class="w-75 p-3" action="<?php echo $this->url("entradas", "gestion") ?>" method="post">                   
        <input type="submit" name="consultasentradas" class="btn btn-previous" value="" />
    </form>       
    <?php  }     ?>  
          
          
    <?php 
        if(isset($_POST['listarentradasporalmacen'])){
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
               echo "<th data-field='NumEntrada' data-sortable='true'  scope='col'>Num Entrada</th><th data-field='NombreEmple' data-sortable='true'  scope='col'>Nombre empleado</th><th data-field='DNI' data-sortable='true'  scope='col'>DNI</th><th data-field='FechaEntrada' data-sortable='true'  scope='col'>Fecha de entrada</th><th data-field='Motivo' data-sortable='true'  scope='col'>Motivo</th>";
               echo "</tr>";
               echo "</thead>";
               echo "<tbody>";
               foreach ($elementos as $fila){    
                    echo "<tr scope='row'>";
    ?>
                    <td>
                    <!-- aqui llevar hidden -->
                    <form  action="<?php echo $this->url("detentradas", "mostrardetalle", $fila['NumEntrada']); ?>" method="POST"> 
                        <input class="fichaest"  type="submit" value="<?php echo $fila['NumEntrada'] ?>" />
                        <input type="hidden" name="valores" value="almacen" />
                        <input name="codalma" type="hidden" value="<?php echo $id; ?>">
                    </form>    
                    </td>
    
    <?php   
                    echo "<td>" .$objetoempleado->getEmpleado($fila['NumEmple'])->getNombre()." ".$objetoempleado->getEmpleado($fila['NumEmple'])->getApellidos()."</td>";
                    echo "<td>" .$objetoempleado->getEmpleado($fila['NumEmple'])->getDNI()."</td>";
                    echo "<td>" . $fila['FechaEntrada'] . "</td>";
                    echo "<td>" . $fila['Motivo'] . "</td>";     
                    echo "</tr>";
            }   //fin foreach
            echo "</tbody>";   
            echo "</table>";  
    ?>
        <form class="mt-3" action="" method="POST" id="formdoc">    
            <input id="export_data" name="export_data" class="btn btn-theme" id="submit" type="submit" value="Generar Documentos"> 
            <input name="tipo" type="hidden" value="almacen">
            <input name="codalma" type="hidden" value="<?php echo $id; ?>">
            <select name="documentos" id="seldoc">               
                <option selected disabled value="">Selecciona una opcion</option>
                <option value="<?php echo $this->url("entradas", "generaexcell"); ?>">Excell</option>
                <option value="<?php echo $this->url("entradas", "generapdf"); ?>">Pdf</option>
            </select>              
        </form>   
         
        <script>
            document.getElementById('seldoc').onchange = function(){
                document.getElementById('formdoc').action = '/'+this.value;
            }
        </script>   
 
    <?php
        echo "</div>";   
         }          
    ?>
        <form class="w-75 p-3" action="<?php echo $this->url("entradas", "gestion") ?>" method="post">                   
            <input type="submit" name="consultasentradas" class="btn btn-previous" value="" />
        </form>      
    <?php } ?>
      

    <?php
    if(isset($_POST['consultasentradas'])){
         $objetocentral = new CentralesModel;
    ?>  
      
        <div class="row w-100 d-flex justify-content-center align-items-center h-100">
            <div class="col-md-6 col-12 text-center mb-4">
                <form class="d-flex flex-column justify-content-center align-items-center  p-3 gestiontarjeta" method="post" action= "<?php echo $this->url("entradas", "verporempleado"); ?>">
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
                    <input class="btn btn-theme" id="boton" type="submit" name="listarentradasporempleado" disabled="disabled" value ="Entradas por empleado"/> 
                </form>                 
            </div>
            <div class="col-md-6 col-12 text-center mb-4">
                <form class="d-flex flex-column justify-content-center align-items-center  p-3 gestiontarjeta"  method="post" action= "<?php echo $this->url("entradas", "verporalmacen"); ?>">
                    <div class="d-flex flex-wrap justify-content-center align-items-center">
                    <select onChange="activa_boton(this,this.form.boton)" name="almacenes">
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
                    <input class="btn btn-theme" id="boton" type="submit" name="listarentradasporalmacen" disabled="disabled" value ="Entradas por almacen"/> 
                </form>    
            </div>                  
            <div class="col-md-6 col-12 text-center mb-4">
                <form class="d-flex flex-column justify-content-center align-items-center  p-3 gestiontarjeta"   method="post" action= "<?php echo $this->url("entradas", "verporempleadoyalmacen"); ?>">
                    <div class="d-flex flex-wrap justify-content-center align-items-center">
                        <select name="empleados">
                  
                                <?php
                                    foreach ($empleados as $fila) {
                                        $selec = "";
                                        echo '<option ' . $selec . ' value="' . $fila->getNumEmple() . '">' . $fila->getDni() . '</option>';
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
                    <input class="btn btn-theme" id="boton" type="submit" name="listarentradasporempleadoyalmacen" value ="Entradas por empleado y almacen"/> 
                    <input type="hidden" name="valores" value ="emplealma"/> 
                </form>                 
            </div>
            <div class="col-md-6 col-12 text-center mb-4">
                <form class="d-flex flex-column justify-content-center align-items-center  p-3 gestiontarjeta"  method="post" action= "<?php echo $this->url("entradas", "listartodas"); ?>">
                    <img class="p-3 mt-2 mb-2 gestiontarjeta_img" src="../recursos/img/gestion4.png">
                    <input type="submit" class="btn btn-theme" name="listartodas" value ="Ver todas las entradas"/> 
                    <input type="hidden" name="valores" value ="todas"/>    
                </form>   
            </div>                       
        </div>         
                             
        <?php }?>                    
        <br>                    
        <!------------------------------------------>             
        </div>
        </div>           
        <!-- FIN SIDEBAR -->
    </div>  
                
      
      
      
      
      
     
      
          
         
          
     
      
      
      
      
        
            
     
           
            
           
        
   
      
   


                
               

            

                   
          
                  
       
 

   
            
            
      
               
            
   
      
     
                   
      
      
        
      
      
      
      
      
      
      

           
       
           
             
           


             
 
 
 

   
            
              
             
             
        
   
             
        
     
      
          
              
          
    

    
      
      
                   
                 
      
     
                     
         
          
            
                  
      
         
          
               
           
    
      
      
      
      
      
      
      
                
        
    
            
           
      
      
     
       
     
      
      
     

 

   
            
            
                   
     
                     
     
      
      
      
      
      
      
      
                
        
         

                   

      
    
      
      
      
      
      
      
      
      
      
      
      
      
      
    