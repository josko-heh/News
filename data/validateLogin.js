$('document').ready(function(){

    $('#username').on('blur', function(){
     var username = $('#username').val().trim();
     if (username == '') {  
         return;
     }
     $.ajax({
       url: '../data/LoginAndReg.php',
       type: 'post',
       data: {
           'username_check' : 1,
           'username' : username,
       },
       success: function(response){
         if (response == 'taken' ) {
            $('#noUsernameAlert').hide();
         }else if (response == 'not_taken') {
            $('#noUsernameAlert').show();
         }else if(response == 'error'){
            console.log("username_check error");
         }
       }
     });
    });		
   
    $('input[name="submit"]').on('click', function(event){ 
        $('.alert').hide();

        var username = $('#username').val().trim();
        var password = $('#password').val();

        $.ajax({
            url: '../data/LoginAndReg.php',
            type: 'post',
            data: {
                'login' : 1,
                'username' : username,
                'password' : password,
            },
            success: function(response){
                if(response.substr(0,9) == "logged-in"){
                    let name = response.substr(10, response.length-10);
                    $('#loginAlert').html('Hello '+ name +'!');
                    $('#loginAlert').show();

                    $('#username').val('');
                    $('#password').val('');
                }else if(response == "failed_login") {
                    $('#loginAlert').html('Login failed. <a href="registration.html">Register here.</a>');
                    $('#loginAlert').show();
                }else if(response == 'error'){
                    $('#loginAlert').html('Login error');
                    $('#loginAlert').show();
                    console.log("login error");
                }
                console.log("response: " + response);
            },
            error: function(){alert("Error");}
        });
    });
   });