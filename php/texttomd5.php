<?php

//check if post
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit();
}

//check if didn't get
if (!isset($_POST["text"])) {
    echo json_encode(["error" => "Didn't Get"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
}

//check if empty
if ($_POST["text"] == "") {
    echo json_encode(["error" => "Empty Input"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
}

require "../genielibrary/autoload.php";
require "config.php";

$text = $_POST["text"];

$obj = new Text();

$result = $obj->TextToMD5($text);

$obj->dbConnect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$obj->saveToDb($result["id"], "Text To MD5", "text", $text, $result["url"]);

echo json_encode($result);