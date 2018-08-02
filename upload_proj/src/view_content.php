<?php
include('../login_auth.php');
if( $_SESSION['login'] != 'true' ) {
    header('Location: ../login.php');
}
?>
<html>
<head>
<meta charset="utf-8">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="../bootstrap/popper.min.js"></script>
  <script type="text/javascript" src="../js/nav.js"></script>
  <script type="text/javascript" src="../js/country_handle.js"></script>
  <script>
  $(document).ready(function(){
  $(document).on('keyup', "#search", function() {
   var value = $(this).val().toLowerCase();
   $(".table tr").filter(function() {
     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
   });
 });
});
  </script>
</head>
<body>
  <div id="nav">
  </div>
  <br>
<div class="container">
  <h1>View Uploaded content</h1>
<br>
Enter date <input id="input_date" type="date" value="<?php echo date("Y-m-d"); ?>"><br><br>
<button id="preview_date" class="btn btn-outline-primary"> Get uploads </button>
<br><br>
<div class="upload_content">
</div>
<div class="modal" id="loading" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <center><img src="../img/loading.gif"></center>
        <center><h2>Loading....</h2></center>
    </div>
  </div>
  </div>
</div>
</div>
</body>
</html>
