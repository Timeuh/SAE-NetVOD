<?php

namespace iutnc\netvod\user;

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
}