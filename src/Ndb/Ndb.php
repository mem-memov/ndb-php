<?php

namespace MemMemov\Ndb;

interface Ndb
{
    public function create(): int;

    public function read(int $id): array;

    public function connect(int $fromId, int $toId): void;

    public function intersect(array $ids): array;

    public function union(array $ids): array;

    public function difference(array $ids): array;

    public function insiders(int $id, array $ids): array;

    public function outsiders(int $id, array $ids): array;

}