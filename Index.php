<?php

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\dispatcher\Dispatcher;

require_once 'vendor/autoload.php';

session_start();
ConnectionFactory::setConfig("config.ini");

$dispatcher = new Dispatcher("icon.png");
$dispatcher->run();
