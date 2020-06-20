<?php

declare(strict_types=1);

namespace App;

class Request
{

    private array $get = [];
    private array $post = [];
    private array $server = [];

    public function __construct(array $get, array $post, array $server)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
    }

    public function getGet(string $name, $default = null)
    {
        return $this->get[$name] ?? $default;
    }

    public function getPost(string $name, $default = null)
    {
        return $this->post[$name] ?? $default;
    }

    public function isGet(): bool
    {
        if ($this->server['REQUEST_METHOD'] == 'GET') {
            return true;
        } else return false;
    }

    public function isPost(): bool
    {
        if ($this->server['REQUEST_METHOD'] == 'POST') {
            return true;
        } else return false;
    }

    public function hasPost(): bool
    {
        return !empty($this->post);
    }


}