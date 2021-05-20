<?php

require_once __DIR__ . '/vendor/autoload.php';

use stevenwadejr\Application;
use stevenwadejr\binary\BinarySearchTreeCommand;

$application = new Application(__DIR__);
$application->add(new BinarySearchTreeCommand('run-binary'));
$application->run();