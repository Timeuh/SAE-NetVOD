<?php

namespace iutnc\netvod\appli;

class Episode
{
    protected ?int $id;
    protected ?int $numero;
    protected ?String $titre;
    protected ?String $resume;
    protected ?int $duree;
    protected ?String $file;
    protected ?int $serieId;

    public function __construct($id, $num, $titre, $resume, $duree, $file, $serieId)
    {
        $this->id=$id;
        $this->numero=$num;
        $this->titre=$titre;
        $this->resume=$resume;
        $this->duree=$duree;
        $this->file=$file;
        $this->serieId=$serieId;
    }

    public function __set(string $name, $value): void {
        if (property_exists($this, $name)) $this->$name = $value;
    }

    public function __get(string $name) : mixed{
        if (isset($this->$name)) return $this->$name;
        return null;
    }

    public function render() : string {
        return "<a href='?action=displayEpisodeAction&id=$this->id'>Epidode $this->numero : $this->titre </a>
                <br>$this->resume<br><img src='$this->file' alt='illustration de la vidéo'>";
    }
}