<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class ActiverCompteAction extends Action
{

    public function execute(): string
    {
        $html ="<a href='?action='>Accueil</a> <br> <br>";

        $db = ConnectionFactory::makeConnection();

        if ($db != null){
            if ($this->http_method === "GET"){

                $html .= "<form method='post'> 
                                <button type='submit'>Activer le compte</button>
                          </form>";

            } elseif($this->http_method === "POST"){
                $token = unserialize($_SESSION['token']);

                if ($token != null) {

                    $queryGetUser = "SELECT * FROM user WHERE activation_token=:token AND activation_expires > date('Y-m-d H:i:s',time())";
                    $stmt1 = $db->prepare($queryGetUser);
                    $stmt1->bindParam('token', $token);
                    $stmt1->execute();

                    $data = $stmt1->fetch();

                    $queryUpdate = "UPDATE user SET active = 1, activation_token=null WHERE activation_token=:token2";
                    $stmt2 = $db->prepare($queryUpdate);
                    $stmt2->bindParam('token2', $token);
                    $stmt2->execute();

                    $html .= "<script>document.location.href='?action='</script>";
                } else {
                    $html .= "Aucun compte ne doit être activé pour le moment <br> <br>
                              <a href='?action='>Retour à Accueil</a>" ;
                }

            } else {
                $html .= "Erreur";
            }
        }

        return $html;

    }

}