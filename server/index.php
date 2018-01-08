<?php

require('config.php');

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

$coords = file_get_contents("coords.txt");
$error = file_get_contents("error.txt");

$lat = get_string_between($coords, "lat\": ", ",");
$lng = get_string_between($coords, "lng\": ", "\n");
$acc = get_string_between($coords, "accuracy\": ", "\n");
$error = get_string_between($error, "error\": {", "}\n}");

echo date("d.m.Y, H:i:s", filemtime("coords.txt")); //TODO time of wifi scan
echo ":  ";
echo $lat;
echo "<>";
echo $lng;
echo "<>";
echo $acc."m";
echo "<br>";
echo date("d.m.Y, H:i:s", filemtime("error.txt")); //TODO time of wifi scan
echo $error;

?>

<!DOCTYPE html>
<html>
  <head>
    <style>
       #map {
        height: 400px;
        width: 100%;
       }
    </style>
  </head>
  <body>
    <h3>Location on a Map</h3>
    <div id="map"></div>
    <script>
      function initMap() {
        var uluru = {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>};
        var dot = {
            path: google.maps.SymbolPath.CIRCLE,
            fillColor: 'blue',
            fillOpacity: 1,
            scale: 10,
            strokeColor: 'white',
            strokeWeight: 2
        };
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 11,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map,
          icon: dot
        });
        // Add circle overlay and bind to marker
        var circle = new google.maps.Circle({
          map: map,
          radius: <?php echo $acc; ?>,
          fillColor: 'blue',
          fillOpacity: '.1',
          strokeColor: 'blue',
          strokeWeight: '1'
        });
        circle.bindTo('center', marker, 'position');
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_key; ?>&callback=initMap">
    </script>
  </body>
</html>
