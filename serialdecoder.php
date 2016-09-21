<?php

$prefixLength = strlen("09/20/16 +20:21:34 0 ");

function splitValue($what) {
    global $prefixLength;
    return trim(substr($what, $prefixLength));
}

$skip = 0;
$pos = "NONE";

for(;;) {
    $line = fgets(STDIN);
    
    if (FALSE === $line) { 
        return;
    }

    if ($skip > 0) {
        $skip--;
        continue;
    }

    if (strpos($line, "WYNIK") > -1) {
        $skip = 0;
        $pos = "TEMP";
    }
    else if ($pos === "TEMP") {
        echo splitValue($line).";";
        $skip = 1;
        $pos = "HUM";
    }
    else if ($pos === "HUM") {
        echo splitValue($line).";\n";
        $skip = 3;
        $pos = "NONE";
    }
    
}