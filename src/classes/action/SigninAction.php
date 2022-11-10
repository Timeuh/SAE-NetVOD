<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;

class SigninAction extends Action {

    public function execute() : string {
        $html = "";
        if($this->http_method === "GET") {
            $html = "
                <form method='post'>
                    <label>Email: </label><input type='text' name='email' placeholder='toto@gmail.com' required>
                    <label>Password: </label><input type='password' name='password' placeholder='example' required>
                    <button type='submit'>Valider</button>
                </form>";
        }
        elseif ($this->http_method === "POST") {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $passwd = $_POST['password'];
            $user = Auth::authenticate($email, $passwd);
            if ($user != null) {
                $html = "<script>document.location.href='index.php'</script>";
            } else {
                $html = "<p>Votre email ou mot de passe est incorrect</p><br><a href='index.php'>Accueil</a>";
            }
        }
        return $html;
    }
}