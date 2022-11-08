<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplayEpisodeAction extends Action
{
    public function execute(): string
    {
        if (($bd = ConnectionFactory::makeConnection()) != null) {
            $query = "select titre, duree, resume, file from episode where id = :id";
            $get = $bd->prepare($query);
            $id = $_GET['id'];
            $get->bindParam(':id', $id);
            $get->execute();
            $info = $get->fetch();
            $html = "<h2> $info[titre] </h2>
                    <p>durée: $info[duree] minutes</p>
                    <p>$info[resume]</p>
                    <embed src='video/$info[file]' autostart=true>
                    <a href='?action=comment&id=$id'><button>Commenter</button></a>";
            return $html;
        }
    }
}