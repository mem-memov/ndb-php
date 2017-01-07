<?php

require __DIR__ . '/../vendor/autoload.php';


$socket = new MemMemov\Ndb\Socket('127.0.0.1', '43152');
$client = new MemMemov\Ndb\Client($socket);

$length = 3;
$ids = [];
for ($i = 0; $i < $length; $i++) {
    $id = $client->create();
    $ids[] = $id;
}

foreach ($ids as $id_1) {
    foreach ($ids as $id_2) {
        if ($id_1 !== $id_2) {
            $client->connect($id_1, $id_2);
            $client->connect($id_2, $id_1);
        }
    }
}

$intersect = $client->intersect([$ids[0], $ids[2]]);
$union = $client->union([$ids[0], $ids[2]]);
$difference = $client->difference([$ids[0], $ids[2]]);

print_r("create");
print_r($ids);
print_r("intersect");
print_r($intersect);
print_r("union");
print_r($union);
print_r("difference");
print_r($difference);
