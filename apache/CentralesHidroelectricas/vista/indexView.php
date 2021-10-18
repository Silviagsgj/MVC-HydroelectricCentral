
<!-- CONTENIDO -->
<div class="d-flex flex-column justify-content-start align-items-center w-100 bg-light" > 
                    
       
     <?php if($_SESSION['login']=="admin"){ ?> <!-- Permisos administrador -->
        <form class="d-flex w-100 justify-content-end pe-2 pt-2"  id="identificarusuario" action="<?php echo $this->url("empleados", "empleadologin"); ?>" method="POST">    
          
            
          
             <input id="cambiovista" class="btn btn-vista" type="submit" value="">
            
       
        </form>      <?php } ?>                              

    <br>
        
    <?php if(isset($canvasadmin)){ ?>       
        <canvas  width="780px" height="480px" class="canvas mt-5" id="myChart"></canvas>
    <?php }?>
    <?php if(isset($canvasemple)){ ?>       
        <canvas  width="780px" height="480px" class="canvas mt-5" id="myChart2"></canvas>
    <?php }?>
        
    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Centrales', 'Empleados', 'Productos', 'Proveedores', 'Entradas', 'Salidas'],
            datasets: [{
                  label: ' ',
                data: [ <?php echo $data1; ?>, <?php echo $data2; ?>, <?php echo $data3; ?>, <?php echo $data4; ?>, <?php echo $data5; ?>, <?php echo $data6; ?>], 
                backgroundColor: [
                    'rgba(17, 70, 99, 0.2)',
                    'rgba(152, 183, 182, 0.2)',
                    'rgba(244, 167, 0, 0.2)',
                    'rgba(209, 79, 139, 0.2)',
                     'rgba(35, 191, 196, 0.2)',
                    'rgba(61, 151, 203, 0.2)'
                ],
                borderColor: [
                    'rgba(17, 70, 99, 1)',
                    'rgba(152, 183, 182, 1)',
                    'rgba(244, 167, 0, 1)',
                    'rgba(209, 79, 139, 1)',
                    'rgba(35, 191, 196, 1)',
                   'rgba(61, 151, 203, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
       responsive: false,
            plugins: {
                legend: {
                    display: false
                }}}           
    });    
    </script>
        
    <script>
      var myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
    </script>
        
        
    <script>
    var ctx = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Entradas', 'Salidas'],
            datasets: [{
                  label: ' ',
                data: [ <?php echo $data1; ?>, <?php echo $data2; ?>], 
                backgroundColor: [
                    'rgba(35, 191, 196, 0.2)',
                    'rgba(61, 151, 203, 0.2)'

                ],
                borderColor: [
                    'rgba(35, 191, 196, 1)',
                    'rgba(61, 151, 203, 1)'

                ],
                borderWidth: 1
            }]
        },
        options: {
         responsive: false,
            plugins: {
                legend: {

                }}}
    });
    </script>
        
    <script>
      var myChart2 = new Chart(
        document.getElementById('myChart2'),
        config
      );
    </script>
 
       
     
 
             
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
    //LISTADO DE CENTRALES ------------------------------------------------------------------------------------------------------------------------
    if(isset($_POST['listarcentrales']) or isset($_POST['delete'])){
        $num= count($elementos);            
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        }else{
            echo "<table id='table' data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true'  data-pagination-pre-text='Anterior'
                  data-pagination-next-text='Siguiente' class='table-light table-striped custom-table'>";           
            echo "<caption class='caption' >$titulo / Total: $num</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th data-field='Codigo' data-sortable='true' scope='col'>Código</th><th data-field='Nombre' data-sortable='true' scope='col'>Nombre</th><th data-field='Telefono' data-sortable='true' scope='col'>Telefono</th><th data-field='Constructor' data-sortable='true' scope='col'>Constructor</th><th data-field='Provincia' data-sortable='true' scope='col'>Provincia</th><th data-field='Poblacion' data-sortable='true' scope='col'>Población</th><th data-field='CP' data-sortable='true' scope='col'>Código Postal</th><th scope='col'></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elementos as $fila){   
                echo "<tr scope='row'>";
                echo "<td>" . $fila->getIdCentral() . "</td>";
    ?>
                <td>
                <a  href="<?php echo $this->url("centrales", "verficha", $fila->getIdCentral()); ?>"><?php echo $fila->getNombre(); ?> </a>
                </td>
                <?php
                echo "<td>" . $fila->getTelefono() . "</td>";
                echo "<td>" . $fila->getConstructor() . "</td>";
                echo "<td>" . $fila->getProvincia() . "</td>";
                echo "<td>" . $fila->getPoblacion() . "</td>";
                echo "<td>" . $fila->getCP() . "</td>";
                echo "<td class='d-flex flex-wrap justify-content-center align-items-center'>";
                ?>       
                <form action="<?php echo $this->url("centrales", "modificar", $fila->getIdCentral()); ?>" method="POST">
                    <input  class="btn btn-modificar" type="submit" value="">
                </form>
                <a href="#delete_<?php echo $fila->getIdCentral();?>" class="btn btn-borrar" data-bs-toggle="modal" data-bs-target="#modalBorrar<?php echo $fila->getIdCentral()?>"></a>
                <?php
                echo "</td>";            
                echo "</tr>";            
                ?>
                
                <!-- Modal borrar -->
                <div class="modal fade" id="modalBorrar<?php echo $fila->getIdCentral(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalBorrar" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form  method="POST" action="<?php echo $this->url("centrales", "borrar", $fila->getIdCentral()); ?>">
                                            <div class="modal-body">               
                                                <center><h5 class="modal-title" id="myModalLabel">¿Estas seguro de eliminar el registro?</h5></center>
                                            </div>            
                                            <div class="modal-footer d-flex justify-content-center align-items-center">             
                                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"></button>                 
                                                <?php
                                                $disabled = "";
                                                $objempleado = new EmpleadosModel();
                                                if ($_SESSION['rol'] == "Admin" and $objempleado->getEmpleado($_SESSION['idemple'])->getIdCentral() == $fila->getIdCentral()) {
                                                    $disabled = "disabled";
                                                }
                                                ?>
                                                <button type="submit" <?php echo $disabled; ?> name="delete" class="btn btn-accept" ></button>                  
                                        </form>
                                    </div>
                                </div>
                </div>
                </div>
    <?php
            }   //fin foreach
            echo "</tbody>";
            echo "</table>";   
        }}
    ?>    
     
              
    <?php 
    //LISTADO DE DEPARTAMENTOS ------------------------------------------------------------------------------------------------------------------------
    if(isset($_POST['listardepartamentos']) or isset($_POST['delete2']) ){
        $num= count($elementos);            
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        }else{
            echo "<div class='table-responsive'>";
            echo "<thead>";
            echo "<table  data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true' data-pagination-pre-text='Anterior'
                data-pagination-next-text='Siguiente' class='table-light table-striped custom-table'>";           
            echo "<caption class='caption'>$titulo / Total: $num</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th data-field='Codigo' data-sortable='true' scope='col'>Código</th><th data-field='Nombre' data-sortable='true' scope='col'>Nombre</th><th scope='col'></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>"; 
            foreach ($elementos as $fila){    
                echo "<tr scope='row'>";
                echo "<td>" . $fila->getCodDepart() . "</td>";
                echo "<td>" . $fila->getNombre() . "</td>";
                echo "<td class='d-flex flex-wrap justify-content-center align-items-center'>";
    ?>       
                <form action="<?php echo $this->url("departamentos", "modificar", $fila->getCodDepart()); ?>" method="POST">
                    <input class="btn btn-modificar" type="submit" value="">
                </form>
                <a href="#delete_<?php echo $fila->getCodDepart();?>" class="btn btn-borrar" data-bs-toggle="modal" data-bs-target="#modalBorrar<?php echo $fila->getCodDepart()?>"></a>
                <?php
                echo "</td>";
                echo "</tr>";
                ?>
                
                <!-- Modal borrar -->
                <div class="modal fade" id="modalBorrar<?php echo $fila->getCodDepart(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalBorrar" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form  method="POST" action="<?php echo $this->url("departamentos", "borrar", $fila->getCodDepart()); ?>">
                                            <div class="modal-body">               
                                                <center><h5 class="modal-title" id="myModalLabel">¿Estas seguro de eliminar el registro?</h5></center>
                                            </div>            
                                            <div class="modal-footer d-flex justify-content-center align-items-center">             
                                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"></button>
                                                <button type="submit" name="delete2" class="btn btn-accept" ></button>                  
                                        </form>
                                    </div>
                                </div>
                </div>
                </div>
    <?php 
            }   //fin foreach
            echo "</tbody>"; 
            echo "</table>";   
            echo "</div>";   
        }}
    ?>    
         
    <?php
    //LISTADO DE CATEGORIAS ------------------------------------------------------------------------------------------------------------------------
    if(isset($_POST['listarcategorias']) or isset($_POST['delete3']) ){
        $num= count($elementos);            
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        }else{
            echo "<div class='table-responsive'>";
            echo "<table data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true' data-pagination-pre-text='Anterior'
                  data-pagination-next-text='Siguiente' class='table-light table-striped custom-table'>";           
            echo "<caption class='caption'>$titulo / Total: $num</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th data-field='Codigo' data-sortable='true' scope='col'>Código</th><th data-field='SalarioBase' data-sortable='true' scope='col'>Salario Base</th><th data-field='HoraExtraNormal' data-sortable='true' scope='col'>Hora Extra Normal</th><th data-field='HoraExtraNocturna' data-sortable='true' scope='col'>Hora Extra Nocturna</th><th data-field='HoraExtraFestivo' data-sortable='true' scope='col'>Hora Extra Festivo</th><th scope='col'></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elementos as $fila){     
                echo "<tr scope='row'>";
                echo "<td>" . $fila->getIdCategoria() . "</td>";
                echo "<td>" . $fila->getSalarioBase() .'€'. "</td>";
                echo "<td>" . $fila->getHoraExtraNormal() .'€'. "</td>";
                echo "<td>" . $fila->getHoraExtraNocturna() .'€'. "</td>";
                echo "<td>" . $fila->getHoraExtraFestivo() .'€'. "</td>";
                echo "<td class='d-flex flex-wrap justify-content-center align-items-center'>";
    ?>       
                <form action="<?php echo $this->url("categorias", "modificar", $fila->getIdCategoria()); ?>" method="POST">
                     <input class="btn btn-modificar" type="submit" value="">
                </form>
                <a href="#delete_<?php echo $fila->getIdCategoria();?>" class="btn btn-borrar" data-bs-toggle="modal" data-bs-target="#modalBorrar<?php echo $fila->getIdCategoria()?>"></a>
                <?php
                echo "</td>";
                echo "</tr>";
                ?>
                
                <!-- Modal borrar -->
                <div class="modal fade" id="modalBorrar<?php echo $fila->getIdCategoria(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalBorrar" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form  method="POST" action="<?php echo $this->url("categorias", "borrar", $fila->getIdCategoria()); ?>">
                                            <div class="modal-body">               
                                                <center><h5 class="modal-title" id="myModalLabel">¿Estas seguro de eliminar el registro?</h5></center>
                                            </div>            
                                            <div class="modal-footer d-flex justify-content-center align-items-center">             
                                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"></button>
                                                <button type="submit" name="delete3" class="btn btn-accept" ></button>                  
                                        </form>
                                    </div>
                                </div>
                </div>
                </div>
    <?php 
            }   //fin foreach
            echo "</tbody>"; 
            echo "</table>";   
            echo "</div>";   
        }}
    ?>    
            
    <?php
    //LISTADO DE PRODUCTOS ------------------------------------------------------------------------------------------------------------------------
    if(isset($_POST['listarproductos']) or isset($_POST['delete4']) or isset($_POST['añade']) or isset($_POST['aumentastock']) ){
        $minimos = new ProductosModel();
        $arraymin = $minimos->getProductosminstock();
        if(count($arraymin) != 0 && $_SESSION['rol']=='Admin'){        
    ?>                  
                <!-- Modal stock mínimo -->
                        <div class="modal fade" id="modalMinStock" tabindex="-1" role="dialog" aria-labelledby="modalMinStock" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form  method="POST" action="<?php echo $this->url("productos", "listaraumentar"); ?>">
                                        <div class="modal-body"> 
                                            <center><h4  class="modal-title nodata">Los siguientes productos tienen poco Stock: </h4></center>
                                            <center><ul class="list-group list-group-flush p-4">
                                                    <?php
                                                    foreach ($arraymin as $fila) {
                                                        echo "<li class='list-group-item list-group-item-light'>" . $fila->getNombre() . " → Stock: <b class='text-primary'>" . $fila->getStock() . "</b></li>";
                                                    }
                                                    ?>
                                                </ul></center>
                                            <center><h5 class="modal-title" id="myModalLabel">¿Deseas aumentarlo?</h5></center>
                                        </div>            
                                        <div class="modal-footer d-flex justify-content-center align-items-center">             
                                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"></button>
                                            <button type="submit" name="aumentastock" class="btn btn-accept" ></button>                  
                                    </form>
                                </div>
                            </div>
                        </div>
        </div>
        <?php
        }
        $num= count($elementos);            
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        }else{
            echo "<div class='table-responsive'>";
            echo "<table data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true'  data-pagination-pre-text='Anterior'
                data-pagination-next-text='Siguiente' class='table-light table-striped custom-table'>";           
            echo "<caption class='caption'>$titulo / Total: $num</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th  data-field='Codigo' data-sortable='true'  scope='col'>Código</th><th  data-field='Nombre' data-sortable='true'  scope='col'>Nombre</th><th  data-field='Marca' data-sortable='true'  scope='col'>Marca</th><th  data-field='Stock' data-sortable='true'  scope='col'>Stock</th><th scope='col'></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elementos as $fila){     
                echo "<tr scope='row'>";
                echo "<td>" . $fila->getCodProd() . "</td>";
    ?>
                <td>
                <a href="<?php echo $this->url("productos", "verficha", $fila->getCodProd()); ?>"><?php echo $fila->getNombre(); ?> </a>
                </td>
                <?php    
                echo "<td>" . $fila->getMarca() . "</td>";
                echo "<td>" . $fila->getStock() . "</td>";     
                echo "<td class='d-flex flex-wrap justify-content-center align-items-center'>";
                if($_SESSION['rol']=="Admin"){
                ?>       
                    <form action="<?php echo $this->url("productos", "modificar", $fila->getCodProd()); ?>" method="POST">
                        <input class="btn btn-modificar" type="submit" value="">
                    </form>
                    <a href="#delete_<?php echo $fila->getCodProd();?>" class="btn btn-borrar" data-bs-toggle="modal" data-bs-target="#modalBorrar<?php echo $fila->getCodProd()?>"></a>
                <?php
                }else{
                ?> 
                    <form action="<?php echo $this->url("productos", "anadiralalmacen");?>" method="POST">               
                        <input class="" type="hidden" name="id"  value="<?php  echo $fila->getCodProd(); ?>" >
                        <input onChange="activa_boton(this,this.form.boton)" class="" type="number" name="unidades"  value="0" min=0 max=<?php echo $fila->getStock(); ?>>
                        <input id="boton" disabled class="btn  btn-add"  name="añade" type="submit"  value="">
                    </form>
                <?php
                }
                echo "</td>";
                echo "</tr>";
                ?>
               
                <!-- Modal borrar -->
                <div class="modal fade" id="modalBorrar<?php echo $fila->getCodProd(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalBorrar" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form  method="POST" action="<?php echo $this->url("productos", "borrar", $fila->getCodProd()); ?>">
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
    <?php           
            }   //fin foreach 
            echo "</tbody>";
            echo "</table>";
            if($_SESSION['rol']=="Emple"){
    ?>
                <form action="<?php echo $this->url("productos", "ver");?>" method="POST">
                <?php            
                    if($con==0){
                        $disabled = "disabled";
                    }else{
                        $disabled="";
                    }          
                ?>
                    <input class="nav-item btn btn-theme" <?php echo $disabled ?> type="submit" name="veralma" value="Revisar productos" /> 
                </form>
    <?php
            }
            echo "</div>";
            }}
    ?>    
            
            
    <?php
    //LISTADO DE PROVEEDORES ------------------------------------------------------------------------------------------------------------------------
    if(isset($_POST['listarproveedores']) or isset($_POST['delete5']) ){
        $num= count($elementos);            
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        }else{   
            echo "<div class='table-responsive'>";        
            echo "<table data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true' data-pagination-pre-text='Anterior'
                    data-pagination-next-text='Siguiente' class='table-light table-striped custom-table'>";           
            echo "<caption class='caption'>$titulo / Total: $num</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th data-field='Codigo' data-sortable='true' scope='col'>Código</th><th data-field='Nombre' data-sortable='true' scope='col'>Nombre</th><th data-field='CIF' data-sortable='true' scope='col'>CIF</th><th data-field='Telefono' data-sortable='true' scope='col'>Telefono</th><th data-field='Direccion' data-sortable='true' scope='col'>Direccion</th><th data-field='Provincia' data-sortable='true' scope='col'>Provincia</th><th data-field='Poblacion' data-sortable='true' scope='col'>Población</th><th data-field='CP' data-sortable='true' scope='col'>Código Postal</th><th scope='col'></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elementos as $fila){   
                echo "<tr scope='row'>";
                echo "<td>" . $fila->getIdProveedor() . "</td>";
                echo "<td>" . $fila->getNombre() . "</td>";
                echo "<td>" . $fila->getCIF() . "</td>";
                echo "<td>" . $fila->getTelefono() . "</td>";
                echo "<td>" . $fila->getDireccion() . "</td>";
                echo "<td>" . $fila->getProvincia() . "</td>";
                echo "<td>" . $fila->getPoblacion() . "</td>";
                echo "<td>" . $fila->getCP() . "</td>";
                echo "<td class='d-flex flex-wrap justify-content-center align-items-center'>";
    ?>       
                <form action="<?php echo $this->url("proveedores", "modificar", $fila->getIdProveedor()); ?>" method="POST">
                     <input class="btn btn-modificar" type="submit" value="">
                </form>      
                <a href="#delete_<?php echo $fila->getIdProveedor();?>" class="btn btn-borrar" data-bs-toggle="modal" data-bs-target="#modalBorrar<?php echo $fila->getIdProveedor()?>"></a>
                <?php
                echo "</td>";            
                echo "</tr>";           
                ?>
                
                 <!-- Modal borrar -->
                 <div class="modal fade" id="modalBorrar<?php echo $fila->getIdProveedor(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalBorrar" aria-hidden="true">
                                 <div class="modal-dialog">
                                     <div class="modal-content">
                                         <form  method="POST" action="<?php echo $this->url("proveedores", "borrar", $fila->getIdProveedor()); ?>">
                                             <div class="modal-body">               
                                                 <center><h5 class="modal-title" id="myModalLabel">¿Estas seguro de eliminar el registro?</h5></center>
                                             </div>            
                                             <div class="modal-footer d-flex justify-content-center align-items-center">             
                                                 <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"></button>
                                                 <button type="submit" name="delete5" class="btn btn-accept" ></button>                  
                                         </form>
                                     </div>
                                 </div>
                 </div>
                </div>
    <?php 
            }   //fin foreach
            echo "</tbody>";  
            echo "</table>";
            echo "</div>";
        }}
    ?>    
                 
    <?php
    //LISTADO DE ALMACENES ------------------------------------------------------------------------------------------------------------------------
    if(isset($_POST['consultasalmacenes'])){
    ?>
        <div class="row w-100 d-flex justify-content-center align-items-start mt-5 h-100">
            <div class="col-md-6 col-12 text-center">               
                <form class="d-flex flex-column justify-content-center align-items-center  p-3 gestiontarjeta"  method="post" action= "<?php echo $this->url("almacenes", "verporcentral"); ?>">
                    <div class="d-flex flex-wrap justify-content-center align-items-center">
                    <select onChange="activa_boton(this,this.form.boton)" name="centrales">
                        <option selected disabled>Selecciona la central</option>
                        <?php
                        foreach ($centrales as $fila){ 
                            $selec = "";
                            echo '<option ' . $selec . ' value="'.$fila->getIdCentral().'">'.$fila->getNombre().'</option>';
                        } //foreach
                        ?>
                   </select>
                   </div>
                   <img class="p-3 mt-2 mb-2 gestiontarjeta_img" src="../recursos/img/gestion3.png">    
                   <input id="boton" disabled="disabled" class="btn btn-theme" type="submit" name="listarporcentral" value ="Almacenes por central"/> 
                   <input type="hidden" name="val" value ="central"/> 
                </form>
            </div>
            <div class="col-md-6 col-12 text-center">
                <form class="d-flex flex-column justify-content-center align-items-center  p-3 gestiontarjeta" method="post" action= "<?php echo $this->url("almacenes", "listar"); ?>">
                    <img class="p-3 mt-2 mb-2 gestiontarjeta_img" src="../recursos/img/gestion4.png">
                    <input type="submit" class="btn btn-theme" name="listartodos" value ="Ver todos los almacenes"/> 
                    <input type="hidden" name="val" value ="todas"/> 
                </form>
            </div>
        </div>
    <?php          
    }
    
    if(isset($_POST['listartodos']) or isset($_POST['listarporcentral']) or isset($_POST['delete6'])){
        $num= count($elementos);            
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        }else{
            $objetocentral = new CentralesModel();           
            echo "<div class='table-responsive'>";        
            echo "<table  data-toggle='table' data-search='true' data-show-search-button='true' data-search-align='right' data-pagination='true' data-pagination-pre-text='Anterior'
                    data-pagination-next-text='Siguiente'   class='table-light table-striped custom-table'>";           
            echo "<caption class='caption'>$titulo / Total: $num</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th data-field='Codigo'  data-sortable='true' scope='col'>Código</th><th data-field='Tipo' data-sortable='true' scope='col'>Tipo</th><th data-field='Ubicacion' data-sortable='true' scope='col'>Ubicación</th><th scope='col' ></th>";
            echo "</tr>";
            echo "</thead>";       
            echo "<tbody>";
            foreach ($elementos as $fila){   
                echo "<tr scope='row'>";
                echo "<td>" . $fila->getCodAlmacen() . "</td>";
                echo "<td>" . $fila->getTipo() . "</td>";
                echo "<td>" . $objetocentral->getUnaCentral($fila->getIdCentral())->getNombre(). "</td>";
                echo "<td class='d-flex flex-wrap justify-content-center align-items-center'>";
    ?>       
                <form action="<?php echo $this->url("almacenes", "modificar", $fila->getCodAlmacen()); ?>" method="POST">
                    <input class="btn btn-modificar" type="submit" value="">
                    <input type="hidden" name="valores" value="<?php echo $_POST['val']; ?>">
                    <input type="hidden" name="centrales" value="<?php echo $_POST['centrales']; ?>">
                </form>
                <a href="#delete_<?php echo $fila->getCodAlmacen();?>" class="btn btn-borrar" data-bs-toggle="modal" data-bs-target="#modalBorrar<?php echo $fila->getCodAlmacen()?>"></a>
                <?php
                echo "</td>";
                echo "</tr>";
                ?>
                
                <!-- Modal borrar -->
                <div class="modal fade" id="modalBorrar<?php echo $fila->getCodAlmacen(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalBorrar" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form  method="POST" action="<?php echo $this->url("almacenes", "borrar", $fila->getCodAlmacen()); ?>">
                                            <div class="modal-body">               
                                                <center><h5 class="modal-title" id="myModalLabel">¿Estas seguro de eliminar el registro?</h5></center>
                                            </div>            
                                            <div class="modal-footer d-flex justify-content-center align-items-center">             
                                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"></button>
                                                <button type="submit" name="delete6" class="btn btn-accept" ></button>                  
                                        </form>
                                    </div>
                                </div>
                </div>
                </div>
    <?php 
            }   //fin foreach
            echo "</tbody>";  
            echo "</table>";
            echo "</div>";
        }
        ?>
            <form class="w-75 p-3" action="<?php echo $this->url("almacenes", "gestion") ?>" method="post">                   
                <input type="submit" name="consultasalmacenes" class="btn btn-previous" value="" />
            </form>
    <?php
    }
    ?>    
                 
    <?php
    if(isset($_POST['consultasempleados']) ){
    ?>
        <div class="row w-100 d-flex justify-content-center align-items-start h-100 mt-5">
            <div class="col-md-6 col-12 text-center ">
                <form  class="d-flex flex-column justify-content-center align-items-center p-3 gestiontarjeta"  method="post" action= "<?php echo $this->url("empleados", "verporcentral"); ?>">
                    <div class="d-flex flex-wrap justify-content-center align-items-center ">
                        <select onChange="activa_boton(this,this.form.boton)" name="centrales">
                            <option selected disabled>Selecciona la central</option>
                            <?php
                            foreach ($centrales as $fila){ 
                            $selec = "";
                            echo '<option ' . $selec . ' value="'.$fila->getIdCentral().'">'.$fila->getNombre().'</option>';
                            } //foreach
                            ?>
                        </select>
                    </div>
                    <img class="p-3 mt-2 mb-2 gestiontarjeta_img" src="../recursos/img/gestion1.png">    
                    <input id="boton"  disabled="disabled" class="btn btn-theme" type="submit" name="listarporcentralemple" value ="Empleados por central"/> 
                    <input type="hidden" name="val" value ="central"/> 
                </form>
            </div>
            <div class="col-md-6 col-12 text-center">
                <form class="d-flex flex-column justify-content-center align-items-center  p-3 gestiontarjeta"  method="post" action= "<?php echo $this->url("empleados", "listar"); ?>">
                    <img class="p-3 mt-2 mb-2 gestiontarjeta_img" src="../recursos/img/gestion2.png">
                    <input type="submit" class="btn btn-theme" name="listaremplestodos" value ="Ver todos los empleados"/> 
                    <input type="hidden" name="val" value ="todas"/> 
                </form>
            </div>
        </div>
                 
    <?php          
    }
    //LISTADO DE EMPLEADOS ------------------------------------------------------------------------------------------------------------------------
    if(isset($_POST['listaremplestodos']) or isset($_POST['listarporcentralemple']) or isset($_POST['delete7'])){
        $num= count($elementos);            
        if($num==0){
            echo "<h3 class='nodata'>No hay datos</h3>";
        }else{  
            echo "<div class='table-responsive'>";        
            echo "<table data-toggle='table' data-search='true' data-show-search-button='true' data-pagination='true' data-pagination-pre-text='Anterior'
                  data-pagination-next-text='Siguiente' class='table-light table-striped custom-table'>";           
            echo "<caption class='caption'>$titulo / Total: $num</caption>";
            echo "<thead>";
            echo "<tr>";
            echo "<th     data-field='NumEmple' data-sortable='true' scope='col'>Nº empleado</th><th  data-field='DNI' data-sortable='true' scope='col'>DNI</th><th  data-field='Nombre' data-sortable='true' scope='col'>Nombre</th><th  data-field='Apellidos' data-sortable='true' scope='col'>Apellidos</th><th  data-field='Telefono' data-sortable='true' scope='col'>Teléfono</th><th  data-field='Email' data-sortable='true' scope='col'>Email</th><th  data-field='Provincia' data-sortable='true' scope='col'>Provincia</th><th scope='col'></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elementos as $fila){   
                echo "<tr scope='row'>";
                echo "<td>" . $fila->getNumEmple() . "</td>";
    ?>
                <td>      
                <form action="<?php echo $this->url("empleados", "verficha", $fila->getNumEmple()); ?>" method="POST"> 
                    <input  class="fichaest" type="submit" value="<?php echo $fila->getDNI();?>" />
                    <input type="hidden" name="valores" value="<?php echo $_POST['val']; ?>" />  <!-- todas o central -->
                    <input name="idcent" type="hidden" value="<?php echo $fila->getIdCentral(); ?>">              
                </form>              
                </td>
                <?php    
                echo "<td>" . $fila->getNombre() . "</td>";
                echo "<td>" . $fila->getApellidos() . "</td>";
                echo "<td>" . $fila->getTelefono() . "</td>";
                echo "<td>" . $fila->getEmail() . "</td>";
                echo "<td>" . $fila->getPoblacion() . "</td>";
                echo "<td class='d-flex flex-wrap justify-content-center align-items-center'>";
                ?>       
                <form action="<?php echo $this->url("empleados", "modificar", $fila->getNumEmple()); ?>" method="POST">
                    <input class="btn btn-modificar" type="submit" value="">
                    <input type="hidden" name="valores" value="<?php echo $_POST['val']; ?>">
                    <input type="hidden" name="centrales" value="<?php echo $_POST['centrales']; ?>">
                  
                </form>             
                <a href="#delete_<?php echo $fila->getNumEmple();?>" class="btn btn-borrar" data-bs-toggle="modal" data-bs-target="#modalBorrar<?php echo $fila->getNumEmple()?>"></a>
                <?php
                echo "</td>";
                echo "</tr>";
                ?>
                
                <!-- Modal borrar -->
                <div class="modal fade" id="modalBorrar<?php echo $fila->getNumEmple(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalBorrar" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form  method="POST" action="<?php echo $this->url("empleados", "borrar", $fila->getNumEmple()); ?>">
                                            <div class="modal-body">               
                                                <center><h5 class="modal-title" id="myModalLabel">¿Estas seguro de eliminar el registro?</h5></center>
                                            </div>            
                                            <div class="modal-footer d-flex justify-content-center align-items-center">              
                                                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal"></button>
                                                <?php
                                                $disabled = "";
                                                if ($_SESSION['rol'] == "Admin" and $_SESSION['idemple'] == $fila->getNumEmple()) {
                                                    $disabled = "disabled";
                                                }
                                                ?>
                                                <button <?php echo $disabled; ?> type="submit" name="delete7" class="btn btn-accept" ></button>                
                                        </form>
                                    </div>
                                </div>
                </div>
                </div>
    <?php          
            }   //fin foreach
            echo "</tbody>";   
            echo "</table>";
            echo "</div>";
        }
    ?>
        <form class="w-75 p-3" action="<?php echo $this->url("empleados", "gestion") ?>" method="post">                   
            <input type="submit" name="consultasempleados" class="btn btn-previous" value="" />
        </form>
    <?php } ?>    
    <br>
    <!------------------------------------------> 
    </div>
    </div>
    <!--    FIN SIDEBAR -->
</div>


                
               

            

         