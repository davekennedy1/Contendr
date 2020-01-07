<?php
session_start();
if(!isset($_SESSION['13072064_contendrUnom'])){
  header('Location: ../index.php');
}
$sessionUser = $_SESSION['13072064_contendrUnom'];
$uid = $_SESSION['13072064_contenderUID'];
include("../conn.php");

$read = "SELECT * FROM Sps_Sport INNER JOIN Sps_Match
         ON Sps_Sport.SportID = Sps_Match.SportID
         INNER JOIN Sps_CityOrTown
         ON Sps_Match.CityID = Sps_CityOrTown.CityOrTownID
         INNER JOIN Sps_Venue
         ON Sps_Match.VenueID = Sps_Venue.VenueID
         WHERE Sps_Match.GameTypeID = 4
         AND Sps_Match.MatchStatusID = 6
         AND Sps_Match.NoOfPlayers < Sps_Match.MaxPlayers
         AND Sps_Match.MatchDateTime > CURRENT_TIMESTAMP
         ORDER BY Sps_Match.MatchDateTime ASC
         LIMIT 10
         ";
$result = $conn->query($read);

$matchesIn = "SELECT Sps_PlayersMatch.MatchID FROM Sps_PlayersMatch
              WHERE Sps_PlayersMatch.UserID = $uid";

$matchesInResult = $conn->query($matchesIn);

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
<body class='indexbk'>
  <?php
    include('usernav.php');
  ?>

  <?php
    echo "
    <div class='containered'>
      <img class='indexImage' src='../logoImages/$num.jpg' alt='logoImage'>
      <div class='imageTextTop'>Pick a sport.</div>
      <div class='imageTextMiddle'>Find a game.</div>
      <div class='imageTextBottom'>Go play.</div>
    </div>


    <div class='container'>




      <div class='col'>
        <hr>
            <h2 class='indexStrap'>Games Currently Looking for Players</h2>
      </div>
      <hr>
      <div class='row'>

    ";
  ?>

  <?php
    $userMatches = [];
    if(!$matchesInResult){
      echo $conn->error;
    } else {

      while($outerRow = $matchesInResult->fetch_assoc()) {
        $userMatchID = $outerRow['MatchID'];
        array_push($userMatches, $userMatchID);
      }


      if(!$result){
        echo $conn->error;
      }else{

        while ($row = $result->fetch_assoc()) {
          $matchID = $row['MatchID'];
          if(in_array($matchID, $userMatches)){
            continue;
          }
          $matchName = $row['MatchName'];
          $cityName = $row['CityOrTownName'];
          $sportName = $row['SportName'];
          $venueName = $row['VenueName'];
          $matchTime = $row['MatchDateTime'];
          $matchStatus = $row['MatchStatusID'];
          $sportID = $row['SportID'];
          $matchImage = $row['MatchImage'];
          $match = new DateTime($matchTime);
          $match = $match->format('jS M - g:iA');


          //$matchTime = str_replace('-', '/', $matchTime);


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


          if($matchStatus == 6){
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

          }else{
            echo"nope";
          }

        }

      }


    }


  ?>

      </div>
    </div>

  <?php
    $conn->close();
  ?>

  <?php
    include('../footer.php');
  ?>
</body>
</html>
