<?php
require __DIR__ . "/config.php";
require "../genielibrary/autoload.php";

header("Content-Type: application/json");

$obj = new Genie();
$obj->dbConnect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$names = $obj->getToolNames();
echo json_encode($names);