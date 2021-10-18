<!-- Contenido -->                    
       
<div class="col d-flex flex-column justify-content-start align-items-center bg-light fondoform">
    
        <?php if($_SESSION['login']=="admin"){ ?> <!-- Permisos administrador -->
        <form class="d-flex w-100 justify-content-end pe-2 pt-2"  id="identificarusuario" action="<?php echo $this->url("empleados", "empleadologin"); ?>" method="POST">    
          
            
          
             <input id="cambiovista" class="btn btn-vista" type="submit" value="">
            
       
        </form>      <?php } ?>                              

    <br>

    <!-- Alert mensajes -->        
    <?php
        if(isset($mensaje)){
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
            <div class='text-light'>".$mensaje."</div>           
            </div>";  
        }       
    ?>

    <?php
    
    
       if(isset($_POST['cambioclave'])){
           
           
            if (isset($objelemento)) {
               
                $clave = $objelemento->getPassword();
               
            } else {

                $clave = "";
            }
           
           ?>
             <form class="w-25" action="<?php echo $this->url("usuarios", "modificalacontraseña"); ?>" method="POST"  id="formulario" name="usupas" novalidate>
      
        <h2 class="title mb-4"><?php echo $titulo; ?>
        <button class="btn btn-pass2" type="submit"></button>                          
                        
        </h2>                    
        <div class="row form-group d-flex justify-content-center align-items-center">                    
            <div class="col-sm-12 mb-3">
                <label class="control-label label" >Clave:</label>                
                <input required class="form-control" type="password" name="clave" id="clave" value="<?php echo $clave; ?>">                  
                <span class="error" id="errorclave"></span>                                   
            </div>                     
	</div> 				
    </form>   		
       <?php } else {
          
    
    
    switch ($opcion) {
        case 'departamento':
            if (isset($objelemento)) {
                $Nombre = $objelemento->getNombre();
                $CodDepart = $objelemento->getCodDepart();
            } else {
                $Nombre = "";
                $CodDepart = "";
            }

            if ($ope == "Modificar") {
                $ruta = "modificareldep";
                $icon = "btn-modificar";
            }
            if ($ope == "Insertar") {
                $ruta = "insertareldep";
                $icon = "btn-add";
            }
    ?>
 <!--------------------------------------- DEPARTAMENTOS ----------------------------------------------------------->
    <?php
        if($ope=="Modificar"){
    ?>
        <form class="w-75 pt-3" action="<?php echo $this->url("departamentos", "listar") ?>" method="post">                   
            <input type="submit" name="listardepartamentos" class="btn btn-previous" value="" />
        </form>    
    <?php } ?>          
    
    <form action="<?php echo $this->url("departamentos", $ruta); ?>" method="POST"  id="formulario" name="departamento" novalidate>
        <input  type="hidden" name="CodDepart" value="<?php echo $CodDepart; ?>"> 
        <h2 class="title mb-4"><?php echo $titulo; ?>
        <button class="btn <?php echo $icon; ?>2 " type="submit"></button>                          
        <?php
            if($ope=="Insertar"){ 
        ?>                             
        <button class="btn btn-reset" type="reset"></button>                     
        <?php } ?>                    
        </h2>                    
        <div class="row form-group d-flex justify-content-center align-items-center">                    
            <div class="col-sm-12 mb-3">
                <label class="control-label label" >Nombre:</label>                
                <input required class="form-control" type="text" name="Nombre" id="nombre" value="<?php echo $Nombre; ?>">                  
                <span class="error" id="errornombre"></span>                                   
            </div>                     
	</div> 				
    </form>   						

    <?php
         break;
     case 'categoria':
         if (isset($objelemento)) {
             $IdCategoria = $objelemento->getIdCategoria();
             $SalarioBase = $objelemento->getSalarioBase();
             $HoraExtraNocturna = $objelemento->getHoraExtraNocturna();
             $HoraExtraNormal = $objelemento->getHoraExtraNormal();
             $HoraExtraFestivo = $objelemento->getHoraExtraFestivo();
         } else {
             $IdCategoria = "";
             $SalarioBase = "";
             $HoraExtraNocturna = "";
             $HoraExtraNormal = "";
             $HoraExtraFestivo = "";
         }


         if ($ope == "Modificar") {
             $ruta = "modificarlacategoria";
             $icon = "btn-modificar";
         }
         if ($ope == "Insertar") {
             $ruta = "insertarlacategoria";
             $icon = "btn-add";
         }
    ?>	    
     
    <!--------------------------------------- CATEGORIAS ----------------------------------------------------------->
    <?php
        if ($ope == "Modificar") {
    ?>
        <form class="w-75 pt-3" action="<?php echo $this->url("categorias", "listar") ?>" method="post">                   
            <input type="submit" name="listarcategorias" class="btn btn-previous" value="" />
        </form>                        
    <?php } ?>                       
                        
        <form class="w-50" action="<?php echo $this->url("categorias", $ruta); ?>" method="POST"  id="formulario" name="categoria" novalidate>
            <input  type="hidden" name="IdCategoria" value="<?php echo $IdCategoria; ?>"> 
            <h2 class="title mb-4"><?php echo $titulo; ?>                                             
            <button class="btn <?php echo $icon; ?>2 " type="submit"></button>
            <?php
                if($ope=="Insertar"){ 
            ?>
            <button class="btn btn-reset" type="reset"></button>
            <?php } ?> 
            </h2>                
            <div class="row form-group d-flex justify-content-center align-items-center">                                
                <div class="col-sm-6 mb-3">                  
                    <label class="control-label label" >Salario Base:</label>                               
                    <input required class="form-control" type="text" name="SalarioBase" id="salariobase" value="<?php echo $SalarioBase; ?>">         
                    <span class="error" id="errorsalariobase"></span>		
		</div>			
                <div class="col-sm-6 mb-3">		
                    <label class="control-label label" >Hora Normal:</label>
                    <input required class="form-control" type="text" name="HoraExtraNormal" id="horaextranormal" value="<?php echo $HoraExtraNormal; ?>">
                    <span class="error" id="errorhoraextranormal"></span>			
                </div>                            
            </div>			 
            <div class="row form-group d-flex justify-content-center align-items-center">                                        
		<div class="col-sm-6 mb-3">
                    <label class="control-label label"> Hora Nocturna:</label>
                    <input required class="form-control" type="text" name="HoraExtraNocturna" id="horaextranocturna" value="<?php echo $HoraExtraNocturna; ?>">
                    <span class="error" id="errorhoraextranocturna"></span>                        
		</div>						
		<div class="col-sm-6 mb-3">
                    <label class="control-label label">Hora Festivo:</label>
                    <input required class="form-control" type="text" name="HoraExtraFestivo" id="horaextrafestivo" value="<?php echo $HoraExtraFestivo; ?>">
                    <span class="error" id="errorhoraextrafestivo"></span>
		</div>		
            </div> 			
        </form>                                
					
    <?php                        
    break;
        case 'central':
            if (isset($objelemento)) {
                $IdCentral = $objelemento->getIdCentral();
                $Nombre = $objelemento->getNombre();
                $Telefono = $objelemento->getTelefono();
                $Constructor = $objelemento->getConstructor();
                $Provincia = $objelemento->getProvincia();
                $Poblacion = $objelemento->getPoblacion();
                $CP = $objelemento->getCP();
                $TipoTurbina = $objelemento->getTipoTurbina();
                $SaltoBruto = $objelemento->getSaltoBruto();
                $NumGeneradores = $objelemento->getNumGeneradores();
                $Potencia = $objelemento->getPotencia();
                $Foto = $objelemento->getFoto();
                $FotoAnterior = $objelemento->getFoto();
            } else {

                $IdCentral = "";
                $Nombre = "";
                $Telefono = "";
                $Constructor = "";
                $Provincia = "";
                $Poblacion = "";
                $CP = "";
                $TipoTurbina = "";
                $SaltoBruto = "";
                $NumGeneradores = "";
                $Potencia = "";
                $Foto = "";
                $FotoAnterior = "";
            }


            if ($ope == "Modificar") {
                $ruta = "modificarlaCentral";
                $icon = "btn-modificar";
            }
            if ($ope == "Insertar") {
                $ruta = "insertarlaCentral";
                $icon = "btn-add";
            }
    ?>
              						
	
    <!--------------------------------------- Centrales  ----------------------------------------------------------->
    <?php 
    if($ope=="Modificar"){                                
    ?>
    <form  class="w-75 pt-3"  action="<?php echo $this->url("centrales", "listar") ?>" method="post">                   
        <input type="submit" name="listarcentrales" class="btn btn-previous" value="" />
    </form>           
    <?php } ?>                            
                            
    <form class="w-50"  action="<?php echo $this->url("centrales", $ruta); ?>" method="POST"  enctype="multipart/form-data" id="formulario" name="central" novalidate>
        <input type="hidden" name="IdCentral" value="<?php echo $IdCentral;?>">                                 
        <h2 class="title mb-4"><?php echo $titulo; ?>                           
        <button onclick="alert2.classList.add('show')" class="btn <?php echo $icon; ?>2 " type="submit"></button>                                          
        <?php
        if($ope=="Insertar"){ 
        ?>
        <button class="btn btn-reset" type="reset"></button>
        <?php
        }                    
        ?>               
        </h2>             
       
        <div class="row form-group">                     
            <div class="col-sm-4 mb-3">
                <label class="control-label label" >Nombre:</label>
		<input required class="form-control" type="text" name="Nombre" id="nombre" value="<?php echo $Nombre; ?>">
                <span class="error" id="errornombre" value=""></span>
            </div>           
            <div class="col-sm-4 mb-3">
                <label class="control-label label"> Telefono:</label>
		<input required  type="text" class="form-control" name="Telefono" id="telefono"  value="<?php echo $Telefono; ?>">
               <span class="error" id="errortelefono"></span>
            </div>                      
            <div class="col-sm-4 mb-3">
                <label class="control-label label">Constructor:</label>
		<input required  type="text" class="form-control" name="Constructor" id="constructor" value="<?php echo $Constructor; ?>">
               <span class="error" id="errorconstructor"></span>
            </div>		
	</div>				
	<div class="row form-group">					
            <div class="col-sm-4 mb-3">
                <label class="control-label label" >Provincia:</label>
                <input required  type="text" class="form-control" name="Provincia" id="provincia" value="<?php echo $Provincia; ?>">
             <span class="error" id="errorprovincia"></span>
            </div>								
            <div class="col-sm-4 mb-3">
                <label class="control-label label" >Poblacion:</label>
		<input required  type="text" class="form-control" name="Poblacion" id="poblacion" value="<?php echo $Poblacion; ?>">
              <span class="error" id="errorpoblacion"></span>
            </div>
            <div class="col-sm-4 mb-3">                                            
		<label class="control-label label" >Codigo Postal:</label>
		<input required  type="text" class="form-control" name="CP" id="cp" value="<?php echo $CP;?>">
              <span class="error" id="errorcp"></span>
            </div>			
        </div>                	
	<div class="row form-group">
            <div class="col-sm-6 mb-3 d-flex flex-column align-items-center justify-content-center">                
		<label class="control-label label" >Tipo de turbina:</label>			
		<div class="d-flex flex-column">				
                    <label class="radio-container label2">Francis
                    <input required  type="radio" checked="checked" name="TipoTurbina" id="tipoturbina" value="Francis" required <?php if($TipoTurbina=="Francis") echo "checked";?>>
                    <span class="checkmark"></span>
                    </label>
                    <label class="radio-container label2">Pelton
                    <input required  type="radio" name="TipoTurbina" id="tipoturbina" value="Pelton" required <?php if($TipoTurbina=="Pelton") echo "checked";?>>
                    <span class="checkmark"></span>
                    </label>                            
                    <label class="radio-container label2">Kaplan
                    <input required  type="radio" name="TipoTurbina" id="tipoturbina" value="Kaplan" required <?php if($TipoTurbina=="Kaplan") echo "checked";?>>
                    <span class="checkmark"></span>
                    </label>                   
                </div>                        
              <span class="error" id="errortipoturbina"></span>                     
            </div>                                    
            <div class="col-sm-4 mb-3 p-3">
                <div>
                <label class="control-label label" >Salto Bruto:</label>
                <input required  type="text" class="form-control" name="SaltoBruto" id="saltobruto"  value="<?php echo $SaltoBruto; ?>">
                 <span class="error" id="errorsaltobruto"></span>
                </div>
           
                <div>
                <label class="control-label label" >Generadores:</label>
                <input required type="number" class="form-control" name="NumGeneradores" id="numgeneradores" min=0 max=100 value="<?php echo $NumGeneradores; ?>">
          <span class="error" id="errornumgeneradores"></span>
                </div>
                <div>
                <label class="control-label label" >Potencia:</label>
                <input required  type="text" class="form-control" name="Potencia" id="potencia" value="<?php echo $Potencia; ?>">
            <span class="error" id="errorpotencia"></span>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-6 mb-3">
                <label class="control-label label">Foto:</label>
                <input type="file" name="Foto" id="foto" accept="image/*" />
            <span class="error" id="errorfoto"></span>
            </div>
            <input type="hidden" name="FotoAnterior" value="<?php echo base64_encode($FotoAnterior) ?> " />                        
            <?php 
                if($ope=="Modificar"){
            ?>                    
                <div class="col-sm-6 mb-3">               
                    <label class="label">Foto Actual</label>       
                    <?php 
                        echo '<br><img class="formulario_img" src="data:image/jpeg;base64, ' . base64_encode($FotoAnterior) . '">';
                    ?>         
                </div>               
            <?php } ?>                    
            </div>                 
        </form>                  
                            
    <?php
        break;
        case 'empleado':

            if (isset($objelemento)) {

                $objetousuario = new UsuariosModel();
                $NumEmple = $objelemento->getNumEmple();
                $DNI = $objelemento->getDNI();
                $Nombre = $objelemento->getNombre();
                $Apellidos = $objelemento->getApellidos();
                $FechaNac = $objelemento->getFechaNac();
                $Telefono = $objelemento->getTelefono();
                $Email = $objelemento->getEmail();
                $Direccion = $objelemento->getDireccion();
                $Provincia = $objelemento->getProvincia();
                $Poblacion = $objelemento->getPoblacion();
                $CP = $objelemento->getCP();
                $Rol = $objetousuario->getUnUsuario($objelemento->getIdUsuario())->getRol();
                $IdCategoria = $objelemento->getIdCategoria();
                $CodDepart = $objelemento->getCodDepart();
                $IdCentral = $objelemento->getIdCentral();
                $Foto = $objelemento->getFoto();
                $FotoAnterior = $objelemento->getFoto();
                $IdUsuario = "";
            } else {
                $NumEmple = "";
                $DNI = "";
                $Nombre = "";
                $Apellidos = "";
                $FechaNac = "";
                $Telefono = "";
                $Email = "";
                $Direccion = "";
                $Provincia = "";
                $Poblacion = "";
                $CP = "";
                $Rol = "";
                $IdCategoria = "";
                $CodDepart = "";
                $IdCentral = "";
                $Foto = "";
                $FotoAnterior = "";
                $IdUsuario = "";
            }
            if ($ope == "Modificar") {
                $ruta = "modificarelemple";
                $icon = "btn-modificar";
            }
            if ($ope == "Insertar") {
                $ruta = "insertarelemple";
                $icon = "btn-add";
            }
    ?>                                       
                             
    <!--------------------------------------- Empleado ----------------------------------------------------------->
    <?php  
        if($ope=="Modificar" && $_SESSION['rol'] == "Admin" ){
            if(isset($_POST['valores'])){                
                    switch ($_POST['valores']){
                        case 'todas':                       
                            $val = $this->url("empleados", "listar");                          
                            $nombre = "listaremplestodos";                            
                            break;
                        case 'central':
                            $val = $this->url("empleados", "verporcentral");
                            $cen = $IdCentral;                  
                            $nombre = "listarporcentralemple";
                            break;                          
                    }
                }   
            if(isset($_POST['valores'])){
    ?>
                <form class="w-75 pt-3" action="<?php echo $val ?>" method="post">                   
                    <input type="submit" disabled name="<?php echo $nombre; ?>" class="btn btn-previous" value="" />
                    <input type="hidden" name="centrales" value="<?php echo $cen; ?>" />
                    <input type="hidden" name="val" value="<?php echo $_POST['valores']; ?>" />
                </form>
    <?php  }                 
    
            if(isset($valu) ){            
                if(intval($valu)==0){      
                   $caso = "todas";                   
    ?>             
                    <form class="w-75 pt-3" action="<?php echo $this->url("empleados", "listar"); ?>" method="post">                   
                        <input type="submit" name="<?php echo "listaremplestodos" ?>" class="btn btn-previous" value="" />              
                    </form>      
                    <?php
                    }else{
                        $caso = "central";
                   ?>
                    <form class="w-75 pt-3" action="<?php echo $this->url("empleados", "verporcentral"); ?>" method="post">                   
                        <input type="submit" name="<?php echo "listarporcentralemple" ?>" class="btn btn-previous" value="" />               
                        <input type="hidden" name="centrales" value="<?php echo $valu ?>">  
                        <input type="hidden" name="val" value="<?php echo $caso ?>" />
                    </form>
    <?php } } }?>     
                
    <form class="w-75" action="<?php echo $this->url("empleados", $ruta); ?>" method="POST"  enctype="multipart/form-data"  id="formulario" name="empleado" novalidate>                       	
	<input  type="hidden" name="NumEmple" value="<?php echo $NumEmple; ?>"> 
        <input type="hidden" name="centrales" value="<?php echo $cen; ?>" /> 
        <input type="hidden" name="dniactual" value="<?php echo $DNI; ?>" /> 
        <h2 class="title mb-4"><?php echo $titulo; ?> 
            <button class="btn <?php echo $icon; ?>2 " type="submit"></button>
            <?php
            if($ope=="Insertar"){ 
            ?>
            <button class="btn btn-reset" type="reset"></button>
            <?php } ?>
        </h2>                    
        <div class="row form-group">
            <div class="col-sm-4 mb-3">
                <label class="control-label label" >DNI:</label>
                <input required class="form-control" type="text" name="DNI" id="dni" value="<?php echo $DNI; ?>">
                <span class="error" id="errordni"></span>  
            </div>			
            <div class="col-sm-4 mb-3">
                <label class="control-label label"> Nombre:</label>
                <input required  type="text" class="form-control" name="Nombre" id="nombre"  value="<?php echo $Nombre; ?>">
                <span class="error" id="errornombre"></span>
            </div>				
            <div class="col-sm-4 mb-3">
                <label class="control-label label">Apellidos:</label>
		<input required  type="text" class="form-control" name="Apellidos" id="apellidos" value="<?php echo $Apellidos; ?>">
                <span class="error" id="errorapellidos"></span>
            </div>			
	</div>			
	<div class="row form-group">								
            <div class="col-sm-4 mb-3">
                <label class="control-label label" >Fecha de nacimiento:</label>
                <input required class="form-control" type="date" name="FechaNac" id="fechanac" value="<?php echo $FechaNac; ?>">
                <span class="error" id="errorfechanac"></span>  
            </div>
            <div class="col-sm-4 mb-3">
                <label class="control-label label"> Teléfono:</label>
                <input required  type="text" class="form-control" name="Telefono" id="telefono"  value="<?php echo $Telefono; ?>">
                <span class="error" id="errortelefono"></span>
            </div>
            <div class="col-sm-4 mb-3">
                <label class="control-label label">Email:</label>
                <input required  type="text" class="form-control" name="Email" id="email" value="<?php echo $Email; ?>">
                <span class="error" id="erroremail"></span>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-4 mb-3">
                <label class="control-label label" >Direccion:</label>
                <input required class="form-control" type="text" name="Direccion" id="direccion" value="<?php echo $Direccion; ?>">
                <span class="error" id="errordireccion"></span>  
            </div>
            <div class="col-sm-4 mb-3">
                <label class="control-label label"> Provincia:</label>
                <input required  type="text" class="form-control" name="Provincia" id="provincia"  value="<?php echo $Provincia; ?>">
                <span class="error" id="errorprovincia"></span>
            </div>
            <div class="col-sm-4 mb-3">
                <label class="control-label label">Población:</label>
                <input required  type="text" class="form-control" name="Poblacion" id="poblacion" value="<?php echo $Poblacion; ?>">
                <span class="error" id="errorpoblacion"></span>
            </div>
        </div>
        <div class="row form-group">                             
            <div class="col-sm-4 mb-3">
                <label class="control-label label" >Código Postal:</label>
                <input required class="form-control" type="text" name="CP" id="cp" value="<?php echo $CP; ?>">
                <span class="error" id="errorcp"></span>  
            </div>
           
            
              <div class="col-sm-4 mb-3">
            <?php $desactivar = "hidden"; ?>
            <label class="control-label label" <?php if($_SESSION['rol']!='Admin' && isset($_SESSION['idemple'])){ echo $desactivar;} ?> >Rol de usuario:</label>
            <select required <?php if($_SESSION['rol']!='Admin' && isset($_SESSION['idemple'])){ echo $desactivar;} ?> class="selecc" name="Rol" id="rolusu">
            <?php
                echo '<option  selected disabled value="">Selecciona una opción</option>';
                    foreach ($elementosusu as $fila) {
                        $selec = "";
                        if ($fila['Rol'] == $Rol) { 
                            $selec = "selected";
                        }
                        echo '<option ' . $selec . ' value="' . $fila['Rol'] . '">' . $fila['Rol'] . '</option>';
                    } //foreach                            
            ?>
            </select>                                                     
            <span class="error" id="errorrolusu"></span>
            </div>  
            
                        
            
        </div>
        <div class="row form-group">
            <div class="col-sm-4 mb-3">
            <?php $desactivar = "hidden"; ?>
            <label class="control-label label" <?php if($_SESSION['rol']!='Admin' && isset($_SESSION['idemple'])){ echo $desactivar;} ?> >Categoria:</label>
            <select required <?php if($_SESSION['rol']!='Admin' && isset($_SESSION['idemple'])){ echo $desactivar;} ?> class="selecc" name="IdCategoria" id="idcategoria">
            <?php
                echo '<option  selected disabled value="">Selecciona una opción</option>';
                    foreach ($elementoscat as $fila) {
                        $selec = "";
                        if ($fila->getIdCategoria() == $IdCategoria) { 
                            $selec = "selected";
                        }
                        echo '<option ' . $selec . ' value="' . $fila->getIdCategoria() . '">' . $fila->getIdCategoria() . '</option>';
                    } //foreach                            
            ?>
            </select>                                                     
            <span class="error" id="erroridcategoria"></span>
            </div>  
            <div class="col-sm-4 mb-3">
                <label class="control-label label" <?php if($_SESSION['rol']!='Admin' && isset($_SESSION['idemple'])){ echo $desactivar;} ?> >Departamento:</label>
                <select required <?php if($_SESSION['rol']!='Admin' && isset($_SESSION['idemple'])){ echo $desactivar;} ?> class="selecc" name="CodDepart" id="coddepart">
                <?php
                    echo '<option selected disabled value="">Selecciona una opción</option>';
                    foreach ($elementosdep as $fila) {
                        $selec = "";
                        if ($fila->getCodDepart() == $CodDepart) { //la que voy a visualizar ahora coincide con la variable de sesion??
                            $selec = "selected";
                        }
                        echo '<option ' . $selec . ' value="' . $fila->getCodDepart() . '">' . $fila->getNombre() . '</option>';
                    } //foreach
                ?>
                </select>
                <span class="error" id="errorcoddepart"></span>
            </div>
            <div class="col-sm-4 mb-3">
                <label class="control-label label" <?php if($_SESSION['rol']!='Admin' && isset($_SESSION['idemple'])){ echo $desactivar;} ?> >Central:</label>
                    <select required <?php if($_SESSION['rol']!='Admin' && isset($_SESSION['idemple'])){ echo $desactivar;} ?> class="selecc" name="IdCentral" id="idcentral">
                        <?php
                        echo '<option ' . $selec . ' value="">Selecciona una opción</option>';
                        foreach ($elementos as $fila) {
                            $selec = "";
                            if ($fila->getIdCentral() == $IdCentral) { //la que voy a visualizar ahora coincide con la variable de sesion??
                                $selec = "selected";
                            }
                            echo '<option ' . $selec . ' value="' . $fila->getIdCentral() . '">' . $fila->getNombre() . '</option>';
                            } //foreach
                        ?>
                    </select>
                    <span class="error" id="erroridcentral"></span>  
            </div>
        </div>                                       
        <div class="row form-group">
            <div class="col-sm-6 mb-3">
                <label class="control-label label" >Foto:</label>
                <input type="file" name="Foto" id="foto" accept="image/*" />
                <span class="error" id="errorfoto"></span>
            </div>
            <input type="hidden" name="FotoAnterior" value="<?php echo base64_encode($FotoAnterior)?> " />  
            <?php 
                if($ope=="Modificar"){
            ?>
            <div class="col-sm-6 mb-3">
                <label class="label">Foto Actual</label>
            <?php 
                echo '<br><img class="formulario_img2" src="data:image/jpeg;base64, ' . base64_encode($FotoAnterior) . '">';
            ?>
            </div>
            <?php  } ?>
        </div>                             
    </form>  
    
    
     <?php
            break;
        case 'producto':
               if(isset($objelemento)){
  $CodProd=$objelemento->getCodProd();
   $Nombre=$objelemento->getNombre();
    $Descripcion=$objelemento->getDescripcion();
    $Marca=$objelemento->getMarca();
    $Stock=$objelemento->getStock();
    $Foto=$objelemento->getFoto();
    $FotoAnterior=$objelemento->getFoto();
 }else{
   $CodProd="";
   $Nombre="";
    $Descripcion="";
    $Marca="";
    $Stock="";
    $Foto="";
    $FotoAnterior="";  
 }
 
  if($ope=="Modificar"){
     $ruta="modificarelproducto";
     $icon="btn-modificar";
 }
 if($ope=="Insertar"){     
     $ruta="insertarelproducto";
     $icon="btn-add";      
 }
    ?>
              
    <!--------------------------------------- Producto ----------------------------------------------------------->
    <?php
    if($ope=="Modificar"){
    ?>
        <form class="w-75 pt-3" action="<?php echo $this->url("productos", "listar") ?>" method="post">                   
            <input type="submit" name="listarproductos" class="btn btn-previous" value="" />
        </form>    
    <?php } ?>
        <form  class="w-50" action="<?php echo $this->url("productos", $ruta); ?>" method="POST"  enctype="multipart/form-data" id="formulario" name="producto" novalidate>
            <input  type="hidden" name="CodProd" value="<?php echo $CodProd; ?>"> 
            <h2 class="title mb-4"><?php echo $titulo; ?> 
            <button class="btn <?php echo $icon; ?>2 " type="submit"></button>
            <?php
            if($ope=="Insertar"){ 
            ?>
            <button class="btn btn-reset" type="reset"></button>
            <?php } ?>
            </h2>
            <div class="row form-group">
		<div class="col-sm-4 mb-3">
                    <label class="control-label label" >Modelo:</label>
                    <input required class="form-control" type="text" name="Nombre" id="modelo" value="<?php echo $Nombre; ?>">
                    <span class="error" id="errornombre"></span>  
		</div>
                <div class="col-sm-4 mb-3">
                    <label class="control-label label"> Marca:</label>
                    <input required  type="text" class="form-control" name="Marca" id="marca"  value="<?php echo $Marca; ?>">
                    <span class="error" id="errormarca"></span>
		</div>
                <div class="col-sm-4 mb-3">
                    <label class="control-label label">Stock:</label>
                    <input required  type="number"  min=0 max=100  class="form-control" name="Stock" id="stock" value="<?php echo $Stock; ?>">
                    <span class="error" id="errorstock"></span>
		</div>
            </div>      
            <div class="row form-group">
		<div class="col-sm-8 mb-3">
                    <label class="control-label label" >Descripción:</label>
                    <textarea class="form-control" name="Descripcion" id="descripcion" cols="50" rows="5"><?php echo $Descripcion; ?></textarea>
                    <span class="error" id="errordescripcion"></span>
		</div>
		
            </div>      
            <div class="row form-group">
		<div class="col-sm-6 mb-3">
                    <label class="control-label label" >Foto:</label>
                    <input type="file" name="Foto" id="foto" accept="image/*" />
                    <span class="error" id="errorfoto"></span>
                </div>
		<input type="hidden" name="FotoAnterior" value="<?php echo base64_encode($FotoAnterior)?> " />  
		<?php 
                if($ope=="Modificar"){
                ?>
                <div class="col-sm-6 mb-3">
                    <label class="label">Foto Actual</label>
                    <?php 
                    echo '<br><img class="formulario_img2" src="data:image/jpeg;base64, ' . base64_encode($FotoAnterior) . '">';
                    ?>
                </div>
                <?php } ?>
            </div>
        </form>       
    <?php
            break;
        case 'almacen':
            if (isset($objelemento)) {
                $CodAlmacen = $objelemento->getCodAlmacen();
                $Tipo = $objelemento->getTipo();
                $IdCentral = $objelemento->getIdCentral();
            } else {
                $CodAlmacen = "";
                $Tipo = "";
                $IdCentral = "";
            }
            if ($ope == "Modificar") {
                $ruta = "modificarelalmacen";
                $icon = "btn-modificar";
            }
            if ($ope == "Insertar") {
                $ruta = "insertarelalmacen";
                $icon = "btn-add";
            }
    ?>               
    <!--------------------------------------- Almacen ----------------------------------------------------------->
    <?php
    if($ope=="Modificar"){
     
    ?>
    <?php      
    if(isset($_POST['valores'])){                 
        switch ($_POST['valores']){
            case 'todas':                       
                $val = $this->url("almacenes", "listar");                           
                $nombre = "listartodos";
                break;
            case 'central':
                $val = $this->url("almacenes", "verporcentral");
                $cen = $IdCentral;                  
                $nombre = "listarporcentral";
                break;
        }
    }     
    if(isset($_POST['valores'])){
    ?>
    <form class="w-75 pt-3" action="<?php echo $val ?>" method="post">                   
        <input type="submit" disabled name="<?php echo $nombre; ?>" class="btn btn-previous" value="" />
        <input type="hidden" name="centrales" value="<?php echo $cen; ?>" />
        <input type="hidden" name="val" value="<?php echo $_POST['valores']; ?>" />
    </form>
    <?php
    }
    if(isset($valu)){
        if(intval($valu)==0){                ?>
            <form class="w-75 pt-3" action="<?php echo $this->url("almacenes", "listar"); ?>" method="post">                   
                <input type="submit" name="<?php echo "listartodos" ?>" class="btn btn-previous" value="" />               
            </form>
            <?php
            }else{
            ?>
                <form class="w-75 pt-3" action="<?php echo $this->url("almacenes", "verporcentral"); ?>" method="post">                   
                    <input type="submit" name="<?php echo "listarporcentral" ?>" class="btn btn-previous" value="" />               
                    <input type="hidden" name="centrales" value="<?php echo $valu ?>">    
                </form>
            <?php
               }
            }
            }?>
            <form  action="<?php echo $this->url("almacenes", $ruta); ?>" method="POST"   id="formulario" name="almacen" novalidate>
                <input  type="hidden" name="CodAlmacen" value="<?php echo $CodAlmacen; ?>"> 
                <input type="hidden" name="centrales" value="<?php echo $cen; ?>" /> 
                <h2 class="title mb-4"><?php echo $titulo; ?> 
                    <?php
                       if($ope=="Modificar"){
                        $disabled=''; 
                       }else{
                          $disabled='disabled'; 
                       }                   
                    
                     ?>
                <button id="boton" <?php echo $disabled; ?> class="btn <?php echo $icon; ?>2 " type="submit"></button>
                <?php
                if($ope=="Insertar"){ 
                ?>
                <button class="btn btn-reset" type="reset"></button>
                <?php
                }
                ?>
                </h2>
                <div class="row form-group d-flex justify-content-center align-items-center">
                    <div class="col-sm-5 mb-3">
                        <label class="control-label label" >Tipo:</label>
			<div class="p-t-10 d-flex flex-column ">
                            <label class="radio-container m-r-45 label2">General
                            <input type="radio" checked="checked" name="Tipo" id="tipo" value="General" required <?php if($Tipo=="General") echo "checked";?>>
                            <span class="checkmark"></span>
                            </label>
                            <label class="radio-container label2">Repuesto
                            <input type="radio" name="Tipo" id="tipo" value="Repuesto" required <?php if($Tipo=="Repuesto") echo "checked";?>>
                            <span class="checkmark"></span>
                            </label>
                        </div>
                        <span class="error" id="errortipo"></span>
                    </div>
                    <div class="col-sm-7 mb-3">
                        <label class="control-label label"> Central:</label>
    		        <select  onChange="activa_boton(this,this.form.boton)" class="selecc" name="IdCentral" id="idcentral">
                        <?php
                            echo '<option selected disabled value="">Selecciona una opción</option>';
                                foreach ($elementos as $fila) {
                                    $selec = "";
                                    if ($fila->getIdCentral() == $IdCentral) { 
                                        $selec = "selected";
                                    }
                                    echo '<option ' . $selec . ' value="' . $fila->getIdCentral() . '">' . $fila->getNombre() . '</option>';
                                } //foreach
                        ?>
                        </select>
                        <span class="error" id="erroridcentral"></span>
                    </div>
                </div>      
            </form>       
            <?php
            break;
        case 'proveedor':
            if (isset($objelemento)) {
                $IdProveedor = $objelemento->getIdProveedor();
                $Nombre = $objelemento->getNombre();
                $CIF = $objelemento->getCIF();
                $Telefono = $objelemento->getTelefono();
                $Direccion = $objelemento->getDireccion();
                $Provincia = $objelemento->getProvincia();
                $Poblacion = $objelemento->getPoblacion();
                $CP = $objelemento->getCP();
            } else {
                $IdProveedor = "";
                $Nombre = "";
                $CIF = "";
                $Telefono = "";
                $Direccion = "";
                $Provincia = "";
                $Poblacion = "";
                $CP = "";
            }
            if ($ope == "Modificar") {
                $ruta = "modificarelproveedor";
                $icon = "btn-modificar";
            }
            if ($ope == "Insertar") {
                $ruta = "insertarelproveedor";
                $icon = "btn-add";
            }
            ?>
    <!--------------------------------------- Proveedor ----------------------------------------------------------->
    <?php
    if($ope=="Modificar"){
    ?>
        <form class="w-75 pt-3" action="<?php echo $this->url("proveedores", "listar") ?>" method="post">                   
            <input type="submit" name="listarproveedores" class="btn btn-previous" value="" />
        </form>
    <?php } ?>
        <form class="w-50" action="<?php echo $this->url("proveedores", $ruta); ?>" method="POST"   id="formulario" name="proveedor" novalidate>
            <input  type="hidden" name="IdProveedor" value="<?php echo $IdProveedor; ?>"> 
            <h2 class="title mb-4"><?php echo $titulo; ?> 
            <button class="btn <?php echo $icon; ?>2 " type="submit"></button>
            <?php
            if($ope=="Insertar"){ 
            ?>
                <button class="btn btn-reset" type="reset"></button>
            <?php } ?>
            </h2>
            <div class="row form-group">
                <div class="col-sm-4 mb-3">
                    <label class="control-label label" >Nombre:</label>
		    <input required class="form-control" type="text" name="Nombre" id="nombre" value="<?php echo $Nombre; ?>">
                    <span class="error" id="errornombre"></span>  
		</div>
                <div class="col-sm-4 mb-3">
                    <label class="control-label label"> Telefono:</label>
		    <input required  type="text" class="form-control" name="Telefono" id="telefono"  value="<?php echo $Telefono; ?>">
                    <span class="error" id="errortelefono"></span>
		</div>
                <div class="col-sm-4 mb-3">
                    <label class="control-label label">CIF:</label>
		    <input required  type="text"  class="form-control" name="CIF" id="cif" value="<?php echo $CIF; ?>">
                    <span class="error" id="errorcif"></span>
		</div>
	    </div>      
            <div class="row form-group">
                <div class="col-sm-4 mb-3">
                    <label class="control-label label" >Direccion:</label>
		    <input required class="form-control" type="text" name="Direccion" id="direccion" value="<?php echo $Direccion; ?>">
                    <span class="error" id="errordireccion"></span>  
		</div>
		<div class="col-sm-4 mb-3">
                    <label class="control-label label"> Provincia:</label>
                    <input required  type="text" class="form-control" name="Provincia" id="provincia"  value="<?php echo $Provincia; ?>">
                    <span class="error" id="errorprovincia"></span>
		</div>
                <div class="col-sm-4 mb-3">
                    <label class="control-label label">Poblacion:</label>
                    <input required  type="text"  class="form-control" name="Poblacion" id="poblacion" value="<?php echo $Poblacion; ?>">
                    <span class="error" id="errorpoblacion"></span>
		</div>
            </div>    
            <div class="row form-group">
                <div class="col-sm-4 mb-3">
                    <label class="control-label label" >Código postal:</label>
                    <input required class="form-control" type="text" name="CP" id="cp" value="<?php echo $CP; ?>">
                    <span class="error" id="errorcp"></span>  
		</div>
            </div>    
        </form>       
        <?php
            break;
        }
       }
     ?>
        <br>
        <!------------------------------------------> 
        </div>
        </div>
        <!-- FIN SIDEBAR -->
    </div>

                    
                    
               

            

                                
                             
            
                          				
					
				 
                                                    
					
				
					
						
					
				               


       

               
                    
                         
                  
         
        
            


               


              
            
            
            
            
            
           
            

        
           
           
            
     
    
    


 
 
 
 
 
 
            
              
                            


            
                


                   		
                                        
                                          




                                           



                                   
                                  



                                   



                                            


                                       
                                   				
					
                                    
                            
                                    
				
                              
      
				
						
					
					
                   
                             
                        
                
             
                  
                        
                 
          
                            
                                  
                                                     
                                                     
                                         
                                 
 
            
 
            
            
            
         
          
    
           
     
           
        
               
               
            
            
               
                 
   
             
                
                
       
          
               
                                        
                             
                        
                        
                        
                
            
            			


                                       

                                                                              
                                        					
					
					
                                    
				
              
                            				
				
					
						
					
					
                                    
                            
                                   
				
				
					
						
				
					
			
				
						
					
					
                 
                                    
                                   
				
					
						
					
					
				
                             
            
			
    
       
                
                          	
				          
                                  
				
					
						
					
					
				
					
						
					
					
                                    
                            
                                    
				            
                    
                              
                                            
                                  
                        
           
      
               
               
               
      
            

              
                                                   
                                 
                                  
				
           