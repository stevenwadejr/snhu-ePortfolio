<?php

require_once __DIR__ . '/vendor/autoload.php';

use stevenwadejr\Application;
use stevenwadejr\binary\BinarySearchTreeCommand;
use stevenwadejr\hash\HashTableCommand;
use stevenwadejr\linked\LinkedListCommand;

$application = new Application(__DIR__);
$application->add(new BinarySearchTreeCommand('run-binary'));
$application->add(new HashTableCommand('run-hash'));
$application->add(new LinkedListCommand('run-linked'));
$application->run();