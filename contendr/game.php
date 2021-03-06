<?php
    include("conn.php");

    $matchID = $conn->real_escape_string(trim($_GET['gameid']));
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
  <script src="//code.jquery.com/jquery-3.3.1.min.js"></script> <!--Probably don't need this-->

  <title>Contendr</title>
</head>
<body class='indexbk'>
  <?php
    include('nav.php');
  ?>

  <?php
    echo "
    <div class='container'>
    ";
  ?>

  <?php
    if(!$matchResult){
      echo $conn->error;
    }else{

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
            if(!$matchImage){
              $sportImage = 'defaultSportImages/bball.jpg';
            }else{
              $sportImage = $matchImage;
            }

            break;

          case '4':
            if(!$matchImage){
              $sportImage = 'defaultSportImages/football.jpg';
            }else{
              $sportImage = $matchImage;
            }
            break;

          case '6':
            if(!$matchImage){
              $sportImage = 'defaultSportImages/tennis.jpg';
            }else{
              $sportImage = $matchImage;
            }
            break;

          case '7':
            if(!$matchImage){
              $sportImage = 'defaultSportImages/golf.jpg';
            }else{
              $sportImage = $matchImage;
            }
            break;

          case '8':
            if(!$matchImage){
              $sportImage = 'defaultSportImages/chess.jpg';
            }else{
              $sportImage = $matchImage;
            }
            break;

          default:
            if(!$matchImage){
              $sportImage = 'defaultSportImages/tennisball.png';
            }else{
              $sportImage = $matchImage;
            }
            break;
        }

          echo"
          <br>
          <div class='row'>
            <div class='col-sm-6'>
              <h1>$matchName</h1>
              <p>$sportName</p>
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
                  if($num != ' ' && $num != NULL){
                    echo"$num<br>";
                  }
                  if($addLine1 != ' ' && $addLine1 != NULL){
                    echo"$addLine1<br>";
                  }
                  if($addLine2 != ' ' && $addLine2 != NULL){
                    echo"$addLine2<br>";
                  }
                  if($addLine3 != ' ' && $addLine3 != NULL){
                    echo"$addLine3<br>";
                  }
                  if($postcode != ' ' && $postcode != NULL){
                    echo"$postcode<br>";
                  }
                  echo"
                  </p></td>
                </tr>
              </table>
            </div>
            <div class='col-sm-6' id='map'>
              <script id='coords' src='js/map.js' data-long='$long' data-lat='$lat'></script>
            </div>
          </div>
          ";



      }

    }


  ?>


    </div>



    <?php
      include('footer.php');
    ?>

  <?php
    $conn->close();
  ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCa3cYpWx3nLwIwV7KmCPuIHtnVl8w9LWM&callback=myMap"></script>
</body>
</html>
