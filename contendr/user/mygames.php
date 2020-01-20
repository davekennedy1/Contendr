<?php
  session_start();
  if (!isset($_SESSION['13072064_contendrUnom'])) {
      header('Location: ../index.php');
  }
  $sessionUser = $_SESSION['13072064_contendrUnom'];
  $uid = $_SESSION['13072064_contenderUID'];
  include("../conn.php");

  $readUpcomingGames = "SELECT Sps_Sport.SportID, Sps_Sport.SportName, Sps_Sport.SportDescription, Sps_Match.MatchID, Sps_Venue.VenueID, Sps_Match.SportTypeID, Sps_Match.MatchTypeID, Sps_Match.SportID, Sps_Match.ProficiencyLevelID, Sps_Match.MatchDateTime, Sps_Match.GameTypeID, Sps_Match.MatchName, Sps_Match.Cost, Sps_Match.MaxPlayers, Sps_Match.MinPlayers, Sps_Match.MatchStatusID, Sps_Match.RecurringMatchID, Sps_Match.EquipmentID, Sps_Match.MatchEndTime, Sps_Match.CityID,Sps_Match.MatchImage, Sps_Match.NoOfPlayers, Sps_CityOrTown.CityOrTownID, Sps_CityOrTown.CityOrTownName, Sps_CityOrTown.CountryID, Sps_Venue.VenueID, Sps_Venue.VenueName, Sps_Venue.Pitch, Sps_Venue.Room, Sps_Venue.TableBooked, Sps_Venue.Court, Sps_Venue.AddressID, Sps_Venue.ParkingDescription, Sps_PlayersMatch.UserID, Sps_PlayersMatch.MatchID FROM Sps_Sport INNER JOIN Sps_Match
ON Sps_Sport.SportID = Sps_Match.SportID
INNER JOIN Sps_CityOrTown
ON Sps_Match.CityID = Sps_CityOrTown.CityOrTownID
INNER JOIN Sps_Venue
ON Sps_Match.VenueID = Sps_Venue.VenueID
INNER JOIN Sps_PlayersMatch
ON Sps_Match.MatchID = Sps_PlayersMatch.MatchID
INNER JOIN Sps_ModeratorMatch
ON Sps_Match.MatchID = Sps_ModeratorMatch.MatchID
WHERE Sps_PlayersMatch.UserID = 11
AND Sps_Match.MatchDateTime > CURRENT_TIMESTAMP
UNION
SELECT Sps_Sport.SportID, Sps_Sport.SportName, Sps_Sport.SportDescription, Sps_Match.MatchID, Sps_Venue.VenueID, Sps_Match.SportTypeID, Sps_Match.MatchTypeID, Sps_Match.SportID, Sps_Match.ProficiencyLevelID, Sps_Match.MatchDateTime, Sps_Match.GameTypeID, Sps_Match.MatchName, Sps_Match.Cost, Sps_Match.MaxPlayers, Sps_Match.MinPlayers, Sps_Match.MatchStatusID, Sps_Match.RecurringMatchID, Sps_Match.EquipmentID, Sps_Match.MatchEndTime, Sps_Match.CityID,Sps_Match.MatchImage, Sps_Match.NoOfPlayers, Sps_CityOrTown.CityOrTownID, Sps_CityOrTown.CityOrTownName, Sps_CityOrTown.CountryID, Sps_Venue.VenueID, Sps_Venue.VenueName, Sps_Venue.Pitch, Sps_Venue.Room, Sps_Venue.TableBooked, Sps_Venue.Court, Sps_Venue.AddressID, Sps_Venue.ParkingDescription, Sps_ModeratorMatch.UserID, Sps_ModeratorMatch.MatchID  FROM Sps_Sport INNER JOIN Sps_Match
ON Sps_Sport.SportID = Sps_Match.SportID
INNER JOIN Sps_CityOrTown
ON Sps_Match.CityID = Sps_CityOrTown.CityOrTownID
INNER JOIN Sps_Venue
ON Sps_Match.VenueID = Sps_Venue.VenueID
INNER JOIN Sps_ModeratorMatch
ON Sps_Match.MatchID = Sps_ModeratorMatch.MatchID
WHERE Sps_ModeratorMatch.UserID = 11
AND Sps_Match.MatchDateTime > CURRENT_TIMESTAMP
ORDER BY `MatchDateTime` ASC";
  $upcomingGamesResult = $conn->query($readUpcomingGames);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- bootstrap cdn -->
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One" rel="stylesheet">
  <!-- css font-family: 'Alfa Slab One', cursive; -->
  <!-- theme colours i like hsl(181,82,15), hsl(37,80,70), hsl(0,0,95) & white -->

  <title>Contendr</title>
</head>
<body>
  <?php
    include('usernav.php');
  ?>
  <div class='container'>

    <div class='row'>
      <div class='col'>
        <hr>
            <a href="creategame.php" id="noDecoration">
              <button type='button' class='btn btn-outline-success btn-lg btn-block'>+ Make a Game</button>
            </a>
      </div>
    </div>
    <div class='row'>
      <div class='col'>
        <hr>
            <h2 class='indexStrap'>My Games</h2>
      </div>
    </div>
    <hr>
    <div class='row'>

      <?php
        if(!$upcomingGamesResult){
          echo $conn->error;
        }else{

          while ($row = $upcomingGamesResult->fetch_assoc()) {
            $matchName = $row['MatchName'];
            $cityName = $row['CityOrTownName'];
            $sportName = $row['SportName'];
            $venueName = $row['VenueName'];
            $matchID = $row['MatchID'];
            $matchTime = $row['MatchDateTime'];
            $matchStatus = $row['MatchStatusID'];
            $sportID = $row['SportID'];
            $matchImage = $row['MatchImage'];
            $match = new DateTime($matchTime);
            $match = $match->format('jS M - g:iA');

            switch ($sportID) {
              case '3':
                if(!$matchImage){
                  $sportImage = '../defaultSportImages/bball.jpg';
                }else{
                  $sportImage = '../'.$matchImage;
                }

                break;

              case '4':
                if(!$matchImage){
                  $sportImage = '../defaultSportImages/football.jpg';
                }else{
                  $sportImage = '../'.$matchImage;
                }
                break;

              case '6':
                if(!$matchImage){
                  $sportImage = '../defaultSportImages/tennis.jpg';
                }else{
                  $sportImage = '../'.$matchImage;
                }
                break;

              case '7':
                if(!$matchImage){
                  $sportImage = '../defaultSportImages/golf.jpg';
                }else{
                  $sportImage = '../'.$matchImage;
                }
                break;

              case '8':
                if(!$matchImage){
                  $sportImage = '../defaultSportImages/chess.jpg';
                }else{
                  $sportImage = '../'.$matchImage;
                }
                break;

              default:
                if(!$matchImage){
                  $sportImage = '../defaultSportImages/tennisball.png';
                }else{
                  $sportImage = '../'.$matchImage;
                }
                break;
            }

            echo"

                <div class='col-sm-6'>
                  <a href='game.php?gameid=$matchID'>
                    <div class='card myBottomMargin'>
                      <img src='$sportImage' class='card-img-top imageLimit' alt='sport image'>
                      <div class='sportText'>$sportName</div>
                      <div class='card-body'>
                        <p class='card-text'>
                           <strong>Venue: </strong>$venueName</br>
                           <strong>City/Town: </strong>$cityName</br>
                           <strong>Date/Time: </strong>$match
                        </p>
                      </div>
                    </div>
                  </a>
                </div>

                </br>
                ";
          }
        }
        $conn->close();
      ?>

    </div>

  <?php
    include('../footer.php');
  ?>
</body>
</html>
