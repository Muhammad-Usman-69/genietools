<?php

function autoload($class)
{
    require ($class . ".php");
}

spl_autoload_register("autoload");