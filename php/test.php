<?php
require "../genielibrary/autoload.php";
require "config.php";

$text = "This is a pen. I lvoe it, I carry it every where. I am in love with it";

header("Content-Type: application/json");

$obj = new Text();

$result = $obj->WordCounter($text);

echo json_encode($result);