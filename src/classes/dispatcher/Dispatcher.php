<?php

namespace iutnc\netvod\dispatcher;

class Dispatcher{

    private ?string $action;

    public function __construct(){
        $this->action = $_GET['action'] ?? "";
    }

    public function run() : void {
        switch ($this->action){
            default: $res = "<h1>Bienvenue !</h1>";
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
        <nav>
            <li><a href='.'>Accueil</a></li>
        </nav>
        $HTML
        </body>
        </html>";
    }
}