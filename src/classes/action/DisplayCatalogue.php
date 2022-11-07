<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\auth\Auth;

class DisplayCatalogue extends Action
{

    public function execute(): string
    {
        // Variable containing the result
        $html = "<a href='?action='> Accueil </a> <br> <br>";

        $db = ConnectionFactory::makeConnection();
        if ($db != null) {
            // Connection with the db
            $query = "SELECT id, img, titre FROM serie";
            $stmt = $db->prepare($query);
            $stmt->execute();

            while ($data = $stmt->fetch()) {
                $html = $html . $data["img"] . "<a href='?action=displaySerie&id=" . $data["id"] . "'>" . $data["titre"] . "</a> <br>";
            }

            return $html;
        }

        return $html . "Catalogue introuvable";
    }
}