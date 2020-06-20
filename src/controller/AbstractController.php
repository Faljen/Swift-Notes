<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\ConfigurationException;
use App\Request;
use App\Database;
use App\View;

class AbstractController
{
    protected const DEFAULT_ACTION = 'list';
    private static array $configuration;
    protected Request $request;
    protected View $view;
    protected Database $db;

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

    }

    private function getAction(): string
    {
        return $this->request->getGet('action', self::DEFAULT_ACTION);
    }
}