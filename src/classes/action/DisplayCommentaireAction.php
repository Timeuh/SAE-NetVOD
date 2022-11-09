<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplayCommentaireAction extends Action {

    public function execute(): string {
        $idSerie = unserialize($_SESSION["idSerie"]);
        $html ="<a href='?action='>Accueil</a> <br> <br>";

        if (($db = ConnectionFactory::makeConnection()) != null ){
            $query = "SELECT email, commentaire FROM commentaire
                      INNER JOIN serie ON serie.id = commentaire.idSerie
                      INNER JOIN user ON user.id = commentaire.idUser
                      WHERE idSerie=:idSerie";

            $stmt = $db->prepare($query);
            $stmt->bindParam("idSerie", $idSerie);
            $stmt->execute();

            while ($data = $stmt->fetch()){

                $query2 = "SELECT nom, prenom FROM user WHERE email=:email";
                $stmt2 = $db->prepare($query2);
                $stmt2->bindParam("email", $data['email']);
                $stmt2->execute();

                $data2 = $stmt2->fetch();

                if (strlen($data2['nom']) == 0 || strlen($data2['prenom']) == 0) {
                    $html = $html . "Inconnu a commenté : ". "<br>" . $data['commentaire'] . "<br> <br>";
                } else {
                    $html = $html . $data2['nom'] . " " . $data2['prenom'] . " a commenté : ". "<br>" . $data['commentaire'] . "<br> <br>";
                }

            }

            return $html . "<br><a href='?action=displaySerie&id=$idSerie'><button>Retour</button></a>";
        }

        return $html . "Connexion a la base perdue";

    }

}