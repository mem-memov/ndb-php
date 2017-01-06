<?php

namespace MemMemov\Ndb;

class Client
{
    private $connection;

    public function __construct(string $server, string $port)
    {
        $this->connection = new Connection($server, $port);
    }

    public function create(): int
    {
        $request = 'create';
        $this->connection->send($request);
        $response = $this->connection->receive();

        return intval($response);
    }

    public function read(int $id): array
    {
        $request = 'read' . ' ' . $id;
        $this->connection->send($request);
        $response = $this->connection->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }

    public function connect(int $fromId, int $toId): void
    {
        $request = 'connect' . ' ' . $fromId . ' ' . $toId;
        $this->connection->send($request);
        $response = $this->connection->receive();
    }

    public function intersect(array $ids): array
    {
        $request = 'intersect' . ' ' . implode(' ', $ids);
        $this->connection->send($request);
        $response = $this->connection->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }

    public function union(array $ids): array
    {
        $request = 'union' . ' ' . implode(' ', $ids);
        $this->connection->send($request);
        $response = $this->connection->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }

    public function difference(array $ids): array
    {
        $request = 'difference' . ' ' . implode(' ', $ids);
        $this->connection->send($request);
        $response = $this->connection->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }

    public function insides(int $id, array $ids): array
    {
        $request = 'insides' . ' ' . $id . ' ' . implode(' ', $ids);
        $this->connection->send($request);
        $response = $this->connection->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }

    public function outsides(int $id, array $ids): array
    {
        $request = 'outsides' . ' ' . $id . ' ' . implode(' ', $ids);
        $this->connection->send($request);
        $response = $this->connection->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }
}