<?php
require 'security.php';

ob_start();
system("./readhumiandtemp.sh");
$val = ob_get_clean();

$lines = explode("\n",$val);
$startIndex = -1;
for ($i=0;$i<count($lines);$i++) {
    if (strpos($lines[$i], "WYNIK") !== FALSE) {
        $startIndex = $i;
        break;
    }
}

if ($startIndex === -1) {
    $data = [
        "error" => "parse error"
    ];    
}
else {
    $datePart = explode(" ", $lines[$startIndex]);
    $date = $datePart[0].' '.$datePart[1];
    $checksum = FALSE !== strpos($lines[$startIndex+6],"OK");
    $temperature = explode(" ", $lines[$startIndex+3])[3];
    $humidity = explode(" ", $lines[$startIndex+1])[3]; 
    $data = [
        "date" => $date,
        "checksum" => $checksum,
        "temperature" => $temperature,
        "humidity" => $humidity
    ];
}



echo json_encode($data);