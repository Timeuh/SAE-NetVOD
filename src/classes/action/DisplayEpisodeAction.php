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
            return "<h2> $info[titre] </h2>
                    <p>durée: $info[duree] minutes</p>
                    <p>$info[resume]</p>
                    <embed src='video/$info[file]' autostart=true><br>
                    <a href='?action=comment&id=$idEp'><button>Commenter</button></a>
                    <br><a href='?action=displaySerie&id=$serie'><button>Retour</button></a>";
        }
        return "<h2>Erreur de connexion</h2><br><a href='Index.php'>Retour à l'accueil</a>";
    }
}