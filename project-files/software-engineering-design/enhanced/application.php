<?php

if (phpversion() < 8) {
    die('PHP version 8 is required');
}

require_once __DIR__ . '/vendor/autoload.php';

use stevenwadejr\Application;
use stevenwadejr\binary\BinarySearchTreeCommand;
use stevenwadejr\hash\HashTableCommand;
use stevenwadejr\linked\LinkedListCommand;
use stevenwadejr\sorting\SortingCommand;

try {
    $application = new Application(__DIR__);
    $application->add(new BinarySearchTreeCommand('run-binary'));
    $application->add(new HashTableCommand('run-hash'));
    $application->add(new LinkedListCommand('run-linked'));
    $application->add(new SortingCommand('run-sort'));
    $application->run();
} catch (Exception $e) {
    echo 'An error occurred while trying to run the application: ' . $e->getMessage();
    exit(1);
}
