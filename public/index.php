<?php


require(__DIR__ . "/../helpers.php");
require(basePath("vendor/autoload.php"));

$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$isAPI = preg_match('/\/api/i', $url);

if ($isAPI) {
    header('Content-Type: application/json');
    require(basePath('./routes.php'));
} else {
    loadPartial("header");
    require(basePath('./routes.php'));
    loadPartial("footer");
}
