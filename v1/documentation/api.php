<?php
spl_autoload_register('autoloader');
function autoloader(string $name)
{

    if (file_exists('../src/controllers/' . $name . '.php')) {
        require_once '../src/controllers/' . $name . '.php';
    } else if (file_exists('../src/' . $name . '.php')) {
        require_once '../src/' . $name . '.php';
    }
}

require($_SERVER['DOCUMENT_ROOT'] . "/api/v1/vendor/autoload.php");
$openapi = \OpenApi\Generator::scan([$_SERVER['DOCUMENT_ROOT'] . '/api/v1/src']);
header('Content-Type: application/json');
echo $openapi->toJSON();