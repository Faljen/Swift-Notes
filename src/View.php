<?php
declare(strict_types=1);

namespace App;

class View
{

    public function render(string $page, array $params = []): void
    {
        $params = $this->entitiesParams($params);

        include_once('templates/layout.php');
    }

    private function entitiesParams($params): array
    {
        $entitiesParams = [];
        foreach ($params as $key => $param) {
            if (is_array($param)) {
                $entitiesParams[$key] = $this->entitiesParams($param);
            } else if ($param) {
                $entitiesParams[$key] = htmlentities($param);
            } else {
                $entitiesParams[$key] = $param;
            }
        }
        return $entitiesParams;
    }

}