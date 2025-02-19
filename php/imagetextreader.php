<?php

//check if post
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit();
}

header("Content-Type: application/json");

//giving name of file type allowed
$allowed = ["png", "jpeg", "jpg"];

require "../genielibrary/autoload.php";
require "config.php";

$img = $_FILES["image"];

$obj = new AI();

$check = $obj->Check($img, $allowed);

$result = $obj->ImgTxtReaderEdenAI(EDENAIAPI);

$obj->dbConnect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

$obj->saveToDb($result["id"], "Image Text Reader", "text", "none", $result["url"]);

echo json_encode($result);
