<?php
spl_autoload_register('autoloader');
function autoloader(string $name) {

    if (file_exists('../objects/'.$name.'.php')){
        require_once '../objects/'.$name.'.php';
    }
}

$exclude = ['tests'];
$pattern = '*.php';
require("../vendor/autoload.php");
$openapi = \OpenApi\Generator::scan(['../objects']);
header('Content-Type: application/json');
echo $openapi->toJSON();