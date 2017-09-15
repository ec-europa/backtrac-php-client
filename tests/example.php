<?php
require_once __DIR__.'/../vendor/autoload.php';
$client = new \EC\Utils\Backtrac\Client(
    1,
    'aaaaaaaaaaaaaaa'
);

/**
 * Create a website object
 */
$website = new \EC\Utils\Backtrac\Website('test-site','http://ci-test.com', 'user', 'pass');

/**
 * Set the new url for the environment :
 */
$client->setWebsite($website, $environment);

/**
 * Compare prod a dev :
 */
$diffId = $client->compareEnvironments(
  \EC\Utils\Backtrac\Client::COMPARE_PROD_DEV
)->result->nid;

/**
 * Wait for the end of the diff and display result :
 */

var_dump(
  $client->waitForResults($diffId)
);

/**
 * Custom compare :
 */
var_dump(
    $client->customCompare(
        'my_diff',
        new \EC\Utils\Backtrac\Website('site_1','http://xxxx.yyy/zzz'),
        new \EC\Utils\Backtrac\Website('site_2', 'http://xxx.yyy/zzzzw')
    )
);


