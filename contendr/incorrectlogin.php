<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- bootstrap cdn -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One" rel="stylesheet">
  <!-- css font-family: 'Alfa Slab One', cursive; -->
  <!-- theme colours i like hsl(181,82,15), hsl(37,80,70), hsl(0,0,95) & white -->

  <title>Contendr</title>
</head>
<body>
  <?php
    include('nav.php');
  ?>
  <div class='bkbody'>
  <div class="leftmargin">
    <p class="text-center textmargin warning">Oops!</br>Unrecognised username or password, please try again!</p>
  </div>
  <div class="formcontent">
  <form autocomplete="on"  method="POST" action="user/loginprocess.php">
  <div class="container topmargin">
    <div class="row">
      <div class="col-4">
        <label class="usernamemargin" for="nameofuser">Email:</label>
      </div>
      <div class="col-8">
        <input type="email" class="form-control" id="ilnameofuser" name ="postemail" placeholder="email" autocomplete="email" autofocus required>
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <label class="usernamemargin" for="pass">Password:</label>
      </div>
      <div class="col-8">
        <input type="password" class="form-control" id="ilpass" name="postuserpswrd"placeholder="password" autocomplete="current-password" required>
      </div>
    </div>

  <div>
    <button type="submit" class="btn btn-primary float-right topMargin">Login</button>
  </div>
  </form>
  </div>
</div>
</div>


  <?php
    $conn->close();
  ?>
</body>
</html>
