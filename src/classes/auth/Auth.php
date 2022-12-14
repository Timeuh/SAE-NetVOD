<?php

namespace iutnc\netvod\auth;

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\user\User;

class Auth {

    public static function authenticate(string $email, string $password): ?User {
        $pdo = ConnectionFactory::makeConnection();
        if (!filter_var($email, FILTER_SANITIZE_EMAIL)) return null;
        $getPass = "select passwd, role , active from user where email = :email";
        $req = $pdo->prepare($getPass);
        $req->bindParam(':email', $email);
        $req->execute();

        while ($data = $req->fetch()) {
            $bdHash = $data['passwd'];
            $role = $data['role'];
            $actif = $data['active'];
            if (password_verify($password, $bdHash) && $actif == 1){
                $user = new User($email, $bdHash, $role);
                $user->setId();
                $_SESSION['user'] = serialize($user);
                return $user;
            }
        }
        return null;
    }

    public static function register(string $email, string $password): bool {
        $bd = ConnectionFactory::makeConnection();
        $query = "select id from user where email = :email";
        $get = $bd->prepare($query);

        if (filter_var($email, FILTER_SANITIZE_EMAIL)) {
            $get->bindParam(':email', $email);
            $get->execute();
            if (!$get->fetch()) {

                // Token d'activation de compte
                $active = 0;
                $activateToken = bin2hex(random_bytes(64));
                $renewToken = bin2hex(random_bytes(64));
                $activationExpires = date('Y-m-d H:i:s',time() + 60*60);
                $activationRenew = date('Y-m-d H:i:s',time() + 60*15);

                $newPass = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
                $insert = "insert into user(email, passwd, active, activation_token, activation_expires, renew_token, renew_expires) 
                           values(:email, :password, :active, :actiT, :actiE, :renewT, :renewE)";
                $do = $bd->prepare($insert);

                $do->bindParam(':email', $email);
                $do->bindParam(':password', $newPass);
                $do->bindParam(':active', $active);
                $do->bindParam(':actiT', $activateToken);
                $do->bindParam(':actiE', $activationExpires);
                $do->bindParam(':renewT', $renewToken);
                $do->bindParam(':renewE', $activationRenew);

                $do->execute();

                return true;
            }
        }
        return false;
    }

    public static function checkPassword(string $password, int $length): bool {
        $goodLength = strlen($password) < $length;
        $digit = preg_match("#\d#", $password);
        $special = preg_match("#\W#", $password);
        $lower = preg_match("#[a-z]#", $password);
        $upper = preg_match("#[A-Z]#", $password);
        if ($goodLength || !$digit || !$special || !$lower || !$upper) return false;
        return true;
    }
}