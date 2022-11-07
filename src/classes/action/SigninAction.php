<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;

class SigninAction extends Action {

    public function execute() : string {
        $html = "";
        if($_SERVER['REQUEST_METHOD'] === "GET") {
            $html = "<<<HTML
                <form action='?action=${_GET['action']}' method='post'>
                    <label>Email: </label><input type='text' name='email' placeholder='toto@gmail.com' required>
                    <label>Password: </label><input type='password' name='password' required>
                    <button type='submit'>Validate</button>
                </form>
            HTML";
        }
        return $html;
    }
}