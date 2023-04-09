<?php 
header("Content-Type: application/json");
$responsedata = file_get_contents('php//input');
$myfile = fopen("mpesa.txt", "w");
fwrite($myfile, $responsedata);
fclose($myfile);
 ?>