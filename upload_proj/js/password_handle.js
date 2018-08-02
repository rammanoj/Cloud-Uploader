$(document).ready(function(){

  $("#submit").click(function(){
    this.disabled = true;
    $(this).addClass( 'disabled' );
    $(this).text(' loading... please wait' );
    $.post('BaseClass.php', {
      action: 'forgot_password',
      email: $("#email").val(),
    }, function(data){
      document.getElementById('submit').disabled = false;
      $("#submit").removeClass( 'disabled' );
      $("#submit").text(' Submit' );
      console.log(data);
      $(".message").text('');
      $(".message").append(data.data.result);
    })
  })
})
