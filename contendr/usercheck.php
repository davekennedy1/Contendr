<?php
  session_start();
  include('conn.php');

  $email = $conn->real_escape_string(trim($_POST['usermail']));

  $checkemailunique = "SELECT * FROM Sps_User WHERE Email = '$email'";

  $result = $conn->query($checkemailunique);
  if(!$result){
    echo $conn->error;
  }

  $num = $result->num_rows;

  //check if username already exists
  if($num<1){
    echo"We'll never share your email with anyone else.";
  }else if($num>0){
    echo"That email is already registered";
  }else{
    echo"Required";
  }

?>
