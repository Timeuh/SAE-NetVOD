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

    #TODO : Remplir la serie avec les episodes correspondant
    public function __construct($id, $titre, $resume, $img, $annee, $dateAjout)
    {
        $this->id=$id;
        $this->titre=$titre;
        $this->resume=$resume;
        $this->img=$img;
        $this->annee=$annee;
        $this->dateAjout=$dateAjout;
    }


}