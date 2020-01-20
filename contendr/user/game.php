<?php
session_start();
if (!isset($_SESSION['13072064_contendrUnom'])) {
    header('Location: ../index.php');
}
$sessionUser = $_SESSION['13072064_contendrUnom'];
$uid = $_SESSION['13072064_contenderUID'];
include("../conn.php");

    $matchID = $conn->real_escape_string(trim($_GET['gameid']));

    $moderatorRead = "SELECT @registeredPlayer := IF((SELECT Sps_ModeratorMatch.UserID FROM Sps_ModeratorMatch INNER JOIN Sps_User
                     On Sps_ModeratorMatch.UserID = Sps_User.UserID
                     WHERE Sps_ModeratorMatch.MatchID = $matchID
                     AND Sps_User.UserID = $uid) = $uid, 1, 0) AS Moderator"; /* Return 1 if player is a moderator of this game else 0 */

    $playerRead = "SELECT @registeredPlayer := IF((SELECT Sps_PlayersMatch.UserID FROM Sps_PlayersMatch INNER JOIN Sps_User
                  On Sps_PlayersMatch.UserID = Sps_User.UserID
                  WHERE Sps_PlayersMatch.MatchID = $matchID
                  AND Sps_User.UserID = $uid) = $uid, 1, 0) AS RegisteredPlayer";  /* Return 1 if player in this game else 0*/

    $slotRead = "SELECT @availableSlot := IF((SELECT COUNT(Sps_User.UserID) FROM Sps_User INNER JOIN Sps_PlayersMatch
                ON Sps_User.UserID = Sps_PlayersMatch.UserID
                INNER JOIN Sps_Match
                On Sps_PlayersMatch.MatchID = Sps_Match.MatchID
                WHERE Sps_Match.MatchID = $matchID) < (SELECT Sps_Match.MaxPlayers FROM Sps_Match WHERE Sps_Match.MatchID = $matchID), 1, 0) AS AvailableSlot";   /* Return 1 if theres an availab;e slot in this game*/

    $moderatorResult = $conn->query($moderatorRead);
    $currentPlayersResult = $conn->query($playerRead);
    $availableSlotResult = $conn->query($slotRead);
    $moderator = 0;
    $regPlayer = 0;
    $availableSlot = 0;

    $read = "SELECT
             Sps_Match.MatchID, Sps_Match.SportID, Sps_Match.MatchImage, Sps_Match.MatchDateTime, Sps_Match.MatchName, Sps_Match.Cost, Sps_Match.MaxPlayers, Sps_Match.MinPlayers, Sps_Match.MatchEndTime, Sps_Venue.VenueName, Sps_Venue.Pitch, Sps_Venue.Room, Sps_Venue.Court, Sps_Venue.TableBooked, Sps_Venue.ParkingDescription, Sps_SportType.SportTypeName, Sps_Sport.SportName, Sps_Sport.SportDescription, Sps_ProficiencyLevel.ProficiencyLevelName, Sps_ProficiencyLevel.ProficiencyLevelDescription,
             Sps_MatchStatus.MatchStatusID, Sps_MatchStatus.MatchStatusName, Sps_RecurringMatch.RecurringMatchDescription,
             Sps_User.Name, Sps_User.haveAvatar, Sps_User.AvatarLocation, Sps_CityOrTown.CityOrTownName,
             Sps_Address.Longitude, Sps_Address.Latitude, Sps_Address.NumberOrName, Sps_Address.AddressLine1,
             Sps_Address.AddressLine2, Sps_Address.AddressLine3, Sps_Address.PostcodeZip
             FROM Sps_Match INNER JOIN Sps_Venue
             ON Sps_Match.VenueID = Sps_Venue.VenueID
             INNER JOIN Sps_SportType
             ON Sps_Match.SportTypeID = Sps_SportType.SportTypeID
             INNER JOIN Sps_Sport
             ON Sps_Match.SportID = Sps_Sport.SportID
             INNER JOIN Sps_ProficiencyLevel
             ON Sps_Match.ProficiencyLevelID = Sps_ProficiencyLevel.ProficiencyLevelID
             INNER JOIN Sps_MatchStatus
             ON Sps_Match.MatchStatusID = Sps_MatchStatus.MatchStatusID
             INNER JOIN Sps_RecurringMatch
             ON Sps_Match.RecurringMatchID = Sps_RecurringMatch.RecurringMatchID
             INNER JOIN Sps_ModeratorMatch
             ON Sps_Match.MatchID = Sps_ModeratorMatch.MatchID
             INNER JOIN Sps_User
             ON Sps_ModeratorMatch.UserID = Sps_User.UserID
             INNER JOIN Sps_CityOrTown
             ON Sps_Match.CityID = Sps_CityOrTown.CityOrTownID
             INNER JOIN Sps_Address
             ON Sps_Venue.AddressID = Sps_Address.AddressID
             WHERE Sps_Match.MatchID = $matchID";

    $matchResult = $conn->query($read);
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <!--  <script src="//code.jquery.com/jquery-3.3.1.min.js"></script> Probably don't need this-->

  <title>Contendr</title>
</head>
<body class='indexbk'>
  <?php
    include('usernav.php');
  ?>

  <?php
  echo "
  <div class='container'>
  ";
  if (!$currentPlayersResult) {
      echo $conn->error;
  } else {

      while ($row = $moderatorResult->fetch_assoc()) {
          $moderator = $row['Moderator'];
      }

      while ($row = $currentPlayersResult->fetch_assoc()) {
          $regPlayer= $row['RegisteredPlayer'];
      }


      if (!$availableSlotResult) {
          echo $conn->error;
      } else {
          while ($row = $availableSlotResult->fetch_assoc()) {
              $availableSlot= $row['AvailableSlot'];
          }



          if (!$matchResult) {
              echo $conn->error;
          } else {
              while ($row = $matchResult->fetch_assoc()) {
                  $matchName = $row['MatchName'];
                  $cityName = $row['CityOrTownName'];
                  $sportName = $row['SportName'];
                  $venueName = $row['VenueName'];
                  $matchTime = $row['MatchDateTime'];
                  $matchStatus = $row['MatchStatusID'];
                  $sportID = $row['SportID'];
                  $matchImage = $row['MatchImage'];
                  $matchEndtime = $row['MatchEndTime'];
                  $endTime = new DateTime($matchEndtime);
                  $endTime = $endTime->format('g:iA');
                  $cost = $row['Cost'];
                  $date = new DateTime($matchTime);
                  $date = $date->format('jS M');
                  $startTime = new DateTime($matchTime);
                  $startTime = $startTime->format('g:iA');
                  $long = $row['Longitude'];
                  $lat = $row['Latitude'];
                  $num = $row['NumberOrName'];
                  $addLine1 = $row['AddressLine1'];
                  $addLine2 = $row['AddressLine2'];
                  $addLine3 = $row['AddressLine3'];
                  $postcode = $row['PostcodeZip'];

                  //$matchTime = str_replace('-', '/', $matchTime);


                  switch ($sportID) {
          case '3':
            if (!$matchImage) {
                $sportImage = '../defaultSportImages/bball.jpg';
            } else {
                $sportImage = '../'.$matchImage;
            }

            break;

          case '4':
            if (!$matchImage) {
                $sportImage = '../defaultSportImages/football.jpg';
            } else {
                $sportImage = '../'.$matchImage;
            }
            break;

          case '6':
            if (!$matchImage) {
                $sportImage = '../defaultSportImages/tennis.jpg';
            } else {
                $sportImage = '../'.$matchImage;
            }
            break;

          case '7':
            if (!$matchImage) {
                $sportImage = '../defaultSportImages/golf.jpg';
            } else {
                $sportImage = '../'.$matchImage;
            }
            break;

          case '8':
            if (!$matchImage) {
                $sportImage = '../defaultSportImages/chess.jpg';
            } else {
                $sportImage = '../'.$matchImage;
            }
            break;

          default:
            if (!$matchImage) {
                $sportImage = '../defaultSportImages/tennisball.png';
            } else {
                $sportImage = '../'.$matchImage;
            }
            break;
        }

                  echo"
          <br>
          ";
          if($moderator == 1) {
            echo"<div class='row'><div class='col'><button type='button' class='btn btn-sm btn-secondary' disabled id='js-moderatorButton'>You are a Moderator</button></div></div>";
          }
          echo"
          <div class='row'>
            <div class='col-sm-6'>
              <h1>$matchName</h1>
            </div>
          </div>
          <div class='row'>
            <div class='col'>
              <p>$sportName</p>
            </div>
            <div class='col'>
            ";
                  if ($regPlayer == 0 && $availableSlot == 1) {
                      echo"
              <button type='button' class='btn btn-sm btn-info' id='js-joinButton' data-toggle='modal' data-target='#joinGameModal'>Join Game</button>
              ";
                  } elseif ($regPlayer == 0 && $availableSlot == 0) {
                      echo"
                <button type='button' class='btn btn-sm btn-danger' disabled>Game Full</button>
              ";
                  } elseif ($regPlayer == 1) {
                      echo"
              <form action='joinLeaveGame.php' method='POST'>
                <input type='hidden' value='0' name='joinLeaveGame'>
                <input type='hidden' value='$matchID' name='matchID'>
                <input type='hidden' value='$matchName' name='matchName'>
                <button type='submit' class='btn btn-sm btn-warning' id='js-leaveButton'>Leave Game</button>
              </form>
                ";
                  }

                  echo"
            </div>
          </div>

          <!-- Modal -->
          <div class='modal fade' id='joinGameModal' tabindex='-1' role='dialog' aria-labelledby='joinGameModalLabel' aria-hidden='true'>
              <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                  <div class='modal-header mainbk'>
                    <h5 class='modal-title mainfont' id=' joinGameModalLabel'>Commit to Game?</h5>
                    <button type='button' class='close mainfont' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>&times;</span>
                    </button>
                  </div>
                  <div class='modal-body'>
                    We know circumstances change and things can come up but you're ready to commit to this game right?
                  </div>
                  <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>No Thanks</button>
                    <form action='joinLeaveGame.php' method='POST'>
                      <input type='hidden' value='1' name='joinLeaveGame'>
                      <input type='hidden' value='$matchID' name='matchID'>
                      <input type='hidden' value='$matchName' name='matchName'>
                      <button type='submit' class='btn btn-info'>Join Game</button>
                    </form>

                  </div>
                </div>
              </div>
            </div>

            <div class='row'>
              <div class='col-sm-6'>
                <table>
                  <tr>
                    <td><strong>Price: </strong></td>
                    <td>£$cost</td>
                  </tr>
                  <tr>
                    <td><strong>Date: </strong></td>
                    <td>$date</td>
                  </tr>
                  <tr>
                    <td><strong>Time: </strong></td>
                    <td>$startTime - $endTime</td>
                  </tr>
                </table>

            </div>
            <div class='col-sm-6'>
              <img class='gamePic' src='$sportImage' alt='sport image'>
            </div>
          </div>
          <div class='row'>
            <div class='col-sm-6'>
              <table>
                <tr>
                  <td><p class='venueTop'><strong>Venue: </strong></p></td>
                  <td><p class='venueTop marginleft'>$venueName</p></td>
                </tr>
                <tr>
                  <td><p class='tableTop'><strong>Address: </strong></p></td>
                  <td><p class='tableTop marginleft'>
                  ";
                  if ($num != ' ' && $num != null) {
                      echo"$num<br>";
                  }
                  if ($addLine1 != ' ' && $addLine1 != null) {
                      echo"$addLine1<br>";
                  }
                  if ($addLine2 != ' ' && $addLine2 != null) {
                      echo"$addLine2<br>";
                  }
                  if ($addLine3 != ' ' && $addLine3 != null) {
                      echo"$addLine3<br>";
                  }
                  if ($postcode != ' ' && $postcode != null) {
                      echo"$postcode<br>";
                  }
                  echo"
                  </p></td>
                </tr>
              </table>
            </div>
            <div class='col-sm-6' id='map'>
             <script id='coords' src='../js/map.js' data-long='$long' data-lat='$lat'></script>
            </div>
          </div>
          ";
              }
          }
      }
  }
  ?>
    </div>
    <?php
      include('../footer.php');
    ?>

  <?php
    $conn->close();
  ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCa3cYpWx3nLwIwV7KmCPuIHtnVl8w9LWM&callback=myMap"></script>
</body>
</html>
