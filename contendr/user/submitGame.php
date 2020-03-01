<?php
  session_start();
  if (!isset($_SESSION['13072064_contendrUnom'])) {
      header('Location: ../index.php');
  }
  $sessionUser = $_SESSION['13072064_contendrUnom'];
  $uid = $_SESSION['13072064_contenderUID'];
  include('../conn.php');

  $sportType = "SELECT Sps_SportType.SportTypeID, Sps_SportType.SportTypeName FROM Sps_SportType";
  $sportTypeResult = $conn->query($sportType);
  $sportTypeNum = $sportTypeResult->num_rows;

  $indoorID;
  $outdoorID;

  $gameType = "SELECT Sps_GameType.GameTypeID, Sps_GameType.GameTypeName FROM Sps_GameType";
  $gameTypeResult = $conn->query($gameType);
  $gameTypeNum = $gameTypeResult->num_rows;

  $privateID;
  $publicID;

  $matchID = $conn->real_escape_string(trim($_POST['matchID']));
  $public = $conn->real_escape_string(trim($_POST['public']));
  $private = $conn->real_escape_string(trim($_POST['private']));
  $publicOrPrivate;

  if (!$gameTypeResult) {
      echo $conn->error;
  } else {
      while ($row = $gameTypeResult->fetch_assoc()) {
        $gameTypeID = $row['GameTypeID'];
        $gameTypeName = $row['GameTypeName'];
        if($gameTypeName == 'Private') {
          $privateID = $gameTypeID;
        } else if ($gameTypeName == 'Public'){
          $publicID = $gameTypeID;
        }
      }
  }

  if($private == 'Private'){
    $publicOrPrivate = $privateID;
  } else {
    $publicOrPrivate = $publicID;
  }

  $venue = $conn->real_escape_string(trim($_POST['venue']));
  $indoorOutdoor = $conn->real_escape_string(trim($_POST['indoorOutdoor']));

  if (!$sportTypeResult) {
      echo $conn->error;
  } else {
      while ($row = $sportTypeResult->fetch_assoc()) {
        $sportTypeID = $row['SportTypeID'];
        $sportTypeName = $row['SportTypeName'];
        if($sportTypeName == 'Indoor') {
          $indoorID = $sportTypeID;
        } else if ($sportTypeName == 'Outdoor'){
          $outdoorID = $sportTypeID;
        }
      }
  }

  if($indoorOutdoor == 'Indoor') {
    $indoorOutdoor = $indoorID;
  } else {
    $indoorOutdoor = $outdoorID;
  }

  $matchType = "SELECT Sps_MatchType.MatchTypeID, Sps_MatchType.MatchTypeName FROM Sps_MatchType";
  $matchTypeResult = $conn->query($matchType);
  $matchTypeNum = $matchTypeResult->num_rows;
  $teamGameID;
  $individualsGameID;

  if (!$matchTypeResult) {
      echo $conn->error;
  } else {
      while ($row = $matchTypeResult->fetch_assoc()) {
        $matchTypeID = $row['MatchTypeID'];
        $matchTypeName = $row['MatchTypeName'];
        if($matchTypeName == 'Team game') {
          $teamGameID = $matchTypeID;
        } else if ($matchTypeName == 'Individuals game'){
          $individualsGameID = $matchTypeID;
        }
      }
  }

  $minPlayers = $conn->real_escape_string(trim($_POST['minPlayers']));
  if($minPlayers > 2) {
    $matchType = $teamGameID;
  } else {
    $matchType = $individualsGameID;
  }
  $sport = $conn->real_escape_string(trim($_POST['sport']));
  $difficulty = $conn->real_escape_string(trim($_POST['difficulty']));
  $date = $conn->real_escape_string(trim($_POST['date']));
  $startTime = $conn->real_escape_string(trim($_POST['startTime']));
  $date = $date.$startTime;
  $dateChange=strtotime($date);
  $matchDateTime = date('Y-m-d H:i:s',$dateChange);

  $gameName = $conn->real_escape_string(trim($_POST['gameName']));
  $cost = $conn->real_escape_string(trim($_POST['cost']));
  $maxPlayers = $conn->real_escape_string(trim($_POST['maxPlayers']));

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
  $initialiseTeam1 = "INSERT INTO SPS_Teams(TeamName, MatchID) VALUES ('Team 1', '$gameID')";
  $initialiseTeam2 = "INSERT INTO SPS_Teams(TeamName, MatchID) VALUES ('Team 2', '$gameID')";
  $addModerator = "INSERT INTO Sps_ModeratorMatch(UserID, MatchID) VALUES ('$uid', '$gameID')";

  // $resultInsert =  $conn->query($createGame);
  $resultInsert2 =  $conn->query($addPlayer);
  $resultInsert3 =  $conn->query($addModerator);
  $resultInsert4 =  $conn->query($initialiseTeam1);
  $resultInsert5 =  $conn->query($initialiseTeam2);


  header('Location: mygames.php');


?>
