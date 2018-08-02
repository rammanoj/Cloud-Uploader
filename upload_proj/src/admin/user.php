<?php
include('../../login_auth.php');
if( $_SESSION['login'] != 'admin' ) {
    header('Location: ../../login.php');
}
?>
<html>
<head>
<meta charset="utf-8">
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
  <script src="../../js/jquery.min.js"></script>
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <script src="../../bootstrap/popper.min.js"></script>
  <script type="text/javascript" src="../../js/nav.js"></script>
  <script>
  $(document).ready(function(){
  $(document).on('keyup', "#search", function() {
   var value = $(this).val().toLowerCase();
   $(".table tr").filter(function() {
     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
   });
 });
  var path = window.location.href.split("?")[1];
  var param = path.split("&")[1];
  param = param.split("=")[1];
  $.get('../../BaseClass.php', {
    action: 'get_user',
    id: param
  }, function(user_data) {
    var data = ' <h2>Name: ' + user_data.data.username + '</h2> <h2>email: ';
    data += user_data.data.email + '</h2> <h2>mobile: ' + user_data.data.mobile;
    data += '</h2> <h2>country: ' + user_data.data.country + '</h2> <h2>state: ';
    data += user_data.data.state + '</h2> <h2>directory: ' + user_data.data.directory + '</h2>';
    $(".card").prepend(data);
    $.get('../../BaseClass.php', {
      id: param,
      action: 'user_uploads'
    }, function(response) {

      $("table").append('');
        if(response.data[0].confirm == 'no') {
          content = "<h2 style='color:red;'>" + response.data[0].details;
        } else {
          var content = "<thead><tr><th>Name</th><th>Date uploaded</th><th>File path</th></tr></thead>";
          for(var i=1; i< response.data.length; i++) {
            content += "<tr><td>" + response.data[i].name + "</td>";
            content += "<td>" + response.data[i].date_uploaded + "</td>";
            content += "<td>" + response.data[i].file_path + "</td></tr>";
          }
        }
        $('.upload_content').prepend("Search: <input type='text' placeholder='Search here...' id='search'><br><br>");
        $("table").append(content);
    });
  });
});
  </script>
  <style>
  h2 {
    padding: 2%;
  }
  </style>
</head>
<body>
  <div id="nav">
  </div>
  <div class="container">
    <br>
    <h1> User details: </h1>
    <div class="card" style="width: 100%;background:#F5F5F5">
    </div><br>
    <div class="upload_content">
      <table class="table table-hover">
      </table>
    </div>
  </div>
</body>
</html>
