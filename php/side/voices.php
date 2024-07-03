<?php

require "../config.php";
require "../../genielibrary/autoload.php";

$obj = new AI();

$voices = $obj->getVoices(TEXTTOVOICEAPI);

//printing
echo $voices;