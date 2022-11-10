<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class RechercheAction extends Action
{
    public function execute(): string
    {
        $html = "<a href='?action=' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'> Accueil </a> <br> <br>
                      <form method='post' action='?action=rechercher'>
                        <input type='search' id='recherche' name='recherche' class='border-2 rounded-md bg-grey-300 text-black'
                        placeholder='Rechercher...' size='150'>
                        <button type='submit' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Rechercher</button>
                      </form> <br>";
        if (($bd = ConnectionFactory::makeConnection()) != null) {
            $titre = "%".filter_var($_POST['recherche'],FILTER_SANITIZE_SPECIAL_CHARS)."%";
            $query = "select id, titre, img from serie where titre like :titre";
            $get = $bd->prepare($query);
            $get->bindParam(':titre', $titre);
            $get->execute();
            while ($data = $get->fetch()){
                $html = $html .  "<img class='img-serie' src='" . "img/" . $data["img"]. "'width='400' height='400'> " . "<a href='?action=displaySerie&id=" . $data["id"] . ">" . $data["titre"] . "</a> <br> <br>";
            }
        }
        return $html;
    }
}