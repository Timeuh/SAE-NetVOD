<?php

namespace iutnc\netvod\dispatcher;

use iutnc\netvod\action\AddUserAction;
use iutnc\netvod\action\DisplayCatalogue;
use iutnc\netvod\action\DisplayEpisodeAction;
use iutnc\netvod\action\DisplaySerieAction;
use iutnc\netvod\action\SigninAction;

class Dispatcher{

    private ?string $action;
    private string $icon;

    public function __construct(string $icon){
        $this->action = $_GET['action'] ?? "";
        $this->icon = $icon;
    }

    public function run() : void {
        switch ($this->action){

            case "signin":
                $signin = new SigninAction();
                $res = $signin->execute();
                break;

            case "add-user":
                $adduser = new AddUserAction();
                $res = $adduser->execute();
                break;

            case "displaySerie":
                $serie = new DisplaySerieAction();
                $res = $serie->execute();
                break;

            case "displayCatalogue":
                $catalogue = new DisplayCatalogue();
                $res = $catalogue->execute();
                break;

            case "displayEpisodeAction":
                $episode = new DisplayEpisodeAction();
                $res = $episode->execute();
                break;

            case "logout":
                break;

            default:
                $res = "<h1>Bienvenue !</h1>";
                $res = $res . "<a href='index.php'>Accueil</a> <br> <br>";
                $res = $res . "<a href='?action=signin'> Connexion </a>" . "<br> <br>";
                $res = $res . "<a href='?action=add-user'> Inscription </a>";
        }
        $this->renderPage($res);
    }

    public function renderPage(string $HTML) : void{
        print "<!DOCTYPE html>
        <html lang='fr'> 
        <head>
        <title>NetVOD</title>
        <meta charset='UTF-8'/>
        <link rel='icon' type='image/png' href='$this->icon'>
        </head> 
        <body>
        <h1>NetVOD</h1>
        $HTML
        </body>
        </html>";
    }
}