<?php
include('config.php');
include_once("Jsonresponse.php");
session_start();
class login {

		public static function login_user($username, $password )
		{
			if($username == '' || $password == 'd41d8cd98f00b204e9800998ecf8427e' ) {
	     login::json_respond(1,1, "Please fill the form completely");
		 } else {
			 $connection = Jsonresponse::dbconnect();
			 $search = $connection->prepare("SELECT * FROM user where username = :username AND password = :password");
			 $search->bindParam(':username',$username);
			 $search->bindParam(':password',$password);
			 $search->execute();
			 $count = $search->rowCount();
			 $row = $search->fetch(PDO::FETCH_BOTH);
		 	if( $count >= 1 ) {
				$session = md5(rand(1000,100000).$row['user_id']);
				$session_update = $connection->prepare("UPDATE user SET session_id = :session WHERE user_id = :user_id");
 			  $session_update->bindParam(':session',$session);
				$session_update->bindParam(':user_id', $row['user_id']);
				$session_update->execute();
				$_SESSION['user'] = $session;
				if($row['status'] === 'never') {
					login::json_respond(0,0,"never");
				}
				if($row['status'] === 'admin' ) {
					// redirect to admin page
					$_SESSION['login'] = 'admin';
					login::json_respond(1,0, "");
				}
				 else if($row['status'] === 'yes' ) {
					$_SESSION['login'] = "true";
					login::json_respond(0,1, "");
				}
				else if($row['status'] == 'decline') {
					unset($_SESSION['user']);
					login::json_respond(0,0, "decline");
				}
				else {
					unset($_SESSION['user']);
					login::json_respond(0,0, "no");
				}
			}
			else {
				login::json_respond(1,1, "Wrong email or password");
			}
		 }
		}

		public static function json_respond($admin, $success, $information) {

			if($success == 0 && $admin == 0) {
				unset($_SESSION['user']);
				unset($_SESSION['login']);
				if($information == 'no') {
					$data['location'] = "verified.html";
				}
				else if($information == 'never'){
					$data['location'] = 'process.html';
				} else {
					$data['location'] = "decline.html";
				}
				$data['result'] = '';
			}
			else if($admin == 1 && $success == 0) {
				$data['location'] = 'src/admin/home.php';
				$data['result'] = '';
			}
			else if($success == 1 && $admin == 0 ) {
				$data['location'] = 'src/home_page.php';
				$data['result'] = '';
			}
			else if( $success == 1 && $admin == 1) {
				$data['location'] = '';
				$data['result'] = $information;
			}
	    Jsonresponse::json_response( 200, "OK", $data );
	  }
}
?>
