<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;

class SigninAction extends Action {

    public function execute() : string {
        $html = "";
        if($this->http_method === "GET") {
            $html = "
                <div class='text-center'>
                <form method='post' class='text-center flex flex-wrap content-center flex-col'>
                    <label>Identifiant : </label><input type='email' name='email' placeholder='toto@gmail.com' required class='text-black border-2 rounded-md border-yellow-500 mb-4'>
                    <label>Mot de passe : </label><input type='password' name='password' placeholder='mot de passe' required class='text-black border-2 rounded-md border-yellow-500 mb-4'>
                    <button type='submit' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Valider</button>
                </form>
                <br><a href='index.php' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Accueil</a>
                </div>";
        }
        elseif ($this->http_method === "POST") {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $passwd = $_POST['password'];
            $user = Auth::authenticate($email, $passwd);
            if ($user != null) {
                $html = "<script>document.location.href='index.php'</script>";
            } else {
                $html = "<div class='text-center text-red-600'>
                <p class='text-2xl '>Votre email ou mot de passe est incorrect</p><br>
                <a href='?action=signin' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600 text-white'>Retour</a>
                </div>";
            }
        }
        return $html;
    }
}