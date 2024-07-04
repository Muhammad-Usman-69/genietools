<?php
//check if post
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit();
}

header("Content-Type: application/json");

//giving name of file type allowed
$allowed = ["png", "jpg", "jpeg"];

require "../genielibrary/autoload.php";
require "config.php";

$img = $_FILES["image"];

$obj = new AI();

//check ext
$check = $obj->Check($img, $allowed);

$apiKey = REMOVEBACKGROUNDAPI;

$result = $obj->RemoveBackground($apiKey);

$obj->dbConnect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

$obj->saveToDb($result["id"], "Remove Background", "image", "none", $result["url"]);

echo json_encode($result);
