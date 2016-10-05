<?php
function secured() {
    header('Content-Type: image/png');
    header("Cache-Control: no-cache, must-revalidate");
    readfile("sample.png");
}

require 'security.php';
