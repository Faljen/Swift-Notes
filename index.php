<?php
declare(strict_types=1);

spl_autoload_register(function (string $namespace) {

    $name = str_replace(['\\', 'App/'], ['/', ''], $namespace);
    $path = 'src/' . $name . '.php';
    require_once($path);
});


$dbconf = require_once('config/config.php');
require_once('src/utils/debug.php');

use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Request;
use App\Exception\AppException;
use App\Exception\ConfigurationException;


$request = new Request($_GET, $_POST, $_SERVER);

try {

    AbstractController::initConfiguration($dbconf);
    (new NoteController($request))->run();

} catch (ConfigurationException $e) {
    echo '<h1 style="text-align: center">ERROR!</h1>';
    echo '<h1 style="text-align: center">' . $e->getMessage() . '</h1>';
    echo '<h1 style="text-align: center">Please, contact with admin!</h1>';
} catch (AppException $e) {
    echo '<h1 style="text-align: center">ERROR!</h1>';
    echo '<h1 style="text-align: center">' . $e->getMessage() . '</h1>';
} catch (\Throwable $e) {
    echo $e;
    echo '<h1 style="text-align: center">Unknown error!</h1>';
}
