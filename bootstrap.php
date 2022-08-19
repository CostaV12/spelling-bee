<?php

/**
 * @file
 * Require autoload and set configs of connection.
 */

require __DIR__ . '/vendor/autoload.php';

//Development.
$config = [
  'db_dsn' => 'mysql:host=database;dbname=spelling_bee',
  'db_user' => 'root',
  'db_pass' => '',
];

// // Production.
// $config = [
//   'db_dsn' => 'mysql:host=us-cdbr-east-06.cleardb.net;dbname=heroku_b07eeb49085b99d',
//   'db_user' => 'b0d0821ac5d28d',
//   'db_pass' => '60a475ea',
// ];
