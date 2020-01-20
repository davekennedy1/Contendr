<?php
  session_start();
  if (!isset($_SESSION['13072064_contendrUnom'])) {
      header('Location: ../index.php');
  }
  $sessionUser = $_SESSION['13072064_contendrUnom'];
  $uid = $_SESSION['13072064_contenderUID'];
  include('../conn.php');

  $venue = $conn->real_escape_string(trim($_POST['venue']));
  $indoorOutdoor = $conn->real_escape_string(trim($_POST['indoorOutdoor']));
  if($indoorOutdoor == 'Indoor') {
    $indoorOutdoor = 3;
  } else {
    $indoorOutdoor = 4;
  }
  $sport = $conn->real_escape_string(trim($_POST['sport']));
  $difficulty = $conn->real_escape_string(trim($_POST['difficulty']));
  $date = $conn->real_escape_string(trim($_POST['date']));
  $startTime = $conn->real_escape_string(trim($_POST['startTime']));
  $date = $date.$startTime;
  $dateChange=strtotime($date);
  $matchDateTime = date('Y-m-d H:i:s',$dateChange);
  $public = $conn->real_escape_string(trim($_POST['public']));
  $private = $conn->real_escape_string(trim($_POST['private']));
  $publicOrPrivate;
  if($private){
    $publicOrPrivate = 3;
  } else {
    $publicOrPrivate = 4;
  }
  $gameName = $conn->real_escape_string(trim($_POST['gameName']));
  $cost = $conn->real_escape_string(trim($_POST['cost']));
  $maxPlayers = $conn->real_escape_string(trim($_POST['maxPlayers']));
  $minPlayers = $conn->real_escape_string(trim($_POST['minPlayers']));
  if($minPlayers > 2) {
    $matchType = 3;
  } else {
    $matchType = 4;
  }
  $status = $conn->real_escape_string(trim($_POST['status']));
  $frequency = $conn->real_escape_string(trim($_POST['frequency']));
  $end = $conn->real_escape_string(trim($_POST['endTime']));
  $endToDate = strtotime($end);
  $endTime = date('H:i:s', $endToDate);
  $city = $conn->real_escape_string(trim($_POST['city']));

  $createGame = "INSERT INTO Sps_Match(VenueID, SportTypeID, MatchTypeID, SportID, ProficiencyLevelID, MatchDateTime, GameTypeID, MatchName, Cost, MaxPlayers, MinPlayers, MatchStatusID, RecurringMatchID, EquipmentID, MatchEndTime, CityID, MatchImage, NoOfPlayers) VALUES ('$venue', '$indoorOutdoor', '$matchType', '$sport', '$difficulty', '$matchDateTime', '$publicOrPrivate','$gameName', '$cost', '$maxPlayers', '$minPlayers' , '$status', '$frequency', NULL, '$endTime', '$city', NULL, 1)";

  if (mysqli_query($conn, $createGame)) {
    $gameID = mysqli_insert_id($conn);
  }

  $addPlayer = "INSERT INTO Sps_PlayersMatch(UserID, MatchID) VALUES ('$uid', '$gameID')";

  $addModerator = "INSERT INTO Sps_ModeratorMatch(UserID, MatchID) VALUES ('$uid', '$gameID')";

  // $resultInsert =  $conn->query($createGame);
  $resultInsert2 =  $conn->query($addPlayer);
  $resultInsert3 =  $conn->query($addModerator);


  header('Location: mygames.php');


?>
