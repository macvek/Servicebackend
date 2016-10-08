<?php
require 'security.php';

if (!@$_POST['operation']) { return; }

function turnCamOn() {
    ob_start();
    system("./turnCamOn.sh");
    ob_clean();
}

function turnCamOff() {
    ob_start();
    system("./turnCamOff.sh");
    system("./archiveSnapshots.sh");
    system("./archiveSnapshotsGC.sh");
    ob_clean();
}

switch($_POST['operation']) {
    case "on":
        turnCamOn(); echo "on"; break;
    case "off":
        turnCamOff(); echo "off"; break;
    default:
        echo "err"; break;
}

