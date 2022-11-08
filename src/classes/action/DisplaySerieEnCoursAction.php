<?php

namespace iutnc\netvod\action;

use iutnc\netvod\appli\Serie;
use iutnc\netvod\db\ConnectionFactory;

class DisplaySerieEnCoursAction
{
    public function execute(): string
    {
        $html = "<a href='?action='> Accueil </a> <br> <br>";
        $bd = ConnectionFactory::makeConnection();
        if ($bd != null){
            $user = unserialize($_SESSION['user']);
            $email = $user->__get('email');
            $query = "select id from user where email =:email";
            $get = $bd->prepare($query);
            $get->bindParam(':email', $email);
            $get->execute();
            $infoUser = $get->fetch();
            $query = "select id, titre, descriptif, annee, date_ajout, img, genre, public from serie inner join serieencoursuser on serie.id = serieencoursuser.idSerie where id = idSerie and iduser =:iduser";
            $get = $bd->prepare($query);
            $get->bindParam(':iduser', $infoUser['id']);
            $get->execute();
            while ($data = $get->fetch()){
                $html = $html .  "<img class='img-serie' src='" . "img/" . $data["img"]. "' width='150' height='150'> " . "<a href='?action=displaySerie&id=" . $data["id"] . "'>" . $data["titre"] . "</a> <br>";
            }
        }
        return $html;
    }
}