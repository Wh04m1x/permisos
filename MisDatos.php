<?php
    session_start();
    include('class.consultas.php');
    include('clases/class.encriptar.php');
    $ObjetosPermisos = new Permisos;
    $idMenu          = 0;
    $IdUsuario       = $_SESSION['USERID'];
    if(isset($_GET["a"])){
        $idMenu         = decrypt($_GET["a"]);

    }
    $BuscarUsuario = array();
    if($idMenu!=0){
        $BuscarUsuario = $ObjetosPermisos->BuscarUsuario($IdUsuario);
    }
    
 ?>
<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="utf-8">
        <title>.: Permisos de Usuarios</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Ejemplo Permisos con Desarrollos PHP">
        <meta name="author" content="Ing. Manuel Cortes Crisanto">

        <!-- CSS -->
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Oleo+Script:400,700'>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script type="text/javascript">
        function Regresar(){
            window.history.back();
        }
       
        </script>

    </head>

    <body>

        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="logo span4">
                        <h1><a href="">Desarrollos en PHP<span class="red">.</span></a></h1>
                    </div>
                    <div class="links span8">
                        <br/>
                       Bienvenid@: <?php echo $_SESSION['USERNO']; ?> | <a href="">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-container container">
            <div class="row">
                <center><img src="assets/img/regresar.png" onclick="Regresar()" style="cursor:pointer; " width="50px"></center>
                <hr />
                <blockquote>
                  <p>Mis Datos: Modifique Sus datos.</p>
                  <small>Desarrollado por: <cite title="Nombre Apellidos">Ing. Manuel Cortes Crisanto</cite>, Especialista en Desarrollo de Software Net, PHP</small>
                </blockquote>
                <hr/>
                 <center>
                    <?php
                    if($idMenu!=0  and $IdUsuario!=0){
                        if(!empty($BuscarUsuario)){
                            foreach ($BuscarUsuario as $key => $value) {
                                # code...
                    ?>
                    
                    <div id="Mensaje2" width="200px"></div><br/>
                    <div class="register" style="width: 570px;">
                   
                    <form action="" method="post" enctype="multipart/form-data" class="formulario">
                        <h2>Mis Datos [<span class="red"><strong><?php echo $value['NOMBRE']." ".$value['APELLIDOS']; ?></strong></span>]</h2>
                        <table width="250px" border=0>
                            <tr>
                                <td colspan=2>
                                    <div id="Mensaje"></div><br/>
                                    
                                </td>
                            </tr>
                             <tr>
                                <td align="right">Nombre:</td>
                                <td><input type="text" id="txtNombre" value="<?php echo $value['NOMBRE']; ?>" name="txtNombre" style="width:350px;height: 30px;" ></td>
                            </tr>

                             <tr>
                                <td align="right">Apellidos:</td>
                                <td><input type="text" id="txtApellidos" value="<?php echo $value['APELLIDOS']; ?>" name="txtApellidos" style="width:350px;height: 30px;" ></td>
                            </tr>

                            <tr>
                                <td colspan=2>
                                    <input type="hidden" id="txtEmail" value="<?php echo $value['CORREO']; ?>" name="txtEmail">
                                    <input type="hidden" id="cbPerfil" value="<?php echo $value['TIPO_USUARIO']; ?>" name="cbPerfil">
                                    <input type="hidden" id="cbEstatus" value="<?php echo $value['ESTATUS']; ?>" name="cbEstatus">
                                    <input type="hidden" id="id" value="<?php echo $IdUsuario; ?>" name="id">
                                </td>
                            </tr>

                           

                           
                            <tr>
                                <td colspan=2><button type="submit">Guardar Información</button></td>
                            </tr>


                        </table>
                        

                        
                    </form>
                    
                </div>
                    <?php
                            }
                        }else{
                            //Nuevo
                            ?>
                   
                </div>

            </td>

            
                        </tr>
                    </table>

              
                            <?php
                        }
                    }else{
                            echo "<br/>";
                            include("NoAcceso.php");
                    }
                     ?>
                  
                </center>
            </div>
        </div>

        <!-- Javascript -->
        <script src="assets/js/jquery-1.8.2.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/jsMisDatos.js"></script>
    </body>

</html>

