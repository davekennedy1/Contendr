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

$cities = "SELECT Sps_CityOrTown.CityOrTownName, Sps_CityOrTown.CityOrTownID FROM Sps_CityOrTown";
$citiesResult = $conn->query($cities);
$citiesNum = $citiesResult->num_rows;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- bootstrap cdn -->
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
    <div>
      <p>Have to lay this out properly and add more stuff</p>
      <!-- Sport, Venue, Date, Name -->

    <form>
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="sport">Sport:</label>
      <select id="sport" class="form-control">
        <option disabled='disabled' selected>Select</option>
        <?php
           for($loop = 0; $loop<$sportsNum; $loop++ ){
              $sportsRow = $sportsResult->fetch_assoc();
              $sportName = $sportsRow['SportName'];
              echo"
                <option value=''>$sportName</option>
              ";
            };
        ?>
      </select>
    </div>
    <div class="form-group col-md-4">
      <label for="city">City:</label>
      <select id="city" onchange="fetchVenues()" class="form-control">
        <option disabled='disabled' selected>Select</option>
        <?php
           for($loop = 0; $loop<$citiesNum; $loop++ ){
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
        <option disabled='disabled' selected>Select</option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Date:</label>
    <input type="DateTime" class="form-control" id="inputAddress" placeholder="Date time">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Game Name:</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="<?php echo"$sessionUser's game";?>">
  </div>
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>
</div>
</div>

<script>
  function fetchVenues() {
    var citySelected = document.getElementById( "city" );
    var cityID = citySelected.options[ citySelected.selectedIndex ].value;
    var venueSelectList = document.getElementById("venue");
    var venueData;
    var option = document.createElement("option");

    removeVenueOptions(venueSelectList);

    $.ajax({

           url: 'fetchVenues.php',
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
    include('../footer.php');
  ?>
</footer>
</html>
