<?php

namespace classes\action;

use iutnc\netvod\db\ConnectionFactory;

class AddPrefAction extends \iutnc\netvod\action\Action
{

    public function execute(): string
    {
        $id = $_GET['id'];
        if(($bd = ConnectionFactory::makeConnection())!=null){

        }
    }
}