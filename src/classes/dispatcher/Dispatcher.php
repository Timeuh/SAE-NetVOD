<?php

namespace iutnc\deefy\dispatcher;

use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddPodcastTrackAction;
use iutnc\deefy\action\AddUserAction;
use iutnc\deefy\action\DisplayPlaylistAction;
use iutnc\deefy\action\SignInAction;

class Dispatcher{

    private ?string $action;

    public function __construct(){
        $this->action = $_GET['action'] ?? "";
    }

    public function run() : void {
        switch ($this->action){
            case 'add-user':
                $addUser = new AddUserAction();
                $res = $addUser->execute();
                break;

            case 'add-podcasttrack':
                $podcast = new AddPodcastTrackAction();
                $res = $podcast->execute();
                break;

            case 'add-playlist':
                $add = new AddPlaylistAction();
                $res = $add->execute();
                break;

            case 'signin':
                $signin = new SignInAction();
                $res = $signin->execute();
                break;

            case 'display-playlist':
                $display = new DisplayPlaylistAction();
                $res = $display->execute();
                break;

            default: $res = "<h1>Bienvenue !</h1>";
        }
        $this->renderPage($res);
    }

    public function renderPage(string $HTML) : void{
        print "<!DOCTYPE html>
        <html lang='fr'> 
        <head>
        <title>Deefy</title>
        <meta charset='UTF-8' />
        </head> 
        <body>
        <h1>Deefy</h1>
        <nav>
            <li><a href='.'>Accueil</a></li>
            <li><a href='?action=add-user'>Inscription</a></li>
            <li><a href='?action=add-playlist'>Creer une playlist</a></li>
            <li><a href='?action=signin'>Connexion</a></li>
        </nav>
        $HTML
        </body>
        </html>";
    }
}