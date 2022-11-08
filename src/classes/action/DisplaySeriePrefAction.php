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
            $query = "SELECT img, titre FROM serie INNER JOIN seriePrefUser ON serie.id = seriePrefUser.idSerie WHERE idUser= :user";
            $stmt = $db->prepare($query);
            $stmt->bindParam('user', $_GET["id"]);
        }
    }
}