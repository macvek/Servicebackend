<?php
require 'security.php';

ob_start();
system("uptime");
$val = ob_get_clean();

echo json_encode(["uptime"=>$val]);

