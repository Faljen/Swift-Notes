<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\ConfigurationException;
use App\Exception\DatabaseException;
use PDO;
use PDOException;

class AbstractModel
{

    protected PDO $connection;

    public function __construct($config)
    {
        try {
            $this->validateConfig($config);
            $this->initializeConnection($config);

        } catch (PDOException $e) {
            throw new DatabaseException('Some database error has occurred! Try again later...');
        }
    }

    private function initializeConnection($config): void
    {
        $dsn = 'mysql:dbname=' . $config['name'] . ';host=' . $config['host'] . '';
        $this->connection = new PDO($dsn, $config['username'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    private function validateConfig(array $config): void
    {
        if (empty($config['name']) || empty($config['host']) || empty($config['username']) || empty($config['password'])) {
            throw new ConfigurationException('No database connection!');
        }
    }
}