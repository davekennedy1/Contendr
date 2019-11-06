
function myMap() {
  var longitude = document.getElementById("coords").getAttribute("data-long");
  var latitude = document.getElementById("coords").getAttribute("data-lat");
  // The location of the venue
  var venue = {lat: (longitude - 0), lng: (latitude - 0)};
  // The map, centered at the venue
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 16, center: venue});
  // The marker, positioned at the venue
  var marker = new google.maps.Marker({position: venue, map: map});
}
