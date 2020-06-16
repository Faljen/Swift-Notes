<?php
declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;

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
        $viewParams = [];

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
            case 'list':
                $page = 'list';
                $notes = $this->db->getNote();
                $data = $this->getRequestGet();
                $viewParams['before'] = $data['before'] ?? null;

        }
        $this->view->render($page, $viewParams);
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