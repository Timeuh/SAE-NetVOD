<?php

namespace iutnc\netvod\action;

use iutnc\netvod\appli\Serie;
use iutnc\netvod\db\ConnectionFactory;

class DisplaySerieAction extends Action{

    public function execute(): string{
        $id = $_GET['id'] ?? 0;
        if ($id != 0){
            if (($bd = ConnectionFactory::makeConnection()) != null){
                $query = $bd ->prepare("select titre, descriptif, annee, date_ajout from serie where id = :id");
                $query->bindParam('id', $id);
                $query->execute();

                $res = $query->fetch();
                $serie = new Serie($id, $res['titre'], $res['descriptif'], $res['annee'], $res['date_ajout']);
                $serie->getEpisodes();
                return $serie->render();
            }
        }
        return "<h1>Série introuvable</h1>";
    }
}