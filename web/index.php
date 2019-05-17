<?php
require(__DIR__ . '/autoloader.php');
use app\components\Router;

$router = new Router();
echo $router->parseUrl();

?>