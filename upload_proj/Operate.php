<?php
include("directory.php");
class Operate {

  public static function change_status($id, $value, $directory) {
    $connection = Jsonresponse::dbconnect();
    $status = $connection->prepare('UPDATE user SET status = :status, directory= :directory WHERE user_id = :id');
    $status->bindParam(':status', $value);
    $status->bindParam(':id', $id);
    $status->bindParam(':directory', $directory);
    $status->execute();
    echo 1;
  }
//don't worry about the dir presently you can get
// the location of the directory from the user and upload in that directoty later
// presenly you can upload to 'uploads' just
  public static function upload_files($directory) {
    if($directory == '') {
      self::json_respond("danger", "Please choose a directory");
    }
      if(count($_FILES['file']['name']) >= 1 ) {
        $array = array();
        $file_names = array();
        for($i=0; $i<count($_FILES['file']['name']); $i++) {

          if( isset($_FILES['file'][$i]) && $_FILES['file']['size'][$i] > 1000000 ) {
            //echo($_FILES['file']['size'][$i]);
            self::json_respond("danger", "Max file size is 30 MB");
            // die();
          }

          $type = explode("/", strtolower($_FILES['file']['type'][$i]))[1];
          if($type =='tiff' || $type =='tif' || $type == 'postscript' || $type == 'octet-stream'
           || $type == 'png' || $type == 'jpg' || $type == 'jpeg' ||$type =='x-icon' || $type == 'gif'
            || $type == 'bmp'|| $type == 'x-compressed'|| $type == 'x-zip-compressed'|| $type == 'zip'|| $type == 'x-zip'|| $type == 'csv'
          || $type == 'x-rar-compressed' || $type == 'octet-stream' || $type == 'mpeg3' || $type == 'x-mpeg3' || $type == 'mpeg' || $type == 'x-mpeg' || $type == 'wav'
          || $type == 'x-wav'|| $type == 'msword'|| $type == 'vnd.oasis.opendocument.text'|| $type == 'pdf'|| $type == 'rtf'|| $type == 'x-tex'|| $type == 'plain'|| $type == 'wordperfect'
        || $type == 'x-wav'|| $type == 'x-wav'|| $type == 'x-wav' || $type == 'mp4' || $type == 'x-ms-wma' || $type == 'vnd.ms-wpl' || $type == 'x-7z-compressed'
      || $type == 'vnd.adobe.photoshop' || $type == 'vnd.apple.keynote' || $type =='vnd.ms-works' || $type == 'vnd.ms-excel' || $type == 'x-shockwave-flash' || $type == 'x-ms-vob' || $type == 'x-ms-wmv'
    || $type =='vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $type == '3gpp2' || $type == '3gpp' || $type =='x-msvideo' || $type == 'x-flv' || $type == 'x-m4v' || $type == 'quicktime'
  || $type == 'vnd.openxmlformats-officedocument.wordprocessingml.document' || $type == 'vnd.wordperfect' || $type == 'wks') {

           } else {
             self::json_respond("danger", 'Supported formats: .mp3, .wav, .wma, .wpl, .7z, .rar, .zip, .csv, .ai, .bmp, .gif,
              .ico, .jpeg, .jpg, .png, .ps, .psd, .tif, .tiff, .key, .odp, .pps, .ppt, .pptx, .ods , .xlr , .xls , .xlsx, .3g2,
               .3gp, .avi , .flv, .m4v, .mov, .mp4, .mpg, .mpeg, .swf, .vob , .wmv , .doc  , .docx , .odt, .pdf , .rtf,
                .tex , .txt , .wks , .wps , .wpd');
           }
        }
        for($i=0; $i<count($_FILES['file']['name']); $i++) {
          $tmp_name = $_FILES['file']['tmp_name'][$i];
          if( $tmp_name != "" ) {
            $file_name = $_FILES['file']['name'][$i];
            $dir = "uploads/".$directory.date("Y-m-d")."/";
            if( !is_dir($dir) && !file_exists($dir) ) {
              mkdir($dir, 0777, true);
            }
            $file_path = $dir.$file_name;
            $file_exist = file_exists( $file_path );
            if( file_exists( "/var/www/html/upload_proj/".$file_path ) ) {
              self::json_respond("danger", "File already exists");
            }
            $move = move_uploaded_file($tmp_name, $file_path);
            $save_name = md5($_SESSION['user'].$file_name);
            $extension = explode( ".",$file_name)[1];
            rename($file_path, $dir.$save_name.".".$extension);
            if($move) {
              $array[$i] = $dir.$save_name.".".$extension;
              $file_names[$i] = $file_name;
            } else {
              $array[$i] = 0;
            }
          }
        }
        for($i=0;$i<sizeof($array);$i++) {
          if($array[$i] === 0 ) {
            self::json_respond("danger", "There is problem in uploading files please try again");
          }
        }
          self::save_to_database($file_names, $array);
          self::json_respond("success", "Successfully uploaded");
      } else {
        self::json_respond("danger", "please select the file first");
      }
  }

  public static function change_password($email)
  {
    if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
      $data['result'] = 'Please enter a valid email';
      Jsonresponse::json_response(200, "OK", $data);
    }
    $rand = md5("forgot_password".rand(1000,1000000));
    $query = Jsonresponse::dbconnect()->prepare("SELECT * FROM user WHERE email = :email");
    $query->bindParam(":email", $email);
    $query->execute();
    $fetch = $query->fetch(PDO::FETCH_ASSOC);
    if( $query->rowCount() == 1)
    {
      $change_password = Jsonresponse::dbconnect()->prepare("UPDATE user SET password = :password WHERE email = :email");
      $change_password->bindParam(":password", md5($rand));
      $change_password->bindParam(":email", $email);
      $change_password->execute();
      $mail_attributes = get_defined_constants(true);
      $subject = $mail_attributes['user']['subject_1'];
      $message = $mail_attributes['user']['message_1'];
      $message .= "<br>Password: $rand";
      sendmail::send_mail("Change password", $fetch['username'], $email, $message);
    }
    else
    {
      $data['result'] = 'We are unable to find your mail, plese recheck it once';
      Jsonresponse::json_response(200, "OK", $data);
    }
  }

  public static function save_to_database($name_of_files, $path_to_files) {
    $query = Jsonresponse::dbconnect()->prepare("SELECT * FROM user WHERE session_id = :id");
    $query->bindParam(':id', $_SESSION['user']);
    $query->execute();
    $id = $query->fetch(PDO::FETCH_ASSOC)['user_id'];
    $filepath = "user_uploads/".$id.".json";
    //loop for every uploaded file saving them in both the files
    for($i=0; $i< sizeof($name_of_files); $i++ ) {
      $data_stored = '{ "name": "'. $name_of_files[$i]. '", "file_path": "'.$path_to_files[$i].'",';
      $data_stored.= '"date_uploaded": "'.date("Y-m-d").'" },';
      file_put_contents($filepath, $data_stored , FILE_APPEND | LOCK_EX);
    }
    $file_2 = "daily_uploads/".date("Y-m-d").".json";
    for($i=0; $i< sizeof($name_of_files); $i++ ) {
        $data_stored = '{ "name": "'. $name_of_files[$i]. '", "file_path": "'.$path_to_files[$i].'",';
        $data_stored.= '"date_uploaded": "'.date("Y-m-d").'", "user": "'.$id.'" },';
        file_put_contents($file_2, $data_stored , FILE_APPEND | LOCK_EX);
    }
  }

  public static function preview_date($date) {
    $response = '[';
    $date = date('Y-m-d', strtotime($date));
    if(file_exists("daily_uploads/".$date.".json")) {
      $data[0]['confirm'] = 'yes';
      $file = file_get_contents("daily_uploads/".$date.".json");
    } else {
      $data[0]['confirm'] = 'no';
      $data[0]['details'] = "No uploads on this date";
      Jsonresponse::json_response(200, "OK", $data);
    }
    $length = strlen($file);
    while(1) {
      if( $file[$length] == ',' ) {
        $file = substr($file, 0, $length-strlen($file));
        break;
      }
      $length--;
    }
    $response .= $file.']';
    $response = json_decode($response);
    $query = Jsonresponse::dbconnect()->prepare("SELECT * FROM user WHERE session_id = :id");
    $query->bindParam(':id', $_SESSION['user']);
    $query->execute();
    $id = $query->fetch(PDO::FETCH_ASSOC)['user_id'];
    if($id == 'admin_user_id' ) {
      for($i=0; $i<sizeof($response);$i++) {
        $data[$i+1]['name'] = $response[$i]->name;
        $data[$i+1]['file_path'] = substr($response[$i]->file_path,
        0, strripos($response[$i]->file_path, "/"));
        $data[$i+1]['date_uploaded'] = $response[$i]->date_uploaded;
        $get_user = Jsonresponse::dbconnect()->prepare("SELECT * FROM user WHERE user_id = :id");
        $get_user->bindParam(':id', $response[$i]->user);
        $get_user->execute();
        $data[$i+1]['user'] = $get_user->fetch(PDO::FETCH_ASSOC)['username'];
      }
      Jsonresponse::json_response(200,"OK", $data);
    }
    for($i=0, $j=1; $i<sizeof($response);$i++) {
      if( $response[$i]->user == $id) {
        $data[$j]['name'] = $response[$i]->name;
        $data[$j]['file_path'] = substr($response[$i]->file_path,
        0, strripos($response[$i]->file_path, "/"));
        $data[$j]['date_uploaded'] = $response[$i]->date_uploaded;
        $j++;
      }
    }
    //print_r($data);
    Jsonresponse::json_response(200,"OK", $data);
  }

  public static function json_respond($err, $data)
  {
    $result['err'] = $err;
    $result['message'] = $data;
    Jsonresponse::json_response(200,"OK", $result);
  }

  public static function all_users() {
    $status = 'yes';
    $user = Jsonresponse::dbconnect()->prepare('SELECT * FROM user WHERE status = :status');
    $user->bindParam(':status', $status);
    $user->execute();
    $details = $user->fetchall(PDO::FETCH_ASSOC);
    for($i=0; $i< sizeof($details); $i++) {
      if( $details[$i]['user_id'] != 'admin_user_id') {
        $rv[$i]['name'] = $details[$i]['username'];
        $rv[$i]['email'] = $details[$i]['email'];
        $rv[$i]['country'] = $details[$i]['country'];
        $rv[$i]['state'] = $details[$i]['state'];
        $rv[$i]['mobile'] = $details[$i]['mobile'];
        $rv[$i]['directory'] = $details[$i]['directory'];
        $rv[$i]['id'] = $details[$i]['user_id'];
      }
      }
    Jsonresponse::json_response("200", "OK", $rv);
  }

  public static function get_user($id) {
    $connection = Jsonresponse::dbconnect();
    $user = $connection->prepare('SELECT * FROM user WHERE user_id = :id');
    $user->bindParam(':id', $id);
    $user->execute();
    $details = $user->fetch(PDO::FETCH_ASSOC);
    $response['username'] = $details['username'];
    $response['id'] = $details['session_id'];
    $response['email'] = $details['email'];
    $response['state'] = $details['state'];
    $response['country'] = $details['country'];
    $response['directory'] = $details['directory'];
    $response['mobile'] = $details['mobile'];

    Jsonresponse::json_response("200", "OK", $response);
  }

  public static function get_user_uploads($id) {

    if(file_exists("user_uploads/".$id.".json")) {
      $data[0]['confirm'] = 'yes';
      $file = file_get_contents("user_uploads/".$id.".json");
    } else {
      $data[0]['confirm'] = 'no';
      $data[0]['details'] = 'No uploads yet';
      Jsonresponse::json_response(200, "OK", $data);
    }
    //this has to be modified to remove the last comma in json data
    $length = strlen($file);
    //print_r($file);
    $file = '['.substr($file, 0, strripos($file,",")).']';
    $response = json_decode($file);
    //print_r($file);
    //print_r($response);
    for($i=0; $i<sizeof($response);$i++) {
      $data[$i+1]['name'] = $response[$i]->name;
      $data[$i+1]['file_path'] = substr($response[$i]->file_path,
      0, strripos($response[$i]->file_path, "/"));;
      $data[$i+1]['date_uploaded'] = $response[$i]->date_uploaded;
    }
    Jsonresponse::json_response(200,"OK", $data);
  }


  public static function construct_directory($path)
  {
    $path_to_files = get_defined_constants(true);
    $permitted_path = explode(",", Settings::get_path($_SESSION['user']));
    $j=0;
    $directories = array();
    if($path === '') {
      $directories[$j] = 'MAM';
      Jsonresponse::json_response(200, "OK", $directories);
      die();
    } else {
      foreach($permitted_path as $i) {
        $directory = $path_to_files['user'][$i];
        if( false!== strpos($directory, $path)) {
          $directories[$j] = str_replace($path, "", $directory);
          $j++;
        }
      }
    }
    $j=0;
    $l=0;
    foreach($directories as $k) {
      $paths[$j] = explode("/", $k)[0];
      if($k == '') {
        $paths[$j] = $l;
        $l++;
      }
      $j++;
    }
    $paths = array_unique($paths);
      $j=0;
      foreach($paths as $i)
      {
        $return_paths[$j] = $i;
        $j++;
      }
  Jsonresponse::json_response(200, "OK", $return_paths);
    //now check if the path string exists in $directories
    // and if it exists, the split those strings in which path exists
    // then return those strings to the client by splitting at "/".
  }
}
?>
