$(document).ready(function(){

  //the below two functions work for getting multiple users

  $(document).on('keyup', "#search", function() {
   var value = $(this).val().toLowerCase();
   $(".table tr").filter(function() {
     $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
   });
 });

  $.get('../../BaseClass.php', {
    action: 'users_view'
  },function(response){
      var table = '<table class="table table-hover"><thead><tr><th>name</th><th>email</th><th>country</th></tr></thead><tbody>';
      for( var i in response.data) {
        table += '<tr><td><a href="#" class="user" id="'+response.data[i].id+'">' + response.data[i].name + '</a></td>';
        table += '<td>' + response.data[i].email + '</td>';
        table += '<td>' + response.data[i].country + '</td></tr>';
      }
      table += '</tbody></table>';
      $('.upload_content').append("Search: <input type='text' placeholder='Search here...' id='search'><br><br>");
      $(".upload_content").append(table);
  });

  $(document).on('click', ".user", function() {
        location.href = 'user.php?action=get_user&id='+ $(this).attr('id');
  });

  // function user_get(user_data) {
  //   var data = '<h2>' + user_data.data.username + '</h2><h2>';
  //   data += user_data.data.email + '</h2><h2>' + user_data.data.mobile;
  //   data += '</h2><h2>' + user_data.data.country + '</h2><h2>';
  //   data += user_data.data.state + '</h2><h2>' + user_data.data.directory + '</h2>';
  //   console.log(data);
  //   $.get('../../BaseClass.php', {
  //     email: user_data.data.email,
  //     action: 'user_uploads'
  //   }, function(response) {
  //       console.log(response);
  //   });
  // }
});
