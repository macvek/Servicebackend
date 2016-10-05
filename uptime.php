<?php
function secured() {
    ob_start();
    system("uptime");
    $val = ob_get_clean();

    echo json_encode(["uptime"=>$val]);
}

require 'security.php';
