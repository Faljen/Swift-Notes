<?php

declare(strict_types=1);

namespace App;

class Database
{

    public function __construct($config)
    {
        $dsn = 'mysql:dbname=' . $config['name'] . ';host=' . $config['host'] . '';
        $db = new \PDO($dsn, $config['username'], $config['password']);
    }

}