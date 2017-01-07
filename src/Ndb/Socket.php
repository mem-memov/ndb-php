<?php

namespace MemMemov\Ndb;

interface Socket
{
    public function receive(): string;

    public function send(string $message): void;
}