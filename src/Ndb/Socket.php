<?php

namespace MemMemov\Ndb;

interface Socket
{
    /**
     * @throws ConnectionFailed
     */
    public function receive(): string;

    /**
     * @throws ConnectionFailed
     */
    public function send(string $message): void;
}