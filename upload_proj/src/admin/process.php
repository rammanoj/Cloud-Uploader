<?php
include('../../login_auth.php');
if( $_SESSION['login'] != 'admin' ) {
    header('Location: ../../login.php');
}
else {
    $api_url = get_defined_constants(true);
    $url = $api_url['user']['users'];
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url
    ));

    $response = curl_exec($curl);
    curl_close($curl);
}
?>
<html>
<head>
<meta charset="utf-8">
  <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../css/bootstrap-multiselect.css">
  <script src="../../js/jquery.min.js"></script>
  <script src="../../bootstrap/popper.min.js"></script>
  <script src="../../bootstrap/js/bootstrap.min.js"></script>
  <script src="../../bootstrap-multiselect.js"></script>
  <script type="text/javascript" src="../../js/nav.js"></script>
  <script type="text/javascript" src="../../js/button_handle.js"></script>
<style>
  .btn {
    width: 10%;
  }
  .path {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
  }
  </style>
  <script>
    $(document).ready(function(){
      $(".multiple").multiselect({
        nonSelectedText: "none",
        buttonWidth: '40%',
        maxHeight: 200,
        dropDown: true,
      });
      var source = $("#include_html").data("source");
      $("#include_html").load(source);
    });
  </script>
</head>
<body>
  <div id="nav">
  </div>
  <br>
  <div class="container">
    <div data-source="../view_path.html" id="include_html"></div>
    <h1>Accept the users Registrations</h1>
    <br>
    <div style="color:#938888;">Note: Please look into <b>view paths</b> button to select directory.</div>
    <br>
    <div id="message">
    </div>
    <div class="list-group">
    <?php
    if($response == '') {
      echo '<h2 style="color:red;"> There are no pending registrations currently. </h2>';
    }
    $details = explode(";", $response);
    for($i=0; $i< sizeof($details) -1; $i++) {
      $user = explode(",", $details[$i]);
      $directory = "<div class='form-group col-md-6'><form><label>directory:</label><select multiple='multiple' class='form-control multiple'id='direct_".$user[2]."'>";
      for($j=1; $j<=55; $j++) {
        $directory .= "<option value='path_" .$j. "'>path ".$j."</option>";
      }
      $directory .= "</select></form></div>";
      $button_1 = '<button type="button" value="accept" class="btn btn-outline-primary float-right">Accept</button>';
      $button_2 = '<button type="button" value="decline" class="btn btn-outline-primary float-right">Decline</button>';
      echo '<a id="'.$user[2].'" href="#" class="list-group-item list-group-item-action">'.
              '<h3>'.$user[0].$button_1.'</h3>'.$user[1].$button_2.'<br>'.$directory.'</a>';
    }
     ?>
   </div>
  </div>
  </body>
</html>
