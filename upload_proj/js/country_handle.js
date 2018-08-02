$(document).ready(function(){
    var country_file = 'countries.json';
    $.getJSON(country_file, function(result){
        for( var i =0; i< result.countries.length; i++) {
          $("#countries").append('<option value="' + result.countries[i].country +
          '">' + result.countries[i].country + '</option>');
        }
      });
      $('#countries').on('change', function(e) {
          var country = $("#countries option:selected").val();
          $.getJSON(country_file, function(result){
            for( var i =0; i< result.countries.length; i++) {
              if(country == result.countries[i].country) {
                $("#states").text('');
                $("#states").append("<option value='none'>None</option>");
                for(var j=0; j<result.countries[i].states.length; j++) {
                  $("#states").append('<option value="' + result.countries[i].states[j] +
                  '">' + result.countries[i].states[j] + '</option>');
                }
                break;
              }
            }
          });
      });

    $('#preview_date').on('click', function() {
      $('#loading').modal('show');
        $.get('../BaseClass.php', {
          date: $("#input_date").val(),
          action: 'preview_date',
        }, function(response) {
          console.log(response);
          $('#loading').modal('toggle');
            $(".upload_content").text('');
            if(response.data[0].confirm == 'no') {
              $(".upload_content").append("<h2 style='color:red;'>"+response.data[0].details+"</h2>");
            } else if(response.data.length == 1 ){
              $(".upload_content").append("<h2 style='color:red;'>No uploads on the date</h2>");
            } else {
              var content = "<table class='table table-hover'><thead><tr><th>file name</th><th>file path</th><th>date uploaded</th></tr></thead>";
              for(var i=1; i< response.data.length; i++) {
                content +='<tr><td>'+response.data[i].name + '</td><td>'+response.data[i].file_path + '</td><td>';
                content += response.data[i].date_uploaded + '</td></tr>';
              }
              content += "</table>";
              $('.upload_content').append("Search: <input type='text' placeholder='Search here...' id='search'><br><br>");
              $(".upload_content").append(content);
            }
        });
    });
});
