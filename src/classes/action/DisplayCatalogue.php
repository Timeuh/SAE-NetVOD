<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplayCatalogue extends Action
{

    public function execute(): string
    {
        // Variable containing the result
        $html = "";

        // Connection with the db
        $query = "SELECT img, titre FROM serie";
        $stmt = ConnectionFactory::makeConnection();
        $stmt->prepare($query);
        $stmt->execute();

        while ($data = $stmt->fetch()){
            $html = $html . $data["img"] . "<a href='?action=displaySerie&id=" . $data["id"] . "'>" . $data["titre"] . "</a>>";
        }

        return $html;
    }
}