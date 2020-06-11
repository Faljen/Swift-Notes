<?php
declare(strict_types=1);

namespace App;

require_once('View.php');

class Controller
{
    private const DEFAULT_ACTION = 'list';

    private array $request;
    private View $view;


    public function __construct(array $request)
    {
        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
        $viewParams = [];

        switch ($this->getAction()) {
            case 'newnote':
                $page = 'newnote';

                $created = false;
                if (!empty($this->getRequestPost())) {
                    $created = true;
                    $viewParams = [
                        'title' => $this->getRequestPost()['title'],
                        'content' => $this->getRequestPost()['content']
                    ];
                }
                $viewParams['created'] = $created;
                break;
            case 'list':
                $page = 'list';
                $viewParams['displayList'] = 'Tutaj jest lista notatek';
                break;

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