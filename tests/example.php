<?php
require_once __DIR__.'/../vendor/autoload.php';
$client = new \EC\Utils\Backtrac\Client(
    1,
    'aaaaaaaaaaaaaaa'
);
var_dump(
    $client->customCompare(
        'my_diff',
        new \EC\Utils\Backtrac\Website('site_1','http://xxxx.yyy/zzz'),
        new \EC\Utils\Backtrac\Website('site_2', 'http://xxx.yyy/zzzzw')
    )
);