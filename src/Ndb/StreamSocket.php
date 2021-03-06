<?php

namespace MemMemov\Ndb;


class StreamSocket implements Socket
{
    private static $ending = "\n";

    private $server;
    private $port;
    private $stream;

    public function __construct(string $server, string $port)
    {
        $this->server = $server;
        $this->port = $port;
        $this->stream = null;
    }

    public function __destruct()
    {
        $this->close();
    }

    public function receive(): string
    {
        $this->open();

        $message = fgets($this->stream);

        rtrim($message, self::$ending);

        return $message;
    }

    public function send(string $message): void
    {
        $this->open();

        $message .= self::$ending;

        $byteCount = fwrite($this->stream, $message);

        if (false === $byteCount) {
            throw new ConnectionFailed(sprintf('Sending message to server %s faild.', $this->server));
        }
    }

    /**
     * @throws ConnectionFailed
     */
    private function open(): void
    {
        if (null === $this->stream) {
            $url = 'tcp://' . $this->server . ':' . $this->port;
            $this->stream = stream_socket_client(
                $url,
                $errno,
                $errstr,
                30,
                \STREAM_CLIENT_CONNECT
            );
            if (false === $this->stream) {
                $this->stream = null;
                throw new ConnectionFailed(sprintf('Socket connection to URL %s faild.', $url));
            }
        }
    }

    private function close(): void
    {
        if (null !== $this->stream) {
            fclose($this->stream);
            $this->stream = null;
        }
    }
}