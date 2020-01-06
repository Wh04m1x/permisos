<?php
    session_start();
    include('class.consultas.php');
    include('clases/class.encriptar.php');
    $ObjetosPermisos = new Permisos;
    $idMenu          = 0;
    $PermisoActivo   = 0;
    $IdUsuario       = 0;
    $bandera         = 0;
    if(isset($_GET["a"]) and isset($_GET["b"]) and isset($_GET["c"])){
        $idMenu         = decrypt($_GET["a"]);
        $PermisoActivo  = decrypt($_GET["b"]);
        $IdUsuario      = decrypt($_GET["c"]);

    }
    $BuscarUsuario = array();
    if($idMenu!=0 and $PermisoActivo!=0 and $IdUsuario!=0){
        $BuscarUsuario = $ObjetosPermisos->BuscarUsuario($IdUsuario);
    }
    if(!empty($BuscarUsuario)){
        $bandera = 1;
    }
    $Perfiles    = $ObjetosPermisos->Perfiles();
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
                  <p>Usuarios: Modifique/Da de alta un nuevo Usuario, Eligiendo su Perfil de Usuario.</p>
                  <small>Desarrollado por: <cite title="Nombre Apellidos">Ing. Manuel Cortes Crisanto</cite>, Especialista en Desarrollo de Software Net, PHP</small>
                </blockquote>
                <hr/>
                 <center>
                    <?php
                    if($idMenu!=0 and $PermisoActivo!=0 and $IdUsuario!=0){
                        if(!empty($BuscarUsuario)){
                            foreach ($BuscarUsuario as $key => $value) {
                                $EstatusUsuario   = $value['ESTATUS'];
                                $TipoUsuario      = $value['TIPO_USUARIO'];
                                # code...
                    ?>
                    
                    <div id="Mensaje2" width="200px"></div><br/>
                    <div class="register" style="width: 570px;">
                   
                    <form action="" method="post" enctype="multipart/form-data" class="formulario">
                        <h2>Editar Perfil <span class="red"><strong><?php echo $value['NOMBRE']." ".$value['APELLIDOS']; ?></strong></span></h2>
                        <table width="250px" border=0>
                            <tr>
                                <td colspan=2>
                                    <div id="Mensaje"></div><br/>
                                    <input type="hidden" id="txtBandera" value="<?php echo $bandera; ?>" name="txtBandera">
                                    <input type="hidden" id="txtidMenu" value="<?php echo $idMenu; ?>" name="txtidMenu">
                                    <input type="hidden" id="id" value="<?php echo $IdUsuario; ?>" name="id">
                                    <input type="hidden" id="control1" value="0" name="control1">
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
                                <td colspan=2><input type="hidden" id="txtEmail" value="<?php echo $value['CORREO']; ?>" name="txtEmail" style="width:350px;height: 30px;" ></td>
                            </tr>

                           <tr>
                                <td align="right">Perfil:</td>
                                <td>
                                    <select name="cbPerfil" id="cbPerfil" style="width:350px;height: 30px;">
                                        <option value="0">---Seleccione Perfil---</option>
                                        <?php
                                            if(!empty($Perfiles)){
                                                foreach ($Perfiles as $key => $value) {
                                                    # code...
                                                    $ActivoPerfil = "";
                                                    if($TipoUsuario == $value['ID']){
                                                        $ActivoPerfil = "selected";
                                                    }
                                                    if($value['ESTATUS']==1){
                                                        echo "<option value='".$value['ID']."' ".$ActivoPerfil.">".$value['DESCRIPCION']."</option>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td align="right"> Estatus:</td>
                                <td>
                                    <select name="cbEstatus" id="cbEstatus" style="width:350px;height: 30px;">
                                        <option value="1" <?php if($EstatusUsuario==1){ echo "selected";} ?>>Activo</option>
                                        <option value="0" <?php if($EstatusUsuario==0){ echo "selected";} ?>>Inactivo</option>
                                    </select>
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
                                <div id="Mensaje2" width="200px"></div><br/>
                    <table>
                        <tr>
                            <td>
                                <div class="register" style="width: 570px;">
                   
                    <form action="" method="post" enctype="multipart/form-data" class="formulario">
                        <h2>Nuevo <span class="red"><strong>Usuario</strong></span></h2>
                        <table width="250px" border=0>
                            <tr>
                                <td colspan=2>
                                    <div id="Mensaje"></div><br/>
                                    <input type="hidden" id="txtBandera" value="<?php echo $bandera; ?>" name="txtBandera">
                                    <input type="hidden" id="txtidMenu" value="<?php echo $idMenu; ?>" name="txtidMenu">
                                    <input type="hidden" id="id" value="0" name="id">
                                    <input type="hidden" id="control1" value="0" name="control1">
                                </td>
                            </tr>
                            <tr>
                                <td align="right">Nombre:</td>
                                <td><input type="text" id="txtNombre" value="" name="txtNombre" style="width:350px;height: 30px;" ></td>
                            </tr>

                             <tr>
                                <td align="right">Apellidos:</td>
                                <td><input type="text" id="txtApellidos" value="" name="txtApellidos" style="width:350px;height: 30px;" ></td>
                            </tr>

                            <tr>
                                <td align="right">Email:</td>
                                <td><input type="text" id="txtEmail" value="" name="txtEmail" style="width:350px;height: 30px;" ></td>
                            </tr>

                           <tr>
                                <td align="right">Perfil:</td>
                                <td>
                                    <select name="cbPerfil" id="cbPerfil" style="width:350px;height: 30px;">
                                        <option value="0">---Seleccione Perfil---</option>
                                        <?php
                                            if(!empty($Perfiles)){
                                                foreach ($Perfiles as $key => $value) {
                                                    # code...
                                                    if($value['ESTATUS']==1){
                                                        echo "<option value='".$value['ID']."'>".$value['DESCRIPCION']."</option>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td align="right"> Estatus:</td>
                                <td>
                                    <select name="cbEstatus" id="cbEstatus" style="width:350px;height: 30px;">
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2><button type="submit">Guardar Información</button></td>
                            </tr>


                        </table>
                    
                    </form>
                    
                </div>

            </td>

            <td>
               &nbsp; <div id="content2" style="display:none;">Hola, soy un nuevo div!</div>
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
        <script src="assets/js/jsUsuarios.js"></script>
    </body>

</html>

