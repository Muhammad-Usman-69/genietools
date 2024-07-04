<?php
//check if post
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit();
}

header("Content-Type: application/json");

//giving name of file type allowed
$allowed = ["webp"];

require "../genielibrary/autoload.php";
require "config.php";

$img = $_FILES["image"];

//changing image now
$obj = new Image();

//check ext
$check = $obj->Check($img, $allowed);

$result = $obj->WebpToPng();

$obj->dbConnect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

$obj->saveToDb($result["id"], "WEBP To PNG", "image", "none", $result["url"]);

echo json_encode($result);
