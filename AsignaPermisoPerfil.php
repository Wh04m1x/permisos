<?php
    session_start();
    include('class.consultas.php');
    include('clases/class.encriptar.php');
    $ObjetosPermisos = new Permisos;
    $idMenu          = 0;
    $PermisoActivo   = 0;
    $IdmenuHijo      = 0;
    if(isset($_GET["a"]) and isset($_GET["b"]) and isset($_GET["c"])){
        $idMenu         = decrypt($_GET["a"]);
        $PermisoActivo  = decrypt($_GET["b"]);
        $IdmenuHijo     = decrypt($_GET["c"]);

    }
    $PerfilesEncontrados = array();
    $MenuSistema         = array();  
    $IconosSistema       = array();  
    if($idMenu!=0 and $PermisoActivo!=0 and $IdmenuHijo!=0){
        $PerfilesEncontrados = $ObjetosPermisos->BuscarPerfiles($IdmenuHijo);
        $MenuSistema         = $ObjetosPermisos->listamenu();
        $IconosSistema       = $ObjetosPermisos->iconos();
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
       function writeData(valor) {
            var EstatusCheck= "";
            var ValorActual = document.getElementById(valor).value;
            ValorActual     = ValorActual.split('|');
            var JidIcono    = ValorActual[0];//Id del icono
            var JPermiso    = ValorActual[1];//Obtenemos estatus del permiso actual si es 
            var JIdPerfil   = ValorActual[2];//Obtenemos el id del perfil
            var IdRadioButt = ValorActual[3];//Id del radio button para cambiar su estado
            var NuevoValor  = "";

            if(JPermiso==0){
                EstatusCheck = 1;
            }else{
                EstatusCheck = 0;
            }
            if(EstatusCheck==1){
                document.getElementById(IdRadioButt).checked=true;
            }else{
                document.getElementById(IdRadioButt).checked=false;
            }
            NuevoValor = JidIcono+"|"+EstatusCheck+"|"+JIdPerfil+"|"+IdRadioButt;
            document.getElementById(valor).value = NuevoValor;
        }
       </script>
       <!-- Javascript -->
        <script src="assets/js/jquery-1.8.2.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/jsPerfilesPermisos.js"></script>

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
                  <p>Asignar Permisos a Perfiles: Asignación de permisos a Perfiles.</p>
                  <small>Desarrollado por: <cite title="Nombre Apellidos">Ing. Manuel Cortes Crisanto</cite>, Especialista en Desarrollo de Software Net, PHP</small>
                </blockquote>
                <hr/>
                 <center>
                    <?php
                        if(!empty($PerfilesEncontrados)){
                            foreach ($PerfilesEncontrados as $key => $value) {
                                # code...
                    ?>
                    <div id="Mensaje2" width="200px"></div><br/>
                    <div class="register" style="width: 670px;">
                   
                    <form action="" method="post" enctype="multipart/form-data" class="formulario">
                        <h3>Asignar Permisos al Perfil <span class="red"><strong><?php echo $value['DESCRIPCION']; ?></strong></span></h3>
                        <hr/>
                        <table width="250px" border=0>
                            <tr>
                                <td colspan=2>
                                    <div id="Mensaje"></div><br/>
                                    <input type="hidden" id="txtidMenu" value="<?php echo $idMenu; ?>" name="txtidMenu">
                                    <input type="hidden" id="txtIdPerfil" value="<?php echo $IdmenuHijo; ?>" name="txtIdPerfil">
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="2">
                                    <table border=0 width="500px">
                                        <?php
                                        $contador = 0;
                                        if(!empty($MenuSistema)){
                                            foreach ($MenuSistema as $key => $value) {
                                                $contador ++;
                                                echo "<tr>";
                                                echo "<td align='left'>";
                                                echo "<h4><img src='".$value['IMAGEN']."'  width='50' height='50'>";
                                                echo "Catalogo <strong>".$value['DESCRIPCION']."</strong></h4>";
                                                echo "</td>";
                                                echo "</tr>";
                                                
                                                echo "<tr>";
                                                echo "<td>";
                                                echo "<table border=0>";
                                                echo "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
                                                echo "<td>";
                                                if(!empty($IconosSistema)){
                                                    echo "<table border=0>";
                                                    $colspan = 0;
                                                    foreach ($IconosSistema as $key => $iconosSis) {
                                                        # code...
                                                        echo '<tr>';
                                                        $Activado  = "";
                                                        $Activo    = 0;
                                                        //Verificamos si tiene asignado el permiso en caso de que no lo tenga, o el estatus este en desactivado
                                                        //Nos regresara un falso
                                                        $PermisoOn = $ObjetosPermisos->PermisoActivado($IdmenuHijo,$iconosSis['ID'],$value['ID'],"1");
                                                        if($PermisoOn==true){
                                                            $Activado = "checked";
                                                            $Activo   = 1;
                                                        }
                                                        echo "<td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;";
                                                        echo "<input type='radio' ".$Activado." id='Icono".$contador.$iconosSis['ID']."'  name='Icono".$contador.$iconosSis['ID']."'>";
                                                        echo "<img src='".$iconosSis['IMAGEN']."'  width='30' height='30'>";
                                                        echo "&nbsp;".$iconosSis["DESCRIPCION"]."&nbsp;&nbsp;&nbsp;&nbsp;";
                                                        echo "<input type='hidden' name='".$contador.$iconosSis['ID']."' id='".$contador.$iconosSis['ID']."' value='".$iconosSis['ID']."|".$Activo."|".$value['ID']."|Icono".$contador.$iconosSis['ID']."'>";
                                                        echo "</td>";
                                                        echo '</tr>';
                                                        /*Javascript para activar el radio*/
                                                        ?>
                                                        <script type="text/javascript">
                                                            jQuery(document).ready(function() {
                                                                jQuery("#Icono<?php echo $contador.$iconosSis['ID']; ?>").click(function(){
                                                                    writeData('<?php echo $contador.$iconosSis['ID']; ?>');
                                                                 });
                                                            });
                                                        </script>
                                                        <?php
                                                    ?>

                                                    <?php
                                                    }
                                                    echo "</table>";
                                                }
                                                echo "</td></tr></table>";
                                                echo "</td>";
                                                echo "</tr>";
                                                echo "<tr><td><br/></td></tr>";
                                            }
                                        }
                                            /*Obtenemos el Id de los iconos*/
                                            $IdsIconos= "";
                                            foreach ($IconosSistema as $key => $iconosSist) {
                                                $IdsIconos = $IdsIconos.$iconosSist['ID'].",";
                                            }
                                            $IdsIconos= substr($IdsIconos, 0, -1);
                                         ?>
                                        <input type="hidden" id="txtIdIconos" value="<?php echo $IdsIconos; ?>" name="txtIdIconos">
                                        <input type="hidden" id="txtContador" value="<?php echo $contador; ?>" name="txtContador">
                                    </table>

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
                            echo "<br/>";
                            include("NoAcceso.php");
                        }
                     ?>
                  
                </center>
            </div>
        </div>
    </body>

</html>

