<?php
$global = include __DIR__.'/global.php';

$overrides = array(
    'db' => array(
        'dsn' => 'mysql:dbname=zend3_tests;host=localhost',
    ),
);
$global['db']['dsn'] = 'mysql:dbname=zend3_tests;host=localhost';

return $global;