<?php
include( 'Jsonresponse.php' );
include('login_auth.php');
class Register {

  // register user
  public static function signup($username, $length, $password, $repass,
                                  $email, $country, $state, $phone ) {
    if( empty($username) || empty($password) || empty($repass) ||
        empty($country) ||  empty($email) ||
          empty($state) || empty($phone) ) {
      Register::json_respond(1, "Please fill form completely");
    } else {
      $connection = Jsonresponse::dbconnect();
      if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
				self::json_respond(1, "Please enter a valid email");
				die();
			}
      $user_check = $connection->prepare('SELECT * FROM user WHERE username = :username');
      $user_check->bindParam(':username', $username);
      $user_check->execute();
      $count_user = $user_check->rowCount();
      if($count_user > 0 )
      {
        self::json_respond(1, "Username already taken, please choose different one");
      }
      if( $length<10 ) {
				self::json_respond(1, "password must be atleast 10 characters, present: $length");
				die();
			}
      if( $password != $repass ) {
        self::json_respond(1, "Please enter same passwords both the times");
				die();
      }
      if( strlen($phone) != 10 && ctype_digit($phone) ) {
        self::json_respond(1, "Phone number must be 10 in length");
      }
      if( $country == 'none' || $state == 'none' ) {
        self::json_respond(1, "Please provide your state and country");
      }
			$query = $connection->prepare("SELECT * from user where email = :email" );
			$query->bindParam( ":email", $email );
      $query->execute();
			$count = $query->rowCount();
			if($count > 0) {
				self::json_respond(1, "The email is already registered");
				die();
			}
			else {
				$status = 'never';
        $user_id = md5($email.rand(10,1000));
        try {
				 $query1 = $connection->prepare("INSERT INTO user (username,password, user_id,email,mobile,state,country,length,status)
				  VALUES  ( :username,:password,:user_id,:email,:mobile,:state,:country,:length,:status )");
				 $query1->bindParam(":username",$username);
         $query1->bindParam(":user_id",$user_id);
				 $query1->bindParam(":password",$password);
				 $query1->bindParam(":email",$email);
				 $query1->bindParam(":state",$state);
				 $query1->bindParam(":mobile",$phone);
         $query1->bindParam(":country",$country);
         $query1->bindParam(":length",$length);
				 $query1->bindParam(":status", $status);
				 $query1->execute();
      } catch(Exception $e) {
          echo $e;
          die();
      }
				$count_3 = $query1->rowCount();
				if( $count_3 == 1 ) {
          // self::json_respond(0, "");
          self::send_mail($user_id, $username, $email);
        }
				else {
					self::json_respond(1, "There is some internal error please try again");
				}
        die();
			}
    }
  }
  public static function send_mail($hash, $username, $email ) {
    $mail_attributes = get_defined_constants(true);
    $subject = $mail_attributes['user']['subject_2'];
    $message = explode("<a href=", $mail_attributes['user']['message_2']);
    $url = $mail_attributes['user']['url'].$hash;
    //$url = "http://localhost/upload_proj/BaseClass.php?action=confirm_reg&hash=$hash";
    $mail_value = $message[0]."<a href=".$url.$message[1];
    $rv = sendmail::send_mail( $subject, $username, $email, $mail_value );
    return $rv;
  }

  // construct json response
  public static function json_respond($success, $information) {
    if($success == 0) {
      $data['location'] = "process.html";
      $data['result'] = $information;
    } else {
      $data['location'] = '';
      $data['result'] = $information;
    }
    Jsonresponse::json_response( 200, "OK", $data );
  }
}

 ?>
