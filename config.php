<?php

# DEBUG SETTINGS
ini_set("display_errors", 1);
error_reporting(E_ALL ^ E_NOTICE);

#############################################
# SERVER & DATABASE - Needed to configure
#############################################

# User should get access to the website by feeding this into the browser
$GLOBALS["root_addr"] = "http://www.example.com/GLU/index.php";

# Database settings
$GLOBALS["db_hostname"] = ""; # should be reachable by the web server
$GLOBALS["db_database"] = "";
$GLOBALS["db_username"] = "";
$GLOBALS["db_password"] = ""; # keep this secret!
$GLOBALS["db_table"] = "";

$GLOBALS["recaptcha_site_key"] = "";
$GLOBALS["recaptcha_secret_key"] = ""; # keep this secret!

############################################################
# SITE CONFIGURATION - Needed by site developer
############################################################
$GLOBALS["main_page"] = "main.php";
$GLOBALS["accepted_page"] = "accepted.php";
$GLOBALS["download_page"] = "download.php";
$GLOBALS["error_page"] = "error.php";
$GLOBALS["maintenance_page"] = "maintenance.php";

$GLOBALS["package_dir"] = "packages/";

$GLOBALS["secs_before_download"] = 3;

# Prevents access to this page
require_once("utility.php");
require_once("recaptchalib.php");

?>
