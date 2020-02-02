<?php
  session_start();
  if (!isset($_SESSION['13072064_contendrUnom'])) {
      header('Location: ../index.php');
  }
  $sessionUser = $_SESSION['13072064_contendrUnom'];
  $uid = $_SESSION['13072064_contenderUID'];
  include('../conn.php');

  $matchID = $conn->real_escape_string(trim($_POST['matchID']));

  $deletePlayersFromGame = "DELETE FROM Sps_PlayersMatch WHERE Sps_PlayersMatch.MatchID = $matchID";
  $deleteModeratorsFromGame = "DELETE FROM Sps_ModeratorMatch WHERE Sps_ModeratorMatch.MatchID = $matchID";
  $deleteGame = "DELETE FROM Sps_Match WHERE Sps_Match.MatchID = $matchID";

  if ($conn->query($deletePlayersFromGame) === TRUE) {
    echo "Delected players from game successfully";

    if ($conn->query($deleteModeratorsFromGame) === TRUE) {
      echo "Delected moderators from game successfully";

      if ($conn->query($deleteGame) === TRUE) {
        echo "Delected game successfully";
      } else {
        echo "Error deleting game: " . $conn->error;
      }

    } else {
      echo "Error deleting moderators: " . $conn->error;
    }

  } else {
    echo "Error deleting players: " . $conn->error;
  }

  header('Location: mygames.php');

  ?>
