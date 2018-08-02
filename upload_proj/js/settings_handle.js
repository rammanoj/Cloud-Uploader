$(document).ready(function(){
  var addr = '../BaseClass.php';
  details_display();
  $(".update").click(function(){
    var attribute = $(this).attr('id').split("_");
    if(attribute[0] != 'password' && attribute[0] != 'location' ) {
      $(".btn-danger").click();
      $("#loading").modal('show');
        $.post(addr,{
          attribute: attribute[0],
          value: $("#" + attribute[0] + "_in").val(),
          action: 'settings'
        }, function( data ) {
            console.log(data);
            $("#loading").modal('toggle');
            $('#message').text('');
            if(data.data.hasOwnProperty('result'))
            {
              $("#message").append("<div class='alert alert-success'>"+data.data.result+"</div>");
            }
            else {
              $("#message").append(data.data);
            }
            details_display();
        });
    } else if(attribute[0] == 'password') {
      $(".btn-danger").click();
      $("#loading").modal('show');
      $.post(addr,{
        attribute: attribute[0],
        old_password: $.md5($("#old_" + attribute[0]).val()),
        new_password: $.md5($("#" + attribute[0] + "_in_1").val()),
        confirm_password: $.md5($("#" + attribute[0] + "_in_2").val()),
        action: 'settings'
      }, function(data){
        $("#loading").modal('toggle');
        $('#message').text('');
        $('#message').append(data.data);
        details_display();
      });
    }
    else {
      //update both country and state
      $("#loading").modal('show');
      console.log("change location");
      $(".btn-danger").click();
      $.post(addr, {
        action: 'settings',
        attribute: 'location',
        country: $("#country_in").val(),
        state: $("#state_in").val()
      }, function(data){
        console.log(data);
        $("#loading").modal('toggle');
        $('#message').text('');
        $("#message").append(data.data);
        details_display();
      })
    }
  });

  function details_display() {
    $("#loading").modal('show');
    $.post(addr, {
      attribute: 'get_value',
      action: 'settings'
    }, function(data) {
      $("#loading").modal('toggle');
      console.log(data);
      $('#username_value').text(data.data.username);
      $('#password_value').text(data.data.password);
      $('#email_value').text(data.data.email);
      $('#mobile_value').text(data.data.mobile);
      $('#country_value').text(data.data.country);
      $('#state_value').text(data.data.state);
    });
  }
});
