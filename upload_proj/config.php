<?php
/*
  A config file where information regarding databases, host and mail can be configured.

*/
// specifies the name of the host
define('hostname', 'localhost');

// username of database
define('username', 'root');

// password of database
define('password', 'manoj1999');

//database name
define('dbname', 'amrita');

//mail address
//1. to password confirmation, and other details
define('subject_1', 'Change password');
define('message_1', 'We received a request about you forgetting your password,
 So we are mailing this password to you Please change this password after logging in,
  else it may sometimes lead to security risks');

//2. to the email confirmation during signup, other details
define('url', 'http://localhost/upload_proj/BaseClass.php?action=confirm_reg&hash=');
define('subject_2', 'Confirm your email');
define('message_2', "A request from your mail account to reister at our site has come in.
To confirm registration please <a href=>click here</a>. If you didn't authorize it please ignore.");

//3. to the email-change operation in settings page, other details
define('subject_3', 'Confirm changed emailid');
define('message_3', 'A request to change your email has been detected.
          This is a verification mail to the new mail account<br>Please <a href="http://localhost/upload_proj/BaseClass.php?action=change_email"click here</a>
             to update your mail');

//request users
define('users', 'localhost/upload_proj/BaseClass.php?action=users');
 ?>
