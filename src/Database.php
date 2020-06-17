<?php

declare(strict_types=1);

namespace App;

require_once('src/exceptions/DatabaseException.php');
require_once('src/exceptions/NotFoundException.php');

use App\Exception\ConfigurationException;
use App\Exception\DatabaseException;
use App\Exception\NotFoundException;
use PDO;
use PDOException;
use Throwable;


class Database
{
    private PDO $connection;

    public function __construct($config)
    {
        try {

            $this->validateConfig($config);
            $this->initializeConnection($config);

        } catch (PDOException $e) {
            throw new DatabaseException('Some database error has occurred! Try again later...');
        }
    }

    public function getNote(int $id): array
    {
        try {
            $query = "SELECT * FROM notes WHERE id = $id";
            $result = $this->connection->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);

        } catch (Throwable $e) {
            throw new DatabaseException('Error! Failed to fetch a note!');
        }

        if (!$note) {
            throw new NotFoundException("Note doesn't exist");
        }
        return $note;
    }

    public function getNotes(): array
    {
        try {
            $query = "SELECT id, title, created FROM notes";
            $result = $this->connection->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new DatabaseException('Error! Failed to fetch a notes!');
        }
    }

    public function createNote($data): void
    {
        try {
            if ((empty($data['title']) || (empty($data['content'])))) {
                echo "<script type='text/javascript'>alert('Both fields must be filled!');window.location = '/?action=newnote';</script>";
                die();

            }

            if (strlen($data['title']) > 99) {
                echo "<script type='text/javascript'>alert('Title can\'t have more than 99 characters!');window.location = '/?action=newnote';</script>";
                die();

            }

            if (strlen($data['content']) > 250) {
                echo "<script type='text/javascript'>alert('Content of note can\'t have more than 250 characters!');window.location = '/?action=newnote';</script>";
                die();

            }
            $title = $this->connection->quote($data['title']);
            $content = $this->connection->quote($data['content']);
            $date = $this->connection->quote(date('Y/m/d H:i:s'));

            $query = "INSERT INTO notes(title, content, created) VALUES ($title, $content, $date)";
            $this->connection->exec($query);

        } catch (Throwable $e) {
            throw new DatabaseException("There are some error - note not saved. Please contact with admin.");
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