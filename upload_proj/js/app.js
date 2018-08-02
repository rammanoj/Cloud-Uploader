$(document).ready(function(){
    $('.register-message' ).text( '' );
  $('#register').click(function() {
    this.disabled = true;
    $(this).addClass( 'disabled' );
    $(this).text(' loading... please wait' );
    var formData = new FormData( $( '#register-form' )[0] );
    $.post('BaseClass.php',
     {
        username: $('#username').val(),
        length: $('#password').val().length,
        password: $.md5( $('#password').val() ),
        repass: $.md5( $('#repass').val() ),
        email: $('#email').val(),
        country: $('#countries').val(),
        mobile: $('#mobile').val(),
        state: $('#states').val(),
        action: 'register'
      },
      function( data ) {
        console.log(data);
        $('.register-message' ).text( '' );
        if( data.data.location != "" ) {
          // redirect to inside page
          location.href = data.data.location;
        }
        else {
          $( '.register-message' ).append( '<h4>' + data.data.result + '</h4>' )
                               .css( 'color', 'red' );
          document.getElementById( 'register' ).disabled = false;
          //}
          $('#register').text( 'SignUp' );
          $('#register').removeClass( 'disabled' );
            $("html, body").animate({ scrollTop: 0 }, "slow");
          }
      } );
  });
  $('#login').click(function(){
    console.log("manoj");
    this.disabled = true;
    $(this).addClass( 'disabled' );
    $(this).text(' loading... please wait' );
     var formData = new FormData( $( '#login-form')[0] );
    $.post('BaseClass.php', {

      username: $('#username').val(),
      password: $.md5($('#password').val()),
      action: 'login'
    },
      function( data ) {
        console.log(data);
        $('.login-message' ).text( '' );
        console.log(data);
        if( data.data.location !== "") {
          // redirect to inside page
          location.href = data.data.location;
        }
        else {
          $( '.login-message' ).append( '<h4>' + data.data.result + '</h4>' )
                               .css( 'color', 'red' );
          }
          document.getElementById( 'login' ).disabled = false;
          $('#login').text( 'Login' );
          $('#login').removeClass( 'disabled' );
          this.disabled = false;
      });
  });
});
