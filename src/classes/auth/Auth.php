<?php

namespace iutnc\netvod\auth;

use iutnc\netvod\db\ConnectionFactory;
use iutnc\netvod\user\User;

class Auth {

    public static function authenticate(string $email, string $password): ?User {
        $pdo = ConnectionFactory::makeConnection();
        if (!filter_var($email, FILTER_SANITIZE_EMAIL)) return null;
        $getPass = "select passwd, role from user where email = :email";
        $req = $pdo->prepare($getPass);
        $req->bindParam(':email', $email);
        $req->execute();

        while ($data = $req->fetch()) {
            $bdHash = $data['passwd'];
            $role = $data['role'];
            if (password_verify($password, $bdHash)){
                $user = new User($email, $bdHash, $role);
                $_SESSION['user'] = $user;
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
                $newPass = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
                $insert = "insert into user(email, passwd) values(:email, :password)";
                $do = $bd->prepare($insert);

                $do->bindParam(':email', $email);
                $do->bindParam(':password', $newPass);
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

    public static function verify_user(int $playlistId) : bool {
        $user = $_SESSION['user'] ?? null;
        if ($user != null) {
            $bd = ConnectionFactory::makeConnection();
            $mail = $user->email;
            $role = $user->role;
            if ($role == 100) return true;

            $userId = $bd->prepare("select id from user where email = :email");
            $userId->bindParam(':email',$mail);
            $userId->execute();
            $id = $userId->fetch()['id'];

            $request = $bd->prepare("select id_pl from user2playlist where id_user = :user");
            $request->bindParam('user', $id);
            $request->execute();

            while ($data = $request->fetch()){
                if ($data['id_pl'] == $playlistId) return true;
            }
        }
        return false;
    }
}