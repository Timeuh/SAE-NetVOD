<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplayCatalogue extends Action {

    public function execute(): string {
        if ($this->http_method == "GET") {
            return $this->display();
        } else {
            $sort = $_POST['tri'] ?? "default";
            return $this->display($sort);
        }
    }

    private function HTMLForm() : string {
        return "<a href='?action='> Accueil </a> <br> <br>
                     <form method='post' action='?action=rechercher'>
                        <input type='search' id='recherche' name='recherche'
                        placeholder='Rechercher...'>
                        <button type='submit'>Rechercher</button>
                      </form>
                      <form method='post' action='?action=displayCatalogue'>
                        <select name='tri'>
                            <option value='select' selected='selected'>Trier le catalogue</option>
                            <option value='titre'>Trier par titre</option>
                            <option value='dateAjout'>Trier par date d'ajout</option>
                            <option value='nbEp'>Trier par nombre d'épisodes</option>
                        </select>
                        <button type='submit'>Trier</button>
                      </form>
                      <form method='post' action='?action=displayCatalogue'>
                        <select name='filtre'>
                            <option value='select' selected='selected'>Filter le catalogue</option>
                            <option value='titre'>Trier par titre</option>
                            <option value='dateAjout'>Trier par date d'ajout</option>
                            <option value='nbEp'>Trier par nombre d'épisodes</option>
                        </select>
                        <button type='submit'>Filtrer</button>
                      </form>";
    }

    private function display(string $sort = "default"): string {
        $html = $this->HTMLForm();

        if (($db = ConnectionFactory::makeConnection()) != null) {
            switch ($sort){
                case 'titre':
                    $query = "SELECT id, img, titre FROM serie order by titre";
                    break;

                case 'dateAjout':
                    $query = "SELECT id, img, titre FROM serie order by date_ajout";
                    break;

                case 'nbEp':
                    $query = "select count(id) as nombre, serie_id from episode group by serie_id order by nombre desc";
                    break;

                default:
                    $query = "SELECT id, img, titre FROM serie";
                    break;
            }

            $req = $db->prepare($query);
            $req->execute();

            if ($sort != "nbEp"){
                while ($data = $req->fetch()) {
                    $html = $html . "<img class='img-serie' src='" . "img/" . $data["img"] . "' width='150' height='150'>
                        <a href='?action=displaySerie&id=" . $data["id"] . "'>" . $data["titre"] . "</a> <br>";
                }
                return $html;
            } else {
                while ($data = $req->fetch()) {
                    $qr = $db->prepare("SELECT id, img, titre FROM serie where id = :id");
                    $qr->bindParam(':id', $data['serie_id']);
                    $qr->execute();

                    $res = $qr->fetch();
                    $html = $html . "<img class='img-serie' src='" . "img/" . $res["img"] . "' width='150' height='150'>
                        <a href='?action=displaySerie&id=" . $res["id"] . "'>" . $res["titre"] . "</a> <br>";
                }
                return $html;
            }
        }
        return "<h1>Erreur de base de données</h1><br><a href='Index.php'>Accueil</a>";
    }
}