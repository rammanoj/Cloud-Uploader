<?php
include('../login_auth.php');
if( $_SESSION['login'] != 'admin' && $_SESSION['login'] != 'true' ) {
    header('Location: ../login.php');
}
?>
<html>
<head>
<meta charset="utf-8">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="../bootstrap/popper.min.js"></script>
  <script type="text/javascript" src="../js/nav.js"></script>
  <script type="text/javascript" src="../js/jquery.md5.js"></script>
  <script type="text/javascript" src="../js/settings_handle.js"></script>
  <style>
  .width {
    min-width: 40%;
    width: auto;
  }
  </style>
</head>
<body>
  <div id="nav">
  </div>
  <br>
  <div class="container">
    <h1>Profile & settings: </h1>
    <br>
    <div id="message">
    </div>
    <div class="modal" id="loading" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <center><img src="../img/loading.gif"></center>
            <center><h2>Loading....</h2></center>
        </div>
      </div>
      </div>
    </div>
    <div class="card">
    <table class="table">
      <tbody>
        <tr>
          <th>Username: <span id="username_value"> </span> </th>
          <td><button type="button" class="btn btn-outline-primary width" data-toggle="modal"
             data-target="#username">change username</button></td>
        </tr>
        <tr>
          <th>Password: <span id="password_value"> </span> </th>
          <td><button type="button" class="btn btn-outline-primary width" data-toggle="modal"
            data-target="#password">change password</button></td>
        </tr>
        <tr>
          <th>email: <span id="email_value"> </span> </th>
          <td><button type="button" class="btn btn-outline-primary width" data-toggle="modal"
            data-target="#email">change email</button></td>
        </tr>
        <tr>
          <th>mobile: <span id="mobile_value">  </span> </th>
          <td> <button type="button" class="btn btn-outline-primary width" data-toggle="modal"
            data-target="#mobile">change mobile</button></td>
        </tr>
        <tr>
          <th>country: <span id="country_value">  </span><br><br>
          state: <span id="state_value">  </span> </th>
          <td> <button type="button" class="btn btn-outline-primary width" data-toggle="modal"
            data-target="#country">change Location</button>
          </td>
        </tr>
        <!-- <tr>
          <td> <button type="button" class="btn btn-outline-primary width" data-toggle="modal"
            data-target="#state">change state</button></td>
        </tr> -->
      </tbody>
    </table>
  </div>
    <div class="modal fade" id="username">
   <div class="modal-dialog">
     <div class="modal-content">

       <div class="modal-header">
         <h4 class="modal-title">Update username</h4>
       </div>

       <div class="modal-body">
           <div class="text-center">
             <form>
               <label>Username:</label>
               <input type="text" id="username_in" placeholder="Enter username">
               <br><br>
            </form>
            <button class="btn btn-primary update" id="username_up"> Update</button>
          </div>
       </div>

       <div class="modal-footer">
         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
       </div>
     </div>
     </div>
     </div>
  </div>

  <div class="modal fade" id="password">
 <div class="modal-dialog">
   <div class="modal-content">

     <!-- Modal Header -->
     <div class="modal-header">
       <h4 class="modal-title">Update Password</h4>
     </div>

     <!-- Modal body -->
     <div class="modal-body">
       <div class="text-center">
       <form>
        <label>Old password:</label>
       <input type="password" id="old_password" placeholder="Enter password"><br>
      <label>New password:</label>
      <input type="password"  id="password_in_1" placeholder="Enter password"><br>
     <label>Confirm password:</label>
     <input type="password" id="password_in_2" placeholder="Enter password">
       <br><br>
       </form>
       <button class="btn btn-primary update" id="password_up"> Update </button>
       </div>
     </div>

     <!-- Modal footer -->
     <div class="modal-footer">
       <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
     </div>
   </div>
   </div>
   </div>
</div>

<div class="modal fade" id="email">
<div class="modal-dialog">
 <div class="modal-content">

   <!-- Modal Header -->
   <div class="modal-header">
     <h4 class="modal-title">Update email</h4>
   </div>

   <!-- Modal body -->
   <div class="modal-body">
    <div class="text-center">
     <form>
     <label>email:</label>
     <input type="email" id="email_in" placeholder="Enter email">
     <br><br>
     </form>
     <button class="btn btn-primary update" id="email_up"> Update</button>
     </div>
   </div>

   <!-- Modal footer -->
   <div class="modal-footer">
     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
   </div>
 </div>
 </div>
 </div>
</div>

<div class="modal fade" id="mobile">
<div class="modal-dialog">
 <div class="modal-content">

   <!-- Modal Header -->
   <div class="modal-header">
     <h4 class="modal-title">Update mobile</h4>
   </div>

   <!-- Modal body -->
   <div class="modal-body">
    <div class="text-center">
     <form>
     <label>mobile:</label>
     <input type="tel" id="mobile_in" placeholder="Enter number">
     <br><br>
     </form>
     <button class="btn btn-primary update" id="mobile_up"> Update </button>
     </div>
   </div>

   <!-- Modal footer -->
   <div class="modal-footer">
     <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
   </div>
 </div>
 </div>
 </div>

 <div class="modal fade" id="country">
 <div class="modal-dialog">
  <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">Update Location</h4>
    </div>

    <!-- Modal body -->
    <div class="modal-body">
     <div class="text-center">
      <form>
      <div class="form-group col-md-8">
        <label for="countries">country: </label>
        <select class="custom-select" id="country_in">
          <option value="none" selected>None</option>
        </select>
      </div>
      <br>
      <div class="form-group col-md-8">
        <label for="countries">State: </label>
        <select class="custom-select" id="state_in">
          <option value="none" selected>None</option>
        </select>
      </div>
      </form>
      <button class="btn btn-primary update" id="location_up"> Update </button>
      </div>
    </div>

    <!-- Modal footer -->
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
  </div>
  </div>
  </div>
  <script>
  $.getJSON('../countries.json', function(result){
      for( var i =0; i< result.countries.length; i++) {
        $("#country_in").append('<option value="' + result.countries[i].country +
        '">' + result.countries[i].country + '</option>');
      }
    });
    $('#country_in').on('change', function(e) {
        var country = $("#country_in option:selected").val();
        $.getJSON('../countries.json', function(result){
          for( var i =0; i< result.countries.length; i++) {
            if(country == result.countries[i].country) {
              $("#state_in").text('');
              $("#state_in").append("<option value='none'>None</option>");
              for(var j=0; j<result.countries[i].states.length; j++) {
                $("#state_in").append('<option value="' + result.countries[i].states[j] +
                '">' + result.countries[i].states[j] + '</option>');
              }
              break;
            }
          }
        });
    });
  </script>
</body>
</html>
