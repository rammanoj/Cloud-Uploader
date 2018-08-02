<?php
class Jsonresponse
{
    /*
    * returns Json response to the username
    */
    public static function json_response( $status, $status_message, $data )
    {
      header( "HTTP/1.1 $status $status_message");
      header( "Content-Type: application/json" );
      header( "Connection: keep-alive");
      $response['data'] = $data;
      $rv = json_encode( $response );
      echo $rv;
      die();
    }

    /*
    * Connect to database
    * @return $connection
    */
    public static function dbconnect()
    {
      $host_vars = get_defined_constants(true);
      $hostname = $host_vars['user']['hostname'];
      $username = $host_vars['user']['username'];
      $password = $host_vars['user']['password'];
      $dbname = $host_vars['user']['dbname'];
      try {
        $connection = new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8mb4", $username, $password);
        // set PDO error mode to Exception
    	   $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         return $connection;
       } catch(PDOException $err){
         echo "he ".$hostname. " llo";
    	    echo "DataBase Connection failed, Error:".$err->getMessage(). " ".$username;;
    	     die();
         }
    }

    public static function prevent_sql( $value )
    {
      // operations to prevent sql injection
      $value = str_replace(' ','',strtolower($value));
      return $value;
    }
}
 ?>
