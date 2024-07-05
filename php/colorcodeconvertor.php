<?php

//check if post
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit();
}

//check if didn't get
if (!isset($_POST["color"]) || !isset($_POST["convert"])) {
    echo json_encode(["error" => "Didn't Get"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
}

//check if empty
if ($_POST["color"] == "" || $_POST["convert"] == "") {
    echo json_encode(["error" => "Empty Input"], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    exit();
}

require "../genielibrary/autoload.php";
require "config.php";

$color = $_POST["color"];
$convert = $_POST["convert"];

$obj = new Text();

if (str_contains($convert, "hex")) {
    //taking color
    $red = $color[0];
    $green = $color[1];
    $blue = $color[2];
    $alpha = $color[3];

    //if hex
    $result = $obj->RgbaToHex($red, $green, $blue, $alpha);

    //creating prompt
    $prompt = "rgba($red $green $blue $alpha)";

} else if (str_contains($convert, "rgba")) {
    //taking hex
    $hex = $color[0];

    //if rgb
    $result = $obj->HexToRgba($hex);

    //creating prompt
    $prompt = "#$hex";

} else {
    exit();
}

$obj->dbConnect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$obj->saveToDb($result["id"], "Color Code Convertor", "text", $prompt, $result["text"]);

echo json_encode($result);