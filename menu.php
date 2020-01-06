<?php
    session_start();
    include('class.consultas.php');
    include('clases/class.encriptar.php');
    $ObjetosPermisos = new Permisos;
    $MenuSistema     = $ObjetosPermisos->listamenu();
    $PermisosIconosM = $ObjetosPermisos->iconos_menu($_SESSION['USERID'],0);
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
        function GeneraLiga(url){
            window.location=url;
        }
        function Control(valor){
            document.formularios.control.value=valor;
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
                <!--- Utilizamos el formulario para llevar el control de lo que se va eliminar o editar -->
                <form name="formularios" id="formularios">
                    <input type="hidden" name="control" id="control" value="">
                </form>
                <!--- Fin del formulario -->
                <center><img src="assets/img/regresar.png" onclick="Regresar()" style="cursor:pointer; " width="50px"></center>
                <hr />
                <blockquote>
                  <p>Menu del Sistema para configurarlo. Se debe de configurar correctamente</p>
                  <small>Desarrollado por: <cite title="Nombre Apellidos">Ing. Manuel Cortes Crisanto</cite>, Especialista en Desarrollo de Software Net, PHP</small>
                </blockquote>
                <hr/>
                <div id="estatus"></div>
                 <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Descripción</th>
                        <th>Url</th>
                        <th>Imagen</th>
                        <th>Ordenamiento</th>
                        <th>Estatus</th>
                    </tr>
                    </thead>
                    <tbody>



  
                <?php
                   if(!empty($MenuSistema)){
                        $contador = 0;
                        foreach ($MenuSistema as $key => $value) {
                            $contador = $contador + 1;
                            $IdMenu         = encrypt(0);
                            $IdMenuHijo     = encrypt($value["ID"]);
                            # code...
                            echo "<tr>";
                            echo "<td>";
                            /*creamos los iconos*/
                            if(!empty($PermisosIconosM)){
                                foreach ($PermisosIconosM as $key => $icon) {
                                    $IdImagen  = "editar";
                                    $IdIcono   = trim($icon["ID"]);
                                    $IdIcono   = encrypt($IdIcono);
                                    if(trim($icon["DESCRIPCION"])=="Eliminar"){
                                        $IdImagen = "eliminar";
                                    }
                                    # code...
                            ?>

                                    <img  name="<?php echo $IdImagen; ?>" onclick="Control('<?php echo $IdMenu."|".$_SESSION['USERID']."|".$IdIcono."|".$IdMenuHijo; ?>')" id="<?php echo $IdImagen; ?>" src="<?php echo $icon['IMAGEN']; ?>" title="<?php $icon['DESCRIPCION']; ?>" style="cursor:pointer;" width="30" height="30">
                            <?php
                                }
                            }

                            echo "</td>";
                            echo "<td>".$value["DESCRIPCION"]."</td>";
                            echo "<td>".$value["URL"]."</td>";
                            echo "<td><img src='".$value["IMAGEN"]."' width='30' height='30'></td>";
                            echo "<td>".$value["ORDENAMIENTO"]."</td>";
                            echo "<td>";
                            if($value["ESTATUS"]==1){echo "Activo";}else{echo "Inactivo";}
                            echo "</td>";
                            echo "</tr>";
                        }
                   }
                 ?>
                  </tbody>
            </table>
            </div>
        </div>

        <!-- Javascript -->
        <script src="assets/js/jquery-1.8.2.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/jconfirmaction.jquery.js"></script>
        <script src="assets/js/jsMenu.js"></script>
    </body>

</html>

