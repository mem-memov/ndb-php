<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new MemMemov\Ndb\Client('127.0.0.1', '43152');

$length = 5;
$nodes = [];
for ($i = 0; $i < $length; $i++) {
    $id = $client->create();
    $nodes = [$id=>[]];
}

for ($i = 0; $i < $length; $i++) {
    for ($j = 0; $j < $length; $j++) {
        $client->connect($ids[$i], $ids[$j]);
    }
}

foreach ($nodes as $id => $data) {
    $nodes[$id]['read'] = $client->read($id);
}

print_r($nodes);