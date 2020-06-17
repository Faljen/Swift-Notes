<?php
declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

require_once('View.php');
require_once('exceptions/ConfigurationException.php');


class Controller
{
    private const DEFAULT_ACTION = 'list';

    private static array $configuration;
    private array $request;
    private View $view;
    private Database $db;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(array $request)
    {
        if (empty(self::$configuration['db'])) {
            throw new ConfigurationException('Configuration error!');
        }
        $this->db = new Database(self::$configuration['db']);
        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
        switch ($this->getAction()) {
            case 'newnote':
                $page = 'newnote';

                $data = $this->getRequestPost();

                if (!empty($data)) {

                    $noteData = [
                        'title' => $data['title'],
                        'content' => $data['content']
                    ];

                    $this->db->createNote($noteData);
                    header('Location: /?before=created');

                }
                break;

            case 'show':
                $page = 'show';
                $get = $this->getRequestGet();
                $id = (int)$get['id'];

                try {
                    $note = $this->db->getNote($id);
                } catch (NotFoundException $e) {
                    header('Location: /?error=notfound');
                }

                $viewParams = [
                    'note' => [
                        'ID' => $note['ID'],
                        'title' => $note['title'],
                        'content' => $note['content'],
                        'created' => $note['created']
                    ]
                ];
                break;

            default:
                $page = 'list';
                $notes = $this->db->getNotes();
                $data = $this->getRequestGet();
                $viewParams = [
                    'notes' => $notes,
                    'before' => $data['before'] ?? null,
                    'error' => $data['error'] ?? null
                ];
                break;

        }
        $this->view->render($page, $viewParams ?? []);

    }

    private function getRequestGet(): array
    {
        return $this->request['get'] ?? [];
    }

    private function getRequestPost(): array
    {
        return $this->request['post'] ?? [];
    }

    private function getAction(): string
    {
        $get = $this->getRequestGet();
        return $get['action'] ?? self::DEFAULT_ACTION;
    }

}