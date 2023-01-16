<?php

require_once realpath("vendor/autoload.php");

use Source\Core\Components\ComissionController;

$GLOBALS['newline'] = "<br>";
$file = "input.csv";

//if script is being run from the console
if (isset($argc)) {
    $GLOBALS['newline'] = "\n";
    if (!empty($argv[1])) {
        $file = $argv[1];
    }
}

try {
    //call main controller of operations
    $comissionController = new ComissionController($file);
    $comissionController->manageTransactions();
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), $GLOBALS['newline'];
}