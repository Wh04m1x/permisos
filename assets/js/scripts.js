jQuery(document).ready(function() {
    $('input#usuario_login').focus();
    $('.register form').submit(function(){
        /*Datos para validacion login*/
        $(this).find("label[for='usuario_login']").html('Usuario:');
        $(this).find("label[for='password_login']").html('Password:');
        $(this).find("label[for='Mensaje']").html('');
        /*Datos para validacion login*/
        var Usuario_login  = $(this).find('input#usuario_login').val();
        var Password_login = $(this).find('input#password_login').val(); 
        /*Validacion para login*/
        if(Usuario_login == '') {
            $(this).find("label[for='usuario_login']").append("<span style='display:none' class='red'> * El Usuario Esta Vacio.</span>");
            $(this).find("label[for='usuario_login'] span").fadeIn('medium');
            $('input#usuario_login').focus();
            return false;
        }
        if(Password_login == '') {
            $(this).find("label[for='password_login']").append("<span style='display:none' class='red'> * El Password Esta Vacio.</span>");
            $(this).find("label[for='password_login'] span").fadeIn('medium');
            $('input#password_login').focus();
            return false;
        }
        if(Usuario_login != '' & Password_login != ''){
            $("#Mensaje").append("<span  class='red'><img src='assets/img/ajax-loader.gif'> Solicitando Peticion...</span>");
            var datos = 'username='+Usuario_login+'&password='+Password_login;
            $.ajax({ 
                type : 'POST',
                data : datos,
                url  : 'login.php',
                success: function(responseText){ 
                    $("#Mensaje").html('');
                    if(responseText==0){
                        $("#Mensaje").append("<span  class='red'>* Usuario/Password Incorrecto</span>");
                    }
                    if(responseText==1){
                        window.location="principal.php";
                    }
                    if(responseText==2){
                        $("#Mensaje").append("<span  class='red'>* La cuenta esta inhabilitada</span>");
                    }
                    if(responseText==3){
                        $("#Mensaje").append("<span  class='red'>* La cuenta no ha sido Verificada</span>");
                    }
                }
            });
            return false;
        }
    });
});
