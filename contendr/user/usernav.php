<?php
if(!isset($_SESSION['13072064_contendrUnom'])){
  header('Location: ../index.php');
}

$sessionUser = $_SESSION['13072064_contendrUnom'];
$uid = $_SESSION['13072064_contenderUID'];
include("../conn.php");

$GLOBALS['num'] = rand(1, 5);
$logoImage = "../logoImages/".$num.".png";

$getAvatar = "SELECT AvatarLocation FROM Sps_User WHERE UserID = $uid;";
$avatarResult = $conn->query($getAvatar);

if(!$avatarResult){
  echo $conn->error;
}else{
  //get details of item from database
  $avatarRow = $avatarResult->fetch_assoc();
  if(!$avatarRow['AvatarLocation']||$avatarRow['AvatarLocation']==='avatarImages/default_avatar.png'){
    $avatarImage = 'avatarImages/default_avatar.png';
  }else{
    $avatarImage = 'avatarImages/'.$uid.'/'.$avatarRow['AvatarLocation'];
  }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/offcanvas/">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="../stylesheets/offcanvas.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One" rel="stylesheet">
    <link rel="stylesheet" href="../stylesheets/gui.css">
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
  "
?>

<button class="navbar-toggler p-0 border-0 navButton" type="button" data-toggle="offcanvas">
    <?php echo"<img class='usrNavImage' src='../$avatarImage' width='25'> ";?>

</button>

<div class="navbar-collapse offcanvas-collapse" id="offcanvasNav">
    <ul class="navbar-nav ml-auto">

        <li class="nav-item active">
            <a class="nav-link" href="index.php"><?php echo "$sessionUser";?><span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item navList">
            <a class="nav-link" id="navButton" href="mygames.php"><img src="../logoImages/1.png" width='27' height='27' class='navImages' alt='logoImage'>Games</a>
        </li>
        <li class="nav-item navList">
            <a class="nav-link" id="navButton" href="#"><img src="../logoImages/2.png" width='27' height='27' class='navImages' alt='logoImage'>Groups</a>
        </li>
        <li class="nav-item navList">
            <a class="nav-link" id="navButton" href="#"><img src="../logoImages/3.png" width='27' height='27' class='navImages' alt='logoImage'>Messages</a>
        </li>
        <li class="nav-item navList">
            <a class="nav-link" id="navButton" href="#"><img src="../logoImages/4.png" width='27' height='27' class='navImages' alt='logoImage'>Settings</a>
        </li>
        <li class="nav-item navList">
            <a class="nav-link" id="navButton" href="signout.php"><img src="../logoImages/1.png" width='27' height='27' class='navImages' alt='logoImage'>Logout</a>
        </li>
    </ul>
  </div>

</nav>
</div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="/docs/4.3/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/offcanvas.js"></script>
</body>
</html>
