<?php
include('login_auth.php');
include('sql/dbcheck.php');
include('sql/dbcreate.php');
if( $_SESSION['login'] == 'true' || $_SESSION['login'] == 'admin' ) {
  $_SESSION['login'] = false;
  unset($_SESSION['login']);
  unset($_SESSION['user']);
}
else {
  if( Dbcheck::check_existence() < 1 ) {
    Dbcreate::setup_db();
  }
}
 ?>
<html>
<head>
<meta charset="utf-8">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.md5.js" ></script>
  <script type="text/javascript" src="js/app.js"></script>
  <script type="text/javascript" src="js/nav.js"></script>
<style>
.card-header {

background: #ffffff;
}
.login-message {
  text-align: center;
}
</style>
</head>
<body>
<div id="nav">
</div>
<div class="container">
<br><br><br><br><br><br>
<div class="login-message">
</div>
<br>
<div class="row">
<div class="col-md-4 offset-md-4 card">
<div class="card-header"></span><h1>Login</h1></div>
<div class="card-body">
<form class="form-horizontal login-form">
    <div class="form-group">
      <label class="control-label">Username:</label>
        <input class="form-control" placeholder="Enter username" name="username" id="username">
    </div>
    <div class="form-group">
      <label class="control-label">Password:</label>
	 <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input type="password" class="form-control" placeholder="Enter password" name="password" id="password">
    </div>
    <!-- <div class="checkbox">
  	<label><input type="checkbox" value=""> Remember</label>
    </div> -->
    <a class="forgot" href="password_change.html"> forgot password?</a><br>
    <a class="signup" href="signup.php"> don't have an account?</a>
    <br>
</form>
<div class="form-group">
<button type="submit" class="btn btn-primary btn-md" id="login">Login</button>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
