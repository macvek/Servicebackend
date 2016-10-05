<?php
require 'passphrase.php';

session_start();

if (@$_SESSION['authorized'] || passphrase() === @$_POST['phrase']) {
    $_SESSION['authorized'] = 1;
    header("Location: index.php");
    die();
}
?>
<!doctype html>
<html>
<body>
<style>
body {
    background-color:#222;
}

div {
    width:100%;
    margin:0 auto;
    margin-top:25px;
    text-align:center;
}

input {
    background-color:#222;
    margin:15px;
    font-size:2em;
    color:white;
    border:1px solid #58c;
    border-radius: 15px;
    padding:10px;
    color:#a9c;
}
</style>
<div>
<form method="POST">
    <input type="password" name="phrase"></input><br/>
    <input type="submit" value="proceed"></input>
</form>
</div>
</body>
</html>