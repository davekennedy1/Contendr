<?php
session_start();
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <link rel="stylesheet" href="../stylesheets/gui.css">


  <link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One" rel="stylesheet">

  <title>Contendr</title>
</head>

<body>
<nav class='navbar sticky-top navbar-expand-sm navbar-dark mainbk'>
<?php echo"
  <a class='navbar-item' href='index.php'>
    <blockqoute class='navfont'>CONTENDR</blockquote>
    <img src='$logoImage' width='27' height='27' class='navImages' alt='logoImage'>
  </a>
  "
?>

<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo "$sessionUser"; echo"<img class='usrNavImage' src='../$avatarImage' width='25'> ";?></a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="signout.php">Logout</a>
        </div>
      </li>
    </ul>
  </div>


</nav>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
