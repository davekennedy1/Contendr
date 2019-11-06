<?php
  session_start();
  include('conn.php');
  $name = $conn->real_escape_string(trim($_POST['name']));
  $email = $conn->real_escape_string(trim($_POST['email']));
  $phone = $conn->real_escape_string(trim($_POST['phoneNumber']));
  $dob = $conn->real_escape_string(trim($_POST['dob']));
  $userpass = $conn->real_escape_string(trim($_POST['pass']));
  $avatar = "avatarImages/default_avatar.png";

  echo"$name, $email, $phone, $dob, $userpass";


?>
