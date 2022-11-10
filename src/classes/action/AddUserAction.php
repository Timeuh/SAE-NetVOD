<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;

class AddUserAction extends Action
{

    public function execute(): string
    {
        if($_SERVER['REQUEST_METHOD']==="GET"){
            $html = <<<EOF
                <form id="form" method="post" action="?action=add-user" class="text-center flex flex-wrap content-center flex-col">
                    <label for="form_email">Email</label>
                    <input type="email" id="form_email" name="email" placeholder="<email>" required class='border-2 rounded-md border-yellow-500 text-black mb-4'>
                    <br><label for="form_mdp">Mot de passe</label>
                    <input type="password" id="form_mdp" name="password" placeholder="<mot de passe>" required class='border-2 rounded-md border-yellow-500 text-black mb-4'>
                    <br><label for="form_confirm">Confirmation du mot de passe</label>
                    <input type="password" id="form_confirm" name="confirm" placeholder="<mot de passe>" required class='border-2 rounded-md border-yellow-500 text-black mb-4'>
                    <br><button type="submit" class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600 mb-4'>S'inscrire</button>
                    <a href='index.php' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retour</a>
            </form>
            
            EOF;
        }elseif ($_SERVER['REQUEST_METHOD']==="POST"){
            if($_POST['password']===$_POST['confirm']){
                $res = Auth::register(filter_var($_POST['email'],FILTER_SANITIZE_EMAIL),$_POST['password']);
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