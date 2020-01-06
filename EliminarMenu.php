<?php
	session_start();
    include('class.consultas.php');
    include('clases/class.encriptar.php');
    $ObjetosPermisos = new Permisos;
    $idMenuPapa      = 0;
    $IdUsuario   	 = 0;
    $PermisoIcono    = 0;
    $IdMenuEliminar  = 0;
    if(isset($_GET["a"]) and isset($_GET["b"])){
        $idMenuPapa     = decrypt($_GET["a"]);
        $IdUsuario      = trim($_GET["b"]);
        $PermisoIcono   = decrypt($_GET["c"]); 
        $IdMenuEliminar = decrypt($_GET["d"]);

    }
    if($IdUsuario!=0 and $PermisoIcono!=0 and $IdMenuEliminar!=0){
        //Si se recibio las variables correctamente entonces 
        //Validamos nuevamente los permisos
        $PermisosEjecucion = $ObjetosPermisos->permisos_accion_ejecucion($IdUsuario, $idMenuPapa,$PermisoIcono);
        if(!empty($PermisosEjecucion)){
            $EjecucionEliminar = $ObjetosPermisos->EliminarMenu($IdMenuEliminar);
            if($EjecucionEliminar==true){
                echo "0";
            }else{
                echo "2";
            }
        	
        }else{
        	echo "1";
        }
    }
 ?>