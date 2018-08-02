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
</head>
<body>
  <div id="nav">
  </div>
  <div class="container">
    <br>
    <h1> View all files uploaded </h1>
    <br>
  Enter date <input id="input_date" type="date" value="<?php echo date("Y-m-d"); ?>"><br><br>
  <button id="preview_date" class="btn btn-outline-primary"> Get uploads </button>
  <br><br>
  <div class="upload_content">
    <!-- <input type="text" id="search"> -->
  </div>
  </div>
  <div class="modal" id="loading" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <center><img src="../../img/loading.gif"></center>
          <center><h2>Loading....</h2></center>
      </div>
    </div>
    </div>
  </div>
<script>
$(document).ready(function(){
  $(document).on('keyup', "#search", function() {
   var value = $(this).val().toLowerCase();
   $(".table tr").filter(function() {
     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
   });
 });
  $('#preview_date').on('click', function() {
      $("#loading").modal("show");
      $.get('../../BaseClass.php', {
        date: $("#input_date").val(),
        action: 'preview_date',
      }, function(response) {
        console.log(response);
          $("#loading").modal("toggle");
          $(".upload_content").text('');
          if(response.data[0].confirm == 'no') {
            $(".upload_content").append("<h2 style='color:red;'>"+response.data[0].details+"</h2>");
          } else if(response.data.length == 1 ) {
            $(".upload_content").append("<h2 style='color:red;'>No uploads on the date</h2>");
          } else {
            var content = "<table class='table table-hover'><thead><tr><th>file name</th><th>file path</th><th>User</th><th>date uploaded</th></tr></thead>";
            for(var i=1; i< response.data.length; i++) {
              content +='<tr><td>'+response.data[i].name + '</td><td>'+response.data[i].file_path + '</td><td>';
              content += response.data[i].user + "</td><td>" + response.data[i].date_uploaded + '</td></tr>';
            }
            content += "</table>";
            $('.upload_content').append("Search: <input type='text' placeholder='Search here...' id='search'><br><br>");
            $(".upload_content").append(content);
          }
      });
  });
});
  </script>
</body>
</html>
