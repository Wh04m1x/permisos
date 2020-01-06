<?php 
	session_start();
    include('class.consultas.php');
    include('clases/class.encriptar.php');
    $ObjetosPermisos = new Permisos;
	$txtBandera		= $_POST['txtBandera'];
	$txtidMenu      = $_POST['txtidMenu'];
	$txtIdPerfil	= $_POST['txtIdPerfil'];
	$txtdescripcion	= $_POST['txtdescripcion'];
	$cbEstatus		= $_POST['cbEstatus'];
	$Estatus        = "";
	if($txtBandera==1){
		$Estatus = $ObjetosPermisos->ActualizaPerfil($txtIdPerfil,$txtdescripcion,$cbEstatus,1);
	}else{
		$Estatus = $ObjetosPermisos->ActualizaPerfil($txtIdPerfil,$txtdescripcion,$cbEstatus,0);
	}
	echo "1";

?>