<?php
// Load Helpers
require_once 'helpers/functions.php';

//Load Config
require_once "config/config.php";


// Autoload Core Librabries
spl_autoload_register(

    function ($classname) {

        require_once "core/" . $classname . ".php";
    }
);
