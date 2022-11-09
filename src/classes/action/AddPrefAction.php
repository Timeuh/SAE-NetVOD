<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class AddPrefAction extends \iutnc\netvod\action\Action
{

    public function execute(): string
    {
        $idSerie = unserialize($_SESSION['idSerie']);
        $user = unserialize($_SESSION['user']);
        $idUser = $user->__get('id');

        if(($bd = ConnectionFactory::makeConnection())!=null){
            $query = $bd->prepare("select idSerie from seriePrefUser where idUser = ? and idSerie = ?");
            $query->bindParam(1, $idUser);
            $query->bindParam(2, $idSerie);
            $query->execute();

            if(!$query->fetch()){
                $insert = $bd->prepare("insert into seriePrefUser(idUser, idSerie) values (?,?)");
                $insert->bindParam(1,$idUser);
                $insert->bindParam(2,$idSerie);
                if($insert->execute()) return "<p>Votre série a bien été ajoutée à votre liste des préférences</p>
                                                <br><a href='?action=displayCatalogue'>Retour au catalogue</a></br>";
            }else return "<p>Vous avez déjà ajouté cette série à votre liste des préférences</p>
                            <br><a href='?action=displayCatalogue'>Retour au catalogue</a></br>";
        }
        return "<p>Il y a eu un problème lors de l'ajout de la série dans votre liste des préférences,
                veuillez réessayer</p><br><a href='?action=displayCatalogue'>Retour au catalogue</a></br>";
    }
}