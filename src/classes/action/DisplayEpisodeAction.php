<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplayEpisodeAction extends Action
{
    public function execute(): string
    {
        $bd = ConnectionFactory::makeConnection();
        $query = "select titre, duree, resume from episode where id = :id";
        $get = $bd->prepare($query);
        $id = $_GET['id'];
        $get->bindParam(':id', $id);
        $get->execute();
        $info = $get->fetch();
        $html = "<h1> $info[titre] </h1>
                <p>$info[duree]</p>
                <p>$info[resume]</p>";
        return $html;
    }
}