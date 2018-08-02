<?php
include('../../login_auth.php');
if( $_SESSION['login'] != 'admin' ) {
    header('Location: ../../login.php');
}
?>
<head>
<meta charset="utf-8">
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
  <script src="../../js/jquery.min.js"></script>
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <script src="../../bootstrap/popper.min.js"></script>
  <script type="text/javascript" src="../../js/nav.js"></script>
  <script type="text/javascript" src="../../js/users_get.js"></script>
</head>
<body>
  <div id="nav">
  </div>
  <div class="container">
    <h1>Users:</h1>
    <div class="upload_content">

    </div>
  </div>
</body>
</html>
