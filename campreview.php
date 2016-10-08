<?php
require 'security.php';

header('Content-Type: image/jpeg');
header("Cache-Control: no-cache, must-revalidate");
readfile("snapshot.jpeg");
