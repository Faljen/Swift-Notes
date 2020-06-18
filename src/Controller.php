<?php
declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

require_once('View.php');
require_once('exceptions/ConfigurationException.php');
require_once('Request.php');


class Controller
{
    private const DEFAULT_ACTION = 'list';
    private static array $configuration;
    private Request $request;
    private View $view;
    private Database $db;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request)
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

                if ($this->request->hasPost()) {

                    $noteData = [
                        'title' => $this->request->getPost('title'),
                        'content' => $this->request->getPost('content')
                    ];
                    $this->db->createNote($noteData);
                    header('Location: /?before=created');

                }
                break;

            case 'show':
                $page = 'show';

                $id = (int)($this->request->getGet('id'));

                if (!$id) {
                    header('Location: /?error=invalidid');
                    exit;
                }

                try {
                    $note = $this->db->getNote($id);
                } catch (NotFoundException $e) {
                    header('Location: /?error=notfound');
                    exit;
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
                $viewParams = [
                    'notes' => $notes,
                    'before' => $this->request->getGet('before'),
                    'error' => $this->request->getGet('error')
                ];
                break;

        }
        $this->view->render($page, $viewParams ?? []);

    }


    private function getAction(): string
    {
        return $this->request->getGet('action', self::DEFAULT_ACTION);
    }

}