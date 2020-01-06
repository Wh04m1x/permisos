jQuery(document).ready(function() {
	/*Guardamos*/
	$('.register form').submit(function(){
		$("#Mensaje").html("<span></span>");
		var Id  		= $('#id').val();
		var Email  		= $('#txtEmail').val();
		var Nombre 		= $('#txtNombre').val();
		var Apellidos  	= $('#txtApellidos').val();
		var Perfil      = $('#cbPerfil').val();
		var Estatus     = $('#cbEstatus').val();
		if(Nombre==""){
			$("#Mensaje").append("<span  class='red'>* El Nombre esta Vacio</span>");
	        $('#txtNombre').focus();
	        return false;
		}else if(Apellidos==""){
			$("#Mensaje").append("<span  class='red'>* Los Apellidos esta Vacios</span>");
	        $('#txtApellidos').focus();
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

});