<?php

namespace iutnc\netvod\appli;

class Serie
{
    protected ?int $id;
    protected ?String $titre;
    protected ?String $resume;
    protected ?String $img;
    protected ?int $annee;
    protected ?String $dateAjout;
    protected array $episodes = [];

    public function __construct($id, $titre, $resume, $img, $annee, $dateAjout, $episodes = [])
    {
        $this->id=$id;
        $this->titre=$titre;
        $this->resume=$resume;
        $this->img=$img;
        $this->annee=$annee;
        $this->dateAjout=$dateAjout;
        $this->episodes=$episodes;
    }

    public function __get(string $name) : mixed{
        if (isset($this->$name)) {
            return $this->$name;
        }
        return null;
    }


}