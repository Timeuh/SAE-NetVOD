<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class AddEnCoursAction extends Action
{
    public function execute(): string
    {
        $msg = "";
        if (($bd = ConnectionFactory::makeConnection()) != null) {
            $idEp = $_GET['id'];
            $query = "select serie_id from episode where id =:id";
            $get = $bd->prepare($query);
            $get->bindParam(':id', $idEp);
            $get->execute();
            $idSerie = $get->fetch();
            $user = unserialize($_SESSION['user']);
            $email = $user->__get('email');
            $query = "select id from user where email =:email";
            $get = $bd->prepare($query);
            $get->bindParam(':email', $email);
            $get->execute();
            $infoUser = $get->fetch();
            $query = " select idSerie, idUser from serieEnCoursUser where idSerie=:idSerie and idUser=:idUser";
            $get = $bd->prepare($query);
            $get->bindParam(':idSerie', $idSerie['serie_id']);
            $get->bindParam(':idUser', $infoUser['id']);
            $get->execute();
            if(!$get->fetch()) {
                $query = "insert into serieEnCoursUser(idSerie, idUser) values($idSerie[serie_id], $infoUser[id])";
                $get = $bd->prepare($query);
                $get->execute();
                $msg = "Série bien ajouté";
            }
        }
        return $msg;
    }
}