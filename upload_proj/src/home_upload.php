<?php
include('../login_auth.php');
if( $_SESSION['login'] != 'true' ) {
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
  <script src="../js/upload_handle.js"></script>
  <style>
      #file {
        width: 0.1px;
      	height: 0.1px;
      	opacity: 0;
      	overflow: hidden;
      	position: absolute;
      	z-index: -1;
    }
    #upload_label {
      color: #0000EE;
      font-size: 120%;
    }
    #upload_label:hover {
      cursor: pointer;
      text-decoration: underline;
    }
    #upload_img {
      user-drag: none;
      width: 35%;
      height: 40%;
      user-select: none;
      -moz-user-select: none;
      -webkit-user-drag: none;
      -webkit-user-select: none;
      -ms-user-select: none;
    }
    .box {
      border: 2px dashed #becec8;
      border-radius: 4px;
      width: 99%;
      height: 50%;
    }
    .droping {
      width: 100%%;
      height: 51%;
      border: 2px dashed #000000;
      border-radius: 4px;
    }
    .images {
      padding: 4px;
      height: 30%;
      width: 30%;
      border-radius: 10px;
    }
#save {
  position: absolute;
}
.path {
  max-height: calc(100vh - 210px);
  overflow-y: auto;
}
.remove {
  width: 20px;
  height: 20px;
  cursor: pointer;
}
</style>
</head>
<body>
  <div id="nav">
  </div>
    <div class="container">
      <br>
      <div data-source="view_path.html" id="include_html">
      </div>
      <h1> Upload Files...</h1>
        <br>
        <div style="color:#938888;"><b>Note:</b> Please upload files carefully, files can't be deleted after upload</div>
        <br>
        <div class="message">
        </div>
    <form action="" enctype="multipart/form-data" method="post">
        <input type="file" value="Choose file" id="file" name="file[]" multiple="multiple">
        <div class="box" id="drop">
          <br>
          <center><img src="../img/index.png" id="upload_img"></img></center>
          <br>
          <center><h3>Drag and drop your files here</h3>
            <label for="file" id="upload_label"> Choose files</label>
            </center>
        </div>
        <br>
    </form>
    <br>
    <p id="path"><b>path:</b></p>
    <br>
    <button class="btn btn-outline-primary" id="save">Save file</button>
    <br><br><br>
    <div class="content" style="visibility: hidden;">
        <h2>Files to be uploaded </h2>
        <div class="files">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>file name</th>
                <th>file type</th>
                <th>cancel file </th>
              </tr>
            </thead>
          </table>
        </div>
    </div>
  </div>
  <div class="modal" id="loading" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <center><div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
          </div>
        </center>
          <center><h2>Uploading.... please wait</h2></center>
      </div>
    </div>
    </div>
  </div>
</body>
</html>
