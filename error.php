<?php require_once("utility.php"); ?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>GLU - Error Page</title>
        <link rel='stylesheet' type='text/css' href='styles.css' />
    </head>
    <body>
        <h1 class="err">We are sorry. You got an error :-(</h1>
        <p class="err">The GLU website says:</p>
        <p class="err"><?=$GLOBALS["error_msg"]?></p>
    </body>
</html>

