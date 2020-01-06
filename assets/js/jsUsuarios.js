jQuery(document).ready(function() {
	$('img[name=editar]').click(function(){
            //Obtenemos los valores a eliminar                  
            var ValoresPermisos  = $('#control').val();
            ValoresPermisos      = ValoresPermisos.split('|');
            var IdMenu           = ValoresPermisos[0];
            var Icono            = ValoresPermisos[1];
            var IdRegistro       = ValoresPermisos[2];
            window.location      = "NuevoUsuario.php?a="+IdMenu+"&b="+Icono+"&c="+IdRegistro;
    });
    //Funcion para Nuevo
        $('input[name=nuevo]').click(function(){
            //Obtenemos los valores a eliminar                  
            var ValoresPermisos  = $('#control').val();
            ValoresPermisos      = ValoresPermisos.split('|');
            var IdMenu           = ValoresPermisos[0];
            var Icono            = ValoresPermisos[1];
            var IdRegistro       = ValoresPermisos[2];
            window.location      = "NuevoUsuario.php?a="+IdMenu+"&b="+Icono+"&c="+IdRegistro;
        });
	$("#txtEmail").blur(function() {
  		//Validamos el Mail que no este vacio
  		 $("#Mensaje").html("<span></span>");
  		var Email  = $('#txtEmail').val();
  		$("#control1").attr("value","0");
  		if(Email!=""){
  			//Utilizamos una expresion regular
	    	var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
	    	//Se utiliza la funcion test() nativa de JavaScript
		    if (regex.test($('#txtEmail').val().trim())) {
		        //Verificamos que el correo no Exista
		        var formData     = new FormData();
		        formData.append("Email",Email);
		        $.ajax({ 
                type : 'POST',
                data   : formData,
                cache: false,
                contentType: false,
                processData: false,
                url  : 'ComprobarCorreo.php',
	                success: function(responseText){ 
	                    $("#Mensaje").html('');
	                    if(responseText==0){
	                        $("#Mensaje").append("<span  class='green'> El Correo Esta Disponible. <small>Se le Enviara un Corrreo para que active su Cuenta.</small></span>");
	                    }else if(responseText==1){
	                        $("#Mensaje").append("<span  class='red'>Error: El Correo Ya esta En Uso.</span>");
	                        $("#control1").attr("value","Error: El Correo Ya esta En Uso.");
	                    }else{
	                    	$("#Mensaje").append("<span  class='red'>Error: " + responseText + "</span>");
	                    	$("#control1").attr("value","Error: " + responseText);
	                    }

	                }
            	});
            	return false;
		    }else {
	        	$("#Mensaje").append("<span  class='red'>* El Correo No es Valido</span>");
	        	$('#txtEmail').focus();
	    	}
  		}
  		
	});
	/*Guardamos*/
	$('.register form').submit(function(){
		$("#control2").attr("value","0");
		$("#Mensaje").html("<span></span>");
		var Id  		= $('#id').val();
		var Email  		= $('#txtEmail').val();
		var Nombre 		= $('#txtNombre').val();
		var Apellidos  	= $('#txtApellidos').val();
		var Perfil      = $('#cbPerfil').val();
		var Estatus     = $('#cbEstatus').val();
		var Control     = $('#control1').val();


		if(Nombre==""){
			$("#Mensaje").append("<span  class='red'>* El Nombre esta Vacio</span>");
	        $('#txtNombre').focus();
	        return false;
		}else if(Apellidos==""){
			$("#Mensaje").append("<span  class='red'>* Los Apellidos esta Vacios</span>");
	        $('#txtApellidos').focus();
	        return false;
		}else if(Email==""){
			$("#Mensaje").append("<span  class='red'>* El Email Esta Vacio</span>");
	        $('#txtEmail').focus();
	        return false;
		} else if(Perfil==0){
			$("#Mensaje").append("<span  class='red'>* Elige un Perfil</span>");
	        $('#cbPerfil').focus();
	        return false;
		}else if(Control!=0){
			$("#Mensaje").append("<span  class='red'>" + Control + "</span>");
			$('#txtEmail').focus();
			return false;
		}else{

			/*Guardamos informacion*/
		 $("#Mensaje").append("<span  class='red'><img src='assets/img/ajax-loader.gif'> Enviando Peticion...</span>");
            /*Creamos el objeto */
            var formData = new FormData();
            /*Le agregamos las cajas de texto el objeto*/
            formData.append("id",Id);
            formData.append("txtEmail",Email);
            formData.append("txtNombre",Nombre);
            formData.append("txtApellidos",Apellidos);
            formData.append("cbPerfil",Perfil);
            formData.append("cbEstatus",Estatus);
            $.ajax({ 
                type : 'POST',
                data   : formData,
                cache: false,
                contentType: false,
                processData: false,
                url  : 'GuardaUsuarios.php',
                success: function(responseText){ 
                    $("#Mensaje").html('');
                    if(responseText==1){
                        $("#Mensaje").append("<span  class='green'> Informaciòn Almacenada Correctamente</span>");
                    }else if(responseText==2){
                        $("#Mensaje").append("<span  class='red'>Error: No Tienes Permisos para Actualizar Este Modulo</span>");
                    }else{
                        $("#Mensaje").append("<span  class='red'>Hubo un Error. Intente mas Tarde!!!. "+responseText+"</span>");
                    }
                }
            });
            return false;
		}
		 

		return false;

	});
	/*
	$("#cbPerfil").change(function(){
			$("#content2").html("<span></span>");
			var Perfil      = $('#cbPerfil').val();
			if(Perfil!=0){
				$("#content2").html("<span>Seleccione " + Perfil + "</span>");
            	$("#content2").delay(10).fadeIn("slow");
			}
            return false;
    });*/
});