<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplayCatalogue extends Action {

    public function execute(): string {
        if ($this->http_method == "GET") {
            return $this->display();
        } else {
            $sort = $_POST['tri'] ?? "default";
            $filter = $_POST['filtre'] ?? "default";
            $filter_name = $_POST['result'] ?? "default";
            $filter_name = filter_var($filter_name,FILTER_SANITIZE_SPECIAL_CHARS);

            if ($sort != "default") return $this->display($sort);
            else if ($filter != "default" && $filter_name != "default") return $this->display_filter($filter, $filter_name);
            else return $this->display();
        }
    }

    private function HTMLForm(): string {
        return "<a href='?action='><button class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'> Accueil </button> </a> <br> <br>
                     <form method='post' action='?action=rechercher'>
                        <input type='search' id='recherche' name='recherche' class='border-2 rounded-md bg-grey-300 text-black'
                        placeholder='Rechercher...' size='150'>
                        <button type='submit' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Rechercher</button>
                      </form>
                      <form method='post' action='?action=displayCatalogue'>
                        <select name='tri' class='text-gray-400'>
                            <option value='select' selected='selected'>Trier le catalogue</option>
                            <option value='titre'>Trier par titre</option>
                            <option value='dateAjout'>Trier par date d'ajout</option>
                            <option value='nbEp'>Trier par nombre d'épisodes</option>
                        </select>
                        <button type='submit' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Trier</button>
                      </form>
                      <form method='post' action='?action=displayCatalogue'>
                        <select name='filtre' class='text-gray-400'>
                            <option value='select' selected='selected'>Filter le catalogue</option>
                            <option value='genre'>Filtrer par genre</option>
                            <option value='public'>Filtrer par public</option>
                        </select>
                        <input type='text' name='result' placeholder='champ' required class='text-black'>
                        <button type='submit' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Filtrer</button> <br> <br>
                      </form>";
    }

    private function display(string $sort = "default"): string {
        $html = $this->HTMLForm();

        if (($db = ConnectionFactory::makeConnection()) != null) {
            switch ($sort) {
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


            if ($sort != "nbEp") {
                while ($data = $req->fetch()) {
                    $html = $html . "<img class='img-serie' src='" . "img/" . $data["img"] . "' width='400' height='400'>
                        <a href='?action=displaySerie&id=" . $data["id"] . "'>" . $data["titre"] . "</a> <br>";
                }
                return $html;
            } else {
                while ($data = $req->fetch()) {
                    $qr = $db->prepare("SELECT id, img, titre FROM serie where id = :id");
                    $qr->bindParam(':id', $data['serie_id']);
                    $qr->execute();

                    $res = $qr->fetch();
                    $html = $html . "<img class='img-serie' src='" . "img/" . $res["img"] . "' width='400' height='400'>
                        <a href='?action=displaySerie&id=" . $res["id"] . "'>" . $res["titre"] . "</a> <br>";
                }
                return $html;
            }
        }
        return "<h1>Erreur de base de données</h1><br><a href='Index.php'>Accueil</a>";
    }

    private function display_filter(string $filter = "default", string $filter_name = "default"): string {
        $html = $this->HTMLForm();

        if (($db = ConnectionFactory::makeConnection()) != null) {
            switch ($filter) {
                case 'genre':
                    $req = $db->prepare("SELECT id, img, titre FROM serie where genre = :genre");
                    $req->bindParam(':genre', $filter_name);
                    break;

                case 'public':
                    $req = $db->prepare("SELECT id, img, titre FROM serie where public = :public");
                    $req->bindParam(':public', $filter_name);
                    break;

                default:
                    $req = $db->prepare("SELECT id, img, titre FROM serie");
                    break;
            }
            $req->execute();

            while ($data = $req->fetch()) {
                $html = $html . "<img class='img-serie' src='" . "img/" . $data["img"] . "' width='400' height='400'>
                        <a href='?action=displaySerie&id=" . $data["id"] . "'>" . $data["titre"] . "</a> <br>";
            }
            return $html;
        }
        return "";
    }
}