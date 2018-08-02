$(document).ready(function(){
  $('button[value="accept"]').click(function(){
    var id = $(this).closest('a').attr('id');
    var directory= $("#direct_"+id).val();
    console.log('' + directory);
    if (directory == '') {
      $("#message").text('');
      $("#message").append("<div class='alert alert-danger'>Please choose directory</div>");
    }  else {
      $.post('../../BaseClass.php', {
        action: 'status',
        id: id,
        value: 'yes',
        directory: ''+directory
      },
      function(data) {
          $("#" + id).remove();
        })
    }
  });
  $('button[value="decline"]').click(function(){
    var id = $(this).closest('a').attr('id');
    $.post('../../BaseClass.php', {
      action: 'status',
      value: 'decline',
      id: id,
    },
    function(data) {
      $("#" + id ).remove();
    });
  });
});
