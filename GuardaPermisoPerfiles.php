<?php 
	session_start();
    include('class.consultas.php');
    include('clases/class.encriptar.php');
    $ObjetosPermisos = new Permisos;
	$txtIdIconos	= $_POST['txtIdIconos'];
	$txtContador    = $_POST['txtContador'];
	$txtidMenu      = $_POST['txtidMenu'];//Id del menu en este caso el id de perfiles
	$txtIdIconos    = explode(",",$txtIdIconos);
	for ($i=1;$i<=$txtContador;$i++){
		for($j=0;$j<count($txtIdIconos);$j++){
			$Permisos = $_POST[$i.$txtIdIconos[$j]];
			$Permisos = explode("|",$Permisos);
			$IdIcono  = $Permisos[0];
			$Estatus  = $Permisos[1];
			$IdMenu   = $Permisos[2];//Id del menu que le estamos asignado permisos
			$IdPerfil = $_POST['txtIdPerfil'];
			/*Existe Permiso*/
			$ExistePer= $ObjetosPermisos->PermisoActivado($IdPerfil,$IdIcono,$IdMenu,"0,1");
			if($ExistePer==true){
				//Si existe Actualizamos
				$ActualizaPermisos = $ObjetosPermisos->AsignaPermisosPerfiles($IdPerfil,$IdIcono,$IdMenu,$Estatus,"1");
			}else{
				//Si no existe insertamos  nomas las que esten activas
				if($Estatus==1){
					$ActualizaPermisos = $ObjetosPermisos->AsignaPermisosPerfiles($IdPerfil,$IdIcono,$IdMenu,$Estatus,"0");
				}
			}
		}
	}
	echo "1";
?>