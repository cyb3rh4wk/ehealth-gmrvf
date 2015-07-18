<?php
	$rawData = $_POST['imgBase64'];
	$pid = $_POST['pid'];

	$filteredData = explode(',', $rawData);
	$unencoded = base64_decode($filteredData[1]);

	//Create the image 
	$fp = fopen('./uploads/' . $pid . '.jpg', 'w');
	fwrite($fp, $unencoded);
	fclose($fp);
?>