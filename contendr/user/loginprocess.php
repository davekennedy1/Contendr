<?php
  session_start();
  include('../conn.php');
  $email = $conn->real_escape_string(trim($_POST['postemail']));
  $userpass = $conn->real_escape_string(trim($_POST['postuserpswrd']));
  $checkuser = "SELECT * FROM Sps_User WHERE BINARY Email = '$email' AND password = AES_ENCRYPT('$userpass', 'myN3wK3y15B3tt3rThanMyLa5tK3y')";

  $result = $conn->query($checkuser);
  if(!$result){
    echo $conn->error;
  }

  $num = $result->num_rows;

  if($num>0){
    $row = $result->fetch_assoc();
    $_SESSION['13072064_contendrUnom']= $row['Name'];
    $_SESSION['13072064_contenderUID']= $row['UserID'];
    $conn->close();
    header('Location: index.php');
  }else{
    $conn->close();
    header('Location: ../incorrectlogin.php');
  }
?>
