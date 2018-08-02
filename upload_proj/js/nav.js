$(document).ready(function() {
  $.post('../BaseClass.php',{
    'action': 'navbar',
  },
  function(data) {
    if(data == "true" ) {
      nav_login();
    } else if(data == "admin"){
      nav_admin_2();
    } else {
      nav_login();
    }
  });
  $.post('../../BaseClass.php',{
    'action': 'navbar',
  },
  function(data) {
    if(data == "admin" ) {
      nav_admin();
    } else{
      nav_site();
    }
  });
  $.post('BaseClass.php',{
    'action': 'navbar',
  },
  function(data) {
      nav_site();
  });

  function nav_site()
  {
    // navbar with no login
    var ul2 = $( '<ul>' ).addClass( 'navbar-nav ml-auto' );
    ul2.append( '<li class="nav-item" style="float:right;"><a class="nav-link" href="signup.php">Sign up</a></li>' );
    ul2.append( '<li class="nav-item"><span class="glyphicon glyphicon-log-in"></span><a class="nav-link" href="login.php">Login</a></li>' );
    var $nav = $( '<nav>' ).addClass( 'navbar navbar-expand-sm bg-dark navbar-dark' );
    $nav.append('<a class="navbar-brand" href="#">Home</a>');
    $nav.append(ul2);
    $( '#nav' ).append( $nav );
  }
  function nav_login()
  {
    // navbar on user login
    var ul = $( '<ul>' ).addClass( 'navbar-nav' );
    ul.append( '<li class="nav-item"><a class="nav-link" href="home_page.php">Home</a></li>' );
    ul.append( '<li class="nav-item"><a class="nav-link" href="view_content.php">Past uploads</a></li>' );
    var ul2 = $( '<ul>' ).addClass( 'navbar-nav ml-auto' );
    ul2.append( '<li class="nav-item" style="float:right;"><a class="nav-link" href="settings.php">settings</a></li>' );
    ul2.append( '<li class="nav-item"><span class="glyphicon glyphicon-log-in"></span><a class="nav-link" href="../logout.php">Logout</a></li>' );
    var $nav = $( '<nav>' ).addClass( 'navbar navbar-expand-sm bg-dark navbar-dark' );
    $nav.append(ul);
    $nav.append(ul2);
    $( '#nav' ).append( $nav );
  }

  function nav_admin()
  {
    // navbar on admin login
    var ul = $( '<ul>' ).addClass( 'navbar-nav' );
    ul.append( '<li class="nav-item"><a class="nav-link" href="home.php">Uploads list</a></li>' );
    ul.append( '<li class="nav-item"><a class="nav-link" href="Users.php">Users</a></li>' );
    ul.append( '<li class="nav-item"><a class="nav-link" href="process.php">Process registrations</a></li>' );
    var ul2 = $( '<ul>' ).addClass( 'navbar-nav ml-auto' );
    ul2.append( '<li class="nav-item" style="float:right;"><a class="nav-link" href="../settings.php">settings</a></li>' );
    ul2.append( '<li class="nav-item"><span class="glyphicon glyphicon-log-in"></span><a class="nav-link" href="../../logout.php">Logout</a></li>' );
    var $nav = $( '<nav>' ).addClass( 'navbar navbar-expand-sm bg-dark navbar-dark' );
    $nav.append(ul);
    $nav.append(ul2);
    $( '#nav' ).append( $nav );
  }

  function nav_admin_2()
  {
    // navbar on admin login
    var ul = $( '<ul>' ).addClass( 'navbar-nav' );
    ul.append( '<li class="nav-item"><a class="nav-link" href="admin/home.php">Uploads list</a></li>' );
    ul.append( '<li class="nav-item"><a class="nav-link" href="admin/Users.php">Users</a></li>' );
    ul.append( '<li class="nav-item"><a class="nav-link" href="admin/process.php">Process registrations</a></li>' );
    var ul2 = $( '<ul>' ).addClass( 'navbar-nav ml-auto' );
    ul2.append( '<li class="nav-item" style="float:right;"><a class="nav-link" href="settings.php">settings</a></li>' );
    ul2.append( '<li class="nav-item"><span class="glyphicon glyphicon-log-in"></span><a class="nav-link" href="../logout.php">Logout</a></li>' );
    var $nav = $( '<nav>' ).addClass( 'navbar navbar-expand-sm bg-dark navbar-dark' );
    $nav.append(ul);
    $nav.append(ul2);
    $( '#nav' ).append( $nav );
  }
});
