<?php

if (!isset($_POST["text"]) || !isset($_POST["type"])) {
    echo json_encode(["error" => "Didn't Get"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
}

//check if empty
if ($_POST["text"] == "" || $_POST["type"] == "") {
    echo json_encode(["error" => "Empty Input"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
}

header("Content-Type: application/json");

require "../genielibrary/autoload.php";
require "config.php";

$obj = new Text();

$text = $_POST["text"];
$type = $_POST["type"];

$result = $obj->CaseConvert($text, $type);

$obj->dbConnect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$obj->saveToDb($result["id"], "Case Convertor", "text", $text, $result["text"]);

echo json_encode($result);