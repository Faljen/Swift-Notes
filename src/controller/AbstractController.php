<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ConfigurationException;
use App\Exception\DatabaseException;
use App\Exception\NotFoundException;
use App\Request;
use App\Model\NoteModel;
use App\View;

class AbstractController
{
    protected const DEFAULT_ACTION = 'list';
    private static array $configuration;
    protected Request $request;
    protected View $view;
    protected NoteModel $noteModel;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request)
    {
        if (empty(self::$configuration['db'])) {
            throw new ConfigurationException('Configuration error!');
        }
        $this->noteModel = new NoteModel(self::$configuration['db']);
        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
        try {
            switch ($this->getAction()) {
                case 'newnote':
                    $this->newNote();
                    break;

                case 'show':
                    $this->show();
                    break;

                case 'edit':
                    $this->edit();
                    break;

                case 'delete':
                    $this->delete();
                    break;

                default:
                    $this->list();
                    break;
            }
        } catch (DatabaseException $e) {
            $this->view->render(
                'error',
                [
                    'message' => $e->getMessage()
                ]
            );
        } catch (NotFoundException $e) {
            header('Location: /?error=notfound');
        }
    }

    private function getAction(): string
    {
        return $this->request->getGet('action', self::DEFAULT_ACTION);
    }
}