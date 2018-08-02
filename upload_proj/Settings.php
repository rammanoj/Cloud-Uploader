<?php
class Settings {

  public static function details($value, $id) {
    $connection = Jsonresponse::dbconnect();
    $user_details = $connection->prepare("SELECT * FROM user WHERE session_id = :id");
    $user_details->bindParam(':id', $id);
    $user_details->execute();
    $user = $user_details->fetch(PDO::FETCH_ASSOC);
    if($value == 'null')
    {
      $details = new stdClass();
      $details->username = $user['username'];
      $details->password = "***********";
      $details->email = $user['email'];
      $details->mobile = $user['mobile'];
      $details->country = $user['country'];
      $details->state = $user['state'];
      Jsonresponse::json_response(200, "OK", $details );
    }
    else {
      switch($value)
        {
          case 'username':
            return $user['username'];
            break;
          case 'password':
            return $user['password'];
            break;
          case 'email':
            return $user['email'];
            break;
          case 'mobile':
            return $user['mobile'];
            break;
          case 'country':
            return $user['mobile'];
            break;
          case 'state':
            return $user['mobile'];
            break;
          case 'path':
            return $user['directory'];
            break;
        }
    }
  }

  public static function set_details($value, $details, $id)
  {
    $connection = Jsonresponse::dbconnect();
    $user_details = $connection->prepare("UPDATE user SET $value = :value WHERE session_id = :id");
    $user_details->bindParam(':value', $details);
    $user_details->bindParam(':id', $id);
    $user_details->execute();
    $count = $user_details->rowCount();
    if($count > 0 ) {
      Jsonresponse::json_response(200, "OK", "<div class='alert alert-success'>Sucessfully updated</div>");
      exit(0);
    } else {
      Jsonresponse::json_response(200, "OK", "<div class='alert alert-danger'>Please enter a different value</div>");
    }
  }

  public static function get_username($id) {
    return self::details('username', $id);
  }

  public static function get_password($id) {
    return self::details('password', $id);
  }

  public static function get_email($id) {
    return self::details('email', $id);
  }

  public static function get_mobile($id) {
    return self::details('mobile', $id);
  }
  public static function get_country($id) {
    return self::details('country', $id);
  }
  public static function get_state($id) {
    return self::details('state', $id);
  }
  public static function get_path($id) {
    return self::details('path', $id);
  }
  public static function set_handle($attribute, $value, $id) {
    if($attribute != 'password' && $attribute != 'location' ) {
      if($value == '') {
        Jsonresponse::json_response(200, "OK", "<div class='alert alert-danger'>Please enter any value</div>");
      }
    } else if($attribute == 'password') {
      if($value['password_1'] == 'd41d8cd98f00b204e9800998ecf8427e') {
        Jsonresponse::json_response(200, "OK", "<div class='alert alert-danger'>Please enter any value</div>");
      }
      if( strlen($value['password_1']) < 10 )
      {
        Jsonresponse::json_response(200, "OK", "<div class='alert alert-danger'>Password must be of length 10</div>");
      }
        if(self::get_password($id) == $value['old_password']) {
          if( $value['password_1'] == $value['password_2'] ) {
            self::set_details('password', $value['password_1'], $id);
          }
           else {
            Jsonresponse::json_response(200,"OK", "<div class='alert alert-danger'>Confirm your password correctly</div>");
          }
        }
         else {
          Jsonresponse::json_response(200,"OK", "<div class='alert alert-danger'>Enter current password correctly</div>");
        }
    }
    if($attribute == 'location')
    {
      if( $value['country'] == 'none' || $value['state'] == 'none' )
      {
        Jsonresponse::json_response(200, "Ok", "<div class='alert alert-danger'>Please choose your location correctly</div>");
      }
      $user_details = Jsonresponse::dbconnect()->prepare("UPDATE user SET country = :country, state = :state WHERE session_id = :id");
      $user_details->bindParam(':country', $value['country']);
      $user_details->bindParam(':state', $value['state']);
      $user_details->bindParam(':id', $id);
      $user_details->execute();
      $count = $user_details->rowCount();
      if($count > 0 ) {
        Jsonresponse::json_response(200, "OK", "<div class='alert alert-success'>Location sucessfully updated</div>");
      } else {
        Jsonresponse::json_response(200, "OK", "<div class='alert alert-danger'>Don't enter same city again</div>");
      }
    }
    if($attribute == 'mobile') {
      if( strlen($value) != 10 || !ctype_digit($value) ) {
        Jsonresponse::json_response(200,"OK", "<div class='alert alert-danger'>Enter a valid number</div>");
      }
      // if(!is_int($value)) {
      //   Jsonresponse::json_response(200, "Ok", "<div class='alert alert-danger'>Phone number must be integer</div>" );
      // }
    } else if($attribute == 'email') {
      if( !filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
				Jsonresponse::json_response(200,"OK", "<div class='alert alert-danger'>Please enter a valid email</div>");
				die();
			}
    }
    if($attribute == 'username' || $attribute == 'email' )
    {
      $user_check = Jsonresponse::dbconnect()->prepare("SELECT * FROM user WHERE $attribute = :attr");
      $user_check->bindParam(':attr', $value);
      $user_check->execute();
      $count_user = $user_check->rowCount();
      $fetch_data = $user_check->fetch(PDO::FETCH_ASSOC);
      if($count_user > 0 )
      {
        Jsonresponse::json_response(200,"OK", "<div class='alert alert-danger'>$attribute already taken, please choose different one</div>");
      }
      if( $attribute == 'email' )
      {
        $mail_attributes = get_defined_constants(true);
        $subject = $mail_attributes['user']['subject_3'];
        $message = $mail_attributes['user']['message_3'];
        $_SESSION['email'] = $value;
        sendmail::send_mail($subject, $fetch_data['username'], $value, $message);
      }
    }
    self::set_details($attribute, $value, $id);
  }
}
 ?>
