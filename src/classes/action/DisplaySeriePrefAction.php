<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplaySeriePrefAction extends Action
{

    public function execute(): string
    {

        $user = unserialize($_SESSION['user']);
        $email = $user->__get("email");

        $html = "<a href='?action='> Accueil </a> <br> <br>";

        $db = ConnectionFactory::makeConnection();

        if ($db != null){
            $query = "SELECT serie.id, img, titre FROM serie 
                      INNER JOIN seriePrefUser ON serie.id = seriePrefUser.idSerie 
                      INNER JOIN user ON user.id = seriePrefUser.idUser
                      WHERE email= :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam('email', $email);
            $stmt->execute();

            while ($data = $stmt->fetch()){
                $html = $html .  "<img class='img-serie' src='" . "img/" . $data["img"]. "' width='150' height='150'> " . "<a href='?action=displaySerie&id=" . $data["id"] . "'>" . $data["titre"] . "</a> <br>";
            }

            return $html;
        }

        return $html . "Favorites series do not exist";
        /*
        $html = "";
        $html = $html . $_SESSION['mail'];

        return $html;
        */
    }
}