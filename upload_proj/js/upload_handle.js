$(document).ready(function(){
  var allfiles = [];
  var url = window.location;
  var path = decodeURIComponent(url.toString().split("?")[1]).split("=")[1];
  $("#path").text('');
  $("#path").append("<b>path:</b>"+path);
  var file_names = '';
  var formdata = new FormData();
  $('input[type="file"]').change(function(event){
    event.preventDefault();
    var files = event.target.files;
    var flag = 1;
    for(var i=0; i < files.length; i++) {
      if(files[i].size < 31457280) {
        flag = 1;
          allfiles.push(files[i]);
      } else {
        flag = 0;
        allfiles = [];
        $(".files > .table").empty();
        $(".message").text('');
        $(".message").append("<div class='alert alert-danger'>Max file size is 30 M</div>");
        break;
      }
    }
    if(flag == 1)
    {
      preview(files);
    }
  });
  $("#drop").on('dragover', function() {
    $(this).attr('class', 'droping')
    return false;
  });
  $("#drop").on('dragleave', function() {
    $(this).attr('class', 'box');
    return false;
  });
  $("#drop").on("drop", function(event) {
    event.preventDefault();
    $(this).attr('class', 'box');
    var files = event.originalEvent.dataTransfer.files;
    for(var i=0; i < files.length; i++) {
      allfiles.push(files[i]);
    }
    preview(files);
  });
  function upload() {
    console.log(allfiles);
    for(var i=0; i<allfiles.length; i++) {
      formdata.append("file[]", allfiles[i])
    }
    allfiles = []
    formdata.append("action", "upload");
    formdata.append("dir", $("#path").text().split(":")[1]);
    $('#loading').modal('show');
    $.ajax({
      url: '../BaseClass.php',
      type: 'post',
      data: formdata,
      processData: false,
      contentType: false,
      xhr: function(){
        var xhr = $.ajaxSettings.xhr() ;
        xhr.upload.onprogress = function(evt){
          var percent = evt.loaded/evt.total*100;
           console.log('progress', percent);
           $(".progress-bar").text(Math.round(percent)  + "%");
           $(".progress-bar").css("width", Math.round(percent) + "%");
          };
        xhr.upload.onload = function(){
          console.log('DONE!');
        };
        return xhr ;
      },
      success: function(response) {
        formdata = new FormData();
        console.log(response);
        var alert = `<div class="alert alert-`+response.data.err + ` alert-dismissible fade show">`
         + response.data.message + `</div>`;
        $('#loading').modal('toggle');
         $(".message").text('');
        $(".message").append(alert);
      },
      error: function(response) {
        $("There is an error in uploading, please try again later");
      }
    });
  }

  function preview(files) {
    for(var i=0; i < files.length; i++) {
      var reader = new FileReader();
      reader.onload = function (e, file) {
      }
        //console.log(data);
        reader.readAsDataURL(files[i]);
        var name = files[i].name;
        var table = "<tr><td>"+name+"</td>"+"<td>"+files[i].type + "</td>";
        table += "<td><img id='"+files[i].lastModified+"' src='../img/cancel.png' class='remove'></td></tr>";
        $(".files > .table").append(table);
    }
    $(".content").css('visibility', 'visible');
  }
  $("#save").on('click', function(){
    $(".files > .table").empty();
    $(".files > .table").append("<thead><tr><th>file name</th><th>file type </th></tr></thead>")
    $(".content").css('visibility', 'hidden');
    upload();
  });
  $("body").on('click', '.remove', function(){
    $(this).closest("tr").remove();
    console.log($(this).attr('id'));
    allfiles = allfiles.filter(x=>x.lastModified != $(this).attr('id') );
    console.log(allfiles);
  });
});
