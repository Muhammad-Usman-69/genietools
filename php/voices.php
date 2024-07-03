<?php

require "../genielibrary/autoload.php";
require "./config.php";

$obj = new AI();

$voices = $obj->getVoices(TEXTTOVOICEAPI);

//printing
echo $voices;