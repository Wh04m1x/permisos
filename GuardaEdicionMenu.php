<?php
	session_start();
    include('class.consultas.php');
    $ObjetosPermisos = new Permisos;
	$id 		= $_POST['id'];
	$descripcion= $_POST['descripcion'];
	$url		= $_POST['url'];
	$orden		= $_POST['orden'];
	$estatus 	= $_POST['estatus'];
	$icono      = $_POST['icono'];
	$file 		= $_FILES['archivo']['name'];
	$nueva_image= "0";
	$tipo_archi = ""; 
	$control    = 0;
	if($file!=""){
		$control = 1;
		$tipo_archi = extension($file); 
	}
	/*Nuevamente Validamos los permisos de usuario*/
	$PermisosEjecucion = $ObjetosPermisos->permisos_accion_ejecucion($_SESSION['USERID'],0,$icono);
	if(!empty($PermisosEjecucion)){
		/*Si enviamos nueva foto entonces subimos a la carpeta*/
		if($control==1){
			if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"assets/img/".$descripcion.".".$tipo_archi))
		    {
		       $nueva_image = "assets/img/".$descripcion.".".$tipo_archi;
		    }
		}
		/*Realizamos Update en la base de datos*/
	    $EstatusOperacion= $ObjetosPermisos->ActualizaMenu($descripcion,$url,$orden,$estatus,$id,$nueva_image);
	    //echo $EstatusOperacion;
	    if($EstatusOperacion==true){
	    	echo "1";
	    }
	}else{
		echo "2";
	}
	

    function extension($mi_extension){
		return end(explode(".", $mi_extension));
	}
 ?>