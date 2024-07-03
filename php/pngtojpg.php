<?php
//check if post
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit();
}

header("Content-Type: application/json");

//giving name of file type allowed
$allowed = ["png"];

require "../genielibrary/autoload.php";
require "config.php";

$img = $_FILES["image"];

//changing image now
$obj = new ImgToImg();

//check ext
$check = $obj->Check($img, $allowed);

$result = $obj->PngToJpg();

$obj->dbConnect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

$obj->saveToDb($result["id"], "Png To Jpg", "image", "none", $result["url"]);

echo json_encode($result);
