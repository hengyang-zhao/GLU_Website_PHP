<?php

// Mark this valid entry
$GLOBALS["initialized"] = true;

// The php functions library, which also validates the entry
require_once("utility.php");

// Handle application for downloading forms
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $app = $_POST;
    $app["peer_addr"] = $_SERVER["REMOTE_ADDR"];
    $error_msg = validate_application($app);
    if ($error_msg == "passed") {
        $id = add_user($app);
        $GLOBALS["download_id"] = $id;
        require($GLOBALS["accepted_page"]);
    } else {
        display_error($error_msg);
    }
    exit;
}

// Handle download request and offer download if valid
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    offer_download($_GET["id"]);
    exit;
}

// Handle internal maintainance pages
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["users"])) {
    require($GLOBALS["maintenance_page"]);
    exit;
}

// Provide main page
require($GLOBALS["main_page"]);

?>

