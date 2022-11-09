<?php

namespace iutnc\netvod\dispatcher;

use iutnc\netvod\action\AddEnCoursAction;
use iutnc\netvod\action\AddPrefAction;
use iutnc\netvod\action\AddUserAction;
use iutnc\netvod\action\CommentAction;
use iutnc\netvod\action\DisplayCatalogue;
use iutnc\netvod\action\DisplayCommentaireAction;
use iutnc\netvod\action\DisplayEpisodeAction;
use iutnc\netvod\action\DisplaySerieAction;
use iutnc\netvod\action\DisplaySerieEnCoursAction;
use iutnc\netvod\action\DisplaySeriePrefAction;
use iutnc\netvod\action\LogoutAction;
use iutnc\netvod\action\RechercheAction;
use iutnc\netvod\action\SigninAction;
use iutnc\netvod\action\DelPrefAction;
use iutnc\netvod\action\ModifierProfileAction;

class Dispatcher{

    private ?string $action;
    private string $icon;
    private string $style;

    public function __construct(string $icon, string $style){
        $this->action = $_GET['action'] ?? "";
        $this->icon = $icon;
        $this->style = $style;
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

            case "modifierProfil":
                $modifUser = new ModifierProfileAction();
                $res = $modifUser->execute();
                break;

            case "displaySerie":
                $serie = new DisplaySerieAction();
                $res = $serie->execute();
                break;

            case "displayCatalogue":
                $catalogue = new DisplayCatalogue();
                $res = $catalogue->execute();
                break;

            case "displayEpisode":
                $addEnCours = new AddEnCoursAction();
                $res = $addEnCours->execute();
                $episode = new DisplayEpisodeAction();
                $res = $episode->execute();
                break;

            case "add-pref":
                $pref = new AddPrefAction();
                $res = $pref->execute();
                break;

            case "del-pref":
                $pref = new DelPrefAction();
                $res = $pref->execute();
                break;

            case "displaySeriePref":
                $seriePref = new DisplaySeriePrefAction();
                $res = $seriePref->execute();
                break;

            case "displaySerieEnCours":
                $serieEnCours = new DisplaySerieEnCoursAction();
                $res = $serieEnCours->execute();
                break;

            case "displayCommentaire":
                $comment = new DisplayCommentaireAction();
                $res = $comment->execute();
                break;

            case "rechercher":
                $rechercher = new RechercheAction();
                $res = $rechercher->execute();
                break;

            case "logout":
                $deco = new LogoutAction();
                $res = $deco->execute();
                break;

            case "comment":
                $comm = new CommentAction();
                $res = $comm->execute();
                break;

            default:
                if (isset($_SESSION['user'])) $res = "<p>Vous êtes connecté(e)</p><br>
                                                      <a href='?action=modifierProfil'>Modifier Profil</a> <br> <br>
                                                      <a href='?action=displayCatalogue'>Catalogue</a> <br> <br>
                                                      <a href='?action=displaySeriePref'>Séries Favorites</a> <br> <br>
                                                      <a href='?action=displaySerieEnCours'>Séries En Cours</a> <br> <br>
                                                      <a href='?action=logout'>Deconnexion</a>";

                else $res = "<h1>Bienvenue !</h1><a href='index.php'>Accueil</a> 
                        <br><br><a href='?action=signin'> Connexion </a><br><br>
                        <a href='?action=add-user'> Inscription </a>";
        }
        $this->renderPage($res);
    }

    public function renderPage(string $HTML) : void{
        print "<!DOCTYPE html>
        <html lang='fr'> 
        <head>
        <title>NetVOD</title>
        <meta charset='UTF-8'/>
        <link rel='stylesheet' href='$this->style'>
        <link rel='icon' type='image/png' href='$this->icon'>
        </head> 
        <body>
        <div id='title'>
            <img src='$this->icon' alt='logo du site'/>
            <h1>NetVOD</h1>
        </div>
        $HTML
        </body>
        </html>";
    }
}