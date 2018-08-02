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
  <!-- <script src="../bootstrap/popper.min.js"></script> -->
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="../js/nav.js"></script>
  <script src="../js/directory.js"></script>
  <style>
  img {
    margin: 5%;
    width: 50%;
    height: 60%;
    cursor: pointer;
  }
  </style>
</head>
<body>
  <div id="nav">
  </div>
    <div class="container">
      <br>
      <h1> Select path to upload... </h1>
        <div class="row">

        </div>
        <div class="path">
          <p id="dir_path"><b>Path:</b></p>
        </div>
    </div>

    <!-- loading modal -->
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
</body>
</html>
