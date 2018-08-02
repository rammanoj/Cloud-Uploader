<?php

// use goole oauth2 to send emails

require_once __DIR__.'/vendor/autoload.php';

class sendmail
{
  public static function send_mail( $header, $username, $email, $message ) {
    require __DIR__ . '/vendor/autoload.php';
    $client = new Google_Client();
    $client->setApplicationName('Gmail API PHP Quickstart');
    $client->setScopes(Google_Service_Gmail::GMAIL_COMPOSE  );
    $client->setAccessType("offline");
    $client->setAuthConfig('client_secret.json');
    $credentialsPath = 'token.json';
        if (file_exists($credentialsPath)) {
            $accessToken = json_decode(file_get_contents($credentialsPath), true);
        } else {
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            if (!file_exists(dirname($credentialsPath))) {
                mkdir(dirname($credentialsPath), 0700, true);
            }
            file_put_contents($credentialsPath, json_encode($accessToken));
            printf("Credentials saved to %s\n", $credentialsPath);
        }
        $client->setAccessToken($accessToken);
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        }
    $service = new Google_Service_Gmail($client);
    	try {
     		$strSubject = $header;
            $strRawMessage = "From: Ashram@amritapuri<rammanojpotla1608@gmail.com>\r\n";
            $strRawMessage .= "To: $username<$email>\r\n";
            $strRawMessage .= "Subject: =?utf-8?B?" . base64_encode($strSubject) ."?=\r\n";
            $strRawMessage .= "MIME-Version: 1.0\r\n";
            $strRawMessage .= "Content-Type: text/html; charset=utf-8\r\n";
            $strRawMessage .= "Content-Transfer-Encoding: base64" . "\r\n\r\n";
            $strRawMessage .= "$message" . "\r\n";
            $mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
            $msg = new Google_Service_Gmail_Message();
            $msg->setRaw($mime);
            $service->users_messages->send("me", $msg);
            $data['location'] = '';
            $data['result'] = "A mail is sent to your account, please confirm it";
            Jsonresponse::json_response( 200, "OK", $data );
        } catch (Exception $e) {
          $data['location'] = '';
          $data['result'] = "Error in sending mail $e";
          Jsonresponse::json_response( 200, "OK", $data );
        }

  }
}
// sendmail::send_mail("rammanoj", "rammanoj.potla@gmail.com", "welcome to school");
?>
