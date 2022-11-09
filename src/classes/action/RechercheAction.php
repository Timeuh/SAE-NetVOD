<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class RechercheAction extends Action
{
    public function execute(): string
    {
        $html = "<a href='?action='> Accueil </a> <br> <br>
                      <form method='post' action='?action=rechercher'>
                        <input type='search' id='recherche' name='recherche'
                        placeholder='Rechercher...'>
                        <button type='submit'>Rechercher</button>
                      </form>";
        if (($bd = ConnectionFactory::makeConnection()) != null) {
            $titre = "%".$_POST['recherche']."%";
            $query = "select id, titre, img from serie where titre like :titre";
            $get = $bd->prepare($query);
            $get->bindParam(':titre', $titre);
            $get->execute();
            while ($data = $get->fetch()){
                $html = $html .  "<img class='img-serie' src='" . "img/" . $data["img"]. "' width='150' height='150'> " . "<a href='?action=displaySerie&id=" . $data["id"] . "'>" . $data["titre"] . "</a> <br>";
            }
        }
        return $html;
    }
}