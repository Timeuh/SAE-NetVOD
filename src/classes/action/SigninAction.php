<?php

namespace iutnc\netvod\action;

class SigninAction extends Action {

    public function execute() : string {
        $html = "";
        if($_SERVER['REQUEST_METHOD'] === "GET") {
            $html = "
                <form method='post'>
                    <label>Email: </label><input type='text' name='email' placeholder='toto@gmail.com' required>
                    <label>Password: </label><input type='password' name='password' placeholder='example' required>
                    <button type='submit'>Validate</button>
                </form>";
        }
        return $html;
    }
}