<?php

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\dispatcher\Dispatcher;

require_once 'vendor/autoload.php';

session_start();
ConnectionFactory::setConfig("dbconfig.ini");

$dispatcher = new Dispatcher("iconBlack.png", "CSS/tailwind.css");
$dispatcher->run();
