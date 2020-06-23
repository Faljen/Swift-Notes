<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\DatabaseException;
use App\Exception\NotFoundException;
use PDO;
use Throwable;


class NoteModel extends AbstractModel implements ModelInterface
{

    public function search($sortBy, $order, $pageSize, $pageNumber, $searchingText): array
    {
        if (!in_array($sortBy, ['title', 'created'])) {
            $sortBy = 'created';
        }
        if (!in_array($order, ['asc', 'desc'])) {
            $sortBy = 'desc';
        }
        //to fix
        if ($pageNumber < 1) {
            $pageNumber = 1;
        }
        if ($pageNumber > $pageSize) {
            $pageNumber = $pageSize;
        }

        $limit = $pageSize;
        $offset = ($pageNumber - 1) * $pageSize;

        //note that we don't use the index here
        //it's acceptable because we won't have a huge amount of data in the database
        $searchingText = $this->connection->quote('%' . $searchingText . '%', PDO::PARAM_STR);

        try {
            $query = "SELECT id, title, created FROM notes WHERE title LIKE ($searchingText) ORDER BY $sortBy $order LIMIT $offset,$limit";
            $result = $this->connection->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new DatabaseException('Error! Failed to search notes!');
        }
    }

    public function searchCount($searchingText): int
    {
        $searchingText = $this->connection->quote('%' . $searchingText . '%', PDO::PARAM_STR);

        try {
            $query = "SELECT count(*) AS countOfNotes FROM notes WHERE title LIKE ($searchingText)";
            $result = $this->connection->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            $result = (int)$result['countOfNotes'];
            return $result;
        } catch (Throwable $e) {
            throw new DatabaseException('Error! Failed to fetch a count of searching notes!');
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

    public function edit(array $noteData, int $id): void
    {
        try {
            $newTitle = $this->connection->quote($noteData['title']);
            $newContent = $this->connection->quote($noteData['content']);
            $query = "UPDATE notes SET title=$newTitle, content=$newContent WHERE id=$id";
            $this->connection->query($query);

        } catch (Throwable $e) {
            throw new DatabaseException('Some error, when edit note! Please contact with admin');
        }
    }

    public function delete(int $id): void
    {
        try {
            $query = "DELETE from notes WHERE ID=$id";
            $this->connection->exec($query);
        } catch (Throwable $e) {
            throw new DatabaseException('Failed to delete note');
        }
    }

    public function getCount(): int
    {
        try {
            $query = "SELECT count(*) AS countOfNotes FROM notes";
            $result = $this->connection->query($query);
            $result = $result->fetch(PDO::FETCH_ASSOC);
            $result = (int)$result['countOfNotes'];
            return $result;
        } catch (Throwable $e) {
            throw new DatabaseException('Error! Failed to fetch a count of notes!');
        }
    }

    public function getNotes($sortBy, $order, $pageSize, $pageNumber): array
    {
        if (!in_array($sortBy, ['title', 'created'])) {
            $sortBy = 'created';
        }
        if (!in_array($order, ['asc', 'desc'])) {
            $sortBy = 'desc';
        }
        //to fix
        if ($pageNumber < 1) {
            $pageNumber = 1;
        }
        if ($pageNumber > $pageSize) {
            $pageNumber = $pageSize;
        }

        $limit = $pageSize;
        $offset = ($pageNumber - 1) * $pageSize;

        try {
            $query = "SELECT id, title, created FROM notes ORDER BY $sortBy $order LIMIT $offset,$limit";
            $result = $this->connection->query($query);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new DatabaseException('Error! Failed to fetch a notes!');
        }
    }

    public function create($data): void
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

}