<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DelPrefAction extends Action
{

    public function execute(): string
    {
        $idSerie = unserialize($_SESSION['idSerie']);
        $user = unserialize($_SESSION['user']);
        $idUser = $user->__get('id');

        if(($bd = ConnectionFactory::makeConnection())!=null){
            $delete = $bd->prepare("delete from seriepref where idUser = ? and idSerie = ?");
            $delete->bindParam(1,$idUser);
            $delete->bindParam(2,$idSerie);
            if($delete->execute()) return "<p>Votre série a bien été retirée de votre liste des préférences</p>
                                                <br><a href='?action=displayCatalogue'>Retour au catalogue</a></br>";
        }
        return "<p>Il y a eu un problème lors du retrait de la série de votre liste des préférences,
                veuillez réessayer</p><br><a href='?action=displayCatalogue'>Retour au catalogue</a></br>";
    }
}