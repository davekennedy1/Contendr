<?php
  session_start();
  if (!isset($_SESSION['13072064_contendrUnom'])) {
      header('Location: ../index.php');
  }
  $sessionUser = $_SESSION['13072064_contendrUnom'];
  $uid = $_SESSION['13072064_contenderUID'];
  include("../conn.php");
  $joinLeave = $conn->real_escape_string(trim($_POST['joinLeaveGame']));
  $matchID = $conn->real_escape_string(trim($_POST['matchID']));
  $matchName = $conn->real_escape_string(trim($_POST['matchName']));

  if ($joinLeave == 1) {
      $joinGame = "INSERT INTO `Sps_PlayersMatch` (`UserMatchID`, `UserID`, `MatchID`)
                VALUES (NULL, '$uid', '$matchID')";
      $resultJoin = $conn->query($joinGame);

      if (!$resultJoin) {
          echo $conn->error;
      }
  } elseif ($joinLeave == 0) {
      $leaveGame = "DELETE FROM Sps_PlayersMatch
                  WHERE Sps_PlayersMatch.UserID = $uid
                  AND Sps_PlayersMatch.MatchID = $matchID";
      $resultLeave = $conn->query($leaveGame);

      if (!$resultLeave) {
          echo $conn->error;
      }
  };
  header('Location: game.php?gameid='.$matchID);