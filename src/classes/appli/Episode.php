<?php

namespace iutnc\netvod\appli;

class Episode
{
    protected $numero;
    protected $titre;
    protected $resume;
    protected $duree;
    protected $file;
    protected $serieId;

    public function __construct($num, $titre, $resume, $duree, $file, $serieId)
    {
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

}