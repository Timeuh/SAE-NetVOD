<?php

namespace iutnc\netvod\appli;

use iutnc\netvod\db\ConnectionFactory;

class Serie
{
    protected ?int $id;
    protected ?String $titre;
    protected ?String $resume;
    protected ?String $img;
    protected ?int $annee;
    protected ?String $dateAjout;
    protected ?string $genre;
    protected ?string $public;
    protected array $episodes = [];

    public function __construct($id, $titre, $resume, $annee, $dateAjout, $img, $genre, $public)
    {
        $this->id=$id;
        $this->titre=$titre;
        $this->resume=$resume;
        $this->annee=$annee;
        $this->dateAjout=$dateAjout;
        $this->img = $img;
        $this->genre = $genre;
        $this->public = $public;
        $this->episodes= [];
    }

    public function __get(string $name) : mixed{
        if (isset($this->$name)) {
            return $this->$name;
        }
        return null;
    }

    public function getEpisodes() : bool{
        if (($bd = ConnectionFactory::makeConnection()) != null){
            $query = $bd->prepare("select id, numero, titre, resume, duree, file from episode where serie_id = :id");
            $query->bindParam(':id', $this->id);
            $query->execute();

            while ($data = $query->fetch()){
                $ep = new Episode($data['id'], $data['numero'], $data['titre'], $data['resume'],
                    $data['duree'], $data['file'], $this->id);
                $this->episodes[] = $ep;
            }
            return true;
        }
        return false;
    }

    public function render() : string {
        $nbEp = count($this->episodes);
        $list = "";
        foreach ($this->episodes as $key => $value) $list = $list . "<li>" . $value->render($this->img) . "</li><br>";

        return "<div id='serie'>
                    <h3>$this->titre</h3> $nbEp épisodes,
                    Ajouté le $this->dateAjout, sortie en $this->annee<br><br>
                    Genre : $this->genre, Public : $this->public<br><br>
                    Résumé : $this->resume<br><br>

                    <a href='?action=displayCommentaire'>Afficher Commentaire</a> <br> <br>
                    <a href='?action=add-pref'><button>Ajouter aux favoris</button></a>
                    <h3>Épisodes :</h3>$list
                </div>";
    }
}