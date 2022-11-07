<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\auth\Auth;

class DisplayCatalogue extends Action
{

    public function execute(): string
    {
        // Variable containing the result
        $html = "";

        // Check if the user is connected
        if (Auth::authenticate($_GET["email"], $_GET["password"])) {

            // Connection with the db
            $query = "SELECT img, titre FROM serie";
            $stmt = ConnectionFactory::makeConnection();
            $stmt->prepare($query);
            $stmt->execute();

            while ($data = $stmt->fetch()) {
                $html = $html . $data["img"] . "<a href='?action=displaySerie&id=" . $data["id"] . "'>" . $data["titre"] . "</a>>";
            }

            return $html;
        }
        return $html;
    }
}