<?php

function autoload($class)
{
    require (__DIR__ . "/" . $class . ".php");
}

spl_autoload_register("autoload");