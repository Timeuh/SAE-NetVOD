<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplaySeriePrefAction extends Action
{

    public function execute(): string
    {
        $html = "";

        $db = ConnectionFactory::makeConnection();

        if ($db != null){

        }
    }
}