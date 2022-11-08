<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplayCommentaireAction extends Action
{

    public function execute(): string
    {

        $idSerie = unserialize($_SESSION["idSerie"]);

        $html ="<a href='?action='>Accueil</a> <br> <br>";

        $db = ConnectionFactory::makeConnection();

        if ($db != null ){

            $query = "SELECT email, commentaire FROM commentaire
                      INNER JOIN serie ON serie.id = commentaire.idSerie
                      INNER JOIN user ON user.id = commentaire.idUser
                      WHERE idSerie=:idSerie";

            $stmt = $db->prepare($query);
            $stmt->bindParam("idSerie", $idSerie);
            $stmt->execute();

            while ($data = $stmt->fetch()){
                $html = $html . $data['email'] . " a commenté : ". "<br>" . $data['commentaire'] . "<br> <br>";
            }

            return $html;
        }

        return $html . "Connexion a la base perdue";

    }

}