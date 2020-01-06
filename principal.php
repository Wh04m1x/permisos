<?php
    session_start();
    include('class.consultas.php');
     include('clases/class.encriptar.php');
    $ObjetosPermisos = new Permisos;
    $menuPrincipal   = $ObjetosPermisos->Menu($_SESSION['USERID']);
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
                       Bienvenid@: <?php echo $_SESSION['USERNO']; ?> | <a href="Salir.php">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-container container">
            <div class="row">
                
                <?php
                    if(!empty($menuPrincipal)){
                        echo '<center><table border=0 width="60%">';
                        echo '<tr><td colspan=3><center><h1>Menu Principal Del Sistema</h1></center></td></tr>';
                        echo '<tr><td colspan=3><hr/></td></tr>';
                        $cuantos=0;
                        foreach($menuPrincipal as $CrearMenu){
                            if($cuantos==0){
                                echo '<tr>';
                            }
                            $cuantos ++;
                            $idUrl  = encrypt($CrearMenu["ID"]);
                            $Style  = encrypt($CrearMenu["DESCRIPCION"]);
                            echo '<td>&nbsp;&nbsp;&nbsp;';
                            echo '<a href="'.$CrearMenu["URL"].'?a='.$idUrl.'&b='.$Style.'">';
                            echo '<center><img src="'.$CrearMenu["IMAGEN"].'" width="128px" height="128px" title="'.$CrearMenu["DESCRIPCION"].'"></center>';
                            echo "</a><br><center>".$CrearMenu["DESCRIPCION"]."</center> &nbsp;&nbsp;&nbsp;";
                            echo "</td>";
                            if($cuantos==3){
                                $cuantos=0;
                                echo '</tr>';
                                echo '<tr><td colspan=3><hr/></td></tr>';
                            }
                        }
                        echo '</table></center>';
                    }else{
                        echo '<center><img src="assets/img/alerta.png"><br/><h2><font color="red">Sin Permisos para el Ver Menu. Solicita los Permisos con un Administrador</font></h2></center>';
                    }
                 ?>
            
            </div>
        </div>

        <!-- Javascript -->
        <script src="assets/js/jquery-1.8.2.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
    </body>

</html>

