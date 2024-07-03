<?php

require "../config.php";
require "../../genielibrary/autoload.php";

header("Content-Type: application/json");

$obj = new Genie();

//connecting
$obj->dbConnect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

//getting names
$names = $obj->getToolNames();

//printing
echo json_encode($names);