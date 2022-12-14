<?php

namespace iutnc\netvod\action;

use iutnc\netvod\auth\Auth;
use iutnc\netvod\db\ConnectionFactory;

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
                    <a href='Index.php' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retour</a>
            </form>
            
            EOF;
        }elseif ($_SERVER['REQUEST_METHOD']==="POST"){

            if($_POST['password']===$_POST['confirm']){

                $res = Auth::register(filter_var($_POST['email'],FILTER_SANITIZE_EMAIL),$_POST['password']);
                if($res===true){

                    $mail = filter_var($_POST['email']);

                    $db = ConnectionFactory::makeConnection();
                    $query = "SELECT activation_token FROM user WHERE email=:mail";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam("mail", $mail);
                    $stmt->execute();
                    $data = $stmt->fetch();

                    $token = $data['activation_token'];

                    $html = <<<EOF
                    <script>document.location.href="?action=activate&token=$token"</script>
                    EOF;

                }else{
                    $html = "<div class='text-center flex flex-wrap content-center flex-col'>
                            <p>Votre inscription a ??chou??, veuillez r??essayer</p>
                            <a href='Index.php' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retour</a>
                            </div>";
                }
            }else{
                $html = "<div class='text-center flex flex-wrap content-center flex-col'>
                         <p class='text-2xl text-red-600 mb-4'>Vos deux mots de passe ne correspondent pas, veuillez r??essayer</p>
                         <a href='Index.php' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600 box-border h-7 w-40'>Retour</a>
                         </div>";
            }
        }
        return $html;
    }
}