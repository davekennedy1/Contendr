<?php
include("conn.php");

$GLOBALS['num'] = rand(1, 5);
$logoImage = "logoImages/".$num.".png";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <!--<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="HandheldFriendly" content="true">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="stylesheets/gui.css">


  <link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One" rel="stylesheet">

  <title>Contendr</title>
</head>
<body>
<div class='navPad'>

<nav class='navbar fixed-top navbar-dark mainbk'>
<?php echo"
  <a class='navbar-item' id='navBrand' href='index.php'>
    <blockqoute class='navfont'>CONTENDR</blockquote>
    <img src='$logoImage' width='27' height='27' class='navImages' alt='logoImage'>
  </a>
  ";
?>

  <div class="d-flex flex-row order-2 order-lg ml-auto">

    <ul class="navbar-nav flex-row">
      <li class="nav-item linkpad">  <a class="nav-link" data-toggle="modal" data-target="#loginModal" href="#">Login</a></li>
      <li class="nav-item linkpad">  <a class="nav-link" data-toggle="modal" data-target="#signUPModal" href="#">Signup</a></li>
    </ul>
  </div>
</nav>
</div>

<!--Login modal-->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header mainbk">
      <h5 class="modal-title mainfont" id="loginModalLabel">Login</h5>
      <button type="button" class="close mainfont" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">

      <form autocomplete="on" method="POST" action="user/loginprocess.php">

      <div class="container">
        <div class="row">
          <div class="col-4">
            <label class="usernamemargin" for="nameofuser">Email:</label>
          </div>
          <div class="col-8">
            <input type="email" class="form-control" id="nameofuser" name ="postemail" placeholder="email" autofocus required>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <label class="usernamemargin" for="pass">Password:</label>
          </div>
          <div class="col-8">
            <input type="password" class="form-control" id="pass" name="postuserpswrd"placeholder="password" required>
          </div>
        </div>
      </div>

    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Login</button>
    </div>

  </form>
  </div>
</div>
</div>


<!--Register modal-->
<div class="modal fade" id="signUPModal" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header mainbk">
      <h5 class="modal-title mainfont" id="signUpModalLabel">Sign Up</h5>
      <button type="button" class="close mainfont" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="modal-body">

      <div class="container">
        <div class="row">
          <div class="signupLayout buttonpos">
            <p class='centeredText'>Already a member?</p>
            <a class="btn btn-warning btn-block" data-toggle="modal" data-target="#loginModal" data-dismiss="modal" href="#" role="button">Login</a>
          </div>
        </div>
        <div class="row">
          <div class="col signupPad">

            <p class='centeredText'>OR</p>

          </div>
        </div>
        <div class="row">
          <div class="signupBttmBtn buttonpos">
            <a class="btn btn-info btn-block" href="#" role="button">Sign Up</a><!--signup.php  for href -->
          </div>
        </div>
      </div>

    </div>
    <div class="modal-footer">

    </div>
  </form>
  </div>
</div>
</div>




  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
