<?php

namespace MemMemov\Ndb;

class Client implements Ndb
{
    private $socket;

    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    public function create(): int
    {
        $request = 'create';
        $this->socket->send($request);
        $response = $this->socket->receive();

        return intval($response);
    }

    public function read(int $id): array
    {
        $request = 'read' . ' ' . $id;
        $this->socket->send($request);
        $response = $this->socket->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }

    public function connect(int $fromId, int $toId): void
    {
        $request = 'connect' . ' ' . $fromId . ' ' . $toId;
        $this->socket->send($request);
        $response = $this->socket->receive();
    }

    public function intersect(array $ids): array
    {
        $request = 'intersect' . ' ' . implode(' ', $ids);
        $this->socket->send($request);
        $response = $this->socket->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }

    public function union(array $ids): array
    {
        $request = 'union' . ' ' . implode(' ', $ids);
        $this->socket->send($request);
        $response = $this->socket->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }

    public function difference(array $ids): array
    {
        $request = 'difference' . ' ' . implode(' ', $ids);
        $this->socket->send($request);
        $response = $this->socket->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }

    public function insiders(int $id, array $ids): array
    {
        $request = 'insiders' . ' ' . $id . ' ' . implode(' ', $ids);
        $this->socket->send($request);
        $response = $this->socket->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }

    public function outsiders(int $id, array $ids): array
    {
        $request = 'outsiders' . ' ' . $id . ' ' . implode(' ', $ids);
        $this->socket->send($request);
        $response = $this->socket->receive();
        $ids = array_map('intval', explode(' ', $response));

        return $ids;
    }
}