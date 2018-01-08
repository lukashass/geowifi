<?php

$coords = $_POST["coords"];
echo $coords;

file_put_contents("lat.txt", $coords);

//file_put_contents(lat.txt, $_REQUEST["lng"]);

?>