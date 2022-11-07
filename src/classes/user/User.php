<?php

namespace iutnc\deefy\user;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\db\ConnectionFactory;

class User {

    private ?string $email, $passwd, $role;

    public function __construct($email, $passwd, $role){
        $this->email = $email;
        $this->passwd = $passwd;
        $this->role = $role;
    }

    public function __set(string $name, $value): void {
        if (property_exists($this, $name)) $this->$name = $value;
    }

    public function __get(string $name) : mixed{
        if (isset($this->$name)) return $this->$name;
        return null;
    }

    public function getPlaylists() : ?array {
        $bd = ConnectionFactory::makeConnection();
        $idUser = "select id from user where email = :email";
        $query = "select id_pl from user2playlist where id_user = :user";
        $playlist = [];

        $list = $bd->prepare($query);
        $id = $bd->prepare($idUser);

        $id->bindParam(':email', $this->email);
        $id->execute();

        $user = $id->fetch()['id'];
        $list->bindParam(':user', $user);
        $list->execute();

        while ($data = $list->fetch()){
            $pl = "select nom from playlist where id = :id";
            $res = $bd->prepare($pl);
            $res->bindParam(':id',$data['id_pl']);
            $res->execute();

            while ($result = $res->fetch()){
                $playlist[] = new Playlist($result['nom']);
            }
        }
        return $playlist;
    }
}