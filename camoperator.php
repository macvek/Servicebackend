<?php
require 'security.php';

if (!@$_POST['operation']) { return; }

function turnCamOn() {
  touch("daemoncmd/on");
}

function turnCamOff() {
  touch("daemoncmd/off");
}

switch($_POST['operation']) {
    case "on":
        turnCamOn(); echo "on"; break;
    case "off":
        turnCamOff(); echo "off"; break;
    default:
        echo "err"; break;
}

