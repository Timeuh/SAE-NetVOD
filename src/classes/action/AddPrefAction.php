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
            $query = $bd->prepare("select idSerie from seriepref where idUser = ? and idSerie = ?");
            $query->bindParam(1, $idUser);
            $query->bindParam(2, $idSerie);
            $query->execute();

            if(!$query->fetch()){
                $insert = $bd->prepare("insert into seriepref(idUser, idSerie) values (?,?)");
                $insert->bindParam(1,$idUser);
                $insert->bindParam(2,$idSerie);
                if($insert->execute()) return "<a href='?action=displayCatalogue' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retour au catalogue</a> </br> <br>
                                               <p>Votre série a bien été ajoutée à votre liste des préférences</p>";
            }else return "<a href='?action=displayCatalogue' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retour au catalogue</a></br> <br>
                          <p>Vous avez déjà ajouté cette série à votre liste des préférences</p>";
        }
        return "<a href='?action=displayCatalogue'>Retour au catalogue</a><br> <br>
                <p>Il y a eu un problème lors de l'ajout de la série dans votre liste des préférences, veuillez réessayer</p>";
    }
}