<?php require_once("utility.php"); ?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>GLU - GPU LU Solver</title>
        <link rel='stylesheet' type='text/css' href='styles.css' />
    </head>
    <body>
        <h1>Thank you for requesting this library</h1>
        <p>An email has been automatically sent to your provided mail box.</p>
        <p>Have you not received the email in 5 minutes, please apply again, or 
contact us by mail <a href="mailto:stan@ece.ucr.edu">Dr. Sheldon Tan</a> or <a 
href="mailto:hzhao@ece.ucr.edu">Hengyang Zhao</a>.</p>
<?php
/* XSS attack point. Make sure the info validations work well in utility.php */
/* Send offer to user */
exec("sed -e 's/__URL__/" . str_replace("/", "\/", $GLOBALS["root_addr"]) . "?id=" . $GLOBALS["app_info"][":ID"] . "/g' " .
    "-e 's/__FIRST__/" . $GLOBALS["app_info"][":FirstName"] . "/g' " .
    "-e 's/__LAST__/" . $GLOBALS["app_info"][":LastName"] . "/g' " .
    "offer.mail | sendmail " . $GLOBALS["app_info"][":Email"]);

/* Notify administrator */
exec("sed -e 's/__NAME__/" . $GLOBALS["app_info"][":FirstName"] . "/g' " .
    "-e 's/__PACKAGE__/" . $GLOBALS["app_info"][":PackageName"] . "/g' " .
    "-e 's/__MAINTENANCE__/" . str_replace("/", "\/", $GLOBALS["root_addr"]) . "?users" . "/g' " .
    "report.mail | sendmail " . $GLOBALS["reports_to"]);
?>
    </body>
</html>
