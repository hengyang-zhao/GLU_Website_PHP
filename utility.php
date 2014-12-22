<?php

require_once("config.php");

function add_user($app) {
    $db = new PDO(
        "mysql:host=" . $GLOBALS["db_hostname"] . ";dbname=" . $GLOBALS["db_database"] . ";charset=utf8",
        $GLOBALS["db_username"], $GLOBALS["db_password"]);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = bin2hex(openssl_random_pseudo_bytes(20));

    $stmt = $db->prepare("INSERT INTO " . $GLOBALS["db_table"] . " " .
        "(ID, FirstName, LastName, Email, Phone, Organization, ResearchArea, PackageName, WhenApplied, WhyApplied)" .
        " VALUES " .
        "(:ID, :FirstName, :LastName, :Email, :Phone, :Organization, :ResearchArea, :PackageName, NOW(), :WhyApplied)"
    );
    $stmt->execute(array(
        ":ID" => $id,
        ":FirstName" => trim($app["firstName"]),
        ":LastName" => trim($app["lastName"]),
        ":Email" => trim($app["email"]),
        ":Phone" => trim($app["phone"]),
        ":Organization" => trim($app["organization"]),
        ":ResearchArea" => trim($app["researchArea"]),
        ":PackageName" => trim($app["package"]),
        ":WhyApplied" => trim($app["reason"])
    ));

    return $id;
}

function print_downloaders() {
    echo '<table class="reg"><tr>' .
        "<th>Name</th>" .
        "<th>Email</th>" .
        "<th>Phone</th>" .
        "<th>Organization</th>" .
        "<th>Research Area</th>" .
        "<th>Package Name</th>" .
        "<th>When Applied</th>" .
        "<th>Why Applied</th>" .
        "</tr>";

    $db = new PDO(
        "mysql:host=" . $GLOBALS["db_hostname"] . ";dbname=" . $GLOBALS["db_database"] . ";charset=utf8",
        $GLOBALS["db_username"], $GLOBALS["db_password"]);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->query('SELECT ID, FirstName, LastName, Email, Phone, Organization, ResearchArea, PackageName, WhenApplied, WhyApplied FROM ' . $GLOBALS["db_table"]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>" .
            '<td><span class="uinfo">' . $row["FirstName"] . " " . $row["LastName"]. "</span></td>" .
            '<td><span class="uinfo">' . $row["Email"] . "</span></td>" .
            '<td><span class="uinfo">' . $row["Phone"] . "</span></td>" .
            '<td><span class="uinfo">' . $row["Organization"] . "</span></td>" .
            '<td><span class="uinfo">' . $row["ResearchArea"] . "</span></td>" .
            '<td><span class="uinfo">' . $row["PackageName"] . "</span></td>" .
            '<td><span class="uinfo">' . $row["WhenApplied"] . "</span></td>" .
            '<td><span class="uinfo">' . $row["WhyApplied"] . "</span></td>" .
            "</tr>";
    }
    echo "</table>";
}

function validate_application($app) {
    if (!filter_var(trim($app["firstName"]), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[A-Za-z]+/"))))
        return "Invalid input: First name";
    if (!filter_var(trim($app["lastName"]), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[A-Za-z]+/"))))
        return "Invalid input: Last name";
    if (!filter_var(trim($app["email"]), FILTER_VALIDATE_EMAIL))
        return "Invalid input: Email";
    if ($app["phone"] && !filter_var(trim($app["phone"]), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/[\(\)0-9\-]+/"))))
        return "Invalid input: Phone number";
    if (!filter_var(trim($app["organization"]), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/.+/"))))
        return "Invalid input: Organization";
    if (!filter_var(trim($app["researchArea"]), FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/.+/"))))
        return "Invalid input: Research Area";
    if (!in_array($app["package"], enumerate_packages($GLOBALS["package_dir"])))
        return "Invalid input: Package name (This should not happen in your regular access. If this error message appears, please contact us (hzhao009@ucr.edu). Thank you!";

    $resp = recaptcha_check_answer($GLOBALS["recaptcha_secret_key"],
                                   $app["peer_addr"],
                                   $app["recaptcha_challenge_field"],
                                   $app["recaptcha_response_field"]);

    if (!$resp->is_valid) {
        return "Invalid reCaptcha code: " . $resp->error;
    }

    return "passed";
}

function enumerate_packages($dir) {
    $files = scandir($dir);
    $results = array();
    foreach ($files as $f) {
        if (is_file($GLOBALS["package_dir"] . "/" . $f)) {
            array_push($results, $f);
        }
    }
    return $results;
}

function display_error($msg) {
    $GLOBALS["error_msg"] = $msg;
    require($GLOBALS["error_page"]);
}

function offer_download($id) {
    $db = new PDO(
        "mysql:host=" . $GLOBALS["db_hostname"] . ";dbname=" . $GLOBALS["db_database"] . ";charset=utf8",
        $GLOBALS["db_username"], $GLOBALS["db_password"]);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->prepare('SELECT PackageName FROM ' . $GLOBALS["db_table"] . ' WHERE (whenApplied + 604800 > NOW()) AND (id = :ID)');
    $stmt->execute(array(":ID" => $id,));
    if ($stmt->rowCount() > 0) {
        $package = $stmt->fetch(PDO::FETCH_ASSOC)["PackageName"];
        push_file($GLOBALS["package_dir"] . "/" . $package);
    }
}

function push_file($fname) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($fname));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fname));
    readfile($fname);
    exit;
}

function forbid_direct_access() {
    if ($GLOBALS["initialized"]) return;
    display_error("Access denied for this page.");
    exit;
}

forbid_direct_access();
?>
