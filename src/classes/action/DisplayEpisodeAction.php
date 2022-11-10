<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplayEpisodeAction extends Action{
    public function execute(): string{
        if (($bd = ConnectionFactory::makeConnection()) != null) {
            $query = "select titre, duree, resume, file, serie_id from episode where id = :id";
            $get = $bd->prepare($query);
            $idEp = $_GET['id'];
            $get->bindParam(':id', $idEp);
            $get->execute();
            $info = $get->fetch();
            $serie = $info['serie_id'];
            return "<a href='?action=displaySerie&id=$serie'><button class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retour</button></a> <br> <br>
                    <h1 class='text-3xl'> $info[titre] </h1>
                    <p>durée: <span class='text-yellow-500'>$info[duree] minutes</span></p>
                    <p>$info[resume]</p>
                    <embed src='video/$info[file]' autostart=true height='400' width='700' class='m-0 p-0'>
                    <a href='?action=comment&id=$idEp'><button class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600 mr-5'>Commenter</button></a>";
        }
        return "<h2>Erreur de connexion</h2><br><a href='Index.php'>Retour à l'accueil</a>";
    }
}