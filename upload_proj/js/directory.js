$(document).ready(function(){

    $('#loading').modal('show');
  $.get("../BaseClass.php", {
    action: "get_dir",
    path: '',
  }, function(data){
      $('#loading').modal('toggle');
      console.log(data);
      //data.data has the array of paths
      var code = "<div class='col-md-4 img'><img src='../img/folderempty.png' />";
      for(var i in data.data) {
        code += "<p class='dir_name'><b>"+ data.data[i] + "</b></p></div>";
        $(".row").append(code);
      }
  });

  $(document).on("click", "img", function(){
    console.log("hello");
      $('#loading').modal('show');
    var parent = $(this).parent();
    $("#dir_path").append( $(".dir_name", parent).text()+"/"); //add some file name
    console.log($(".path #dir_path").text().split(":")[1]);
    $.get("../BaseClass.php", {
      action: "get_dir",
      path: $(".path #dir_path").text().split(":")[1],
    }, function(data){
      $(".row").text('');
        $('#loading').modal('toggle');
        console.log("data");
        console.log(data);
        //data.data has the array of paths
        for(var i in data.data) {
          if($.isNumeric(data.data[i])) {
            var path = $("#dir_path").text().split(":")[1];
            console.log(path);
            window.location = 'home_upload.php?path='+encodeURIComponent(path);
          } else {
            var code = "<div class='col-md-4 img'><img src='../img/folderempty.png' />";
            code += "<p class='dir_name'><b>" + data.data[i] + "</b></p></div>";
            $(".row").append(code);
          }
        }
    });
  });
});
