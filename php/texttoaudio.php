<?php

//check if post
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit();
}

//check if didn't get
if (!isset($_POST["prompt"]) || !isset($_POST["voice"])) {
    echo json_encode(["error" => "Didn't Get"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
}

//checkif empty
if ($_POST["prompt"] == "" || $_POST["voice"] == "") {
    echo json_encode(["error" => "Empty Input"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
}

require "../genielibrary/autoload.php";
require "config.php";

$prompt = $_POST["prompt"];
$voice = $_POST["voice"];

$apiKey = TEXTTOVOICEAPI;

//new obj
$obj = new AI();


$result = $obj->TextToAudio($prompt, $voice, $apiKey);

$obj->dbConnect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$obj->saveToDb($result["id"], "Text To Audio", "image", $prompt, $result["url"]);

echo json_encode($result);