<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\auth\Auth;

class DisplayCatalogue extends Action {

    public function execute(): string {
        if ($this->http_method == "GET") {
            // Variable containing the result
            $html = "<a href='?action='> Accueil </a> <br> <br>
                      <form method='post' action='?action=displayCatalogue'>
                        <select name='tri'>
                            <option value='select' selected='selected'>Trier le catalogue</option>
                            <option value='titre'>Trier par titre</option>
                            <option value='dateAjout'>Trier par date d'ajout</option>
                            <option value='nbEp'>Trier par nombre d'épisodes</option>
                        </select>
                        <button type='submit'>Trier</button>
                      </form>";

            return $html . $this->display();
        } else {
            $sort = $_POST['tri'] ?? "default";
            return $this->display($sort);
        }
    }

    private function display(string $sort = "default"): string {
        if (($db = ConnectionFactory::makeConnection()) != null) {
            switch ($sort){
                case 'titre':
                    $query = "SELECT id, img, titre FROM serie order by titre";
                    break;

                case 'dateAjout':
                    $query = "SELECT id, img, titre FROM serie order by date_ajout";
                    break;

                default:
                    $query = "SELECT id, img, titre FROM serie";
                    break;
            }

            $req = $db->prepare($query);
            $req->execute();
            $html = "<a href='?action='> Accueil </a> <br> <br>
                      <form method='post' action='?action=displayCatalogue'>
                        <select name='tri'>
                            <option value='select' selected='selected'>Trier le catalogue</option>
                            <option value='titre'>Trier par titre</option>
                            <option value='dateAjout'>Trier par date d'ajout</option>
                            <option value='nbEp'>Trier par nombre d'épisodes</option>
                        </select>
                        <button type='submit'>Trier</button>
                      </form>";

            while ($data = $req->fetch()) {
                $html = $html . "<img class='img-serie' src='" . "img/" . $data["img"] . "' width='150' height='150'>
                        <a href='?action=displaySerie&id=" . $data["id"] . "'>" . $data["titre"] . "</a> <br>";
            }
            return $html;
        }
        return "";
    }
}