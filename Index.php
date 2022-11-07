<?php

use iutnc\deefy\db\ConnectionFactory;
use iutnc\deefy\dispatcher\Dispatcher;

require_once 'vendor/autoload.php';

session_start();
ConnectionFactory::setConfig("config.ini");

$dispatcher = new Dispatcher();
$dispatcher->run();
