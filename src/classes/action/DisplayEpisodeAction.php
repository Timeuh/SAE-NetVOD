<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class DisplayEpisodeAction extends Action {
    public function execute() : string {
        $id = $_GET['id'];
    }
}