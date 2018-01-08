<?php

if(isset($_POST["coords"])){
	$coords = $_POST["coords"];
	if(strpos($coords, "\"error\": {")==false){
		file_put_contents("coords.txt", $coords);
	} else {
		file_put_contents("error.txt", $coords);
	}
}

if(isset($_POST["wifi"])){
echo "wifi:" . $_POST["wifi"];
}



/*$apistart = "";
$apicontent = "";
$apiend = "";

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

if(!empty($_REQUEST["scan"])){
	echo "worked\n";
	$cells = explode("Cell", $_REQUEST["scan"]);
	foreach ($cells as $cell) {
		$address = get_string_between($cell, "Address: ", "\n");
		$signal = get_string_between($cell, "level=", " dBm");
		if(empty($address) || empty($signal)){
			continue;
		}
		echo $address;
		echo " ## ";
		echo $signal;
		}
} else{
	echo "failed\n";
}

//echo $_REQUEST["scan"];*/
?>