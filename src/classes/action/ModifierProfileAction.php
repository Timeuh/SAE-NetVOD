<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class ModifierProfileAction extends Action
{

    public function execute(): string
    {
        $html = "";

        $user = unserialize($_SESSION['user']);
        $id = (int) $user->__get('id');

        $bd = ConnectionFactory::makeConnection();

        if ($bd != null){

            $query = "SELECT nom, prenom, genrePref FROM user WHERE id=:id";
            $stmt = $bd->prepare($query);
            $stmt->bindParam("id", $id);
            $stmt->execute();

            $data = $stmt->fetch();

            $html ="<a href='?action=' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Accueil</a> <br> <br> Information de base : <br> <br> Prenom : <span class='text-yellow-500'>" . $data['prenom'] . "</span><br> Nom : <span class='text-yellow-500'>" . $data['nom'] . "</span><br> Genre Préféré : <span class='text-yellow-500'>" . $data['genrePref'] . "</span><br> <br>";

            if ($this->http_method === "GET"){
                $html .= "<form method='post'>
                                <label>Prenom : </label> <input type='text' name='prenom' class='rounded-md border-yellow-500 border-2 text-black'> <br> <br>
                                <label>Nom : </label> <input type='text' name='nom' class='rounded-md border-yellow-500 border-2 text-black'> <br> <br>                               
                                <label>Genre Préféré : </label> <input type='text' name='genre' class='rounded-md border-yellow-500 border-2 text-black'> <br> <br>
                                <button type='submit' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Changer information</button>
                          </form>";
            } elseif ($this->http_method==="POST"){

                if (strlen($_POST['prenom'] > 0)){
                    $query2 = "UPDATE user SET prenom='" .filter_var($_POST['prenom'],FILTER_SANITIZE_SPECIAL_CHARS) . "' WHERE id=:id";
                    $stmt2 = $bd->prepare($query2);
                    $stmt2->bindParam("id", $id);
                    $stmt2->execute();
                }

                if (strlen($_POST['nom'] > 0)){
                    $query2 = "UPDATE user SET nom='" .filter_var($_POST['nom'],FILTER_SANITIZE_SPECIAL_CHARS) . "' WHERE id=:id";
                    $stmt2 = $bd->prepare($query2);
                    $stmt2->bindParam("id", $id);
                    $stmt2->execute();
                }

                if (strlen($_POST['genre'] > 0)){
                    $query2 = "UPDATE user SET genrePref='" .filter_var($_POST['genre'],FILTER_SANITIZE_SPECIAL_CHARS) . "' WHERE id=:id";
                    $stmt2 = $bd->prepare($query2);
                    $stmt2->bindParam("id", $id);
                    $stmt2->execute();
                }


                $html .= "<script>document.location.href='?action=modifierProfil'</script>";

            } else {
                $html .= "Erreur d'affichage";
            }
        } else {
            $html .= "Erreur d'affichage";
        }
        return $html;
    }
}