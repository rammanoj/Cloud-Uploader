<?php
class Dbcheck {
/*
* Check if database already exists
* @return $count
*/
public static function check_existence() {
    try {
      $host_vars = get_defined_constants(true);
      $hostname = $host_vars['user']['hostname'];
      $username = $host_vars['user']['username'];
      $password = $host_vars['user']['password'];
      $dbname = $host_vars['user']['dbname'];
      $server = new PDO("mysql:host=$hostname", $username, $password );
      $server1 = $server->prepare("SHOW DATABASES LIKE $dbname");
      $server1->execute();
      $count = $server1->rowCount();
      /*
      * if count == 1: database exist
      */
      return $count;
    }
    catch(Exception $e) {
      return -1;
      exit();
    }
  }
}
?>
