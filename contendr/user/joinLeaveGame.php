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

      $incrementNoPlayers = "UPDATE Sps_Match
                             SET Sps_Match.NoOfPlayers = Sps_Match.NoOfPlayers + 1
                             WHERE Sps_Match.MatchID = $matchID";
      $resultIncrement = $conn->query($incrementNoPlayers);

      if (!$resultJoin) {
          echo $conn->error;
      }
  } elseif ($joinLeave == 0) {
      $leaveGame = "DELETE FROM Sps_PlayersMatch
                  WHERE Sps_PlayersMatch.UserID = $uid
                  AND Sps_PlayersMatch.MatchID = $matchID";
      $resultLeave = $conn->query($leaveGame);

      $decrementNoPlayers = "UPDATE Sps_Match
                             SET Sps_Match.NoOfPlayers = Sps_Match.NoOfPlayers - 1
                             WHERE Sps_Match.MatchID = $matchID";
      $resultDecrement = $conn->query($decrementNoPlayers);

      if (!$resultLeave) {
          echo $conn->error;
      }
  };
  $conn->close();
  header('Location: game.php?gameid='.$matchID);
