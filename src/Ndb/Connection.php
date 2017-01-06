<?php

namespace MemMemov\Ndb;

class Connection
{
    private $server;
    private $port;
    private $filePointer;

    public function __construct(string $server, string $port)
    {
        $this->server = $server;
        $this->port = $port;
        $this->filePointer = null;
    }

    public function __destruct()
    {
        $this->close();
    }

    public function receive(): string
    {
        $this->open();

        $message = '';

        while (!feof($this->filePointer)) {
            $message .= fgets($this->filePointer, 1024);
        }

        return $message;
    }

    public function send(string $message): void
    {
        $this->open();

        fwrite($this->filePointer, $message);
    }

    private function open(): void
    {
        if (null === $this->filePointer) {
            $this->filePointer = stream_socket_client('tcp://' . $this->server . ':' . $this->port);
        }
    }

    private function close(): void
    {
        if (null !== $this->filePointer) {
            fclose($this->filePointer);
            $this->filePointer = null;
        }
    }
}