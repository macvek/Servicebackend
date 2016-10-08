<?php
require 'security.php';

if (!is_dir("snapshots")) {
    die("snapshots not supported");
}

$num = "empty";

$dir = opendir("snapshots");
while (($file = readdir($dir)) !== false) {
    if (strpos($file,"snap") !== 0) {
        continue;
    }

    $numPart = substr($file,4,8);
    $eachNum = intval($numPart);
    if ("empty" === $num || $eachNum > $num) {
        $num = $eachNum;
        $numName = $numPart;
    }
}
closedir($dir);
$fullname = "snapshots/snap$numName.jpeg";

if ("empty" === $num || !file_exists($fullname)) {
    die("no snapshots found");
}

header('Content-Type: image/jpeg');
header("Cache-Control: no-cache, must-revalidate");
readfile($fullname);
