<?php

require __DIR__ . '/vendor/autoload.php';

use React\EventLoop\Factory as LoopFactory;
use Clue\React\Redis\Factory as RedisFactory;

$loop = LoopFactory::create();
$redisFactory = new RedisFactory($loop);

//$loop->addPeriodicTimer(1, function () {
//    echo "\r[Godzina: " . date('Y-m-d H:i:s') . "]";
//});

$redisFactory->createClient('localhost:6379/0')->then(function ($redis) {
//    echo "+--------+-----------------------+--------------+--------------+-----------------+\n";
//    echo "|   ID   |        Godziny        |    Wagony    |   Personel   |   Klienci dz.   |\n";
//    echo "+--------+-----------------------+--------------+--------------+-----------------+\n";

//    $coasterRow = function (array $coaster, array $wagons) {
//        $row  = "+--------+-----------------------+--------------+--------------+-----------------+\n";
//        $row .= "+--{$coaster['id']}---+-----------------------+--------------+--------------+-----------------+\n";
//
//    };

    $redis->scan(0, 'MATCH', 'coaster:*')->then(function ($result) use ($redis) {
        [$cursor, $keys] = $result;

        foreach ($keys as $key) {
            print_r($key);
        }
    });
});

$loop->run();