<?php

require __DIR__ . '/../vendor/autoload.php';

$socket = new MemMemov\Ndb\StreamSocket('127.0.0.1', '43152');
$client = new MemMemov\Ndb\Client($socket);

$length = 3;
$ids = [];
for ($i = 0; $i < $length; $i++) {
    $id = $client->create();
    $ids[] = $id;
}

print_r("create\n");
print_r($ids);

$client->connect($ids[0], $ids[1]);
$client->connect($ids[0], $ids[2]);
$client->connect($ids[1], $ids[2]);
$client->connect($ids[2], $ids[1]);

print_r("read\n");
foreach ($ids as $id) {
    $connections = $client->read($id);
    print_r($connections);
}

$intersect = $client->intersect([$ids[0], $ids[2]]);
print_r("intersect\n");
print_r($intersect);

$union = $client->union([$ids[0], $ids[2]]);
print_r("union\n");
print_r($union);

$difference = $client->difference([$ids[0], $ids[2]]);
print_r("difference\n");
print_r($difference);
