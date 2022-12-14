<?php

namespace iutnc\netvod\action;

use iutnc\netvod\appli\Serie;
use iutnc\netvod\db\ConnectionFactory;

class DisplaySerieAction extends Action{

    public function execute(): string{
        $id = $_GET['id'] ?? 0;
        if ($id != 0){
            if (($bd = ConnectionFactory::makeConnection()) != null){
                $query = $bd ->prepare("select titre, descriptif, annee, date_ajout, img, genre, public from serie where id = :id");
                $query->bindParam('id', $id);
                $query->execute();

                $res = $query->fetch();
                if (!$res) return "<h1>Série introuvable</h1><a href='Index.php'><button class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Accueil</button></a>";
                $serie = new Serie($id, $res['titre'], $res['descriptif'], $res['annee'], $res['date_ajout'], $res['img'], $res['genre'], $res['public']);
                $serie->getEpisodes();

                $_SESSION['idSerie'] = serialize($id);

                return $serie->render();
            }
        }
        return "<h1>Série introuvable</h1><a href='Index.php'><button class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Accueil</button></a>";
    }
}