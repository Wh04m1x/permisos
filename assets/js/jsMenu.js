jQuery(document).ready(function() {
        //funcion de eliminar
        $('img[name=eliminar]').click(function(e){
            //Limpiamos la etiqueta
            $("#estatus").html("<span></span>");
            
            //Obtenemos los valores a eliminar
            var ValoresEliminar  = $('#control').val();
            ValoresEliminar      = ValoresEliminar.split('|');
            var IdMenu           = ValoresEliminar[0];
            var Permiso          = ValoresEliminar[1];
            var IdIcono          = ValoresEliminar[2];
            var IdMenuEliminar   = ValoresEliminar[3];
            var EnvioVariables   = "a="+IdMenu+"&b="+Permiso+"&c="+IdIcono+"&d="+IdMenuEliminar;
            //Asignamos el evento
            e.preventDefault();
            var action = confirm('Está seguro que desea eliminar ese registro?');
            if(action==true){
                //Mostramos la peticion
                $("#estatus").append("<span  class='red'><img src='assets/img/ajax-loader.gif'> Enviando Peticion...</span>");
                $.ajax({
                type : 'GET',
                data   : EnvioVariables,
                cache: false,
                contentType: false,
                processData: false,
                url  : 'EliminarMenu.php',
                success: function(responseText){ 

                    $("#estatus").html("<span></span>");
                    if(responseText==0){
                        $("#estatus").append("<span  class='green'> Registro Eliminado Correctamente</span>");
                    }else if(responseText==1){
                        $("#estatus").append("<span  class='red'>Atencion: No Tienes Permisos para Eliminar!!! Actualiza La pagina. </span>");
                    }else if(responseText==2){
                        $("#estatus").append("<span  class='red'>Error: No se Pudo Completar La operaciòn: "+responseText+" </span>");
                    }
                }
             });
            }else{
                $("#estatus").html("<span></span>");
                $("#estatus").append("<span  class='red'>Cancelo La Eliminacion del Registro!!!</span>");
            }
             return false;
        });
        //Fin de la funcion de eliminar
        //Funcion para editar
        $('img[name=editar]').click(function(){
            //Obtenemos los valores a eliminar
            var ValoresEditar    = $('#control').val();
            ValoresEditar        = ValoresEditar.split('|');
            var IdMenu           = ValoresEditar[3];
            var Permiso          = ValoresEditar[2];
            window.location      = "EditarMenu.php?a="+IdMenu+"&b="+Permiso;
        });
        //Fin funcion para editar
        //función que observa los cambios del campo file y obtiene información
        $(':file').change(function()
        {
            $("#Mensaje2").html("<span></span>");
            //obtenemos un array con los datos del archivo
            var file = $("#imagen")[0].files[0];
            //obtenemos el nombre del archivo
            var fileName = file.name;
            //obtenemos la extensión del archivo
            fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
            //obtenemos el tamaño del archivo
            var fileSize = file.size;
            //obtenemos el tipo de archivo image/png ejemplo
            var fileType = file.type;
            //mensaje con la información del archivo
            $("#Mensaje2").append("<span class='info'>La imagen: "+fileName+", Reemplazara la imagen Actual, Pesa: "+fileSize+" bytes.</span>");
        });
        //fin de la opcion del archivo file
        //Formulario para guardar la edicion
    $('.register form').submit(function(){

        /*Datos para validacion login*/
        $(this).find("label[for='Mensaje']").html('');
        /*Datos para validacion login*/
        var Descripcion  = $(this).find('input#txtdescripcion').val();
        var Url          = $(this).find('input#txturl').val(); 
        var Ordenamiento = $(this).find('select#cbOrdenamiento').val(); 
        var Estatus      = $(this).find('select#cbEstatus').val(); 
        var Id           = $(this).find('input#txtid').val();
        var IdIconoEdicio= $(this).find('input#txtIcono').val();
        /*Validacion para login*/
        if(Descripcion == '') {
            $("#Mensaje").append("<span  class='red'>* El Nombre del Menu esta Vacio</span>");
            $('input#txtdescripcion').focus();
            return false;
        }
        if(Url == '') {
            $("#Mensaje").append("<span  class='red'>* El Url esta Vacio</span>");
            $('input#txturl').focus();
            return false;
        }
        if(Descripcion != '' & Url != ''){
            $("#Mensaje").append("<span  class='red'><img src='assets/img/ajax-loader.gif'> Enviando Peticion...</span>");
            var datos = 'id='+Id+'&descripcion='+Descripcion+'&url='+Url+'&orden='+Ordenamiento+'&estatus='+Estatus;
            /*Creamos el objeto y le agregamos la imagen*/
            var formData = new FormData($(".formulario")[0]);
            /*Le agregamos las cajas de texto el objeto*/
            formData.append("id",Id);
            formData.append("descripcion",Descripcion);
            formData.append("url",Url);
            formData.append("orden",Ordenamiento);
            formData.append("estatus",Estatus);
            formData.append("icono",IdIconoEdicio);
            $.ajax({ 
                type : 'POST',
                data   : formData,
                cache: false,
                contentType: false,
                processData: false,
                url  : 'GuardaEdicionMenu.php',
                success: function(responseText){ 
                    $("#Mensaje").html('');
                    if(responseText==1){
                        $("#Mensaje").append("<span  class='green'> Actualización Realizada Correctamente</span>");
                    }else if(responseText==2){
                        $("#Mensaje").append("<span  class='red'>Error: No Tienes Permisos para Actualizar Este Modulo</span>");
                    }else{
                        $("#Mensaje").append("<span  class='red'>Hubo un Error. Intente mas Tarde!!!. "+responseText+"</span>");
                    }
                }
            });
            return false;
        }
    });
//Fin del formulario para edicion
});
