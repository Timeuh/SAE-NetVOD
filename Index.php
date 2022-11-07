<?php

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\dispatcher\Dispatcher;

require_once 'vendor/autoload.php';

session_start();
ConnectionFactory::setConfig("dbconfig.ini");

$dispatcher = new Dispatcher("icon.png");
$dispatcher->run();
