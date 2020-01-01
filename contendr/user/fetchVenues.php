<?php

  include("../conn.php");

  $cityID = ($_POST['cityID']);

  $venues = "SELECT Sps_Venue.VenueID, Sps_Venue.VenueName FROM Sps_Venue INNER JOIN Sps_Address
             ON Sps_Venue.AddressID = Sps_Address.AddressID
             INNER JOIN Sps_CityOrTown
             ON Sps_Address.CityOrTownID = Sps_CityOrTown.CityOrTownID
             WHERE Sps_CityOrTown.CityOrTownID = $cityID";

  $venuesResult = $conn->query($venues);

  $venueArray = [];
  if(!$venuesResult){
    echo $conn->error;
  }else{

    while ($row = $venuesResult->fetch_assoc()) {
        $venueName = $row['VenueName'];
        $venueID = $row['VenueID'];
        array_push($venueArray, array("id"=>$venueID, "name"=> $venueName));

    }
  }
  echo json_encode($venueArray);

$conn->close();
?>
