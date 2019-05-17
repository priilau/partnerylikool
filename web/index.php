<?php
require(__DIR__ . '/autoloader.php');
use app\models\Router;

$router = new Router();
echo $router->parseUrl();

?>