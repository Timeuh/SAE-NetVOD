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
                    <button type='submit'>Validate</button>
                </form>";
        }
        elseif ($this->http_method === "POST") {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $passwd = $_POST['password'];
            $user = Auth::authenticate($email, $passwd);
            if ($user != null) {
                $html = "<p>Vous êtes connecté(e)</p>
                         <a href='?action=modifierProfil'>Modifier Profil</a> <br> <br>
                         <a href='?action=displayCatalogue'>Catalogue</a> <br> <br>
                         <a href='?action=displaySeriePref'>Séries Favorites</a> <br> <br>
                         <a href='?action=displaySerieEnCours'>Séries En Cours</a> <br> <br>
                         <a href='?action=logout'>Deconnexion</a>";
            } else {
                $html = "Votre email ou mot de passe est incorrect";
            }
        }
        return $html;
    }
}