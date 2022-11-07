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
            $passwd = filter_var($_POST['password']);
            if (Auth::authenticate($email, $passwd)) {
                $html = "Youre connected";
            } else {
                $html = "Your email or password is incorrect";
            };
        }
        return $html;
    }
}