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

    function calculerMoyenne($idSerie) : ?float
    {
        $bd = ConnectionFactory::makeConnection();

        if ($bd != null ){

            $query = "SELECT AVG(note) as moyenne FROM commentaire WHERE idSerie=:idSerie";
            $stmt = $bd->prepare($query);
            $stmt->bindParam("idSerie", $idSerie);
            $stmt->execute();

            $data = $stmt->fetch();

            if ($data === null){
                return 0;
            } else {
                return $data['moyenne'];
            }


        }

        return 0;
    }

    public function render() : string {
        $nbEp = count($this->episodes);
        $list = "";
        $moy = $this->calculerMoyenne($this->id);
        foreach ($this->episodes as $key => $value) $list = $list . "<li>" . $value->render($this->img) . "</li><br>";

        $delButton = "";
        if(($bd = ConnectionFactory::makeConnection()) != null){
            $idSerie = unserialize($_SESSION['idSerie']);
            $user = unserialize($_SESSION['user']);
            $idUser = $user->__get('id');

            $query = $bd->prepare("select idSerie from seriepref where idUser = ? and idSerie = ?");
            $query->bindParam(1, $idUser);
            $query->bindParam(2, $idSerie);
            $query->execute();
            if($query->fetch()){
                $delButton = "<a href='?action=del-pref'><button class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retirer des favoris</button></a>";
            }
        }

        return "<div id='serie'>
                    <a href='?action=displayCatalogue'><button class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retour</button></a> <br> <br>
                    <h1 class='text-3xl'>$this->titre</h1>
                    <p> <span class='text-yellow-500'> $nbEp ??pisodes</span> , Ajout?? le 
                    <span class='text-yellow-500'>$this->dateAjout</span>, sortie en 
                    <span class='text-yellow-500'>$this->annee</span><br><br>
                    Genre : <span class='text-yellow-500'>$this->genre</span>
                    , Public : <span class='text-yellow-500'>$this->public</span><br><br>
                    R??sum?? : <span class='text-yellow-500'>$this->resume</span><br> <br>
                    
                    Note : <span class='text-yellow-500'>$moy/5</span></p> <br>

                    <a href='?action=displayCommentaire'><button class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Afficher Commentaire</button></a> <br> <br>
                    <a href='?action=add-pref'><button class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600 mr-5'>Ajouter aux favoris</button></a>
                    $delButton <br> <br>
                    <h3>??pisodes :</h3>$list
                </div>";
    }
}