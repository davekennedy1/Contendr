<?php
session_start();
if (!isset($_SESSION['13072064_contendrUnom'])) {
    header('Location: ../index.php');
}
$sessionUser = $_SESSION['13072064_contendrUnom'];
$uid = $_SESSION['13072064_contenderUID'];
include("../conn.php");

$sports = "SELECT Sps_Sport.SportName FROM Sps_Sport";
$sportsResult = $conn->query($sports);
$sportsNum = $sportsResult->num_rows;

$status = "SELECT Sps_MatchStatus.MatchStatusName FROM Sps_MatchStatus";
$statusResult = $conn->query($status);
$statusNum = $statusResult->num_rows;

$cities = "SELECT Sps_CityOrTown.CityOrTownName, Sps_CityOrTown.CityOrTownID FROM Sps_CityOrTown";
$citiesResult = $conn->query($cities);
$citiesNum = $citiesResult->num_rows;

$proficiency = "SELECT * FROM Sps_ProficiencyLevel";
$proficiencyResult = $conn->query($proficiency);
$proficiencyNum = $proficiencyResult->num_rows;

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
    <!-- <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/default.css"> -->

    <title>Contendr</title>
  </head>

  <body>
    <?php
    include('usernav.php');
    ?>
      <div class='container'>
        <div>
          <p>Have to lay this out properly and add more stuff</p>
          <!-- Sport, Venue, Date, Name -->

          <form>

            <div class="form-row">

              <div class="form-group col-sm-6">
                <label for="inputAddress2">Game Name:</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="<?php echo" $sessionUser 's game";?>">
          </div>

          <div class="form-group col-sm-2">
            <label for="datePicker">Date:</label>
            <input type="text" class="form-control " id="datePicker" />
          </div>

          <div class="form-group col-sm-2">
            <label for="startTimePicker">Start Time:</label>
            <input type="text" class="form-control " id="startTimePicker" />
          </div>

          <div class="form-group col-sm-2">
            <label for="endTimePicker">End Time:</label>
            <input type="text" class="form-control " id="endTimePicker" />
          </div>

      </div>

      <div class="form-row">
        <div class="form-group col-md-4">
          <label for="sport">Sport:</label>
          <select id="sport" class="form-control">
            <option disabled='disabled ' selected>Select</option>
            <?php
               for ($loop = 0; $loop<$sportsNum; $loop++) {
                   $sportsRow = $sportsResult->fetch_assoc();
                   $sportName = $sportsRow['SportName'];
                   echo"
                    <option value=' '>$sportName</option>
                  ";
               };
            ?>
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="city">City:</label>
          <select id="city" onchange="fetchVenues()" class="form-control">
            <option disabled='disabled ' selected>Select</option>
            <?php
               for ($loop = 0; $loop<$citiesNum; $loop++) {
                   $citiesRow = $citiesResult->fetch_assoc();
                   $cityName = $citiesRow['CityOrTownName'];
                   $cityID = $citiesRow['CityOrTownID'];
                   echo"
                    <option value='$cityID'>$cityName</option>
                  ";
               };
            ?>
          </select>
        </div>
        <div class="form-group col-md-4">
          <label for="venue">Venue:</label>
          <select id="venue" onchange="venueNum()" disabled= true class="form-control">
            <option disabled='disabled ' selected>Select</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-3">
          <label for="indoorOutdoor">Indoor/Outdoor:</label>
            <select id="indoorOutdoor" class="form-control">
            <option disabled='disabled ' selected>Select</option>
            <option>Indoor</option>
            <option>Outdoor</option>
            </select>
        </div>
        <div class="form-group col-md-3">
          <label for="difficulty">Difficulty:</label>
            <select id="difficulty" class="form-control">
              <option disabled='disabled ' selected>Select</option>
              <?php
                 for ($loop = 0; $loop<$proficiencyNum; $loop++) {
                     $proficiencyRow = $proficiencyResult->fetch_assoc();
                     $proficiencyID = $proficiencyRow['ProficiencyLevelID'];
                     $proficiencyLevelName = $proficiencyRow['ProficiencyLevelName'];
                     $proficiencyLevelDescription = $proficiencyRow['ProficiencyLevelDescription'];
                     echo"
                      <option value='$proficiencyID ' data-toggle='tooltip' data-placement='right' title='$proficiencyLevelDescription'>$proficiencyLevelName</option>
                    ";
                 };
              ?>
            </select>
        </div>
        <div class="form-group col-md-3">
          <label for="cost">Cost:</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupPrepend">£</span>
              <input type="number" step="0.50" class="form-control" value="3.00" aria-describedby="inputGroupPrepend" required>
            </div>
          </div>
      </div>
        <div class="form-group col-md-3">
          <label>Public Or Private:</label>
          <div class="form-check">

            <input class="form-check-input" onchange="publicPrivate(0)" type="checkbox" value="" id="publicGame" checked>
            <label class="form-check-label" for="publicGame">
              Public Game
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" onchange="publicPrivate(1)" type="checkbox" value="" id="privateGame">
            <label class="form-check-label" for="privateGame">
              Private Game
            </label>
          </div>
        </div>

    </div>
<div class="form-row">
    <div class="form-group col-md-3">
      <label for="players">Min Players:</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="minPlayerPrepend">Min</span>
          <input type="number" class="form-control" value="10" aria-describedby="minPlayerPrepend" required>
        </div>
      </div>
    </div>
    <div class="form-group col-md-3">
      <label for="players">Max Players:</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text" id="maxPlayerPrepend">Max</span>
          <input type="number" class="form-control" value="12" aria-describedby="maxPlayerPrepend" required>
        </div>
      </div>
    </div>
    <div class="form-group col-md-3">
      <label for="status">Status:</label>
      <select id="status" class="form-control">
        <option disabled='disabled ' selected>Select</option>
        <?php
           for ($loops = 0; $loops<$statusNum; $loops++) {
               $statusRow = $statusResult->fetch_assoc();
               $statusName = $statusRow['MatchStatusName'];
               echo"
                <option value=' '>$statusName</option>
              ";
           };
        ?>
      </select>
    </div>
  </div>



</div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <button type="submit" class="btn btn-primary">Sign in</button>
    </div>
    </div>
</form>
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
      disableMobile: "true"
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

               if(venueSelectList.length > 1){
                   venueSelectList.disabled = false;
                   venueSelectList[0].selected = true;
               } else {
                 option.value = 0;
                 option.text = "Select";
                 venueSelectList.add(option);
                 venueSelectList.disabled = true;
               };
           }
       });
  }

  function removeVenueOptions(venueSelectList) {var option = document.createElement("option");
    for(let loop = venueSelectList.length + 1; loop > 0; loop--){
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
    include('../footer.php ');
  ?>
</footer>
</html>
