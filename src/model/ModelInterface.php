<?php

declare(strict_types=1);

namespace App\Model;

interface ModelInterface
{

    public function search($sortBy, $order, $pageSize, $pageNumber, $searchingText): array;

    public function searchCount($searchingText): int;

    public function getNote(int $id): array;

    public function edit(array $noteData, int $id): void;

    public function delete(int $id): void;

    public function getCount(): int;

    public function getNotes($sortBy, $order, $pageSize, $pageNumber): array;

    public function create($data): void;


}