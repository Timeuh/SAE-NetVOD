<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;

class AddUserAction extends Action
{

    public function execute(): string
    {
        if($_SERVER['REQUEST_METHOD']==="GET"){
            $html = <<<EOF
                <form id="form" method="post" action="?action=add-user">
                    <label for="form_email">Email:</label>
                    <input type="email" id="form_email" name="email" placeholder="<email>" required>
                    <label for="form_mdp">Mot de passe:</label>
                    <input type="password" id="form_mdp" name="password" placeholder="<mot de passe>" required>
                    <label for="form_confirm">Confirmation du mot de passe:</label>
                    <input type="password" id="form_confirm" name="confirm" placeholder="<mot de passe>" required>
                    <button type="submit">S'inscrire</button>
            </form>
            EOF;
        }elseif ($_SERVER['REQUEST_METHOD']==="POST"){
            if($_POST['password']===$_POST['confirm']){
                $res = Auth::register($_POST['email'],$_POST['password']);
                if($res===true){
                    $html = <<<EOF
                    <script>document.location.href="?action=signin"</script>
                    EOF;
                }else{
                    $html = "<p>Votre inscription a échouée, veuillez réessayer</p>";
                }
            }else{
                $html = "<p>Vos deux mots de passe ne correspondent pas, veuillez réessayer</p>";
            }
        }
        return $html;
    }
}