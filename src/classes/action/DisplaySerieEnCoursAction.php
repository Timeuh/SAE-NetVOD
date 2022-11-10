<?php

namespace iutnc\netvod\action;

use iutnc\netvod\appli\Serie;
use iutnc\netvod\db\ConnectionFactory;

class   DisplaySerieEnCoursAction
{
    public function execute(): string
    {
        $html = "<a href='?action=' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'> Accueil </a> <br> <br>";
        $bd = ConnectionFactory::makeConnection();
        if ($bd != null){
            $user = unserialize($_SESSION['user']);
            $email = $user->__get('email');
            $query = "select id from user where email =:email";
            $get = $bd->prepare($query);
            $get->bindParam(':email', $email);
            $get->execute();
            $infoUser = $get->fetch();
            $query = "select id, titre, img from serie inner join serieencours on serie.id = serieencours.idSerie where id = idSerie and iduser =:iduser";
            $get = $bd->prepare($query);
            $get->bindParam(':iduser', $infoUser['id']);
            $get->execute();
            while ($data = $get->fetch()){
                $html = $html .  "<img class='img-serie' src='" . "img/" . $data["img"]. "' width='400' height='400'> " . "<a href='?action=displaySerie&id=" . $data["id"] . "'><button class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600 mt-1'>" . $data["titre"] . " </button> </a> <br>";
            }
        }
        return $html;
    }
}