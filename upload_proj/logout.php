<?php
include('login_auth.php');
if( $_SESSION['login'] == 'true' || $_SESSION['login'] == 'admin' ) {
  $_SESSION['login'] = false;
  unset($_SESSION['login']);
  $var = '';
  $query = Jsonresponse::dbconnect()->prepare("SELECT * FROM user where session_id = :session");
  $query->bindParam(':session', $_SESSION['user']);
  $query->execute();
  $fetch = $query->fetch(PDO::FETCH_ASSOC);
  $query1 = Jsonresponse::dbconnect()->prepare("UPDATE user set session_id = :id where user_id = :user");
  $query1->bindParam(':id', $var);
  $query1->bindParam(':user', $fetch['user_id']);
  $query1->execute();
  unset($_SESSION['user']);
  if(isset($_SESSION['email'])) {
    unset($_SESSION['email']);
  }
  $_SESSION = [];
}
 ?>
 <html>
 <head>
 <meta charset="utf-8">
 <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
 <script src="js/jquery.min.js"></script>
   <script src="js/nav.js" ></script>
 </head>
 <body>
   <div id="nav">
   </div>
   <div class="container">
       <div class="row align-items-center h-100">
         <div class="offset-md-4 col-md-4 card">
           <div class="card-header" style="background:white">
             <h5>Logged out</h5>
           </div>
           <div class="card-body">
             Successfully logged out<br><br>
              <a href="login.php"><button type="button" class="btn btn-outline-primary">Login</button></a>
              <a href="signup.php"> <button onclick="signup.php" type="button" class="btn btn-outline-primary">Signup</button></a>
           </div>
         </div>
       </div>
   </div>
 </body>
 </html>
