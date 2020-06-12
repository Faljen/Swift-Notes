<?php
declare(strict_types=1);

namespace App;

require_once('src/utils/debug.php');
require_once('src/Controller.php');
require_once('src/Database.php');
$dbconf = require_once('config/config.php');

$request = [
    'get' => $_GET,
    'post' => $_POST
];


Controller::initConfiguration($dbconf);
(new Controller($request))->run();
