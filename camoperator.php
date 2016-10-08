<?php
require 'security.php';

if (!@$_POST['operation']) { return; }

function turnCamOn() {
    system("./turnCamOn.sh");
}

function turnCamOff() {
    system("./turnCamOff.sh");
}

switch($_POST['operation']) {
    case "on":
        turnCamOn(); echo "on"; break;
    case "off":
        turnCamOff(); echo "off"; break;
    default:
        echo "err"; break;
}

