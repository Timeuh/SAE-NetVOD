<?php

namespace iutnc\netvod\user;

use iutnc\netvod\db\ConnectionFactory;

class User {

    private ?string $email, $passwd, $role;
    private ?int $id;

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

    public function setId() : bool {
        if (($db = ConnectionFactory::makeConnection()) != null){
            $query = $db->prepare("select id from user where email = :email");
            $query->bindParam(':email', $this->email);
            $query->execute();

            $res = $query->fetch();
            $id = $res['id'] ?? 0;
            if ($id != 0){
                $this->id = $id;
                return true;
            }
        }
        return false;
    }
}