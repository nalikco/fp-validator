<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/vendor/autoload.php';

use Framework\Test\TestController;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/', TestController::class);

$app->run();
