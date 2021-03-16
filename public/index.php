<?php

    use App\Router;
    use Tracy\Debugger;

    require_once "../vendor/autoload.php";
    require_once "../config/config.php";

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    debugger::enable();

    $router = new Router();
    $router -> run();