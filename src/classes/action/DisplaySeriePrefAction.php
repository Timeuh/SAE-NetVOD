<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplaySeriePrefAction extends Action
{

    public function execute(): string
    {

        $user = unserialize($_SESSION['user']);
        $email = $user->__get("email");

        $html = "<a href='?action=' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'> Accueil </a> <br> <br>";

        $db = ConnectionFactory::makeConnection();

        if ($db != null){
            $query = "SELECT serie.id, img, titre FROM serie 
                      INNER JOIN seriepref ON serie.id = seriepref.idSerie 
                      INNER JOIN user ON user.id = seriepref.idUser
                      WHERE email= :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam('email', $email);
            $stmt->execute();

            while ($data = $stmt->fetch()){
                $html = $html .  "<img class='img-serie' src='" . "img/" . $data["img"]. "' width='400' height='400'> " . "<a href='?action=displaySerie&id=" . $data["id"] . "'><button class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600 mt-1'>" . $data["titre"] . "</button> </a> <br>";
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