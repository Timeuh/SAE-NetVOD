<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class AddPrefAction extends \iutnc\netvod\action\Action
{

    public function execute(): string
    {
        $serie = $_GET['id'];
        $user = unserialize($_SESSION['user']);
        if(($bd = ConnectionFactory::makeConnection())!=null){
            $insert = $bd->prepare("insert into serieprefuser(idUser, idSerie) values (?,?)");
            $insert->bindParam(1,$user->id);
            $insert->bindParam(2,$serie);
            if($insert->execute()) return "<p>Votre série a bien été ajoutée à votre liste des préférences</p><br><a href='?action=displayCatalogue'>Retour au catalogue</a></br>";
        }
        return "<p>Il y a eu un problème lors de l'ajout de la série dans votre liste des préférences, veuillez réessayer</p><br><a href='?action=displaySerie'>Revenir à la page de la série</a></br>";
    }
}