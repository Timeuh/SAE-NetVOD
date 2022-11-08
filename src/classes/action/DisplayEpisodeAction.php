<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplayEpisodeAction extends Action
{
    public function execute(): string
    {
        $bd = ConnectionFactory::makeConnection();
        $query = "select titre, duree, resume, file from episode where id = :id";
        $get = $bd->prepare($query);
        $id = $_GET['id'];
        $get->bindParam(':id', $id);
        $get->execute();
        $info = $get->fetch();
        $html = "<h2> $info[titre] </h2>
                <p>durée: $info[duree] minutes</p>
                <p>$info[resume]</p>
                <embed src='video/$info[file]' autostart=true>";
        return $html;
    }
}