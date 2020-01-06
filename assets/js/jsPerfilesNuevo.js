jQuery(document).ready(function() {
        //Guardamos Cambios
        $('.register form').submit(function(){
                $("#Mensaje").html("<span></span>");
                var Bandera      = $(this).find('input#txtBandera').val();
                var IdPerfil     = $(this).find('input#txtIdPerfil').val(); 
                var IdMenu       = $(this).find('input#txtidMenu').val();
                var Descripcion  = $(this).find('input#txtdescripcion').val();
                var Estatus      = $(this).find('select#cbEstatus').val();
                var formData     = new FormData();
                formData.append("txtBandera",Bandera);
                formData.append("txtIdPerfil",IdPerfil);
                formData.append("txtidMenu",IdMenu);
                formData.append("txtdescripcion",Descripcion);
                formData.append("cbEstatus",Estatus);

                if(Descripcion==""){
                    $("#Mensaje").append("<span  class='red'>Error: El Campo Descripcion Esta Vacio</span>");
                    return false;
                }else{
                    /*Guardamos las opciones de permisos*/
                    $.ajax({ 
                    type : 'POST',
                    data   : formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    url  : 'GuardaPerfiles.php',
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
                }
                
        });
});