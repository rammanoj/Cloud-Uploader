<?php
include('signup_auth.php');
include('Settings.php');
include('sendmail.php');
include('Operate.php');
class BaseClass {

public function get_request() {

  /*
  * for logging-in users
  */
  if($_POST['action'] == 'login' ) {
    login::login_user( $_POST['username'], $_POST['password'] );
  }

  /*
  * for signing-in users
  */
  else if($_POST['action'] == 'register' ) {
    Register::signup($_POST['username'], $_POST['length'], $_POST['password'], $_POST['repass'],
              $_POST['email'], $_POST['country'], $_POST['state'],
              $_POST['mobile'], $_POST['length'] );
  }

  else if( !empty($_GET['action']) && $_GET['action'] == "confirm_reg" ) {
    $connect = Jsonresponse::dbconnect();
    // the hash exsits change status to 'yes'
    $query_1 = $connect->prepare( "UPDATE user SET status = :status WHERE user_id = :hash");
    $query_1->bindParam(':status', $status = "no" );
    $query_1->bindParam(':hash', $_GET['hash'] );
    $query_1->execute();
    $count_1 = $query_1->rowCount();
    if( $count_1 == 1 ) {
      // move to login page with indication email verified.
      header( 'Location: verified.html' );
    } else {
      header("HTTP/1.0 404 Not Found");
      echo "<h1>There might be some internal error please register again.</h1>";
    }
  }

  /*
  * for navbar
  */
  else if( $_POST['action'] == 'navbar' ) {
    echo $_SESSION['login'];
  }

  else if($_POST['action'] == 'upload') {
    Operate::upload_files($_POST['dir']);
  }
  else if($_GET['action'] == 'preview_date') {
    Operate::preview_date($_GET['date']);
  }
  else if($_GET['action'] == 'directory' ) {
    $query = Jsonresponse::dbconnect()->prepare("SELECT * FROM user where session_id = :id");
    $query->bindParam(':id', $_SESSION['user']);
    $query->execute();
    $rv = $query->fetch(PDO::FETCH_ASSOC)['directory'];
    Jsonresponse::json_response(200, "OK", $rv);
  }

  else if( $_GET['action'] == 'users_view' ) {
    Operate::all_users();
  }

  else if( $_POST['action'] == 'forgot_password' ) {
    Operate::change_password($_POST['email']);
  }
  else if( $_GET['action'] == 'get_user') {
    Operate::get_user($_GET['id']);
  }
  else if($_GET['action'] == 'get_dir') {
      Operate::construct_directory($_GET['path']);
  }

  else if( $_GET['action'] == 'user_uploads') {
    Operate::get_user_uploads( $_GET['id'] );
  }
  /*
  * list of users (to be processed)
  */
  else if( $_GET['action'] == 'users' ) {
    $var = 'no';
    $connection = Jsonresponse::dbconnect();
    $user = $connection->prepare('SELECT * FROM user WHERE status = :status');
    $user->bindParam(':status', $var );
    $user->execute();
    $details = $user->fetchall(PDO::FETCH_ASSOC);
    $values = '';
    for( $i=0; $i < sizeof($details); $i++ ) {
      $rv = $details[$i]['username'].','.  $details[$i]['email']. ','. $details[$i]['user_id'];
      $values .= $rv.';';
    }
    echo(($values));
  }

  else if( $_POST['action'] == 'status' ) {
    Operate::change_status( $_POST['id'], $_POST['value'], $_POST['directory'] );
  }

  else if( $_POST['action'] == 'settings' ) {
    if($_POST['attribute'] == 'get_value' ) {
      Settings::details('null', $_SESSION['user']);
    }
    else if($_POST['attribute'] == 'password') {
      $value['old_password'] = $_POST['old_password'];
      $value['password_1'] = $_POST['new_password'];
      $value['password_2'] = $_POST['confirm_password'];
      Settings::set_handle('password', $value, $_SESSION['user']);
    }
    else if($_POST['attribute'] == 'location' ) {
      $value['country'] = $_POST['country'];
      $value['state'] = $_POST['state'];
      Settings::set_handle('location', $value, $_SESSION['user']);
    }
    else {
      Settings::set_handle($_POST['attribute'], $_POST['value'], $_SESSION['user']);
    }
  }
  else if( $_GET['action'] == 'change_email') {
    if(isset($_SESSION['user']) && !empty($_SESSION['user']))
    {
      if(isset($_SESSION['email']) && !empty($_SESSION['email']))
      {
        $query = Jsonresponse::dbconnect()->prepare("UPDATE user SET email = :email WHERE session_id = :id");
        $query->bindParam(':email', $_SESSION['email']);
        $query->bindParam(':id', $_SESSION['user']);
        $query->execute();
        if( $query->rowCount() == 0)
        {
          echo "Your email already changed, or can't set to same value again";
        }
        else {
          {
            header('Location: src/settings.php');
          }
        }
      }
      else {
        {
          header('Location: response/rechange.html');
        }
      }
    }
    else
    {
      header('Location: response/log.html');
    }
  }
}
}
$api = new BaseClass();
$api->get_request();

 ?>
