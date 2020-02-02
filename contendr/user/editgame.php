<?php
session_start();
if (!isset($_SESSION['13072064_contendrUnom'])) {
    header('Location: ../index.php');
}
$sessionUser = $_SESSION['13072064_contendrUnom'];
$uid = $_SESSION['13072064_contenderUID'];
include("../conn.php");
$matchID = $conn->real_escape_string(trim($_GET['updateId']));

$moderatorRead = "SELECT @registeredPlayer := IF((SELECT Sps_ModeratorMatch.UserID FROM Sps_ModeratorMatch INNER JOIN Sps_User
                  On Sps_ModeratorMatch.UserID = Sps_User.UserID
                  WHERE Sps_ModeratorMatch.MatchID = $matchID
                  AND Sps_User.UserID = $uid) = $uid, 1, 0) AS Moderator"; /* Return 1 if player is a moderator of this game else 0 */
$moderatorResult = $conn->query($moderatorRead);
$moderator = 0;

while ($row = $moderatorResult->fetch_assoc()) {
    $moderator = $row['Moderator'];
};

if($moderator == 0) {
  header('Location: game.php?gameid='.$matchID);
}

$sports = "SELECT Sps_Sport.SportName, Sps_Sport.SportID FROM Sps_Sport";
$sportsResult = $conn->query($sports);
$sportsNum = $sportsResult->num_rows;

$status = "SELECT Sps_MatchStatus.MatchStatusName, Sps_MatchStatus.MatchStatusID FROM Sps_MatchStatus";
$statusResult = $conn->query($status);
$statusNum = $statusResult->num_rows;

$cities = "SELECT Sps_CityOrTown.CityOrTownName, Sps_CityOrTown.CityOrTownID FROM Sps_CityOrTown";
$citiesResult = $conn->query($cities);
$citiesNum = $citiesResult->num_rows;

$proficiency = "SELECT * FROM Sps_ProficiencyLevel";
$proficiencyResult = $conn->query($proficiency);
$proficiencyNum = $proficiencyResult->num_rows;

$frequency = "SELECT * FROM Sps_RecurringMatch";
$frequencyResult = $conn->query($frequency);
$frequencyNum = $frequencyResult->num_rows;

$previousSettings = "SELECT Sps_Match.VenueID, Sps_Match.SportTypeID, Sps_Match.SportID, Sps_Match.ProficiencyLevelID,  Sps_Match.MatchDateTime, Sps_Match.GameTypeID, Sps_Match.MatchName, Sps_Match.Cost, Sps_Match.MaxPlayers, Sps_Match.MinPlayers, Sps_Match.MatchStatusID, Sps_Match.RecurringMatchID, Sps_Match.MatchEndTime, Sps_Match.CityID, Sps_Match.MatchImage FROM Sps_Match WHERE Sps_Match.MatchID = $matchID";
$previousSettingsResult = $conn->query($previousSettings);
$previousSettingsNum = $previousSettingsResult->num_rows;

$previousVenueID;
$sportTypeID;
$sportID;
$previousProficiencyLevelID;
$matchDateTime;
$gameTypeID;
$matchName;
$previousCost;
$maxPlayers;
$minPlayers;
$matchStatusID;
$recurringMatchID;
$matchEndtime;
$previousCityID;
$matchImage;

if (!$previousSettingsResult) {
    echo $conn->error;
} else {
    while ($row = $previousSettingsResult->fetch_assoc()) {
      $previousVenueID = $row['VenueID'];
      $sportTypeID = $row['SportTypeID'];
      $sportID = $row['SportID'];
      $previousProficiencyLevelID = $row['ProficiencyLevelID'];
      $matchDateTime = $row['MatchDateTime'];
      $gameTypeID = $row['GameTypeID'];
      $matchName = $row['MatchName'];
      $previousCost = $row['Cost'];
      $maxPlayers = $row['MaxPlayers'];
      $minPlayers = $row['MinPlayers'];
      $matchStatusID = $row['MatchStatusID'];
      $recurringMatchID = $row['RecurringMatchID'];
      $matchEndtime = $row['MatchEndTime'];
      $previousCityID = $row['CityID'];
      $matchImage = $row['MatchImage'];
    }
}
$previousMatchDate = date('d M Y', strtotime($matchDateTime));
$previousMatchStartTime = date('G', strtotime($matchDateTime));

$venues = "SELECT Sps_Venue.VenueID, Sps_Venue.VenueName, Sps_CityOrTown.CityOrTownID,
          Sps_CityOrTown.CityOrTownName FROM Sps_Venue INNER JOIN Sps_Address
          On Sps_Venue.AddressID = Sps_Address.AddressID
          INNER JOIN Sps_CityOrTown
          On Sps_Address.CityOrTownID = Sps_CityOrTown.CityOrTownID
          WHERE Sps_CityOrTown.CityOrTownID = $previousCityID";
$venuesResult = $conn->query($venues);
$venuesNum = $venuesResult->num_rows;

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One" rel="stylesheet">
    <!-- css font-family: 'Alfa Slab One', cursive; -->
    <!-- theme colours i like hsl(181,82,15), hsl(37,80,70), hsl(0,0,95) & white -->
    <!-- font awesome icons cdn -->
    <script src="https://kit.fontawesome.com/0a85083fa0.js" crossorigin="anonymous"></script>
    <!-- Popper cdn for bootstrap tooltips -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <!-- Date Picker with time cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <title>Contendr</title>
  </head>

  <body>
    <?php
    include('usernav.php');
    ?>
    <div class='container'>
      <div class="topPadding">
        <form action="editgameprocess.php" autocomplete="on" method="POST" enctype="multipart/form-data">
          <div class="form-row">
            <input type="text" class="form-control" name="matchID" <?php echo"value='$matchID'";?> hidden>
            <div class="form-group col-sm-6">
              <label for="gameName">Game Name:</label>
              <input type="text" class="form-control" id="gameName" name="gameName" value="<?php echo"$matchName";?>"required>
        </div>

        <div class="form-group col-sm-2">
          <label for="datePicker">Date:</label>
            <input type="text" class="form-control" name="date" id="datePicker" value="<?php echo"$previousMatchDate";?>"/>
        </div>

        <div class="form-group col-sm-2">
          <label for="startTimePicker">Start Time:</label>
          <input type="text" class="form-control" name="startTime" id="startTimePicker" value="<?php echo"$previousMatchStartTime";?>"/>
        </div>

        <div class="form-group col-sm-2">
          <label for="endTimePicker">End Time:</label>
          <input type="text" class="form-control" name="endTime" id="endTimePicker" value="<?php echo"$matchEndtime";?>"  />
        </div>

    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="sport">Sport:</label>
        <select id="sport" name="sport" class="form-control" required>

          <?php
             for ($loop = 0; $loop<$sportsNum; $loop++) {
                 $sportsRow = $sportsResult->fetch_assoc();
                 $sportName = $sportsRow['SportName'];
                 $sportsID = $sportsRow['SportID'];

                if($sportsID == $sportID){
                  echo"
                   <option selected value='$sportsID'>$sportName</option>
                 ";
                }else {
                  echo"
                   <option value='$sportsID'>$sportName</option>
                 ";
                }
             };
          ?>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="city">City:</label>
        <select id="city" onchange="fetchVenues()" required name="city" class="form-control">

          <?php
             for ($loop = 0; $loop<$citiesNum; $loop++) {
                 $citiesRow = $citiesResult->fetch_assoc();
                 $cityName = $citiesRow['CityOrTownName'];
                 $cityID = $citiesRow['CityOrTownID'];
                 if($previousCityID == $cityID) {
                   echo"
                    <option selected value='$cityID'>$cityName</option>
                  ";
                } else {
                  echo"
                   <option value='$cityID'>$cityName</option>
                 ";
                }

             };
          ?>
        </select>
      </div>

      <!-- seperate call for venues needed here -->
      <div class="form-group col-md-4">
        <label for="venue">Venue:</label>
        <select id="venue" onchange="venueNum()" required name="venue" class="form-control">
          <?php
             for ($loop = 0; $loop<$venuesNum; $loop++) {
                 $venuesRow = $venuesResult->fetch_assoc();
                 $venueName = $venuesRow['VenueName'];
                 $venueID = $venuesRow['VenueID'];
                 if($previousVenueID == $venueID) {
                   echo"
                    <option selected value='$venueID'>$venueName</option>
                  ";
                } else {
                  echo"
                   <option value='$venueID'>$venueName</option>
                 ";
                }

             };
          ?>
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-3">
        <p><?php ?></p>
        <label for="indoorOutdoor">Indoor/Outdoor:</label>
          <select id="indoorOutdoor" name="indoorOutdoor" required class="form-control">
          <?php
            if($sportTypeID == 3) {
              echo"
              <option selected>Indoor</option>
              <option>Outdoor</option>
              ";
            } else {
              echo"
              <option>Indoor</option>
              <option selected>Outdoor</option>
              ";
            }
          ?>

          </select>
      </div>
      <div class="form-group col-md-3">
        <label for="difficulty">Difficulty:</label>
          <select id="difficulty" name="difficulty" required class="form-control">

            <?php
               for ($loop = 0; $loop<$proficiencyNum; $loop++) {
                   $proficiencyRow = $proficiencyResult->fetch_assoc();
                   $proficiencyID = $proficiencyRow['ProficiencyLevelID'];
                   $proficiencyLevelName = $proficiencyRow['ProficiencyLevelName'];
                   $proficiencyLevelDescription = $proficiencyRow['ProficiencyLevelDescription'];
                   if($previousProficiencyLevelID == $proficiencyID) {
                     echo"
                      <option selected value='$proficiencyID ' data-toggle='tooltip' data-placement='right' title='$proficiencyLevelDescription'>$proficiencyLevelName</option>
                    ";
                  } else {
                   echo"
                    <option value='$proficiencyID ' data-toggle='tooltip' data-placement='right' title='$proficiencyLevelDescription'>$proficiencyLevelName</option>
                    ";
                  }
               };
            ?>
          </select>
      </div>
      <div class="form-group col-md-3">
        <label for="cost">Cost:</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupPrepend">£</span>
            <input type="number" name="cost" step="0.50" class="form-control" aria-describedby="inputGroupPrepend" required <?php echo" value='$previousCost' > ";
            ?>
          </div>
        </div>
    </div>
      <div class="form-group col-md-3">
        <label>Public Or Private:</label>

          <?php
            if($gameTypeID == 4) {
              echo "
              <div class='form-check'>
              <input class='form-check-input' name='public' onchange='publicPrivate(0)' type='checkbox' id='publicGame' checked>
              <label class='form-check-label' for='publicGame'>
                Public Game
              </label>
            </div>
            <div class='form-check'>
              <input class='form-check-input' name='private' onchange='publicPrivate(1)' type='checkbox' id='privateGame'>
              <label class='form-check-label' for='privateGame'>
                Private Game
              </label>
            </div>
            ";
            } else {
              echo"
              <div class='form-check'>
              <input class='form-check-input' name='public' onchange='publicPrivate(0)' type='checkbox' id='publicGame'>
              <label class='form-check-label' for='publicGame'>
                Public Game
              </label>
            </div>
            <div class='form-check'>
              <input class='form-check-input' name='private' onchange='publicPrivate(1)' type='checkbox' id='privateGame' checked>
              <label class='form-check-label' for='privateGame'>
                Private Game
              </label>
            </div>
            ";
            }
           ?>


      </div>

  </div>
<div class="form-row">
  <div class="form-group col-md-3">
    <label for="players">Min Players:</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text" id="minPlayerPrepend">Min</span>
        <input type="number" name="minPlayers" class="form-control" <?php echo"value='$minPlayers' "; ?> aria-describedby="minPlayerPrepend" required>
      </div>
    </div>
  </div>
  <div class="form-group col-md-3">
    <label for="players">Max Players:</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text" id="maxPlayerPrepend">Max</span>
        <input type="number" name="maxPlayers" class="form-control" <?php echo"value='$maxPlayers' "; ?> aria-describedby="maxPlayerPrepend" required>
      </div>
    </div>
  </div>
  <div class="form-group col-md-3">
    <label for="status">Status:</label>
    <select id="status" name="status" required class="form-control">

      <?php
         for ($loops = 0; $loops<$statusNum; $loops++) {
             $statusRow = $statusResult->fetch_assoc();
             $statusName = $statusRow['MatchStatusName'];
             $statusID = $statusRow['MatchStatusID'];
             if($matchStatusID == $statusID) {
               echo"
                <option selected value='$statusID'>$statusName</option>
              ";
            } else {
              echo"
               <option value='$statusID'>$statusName</option>
             ";
            }
         };
      ?>
    </select>
  </div>
  <div class="form-group col-md-3">
    <label for="frequency">Frequency:</label>
    <select id="frequency" name="frequency" required class="form-control">

      <?php
         for ($loops = 0; $loops<$frequencyNum; $loops++) {
             $frequencyRow = $frequencyResult->fetch_assoc();
             $frequencyName = $frequencyRow['RecurringMatchDescription'];
             $frequencyID = $frequencyRow['RecurringMatchID'];
             if($recurringMatchID == $frequencyID) {
               echo"
                <option selected value='$frequencyID'>$frequencyName</option>
              ";
            } else {
              echo"
               <option value='$frequencyID'>$frequencyName</option>
             ";
            }

         };
      ?>
    </select>
  </div>
</div>



</div>
  <div class="form-row">
    <div class="form-group col-md-3 bottomPadding topPadding" id="footerText">
      <button type="submit" id="submitButton" class="btn btn-primary">Edit Game</button>
      </form>
      <button class="btn btn-danger" id='js-deleteButton' data-toggle='modal' data-target='#deleteGameModal'>Delete Game</button>
    </div>
  </div>


<!-- Modal -->
<div class='modal fade' id='deleteGameModal' tabindex='-1' role='dialog' aria-labelledby='deleteGameModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered' role='document'>
      <div class='modal-content'>
        <div class='modal-header mainbk'>
          <h5 class='modal-title mainfont' id='deleteGameModalLabel'>Delete Game?</h5>
          <button type='button' class='close mainfont' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>
        <div class='modal-body'>
          Are you sure you want to delete this game?
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-secondary' data-dismiss='modal'>No Thanks</button>
          <form action='deletegame.php' method='POST'>
            <input type='hidden' <?php echo"value='$matchID'"; ?> name='matchID'>
            <button type='submit' class='btn btn-danger'>Delete Game</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>


<script>

$(function () {

  flatpickr("#startTimePicker", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
    defaultMinute: 0,
    minuteIncrement: 30,
    disableMobile: "true"
  });

  flatpickr("#endTimePicker", {
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
    defaultMinute: 0,
    minuteIncrement: 30,
    disableMobile: "true"
  });

  flatpickr("#datePicker", {
    minDate: "today",
    dateFormat: 'd M Y ',
    disableMobile: "true",
  });
});

function publicPrivate(id) {
  var publicGame = document.getElementById("publicGame");
  var privateGame = document.getElementById("privateGame");

  if(id ===0) {
    publicGame.checked = true;
    privateGame.checked = false;
  } else if (id ===1) {
    publicGame.checked = false;
    privateGame.checked = true;
  }
}

function fetchVenues() {
  var citySelected = document.getElementById( "city" );
  var cityID = citySelected.options[ citySelected.selectedIndex ].value;
  var venueSelectList = document.getElementById("venue");
  var venueData;
  var option = document.createElement("option");

  removeVenueOptions(venueSelectList);

  $.ajax({

         url: 'fetchVenues.php ',
         type: "POST",
         data: ({cityID: cityID}),
         success: function(data){

             venueData = JSON.parse(data);
             for(let loop = 0; loop < venueData.length; loop++){
               var options = document.createElement("option");
               options.value = venueData[loop].id;
               options.text = venueData[loop].name;
               venueSelectList.add(options);
             };

             if(venueSelectList.length > 0){
                 venueSelectList.disabled = false;
             } else {
               option.value = 0;
               option.text = "Select";
               venueSelectList.add(option);
               venueSelectList.disabled = true;
             };
         }
     });
}

function removeVenueOptions(venueSelectList) {
  for(let loop = venueSelectList.length + 1; loop >= 0; loop--){
    venueSelectList.remove(loop);
  };
}

function venueNum() {
  var selectedVenue = document.getElementById( "venue" );
  var venueID = selectedVenue.options[ selectedVenue.selectedIndex].value;
  // console.log(venueID);
}
</script>
</body>
<footer>
  <?php
    $conn->close();
    include('../footer.php');
  ?>
</footer>
</html>
