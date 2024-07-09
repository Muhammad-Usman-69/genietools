<?php

//check if post
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit();
}

//check if empty prompt
if (!isset($_POST["id"]) || $_POST["id"] == "") {
    exit();
}

$id = $_POST["id"];

require "config.php";

//starting db connection
$conn = mysqli_connect(DATABASE_HOSTNAME, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

//check if item exists
$sql = "SELECT * FROM `prompts` WHERE `id` = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$num = mysqli_num_rows($result);
if ($num == 0) {
    echo "No Such File Exists";
    exit();
}

$row = mysqli_fetch_assoc($result);

//taking image
$id = $row["id"];
$url = $row["url/result"];
$type = $row["type"];

$arr = explode("/", $url);

$fname = end($arr);

$file = file_get_contents($url);

//downloadign image
header("Content-Type: application/$type");
header("Content-Disposition: attachment; filename=$fname");

echo $file;