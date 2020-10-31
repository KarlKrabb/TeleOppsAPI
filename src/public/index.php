<?php

require '../vendor/autoload.php';

$app = new \Slim\App();

include 'routes/RouteManager.php';

$app->run();

?>