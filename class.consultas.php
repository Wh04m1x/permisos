<?php
/*
Autor: Manuel Cortes Crisanto
Fecha: 13/Noviembre/2014
Descripcion: Archivo para ejecutar las consultas, inserciones y delete
Nota: El codigo es libre de distribuir. Totalmente Gratuito.
Web: www.desarrollosphp.com
email:info@desarrollosphp.com
*/
require("clases/config.php");

class conectorDB extends config
{
	private $conexion;
	public function __construct(){
		$this->conexion = parent::conectar(); //creo una variable con la conexión
		return $this->conexion;										
	}
	
	public function EjecutarSentencia($consulta, $valores = array()){  //funcion principal, ejecuta todas las consultas
		$resultado = false;
		
		if($statement = $this->conexion->prepare($consulta)){  //prepara la consulta
			if(preg_match_all("/(:\w+)/", $consulta, $campo, PREG_PATTERN_ORDER)){ //tomo los nombres de los campos iniciados con :xxxxx
				$campo = array_pop($campo); //inserto en un arreglo
				foreach($campo as $parametro){
					$statement->bindValue($parametro, $valores[substr($parametro,1)]);
				}
			}
			try {
				if (!$statement->execute()) { //si no se ejecuta la consulta...
					print_r($statement->errorInfo()); //imprimir errores
					return false;
				}
				$resultado = $statement->fetchAll(PDO::FETCH_ASSOC); //si es una consulta que devuelve valores los guarda en un arreglo.
				$statement->closeCursor();
			}
			catch(PDOException $e){
				echo "Error de ejecución: \n";
				print_r($e->getMessage());
			}	
		}
		return $resultado;
		$this->conexion = null; //cerramos la conexión
	} /// Termina funcion consultarBD
}/// Termina clase conectorDB

class Permisos
{
	private $permisos;
	/*Permisos Iconos*/
	public function iconos(){
		$consulta = "SELECT * FROM iconos WHERE ESTATUS=1";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function PermisoActivado($Id_Perfil,$Id_Icono,$id_menu,$Estatus){
		$consulta = "SELECT ESTATUS FROM asigna_permisos_perfiles WHERE ID_MENU='".$id_menu."' and ID_PERFIL='".$Id_Perfil."'";
		$consulta = $consulta." AND ID_ICONO='".$Id_Icono."' AND ESTATUS IN (".$Estatus.")";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		if(!empty($this->permisos)){
			return true;
		}else{
			return false;
		}
	}
	public function AsignaPermisosPerfiles($IdPerfil,$IdIcono,$IdMenu,$Estatus,$Accion){
		$Actualizar = false; //creamos una variable de control
		$consulta   = "";
		$valores    = array();
		//Si Accion es 1 Entonces Actualizamos
		if($Accion==1){
			$consulta = "UPDATE asigna_permisos_perfiles  SET ESTATUS=:ESTATUS WHERE ID_PERFIL=:ID_PERFIL AND ID_ICONO=:ID_ICONO AND ID_MENU=:ID_MENU";
			//variables para actualizar
			$valores = array("ID_PERFIL"=>$IdPerfil,"ID_ICONO"=>$IdIcono,"ESTATUS"=>$Estatus,"ID_MENU"=>$IdMenu);
		}else{
			$consulta = "INSERT INTO asigna_permisos_perfiles (ID_PERFIL, ID_ICONO,ID_MENU) VALUES(:ID_PERFIL, :ID_ICONO, :ID_MENU)";
			//variables para actualizar
			$valores = array("ID_PERFIL"=>$IdPerfil,"ID_ICONO"=>$IdIcono,"ID_MENU"=>$IdMenu);
		}
		$oConexion = new conectorDB; //instanciamos conector
		$Actualizar= $oConexion->EjecutarSentencia($consulta, $valores);
		
		if($Actualizar !== false){
			return true;
		}
		else{
			return false;
		}
	}
	public function BuscarPermisosPerfil($idPerfil){
		$consulta = "SELECT * FROM asigna_permisos_perfiles WHERE ID_PERFIL='".$idPerfil."' and ESTATUS=1";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	/*Fin Permisos Iconos*/
	public function ValidacionLogin($usuario,$password){
		$consulta = "SELECT * FROM usuarios WHERE USUARIO='".$usuario."' and PASSWORD='".$password."' limit 1";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function Menu($id){
		$consulta = "SELECT M.ID, M.ORDENAMIENTO,M.DESCRIPCION, M.IMAGEN, M.URL FROM menu as M INNER JOIN permisos AS P";
		$consulta = $consulta." on M.ID=P.ID_MENU WHERE P.ID_USUARIO=".$id." AND P.ESTATUS=1 ORDER BY M.ORDENAMIENTO ASC";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function listamenu(){
		$consulta = "SELECT * FROM menu WHERE ID>0 order by ORDENAMIENTO ASC";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function iconos_menu($id_usuario,$id_menu){
		$consulta = "SELECT I.ID, I.DESCRIPCION, I.IMAGEN, P.ESTATUS FROM iconos As I inner join permisos_iconos as P";
		$consulta = $consulta." on I.ID=P.ID_ICONO WHERE P.ID_USUARIO = ".$id_usuario." AND P.ID_MENU = ".$id_menu." AND P.ESTATUS=1";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function permisos_accion_ejecucion($id_usuario, $id_menu,$id_icono){
		$consulta = "SELECT I.DESCRIPCION, I.IMAGEN, P.ESTATUS FROM iconos As I inner join permisos_iconos as P";
		$consulta = $consulta." on I.ID=P.ID_ICONO WHERE P.ID_USUARIO = ".$id_usuario." AND I.ID=".$id_icono." AND P.ID_MENU = ".$id_menu." AND P.ESTATUS=1";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function BuscarMenu($id){
		$consulta = "SELECT * FROM menu WHERE ID='".$id."' limit 1";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function EliminarMenu($id){
		$consulta  	 = "DELETE FROM menu WHERE ID=:ID";
		$valores   	 = array("ID"=>$id);
		$oConexion 	 = new conectorDB; //instanciamos conector
		$EliminaMenu = $oConexion->EjecutarSentencia($consulta, $valores);
		if($EliminaMenu !== false){
			return true;
		}
		else{
			return false;
		}
	}
	public function ActualizaMenu($descripcion,$url,$ordenamiento,$estatus,$id,$img){
		 $registrar = false; //creamos una variable de control
		 $imagen    = "";
		 $consulta  = "";
		 $valores = array();
		 if($img=="0"){
		 	$consulta = "UPDATE menu  SET DESCRIPCION=:DESCRIPCION, URL=:URL, ORDENAMIENTO=:ORDENAMIENTO, ESTATUS=:ESTATUS WHERE ID=:ID";
			//variables para actualizar
			$valores = array("DESCRIPCION"=>$descripcion,
							"URL"=>$url,
							"ORDENAMIENTO"=>$ordenamiento,
							"ESTATUS"=>$estatus,
							"ID"=>$id);
		 }else{
		 	$consulta = "UPDATE menu  SET DESCRIPCION=:DESCRIPCION, URL=:URL, IMAGEN=:IMAGEN, ORDENAMIENTO=:ORDENAMIENTO, ESTATUS=:ESTATUS WHERE ID=:ID";
			//variables para actualizar
			$valores = array("DESCRIPCION"=>$descripcion,
							"URL"=>$url,
							"ORDENAMIENTO"=>$ordenamiento,
							"ESTATUS"=>$estatus,
							"IMAGEN"=>$img,
							"ID"=>$id);
		 }
		
		$oConexion = new conectorDB; //instanciamos conector
		$registrar = $oConexion->EjecutarSentencia($consulta, $valores);
		
		if($registrar !== false){
			return true;
		}
		else{
			return false;
		}
	}
	/*Perfiles*/
	public function Perfiles(){
		$consulta = "SELECT * FROM perfiles  order by ID ASC";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function BuscarPerfiles($id){
		$consulta = "SELECT * FROM perfiles WHERE ID='".$id."' limit 1";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function ActualizaPerfil($IdPerfil,$DescripcionPerfil,$estatusperfil,$accion){
		$registrar = false; //creamos una variable de control
		$consulta  = "";
		$valores   = array();
		if($accion==1){
			$consulta = "UPDATE perfiles  SET DESCRIPCION=:DESCRIPCION, ESTATUS=:ESTATUS WHERE ID=:ID";
			//variables para actualizar
			$valores  = array("DESCRIPCION"=>$DescripcionPerfil,"ESTATUS"=>$estatusperfil,"ID"=>$IdPerfil);
		}else{
			$consulta = "insert into perfiles(DESCRIPCION, ESTATUS) values (:DESCRIPCION, :ESTATUS)";
			$valores  = array("DESCRIPCION"=>$DescripcionPerfil,"ESTATUS"=>$estatusperfil);
		}
		$oConexion = new conectorDB; //instanciamos conector
		$registrar = $oConexion->EjecutarSentencia($consulta, $valores);
		
		if($registrar !== false){
			return true;
		}
		else{
			return false;
		}
	}
	/*Usuarios*/
	public function Usuarios(){
		$consulta = "SELECT * FROM usuarios  order by ID ASC";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function BuscarUsuario($id){
		$consulta = "SELECT * FROM usuarios WHERE ID=".$id."  order by ID ASC";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function BuscaEmail($Email){
		$consulta = "SELECT * FROM usuarios WHERE CORREO='".$Email."' limit 1";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta);
		return $this->permisos;
	}
	public function GuardarUsuario($id,$nombre,$apellidos,$email,$perfil,$estatus){
		date_default_timezone_set('America/Mexico_City');
		$Actualizar = false; //creamos una variable de control
		$consulta   = "";
		$usuario    = explode("@",$email);
		$password   = "";
		$fecha1     = date('Y-m-j H:i:s');
		$valores    = array();
		/*Generamos la contraseña*/
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        for($i=0;$i<12;$i++) {
            $password .= substr($str,rand(0,62),1);
        }
		//Si Accion es 1 Entonces Actualizamos
		if($id!=0){
			$consulta = "UPDATE usuarios  SET NOMBRE=:NOMBRE,APELLIDOS=:APELLIDOS, ESTATUS=:ESTATUS,";
			$consulta = $consulta."TIPO_USUARIO=:TIPO_USUARIO,FECHA_ACTUALIZACION=:FECHA_ACTUALIZACION WHERE ID=:ID";
			//variables para actualizar
			$valores = array("NOMBRE"=>$nombre,"APELLIDOS"=>$apellidos,"ESTATUS"=>$estatus,"TIPO_USUARIO"=>$perfil,"FECHA_ACTUALIZACION"=>$fecha1,"ID"=>$id);
			$this->AsignaPermisosAutomaticosUsuarios($perfil,$id);
		}else{
			$consulta = "INSERT INTO usuarios (NOMBRE, APELLIDOS, CORREO, USUARIO, PASSWORD, FECHA_REGISTRO, ESTATUS, TIPO_USUARIO)";
			$consulta = $consulta." VALUES (:NOMBRE,:APELLIDOS,:CORREO,:USUARIO,:PASSWORD,:FECHA_REGISTRO,:ESTATUS,:TIPO_USUARIO)";
			//variables para actualizar
			$valores = array("NOMBRE"=>$nombre,"APELLIDOS"=>$apellidos,"CORREO"=>$email,"USUARIO"=>$usuario[0],"PASSWORD"=>$password,"FECHA_REGISTRO"=>$fecha1,"ESTATUS"=>$estatus,"TIPO_USUARIO"=>$estatus);
		}
		$oConexion = new conectorDB; //instanciamos conector
		$Actualizar= $oConexion->EjecutarSentencia($consulta, $valores);
		
		if($Actualizar !== false){
			return true;
		}
		else{
			return false;
		}
	}
	public function EliminaPermisosIconos($idUser){
		$registrar = false; //creamos una variable de control
		$consulta  = "DELETE FROM permisos_iconos  WHERE ID_USUARIO=:ID_USUARIO AND ID_MENU !=0";
		$valores   = array("ID_USUARIO"=>$idUser);
		
		$oConexion = new conectorDB; //instanciamos conector
		$registrar = $oConexion->EjecutarSentencia($consulta, $valores);
		
		if($registrar !== false){
			return true;
		}
		else{
			return false;
		}
	}
	public function AsignarPermisosUsuariosIconos($idusuario, $idIcono, $IdMenu){

		/*Buscamos */
		$registrar = false; //creamos una variable de control
		$consulta  = "INSERT INTO permisos_iconos (ID_USUARIO, ID_ICONO, ID_MENU) VALUES (:ID_USUARIO, :ID_ICONO, :ID_MENU)";
		$valores   = array("ID_USUARIO"=>$idusuario,"ID_ICONO"=>$idIcono,"ID_MENU"=>$IdMenu);
		
		$oConexion = new conectorDB; //instanciamos conector
		$registrar = $oConexion->EjecutarSentencia($consulta, $valores);
		
		if($registrar !== false){
			return true;
		}
		else{
			return false;
		}
	}
	public function AsignarPermisosUsuariosMenu($idusuario, $IdMenu){
		/*Buscamos Permiso Menu*/
		$consulta1 = "SELECT * FROM permisos WHERE ID_USUARIO='".$idusuario."' AND ID_MENU='".$IdMenu."'";
		$conexion = new conectorDB;
		$this->permisos = $conexion->EjecutarSentencia($consulta1);
		$PermisoMenu    = $this->permisos;
		$registrar      = false; //creamos una variable de control
		$consulta       = "";
		$valores        = array();
		if(!empty($PermisoMenu)){
			$consulta  = "UPDATE permisos SET ESTATUS=:ESTATUS WHERE ID_USUARIO=:ID_USUARIO AND ID_MENU=:ID_MENU";
			$valores   = array("ESTATUS"=>"1","ID_USUARIO"=>$idusuario,"ID_MENU"=>$IdMenu);
		}else{
			$consulta  = "INSERT INTO permisos (ID_USUARIO, ID_MENU) VALUES (:ID_USUARIO, :ID_MENU)";
			$valores   = array("ID_USUARIO"=>$idusuario,"ID_MENU"=>$IdMenu);
		}
		$oConexion = new conectorDB; //instanciamos conector
		$registrar = $oConexion->EjecutarSentencia($consulta, $valores);
		
		if($registrar !== false){
			return true;
		}
		else{
			return false;
		}
	}
	/*Funcion que se encarga de asignar los permisos de acuerdo al perfil elegido*/
	public function AsignaPermisosAutomaticosUsuarios($idPerfil, $idUsuario){
		/*Eliminamos los permisos asignados a ese usuario*/
		$EstatusEliminar = $this->EliminaPermisosIconos($idUsuario);
		if($EstatusEliminar==true){
			/*Traemos los permisos asignados a ese perfil*/
			$PermisosPerfil  = $this->BuscarPermisosPerfil($idPerfil);
			if(!empty($PermisosPerfil)){
				foreach ($PermisosPerfil as $key => $value) {
					# code...
					$IdIcono      = $value["ID_ICONO"];
					$IdMenu       = $value["ID_MENU"];
					$this->AsignarPermisosUsuariosIconos($idUsuario,$IdIcono,$IdMenu);
					$this->AsignarPermisosUsuariosMenu($idUsuario,$IdMenu);
				}
			}else{
				echo " <br/>El Perfil Que Selecciono No tiene Asignado Ningun Permiso ";
			}
			
		}
		
	}
}/// TERMINA CLASE USUARIOS ///