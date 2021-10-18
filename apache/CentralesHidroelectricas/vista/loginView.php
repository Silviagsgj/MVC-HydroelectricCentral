
<html lang="es">
    <head>
        <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="http://localhost/CentralesHidroelectricas/recursos/fontawesome/css/all.css">
                    <link rel="stylesheet" href="http://localhost/CentralesHidroelectricas/recursos/bootstrap/css/bootstrap.css">  
                        <link rel="stylesheet" href="http://localhost/CentralesHidroelectricas/recursos/css/estilos.css">                             
        
                            <title>Login</title>
                            </head>
                            <body class="body d-flex flex-column justify-content-center align-items-center bg-login">
                               
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

                                <div class="container">
                                    <div class="card  border-0 shadow-lg" >
                                        <div class="card-body p-0">
                                            <div class="row">
                                                <div class="col-12 col-md-5 fondologin" ></div>
                                                <div class="col-12 col-md-7 p-5 d-flex flex-column justify-content-center align-items-center">
                                                    <h4 class="mb-4 title"><?php echo $titulo; ?></h4>
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
                                                    <form class="text-center" action="<?php echo $this->url("centrales", "miconexion"); ?>" method="POST">
                                                        <div class="form-group">
                                                            <input type="text" required class="form-control mb-3" id="exampleInputUser" name="username" placeholder="Usuario" value="<?php echo $username; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" required class="form-control mb-3" name="clave" id="exampleInputPassword" placeholder="Contraseña" value="<?php echo $clave; ?>">
                                                        </div>
                                                        <input type="submit" class="btn btn-theme espacio" name="conectarse" value="Login" />
                                                    </form>
                                                    
                                                    
                                                    
                                                          
                
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <script src="http://localhost/CentralesHidroelectricas/recursos/bootstrap/js/bootstrap.js"></script>
                                    <script src="http://localhost/CentralesHidroelectricas/recursos/js/script.js"></script>
                            </body>
</html>