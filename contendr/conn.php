<?php
  //hostname
  $host = "localhost";
  //username
  $username = "root";
  //password
  $password = "1Qwertyu";
  //dbname
  $db = "Contendr";

  //mysqli api
  $conn = new mysqli($host, $username, $password, $db);

  //catch errors
  if($conn->connect_error){
    echo "Connection failed: ".$conn->connect_error;
  }



?>
