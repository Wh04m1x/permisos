<?php
	session_start();
    include('class.consultas.php');
    $ObjetosPermisos = new Permisos;
	$id				= $_POST['id'];
    $txtEmail		= $_POST['txtEmail'];
    $txtNombre		= $_POST['txtNombre'];
    $txtApellidos 	= $_POST['txtApellidos'];
    $cbPerfil		= $_POST['cbPerfil'];
    $cbEstatus		= $_POST['cbEstatus'];
    $Buscar          = $ObjetosPermisos->BuscaEmail($txtEmail);
    if($id!=0){
    	$Buscar = array();
    }
	if(!empty($Buscar)){
		echo "El Correo Ya esta en Uso";
	}else{
		$estatus        = $ObjetosPermisos->GuardarUsuario($id,$txtNombre,$txtApellidos,$txtEmail,$cbPerfil,$cbEstatus);
	    if($estatus==true){
	    	echo "1";
	    }
	}

    

 ?>