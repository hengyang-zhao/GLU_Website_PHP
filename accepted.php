<?php require_once("utility.php"); ?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>GLU - GPU LU Solver</title>
        <link rel='stylesheet' type='text/css' href='styles.css' />
    </head>
    <body>
        <h1>Thank you for requesting this library</h1>
        <p id="timer">Your download will begin in <?=$GLOBALS["secs_before_download"]?> seconds...</p>
        <p>If your browser did not start download automatically, click <a href="index.php?id=<?=$GLOBALS["download_id"]?>">here</a> to start manually. 
            You also can save the following link for future downloads:
        <pre class="code">
<?=$GLOBALS["root_addr"]?>?id=<?=$GLOBALS["download_id"]?>
        </pre>
        <p>This link will be available in one week.</p>
        <p><a href="<?=$GLOBALS["root_addr"]?>">Go back</a></p>
    </body>
    <script>
        var timeout = <?=$GLOBALS["secs_before_download"]?>;
        function updateTick(t) {
            document.getElementById("timer").innerHTML = "Your download will begin in " + t + " seconds...";
            if (t > 0) nextTick(t);
            if (t == 0) startDownload();
        }
        function nextTick(t) {
            setTimeout(function(){updateTick(t - 1)}, 1000);
        }
        function startDownload() {
            window.location.href = "index.php?id=<?=$GLOBALS["download_id"]?>";
        }
        updateTick(timeout);
    </script>
</html>
