<?php
    $file = "sess" . $_GET["wlux_session"] . "cond" . $_GET["wlux_condition"] . ".txt";
?>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
        p, h2 { text-align: center; margin-top: 1em; }
        </style>
    </head>
    <body>
        <h2>WebLabUX Survey</h2>
        <p>Thank you for taking part in our survey!!</p>
        <p><a href="./study_results/<?=$file?>" target="_blank">View the data collected from this study in a new window</a></p>
        <p><a href="start.php">Start another study</a></p>
    </body>
</html>
