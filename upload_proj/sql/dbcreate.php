<?php
class Dbcreate
{

  public static function setup_db()
  {
    try {
      $host_vars = get_defined_constants(true);
      $hostname = $host_vars['user']['hostname'];
      $username = $host_vars['user']['username'];
      $password = $host_vars['user']['password'];
      $dbname = $host_vars['user']['dbname'];
      $connect_server = new PDO("mysql:host=$hostname", $username, $password );
      $create_default = $connect_server->prepare("CREATE DATABASE $dbname");
      $create_default->execute();
      $connect_server = new PDO("mysql:host=$hostname;dbname=$dbname", $username ,$password );
      $connect_server->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $file = file_get_contents( $_SERVER['DOCUMENT_ROOT'].'/upload_proj/sql/database.sql' );
      $create_tables = $connect_server->prepare($file);
      $create_tables->execute();
      return 1;
    }
    catch(Exception $e) {
      return $e;
    }
  }
}

?>
