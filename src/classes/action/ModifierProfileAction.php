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

            $html ="<a href='?action='>Accueil</a> <br> <br> Information de base : <br> <br> Prenom : " . $data['prenom'] . "<br> Nom : " . $data['nom'] . "<br> Genre Préféré : " . $data['genrePref'] . "<br> <br>";

            if ($this->http_method === "GET"){
                $html .= "<form method='post'>
                                <label>Prenom : </label> <input type='text' name='prenom'> <br> <br>
                                <label>Nom : </label> <input type='text' name='nom'> <br> <br>                               
                                <label>Genre Préféré : </label> <input type='text' name='genre'> <br> <br>
                                <button type='submit'>Changer information</button>
                          </form>";
            } elseif ($this->http_method==="POST"){

                if (strlen($_POST['prenom'] > 0)){
                    $query2 = "UPDATE user SET prenom='" .$_POST['prenom'] . "' WHERE id=:id";
                    $stmt2 = $bd->prepare($query2);
                    $stmt2->bindParam("id", $id);
                    $stmt2->execute();
                }

                if (strlen($_POST['nom'] > 0)){
                    $query2 = "UPDATE user SET nom='" .$_POST['nom'] . "' WHERE id=:id";
                    $stmt2 = $bd->prepare($query2);
                    $stmt2->bindParam("id", $id);
                    $stmt2->execute();
                }

                if (strlen($_POST['genre'] > 0)){
                    $query2 = "UPDATE user SET genrePref='" .$_POST['genre'] . "' WHERE id=:id";
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