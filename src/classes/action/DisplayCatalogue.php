<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\auth\Auth;

class DisplayCatalogue extends Action
{

    public function execute(): string {
        if ($this->http_method == "GET"){
            // Variable containing the result
            $html = "<a href='?action='> Accueil </a> <br> <br>
                      <form method='post' action='?action=displayCatalogue'>
                        <select name='tri'>
                            <option value='select' selected='selected'>Trier le catalogue</option>
                            <option value='titre'>Trier par titre</option>
                            <option value='dateAjout'>Trier par date d'ajout</option>
                            <option value='nbEp'>Trier par nombre d'épisodes</option>
                        </select>
                      </form>";

            $db = ConnectionFactory::makeConnection();
            if ($db != null) {
                // Connection with the db
                $query = "SELECT id, img, titre FROM serie";
                $stmt = $db->prepare($query);
                $stmt->execute();

                while ($data = $stmt->fetch()) {
                    $html = $html . "<img class='img-serie' src='" . "img/" . $data["img"]. "' width='150' height='150'>
                        <a href='?action=displaySerie&id=" . $data["id"] . "'>" . $data["titre"] . "</a> <br>";
                }
                return $html;
            }
            return $html . "Catalogue introuvable";
        } else {
            return "";
        }
    }
}