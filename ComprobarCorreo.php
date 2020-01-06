<?php 
	session_start();
    include('class.consultas.php');
    include('clases/class.encriptar.php');
    $ObjetosPermisos = new Permisos;
	$Email	         = $_POST['Email'];
	$Buscar          = $ObjetosPermisos->BuscaEmail($Email);
	if(!empty($Buscar)){
		echo "1";
	}else{
		echo "0";
	}
?>