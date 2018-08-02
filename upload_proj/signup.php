<?php
include('login_auth.php');
include('sql/dbcheck.php');
include('sql/dbcreate.php');
if( $_SESSION['login'] == 'true' || $_SESSION['login'] == 'admin' ) {
  $_SESSION['login'] = 'false';
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
  <script type="text/javascript" src="js/app.js" ></script>
  <script src="js/nav.js" ></script>
  <script type="text/javascript" src="js/country_handle.js"></script>
<style>
.card-header {

background: #ffffff;
}
.register-message {
  text-align: center;
}
</style>
</head>
<body>
  <div id="nav">
  </div>
<div class="container">
<br><br><br>
<div class="register-message">
</div>
<br>
<div class="row">
<div class="col-md-6 offset-md-3 card">
<div class="card-block"><h1>Signup</h1></div>
<hr>
  <form class="form-horizontal" id="register-form">
    <div class="row">
    <div class="form-group col-md-6">
      <label for="username">Username:</label>
        <input id="username" type="text" class="form-control" placeholder="Enter username" name="username">
    </div>
    <div class="form-group col-md-6">
        <label for="email">email:</label>
          <input id="email" type="email" class="form-control" placeholder="Enter email" name="email">
      </div>
    <div class="form-group col-md-6">
      <label for="password">Password:</label>
        <input id="password" type="password" class="form-control" placeholder="Enter password" name="password">
    </div>
	 <div class="form-group col-md-6">
      <label for="repass">Confirm password:</label>
        <input id="repass" type="password" class="form-control" placeholder="Enter password" name="repass">
    </div>
    <div class="form-group col-md-6">
      <label for="countries">Country: </label>
      <select class="custom-select" id="countries">
        <option value="none" selected>None</option>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="states">state: </label>
      <select class="custom-select" id="states">
        <option value="none" selected>None</option>
      </select>
    </div>
    <div class="form-group col-md-6">
       <label for="mobile">Mobile:</label>
     <input id="mobile" type="text" class="form-control" name="mobile" placeholder="enter mobile number">
   </div>
    </div>
</form>
<div class="form-group" id="button">
    <button type="submit" class="btn btn-primary btn-block" id="register">SignUp</button>
  </div>
</div>
</div>
</div>
<br><br>
</body>
</html>
