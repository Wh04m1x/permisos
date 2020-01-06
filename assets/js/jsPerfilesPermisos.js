jQuery(document).ready(function() {
		//funcion para asignar permisos a los perfiles
		$('img[name=permisos]').click(function(){
            //Obtenemos los valores a eliminar                  
            var ValoresPermisos  = $('#control').val();
            ValoresPermisos      = ValoresPermisos.split('|');
            var IdMenu           = ValoresPermisos[0];
            var Icono            = ValoresPermisos[1];
            var IdRegistro       = ValoresPermisos[2];
            window.location      = "AsignaPermisoPerfil.php?a="+IdMenu+"&b="+Icono+"&c="+IdRegistro;
        });
        //funcion para asignar permisos a los perfiles
        $('img[name=editar]').click(function(){
            //Obtenemos los valores a eliminar                  
            var ValoresPermisos  = $('#control').val();
            ValoresPermisos      = ValoresPermisos.split('|');
            var IdMenu           = ValoresPermisos[0];
            var Icono            = ValoresPermisos[1];
            var IdRegistro       = ValoresPermisos[2];
            window.location      = "NuevoPerfil.php?a="+IdMenu+"&b="+Icono+"&c="+IdRegistro;
        });
        //Funcion para Nuevo
        $('input[name=nuevo]').click(function(){
            //Obtenemos los valores a eliminar                  
            var ValoresPermisos  = $('#control').val();
            ValoresPermisos      = ValoresPermisos.split('|');
            var IdMenu           = ValoresPermisos[0];
            var Icono            = ValoresPermisos[1];
            var IdRegistro       = ValoresPermisos[2];
            window.location      = "NuevoPerfil.php?a="+IdMenu+"&b="+Icono+"&c="+IdRegistro;
        });
        //Guardamos Permisos
        $('.register form').submit(function(){
                var Iconos       = $(this).find('input#txtIdIconos').val();
                var Contador     = $(this).find('input#txtContador').val(); 
                var txtidMenu    = $(this).find('input#txtidMenu').val();
                var txtIdPerfil  = $(this).find('input#txtIdPerfil').val();
                Iconos           = Iconos.split(",");
                var formData     = new FormData();
                formData.append("txtIdIconos",Iconos);
                formData.append("txtContador",Contador);
                formData.append("txtidMenu",txtidMenu);
                formData.append("txtIdPerfil",txtIdPerfil);
                for (i=1;i<=Contador;i++){
                    for(j=0;j<Iconos.length;j++){
                        var InputPermisos= $(this).find('input#'+i+Iconos[j]).val();
                        formData.append(i+Iconos[j],InputPermisos);
                    }

                }
                /*Guardamos las opciones de permisos*/
                $.ajax({ 
                type : 'POST',
                data   : formData,
                cache: false,
                contentType: false,
                processData: false,
                url  : 'GuardaPermisoPerfiles.php',
                    success: function(responseText){ 
                        $("#Mensaje").html('');
                        if(responseText==1){
                            $("#Mensaje").append("<span  class='green'> Información Guardada Correctamente</span>");
                        }else if(responseText==2){
                            $("#Mensaje").append("<span  class='red'>Error: No Tienes Permisos para Actualizar Este Modulo</span>");
                        }else{
                            $("#Mensaje").append("<span  class='red'>Hubo un Error. Intente mas Tarde!!!. "+responseText+"</span>");
                        }
                    }
                });
            return false;
        });
});