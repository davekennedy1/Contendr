<?php
  session_start();
  include('conn.php');
  $name = $conn->real_escape_string(trim($_POST['name']));
  $email = $conn->real_escape_string(trim($_POST['email']));
  $phone = $conn->real_escape_string(trim($_POST['phoneNumber']));
  $dob = $conn->real_escape_string(trim($_POST['dob']));
  $userpass = $conn->real_escape_string(trim($_POST['pass']));
  $avatar = "avatarImages/default_avatar.png";
  $ruleInfringement = 0;

  $checkuserunique = "SELECT * FROM Sps_User WHERE Email = '$email'";

  $result = $conn->query($checkuserunique);
  if(!$result){
    echo $conn->error;
  }

  //email and password validation
  if(preg_match('/(?=.*[@])/', $email) && preg_match('/(?=.*[0-9])(?=.*[A-Z]).{8,}/', $userpass)){
    $ruleInfringement = 0;
  }else{
    $ruleInfringement = 1;
  }

  //empty field validation
  if(empty($name) || empty($email) || empty($dob) || empty($userpass) || $ruleInfringement === 1){
    $ruleInfringement = 1;
    header('Location: signup.php');
  }else{
    $ruleInfringement = 0;

    //check no required field is empty
    $num = $result->num_rows;

    //check if email already exists
    if($num<1){

        $insertUserNew = "INSERT INTO Sps_User(Name, Email, Password, DOB, PhoneNo, UserAccountStatusID, AvatarLocation, haveAvatar) VALUES ('$name', '$email', AES_ENCRYPT('$userpass', 'myN3wK3y15B3tt3rThanMyLa5tK3y'), '$dob', '$phone', 2, '$avatar', 0)";

        $resultInsert =  $conn->query($insertUserNew);
        if(!$resultInsert){
          echo $conn->error;
        }
        header('Location: user/index.php');


    }else{
      header('Location: signup.php');
    }
  }
?>
