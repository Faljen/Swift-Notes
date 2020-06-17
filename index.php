<?php
declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;

require_once('src/utils/debug.php');
require_once('src/Controller.php');
require_once('src/Database.php');
$dbconf = require_once('config/config.php');

$request = [
    'get' => $_GET,
    'post' => $_POST
];

try {

    Controller::initConfiguration($dbconf);
    (new Controller($request))->run();

} catch (ConfigurationException $e) {
    echo '<h1 style="text-align: center">ERROR!</h1>';
    echo '<h1 style="text-align: center">' . $e->getMessage() . '</h1>';
    echo '<h1 style="text-align: center">Please, contact with admin!</h1>';
} catch (AppException $e) {
    echo '<h1 style="text-align: center">ERROR!</h1>';
    echo '<h1 style="text-align: center">' . $e->getMessage() . '</h1>';
} catch (Throwable $e) {
    echo $e;
    echo '<h1 style="text-align: center">Unknown error!</h1>';
}
