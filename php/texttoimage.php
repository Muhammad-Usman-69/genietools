<?php

//check if post
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit();
}

//check if didn't get
if (!isset($_POST["prompt"]) || !isset($_POST["aspect_ratio"])) {
    echo json_encode(["error" => "Didn't Get"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
}

//check if empty
if ($_POST["prompt"] == "" || $_POST["aspect_ratio"] == "") {
    echo json_encode(["error" => "Empty Input"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
}

require "../genielibrary/autoload.php";
require "config.php";

$prompt = $_POST["prompt"];
$aspect_ratio = $_POST["aspect_ratio"];

$apiKey = TEXTTOIMAGEAPI;

//new obj
$obj = new AI();

$result = $obj->TextToImage($prompt, $aspect_ratio, $apiKey);

$obj->dbConnect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$obj->saveToDb($result["id"], "Text To Image", "image", $prompt, $result["url"]);

echo json_encode($result);