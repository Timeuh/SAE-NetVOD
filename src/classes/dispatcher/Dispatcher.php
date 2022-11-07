<?php

namespace iutnc\netvod\dispatcher;

use iutnc\netvod\action\SigninAction;

class Dispatcher{

    private ?string $action;

    public function __construct(){
        $this->action = $_GET['action'] ?? "";
    }

    public function run() : void {
        switch ($this->action){

            case "signin":
                $res = new SigninAction();
                break;

            case "add-user":
                break;

            case "displayCatalogue":
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
        <meta charset='UTF-8' />
        </head> 
        <body>
        <h1>NetVOD</h1>
        $HTML
        </body>
        </html>";
    }
}