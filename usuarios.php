<?php
    session_start();
    include('class.consultas.php');
    include('clases/class.encriptar.php');
    $ObjetosPermisos = new Permisos;

    $Usuarios        = array();
    $PermisosIconos  = array();
    $IdMenu          = "";
    if(isset($_GET['a'])){
        $IdMenu          = decrypt($_GET['a']);
        $Usuarios        = $ObjetosPermisos->Usuarios();
        $PermisosIconos  = $ObjetosPermisos->iconos_menu($_SESSION['USERID'],$IdMenu);
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
                       Bienvenid@: <?php echo $_SESSION['USERNO']; ?> | <a href="Salir.php">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="register-container container">
            <div class="row">
                <!--- Utilizamos el formulario para llevar el control de lo que se va eliminar o editar -->
                <form name="formularios" id="formularios">
                    <input type="hidden" name="control" id="control" value="<?php echo encrypt($IdMenu)."|".encrypt(999999)."|".encrypt(999999); ?>">
                </form>
                <!--- Fin del formulario -->
                <center><img src="assets/img/regresar.png" onclick="Regresar()" style="cursor:pointer; " width="50px"></center>
                <hr />
                <blockquote>
                  <p>Catalogo de Usuarios: Dar de Alta, Asignar Permisos Personalizados, Asignar Perfil, Eliminar y Editar Información de Usuarios</p>
                  <small>Desarrollado por: <cite title="Nombre Apellidos">Ing. Manuel Cortes Crisanto</cite>, Especialista en Desarrollo de Software Net, PHP</small>
                </blockquote>
                <hr/>
                <input type="button" name="nuevo" value="Nuevo" class="btn btn-default btn-lg" onclick="Control('<?php echo encrypt($IdMenu)."|".encrypt(999999)."|".encrypt(999999); ?>')"/>
                <br/><br/>
                <div id="estatus"></div>
                 <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Password</th>
                        <th>Estatus</th>
                    </tr>
                    </thead>
                    <tbody>



  
                <?php
                   if(!empty($Usuarios)){
                        $contador = 0;
                        foreach ($Usuarios as $key => $value) {
                            $contador       = $contador + 1;
                            $IdMenuHijo     = encrypt($value["ID"]);
                            # code...
                            echo "<tr>";
                            echo "<td>";
                            /*creamos los iconos*/
                            if(!empty($PermisosIconos)){
                                foreach ($PermisosIconos as $key => $icon) {
                                    $IdImagen  = "editar";
                                    $IdIcono   = trim($icon["ID"]);
                                    $IdIcono   = encrypt($IdIcono);
                                    if(trim($icon["DESCRIPCION"])=="Eliminar"){
                                        $IdImagen = "eliminar";
                                    }
                                    # code...
                            ?>

                                  <img  name="<?php echo $IdImagen; ?>" onclick="Control('<?php echo encrypt($IdMenu)."|".$IdIcono."|".$IdMenuHijo; ?>')" id="<?php echo $IdImagen; ?>" src="<?php echo $icon['IMAGEN']; ?>" title="<?php $icon['DESCRIPCION']; ?>" style="cursor:pointer;" width="30" height="30">
                            <?php
                                }
                            }

                            echo "</td>";
                            echo "<td>".$value["NOMBRE"]." ".$value["APELLIDOS"]."</td>";
                            echo "<td>".$value["CORREO"]."</td>";
                            echo "<td>".$value["USUARIO"]."</td>";
                            echo "<td>".encrypt($value["PASSWORD"])."</td>";
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
        <script src="assets/js/jsUsuarios.js"></script>
    </body>

</html>

