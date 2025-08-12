<?php

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    protected string $key;

    public function __construct(
        private null|\Predis\Client $predis = null
    )
    {
        $this->predis ??= service('predis');
    }

    private function getNextId(): int|string
    {
        return $this->predis->incr("{$this->key}:id");
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function find($id): array
    {
        return $this->predis->hgetall("{$this->key}:{$id}");
    }

    public function create(array $attributes): array
    {
        $id = $this->getNextId();

        $this->predis->hmset("{$this->key}:{$id}", $attributes);

        return [
            'id' => $id,
            ...$attributes
        ];
    }

    public function update($id, array $attributes): array
    {
        $this->predis->hmset("{$this->key}:{$id}", $attributes);

        return [
            'id' => $id,
            ...$attributes
        ];
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

}