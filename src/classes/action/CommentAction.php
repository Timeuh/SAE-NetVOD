<?php

namespace iutnc\netvod\action;

use iutnc\netvod\db\ConnectionFactory;

class CommentAction extends Action{

    public function execute(): string{
        if ($this->http_method == "GET"){
            $ep = $_GET['id'] ?? 0;
            if ($ep != 0){
                if (($db = ConnectionFactory::makeConnection()) != null){
                    $query = $db->prepare("select serie_id from episode where id = :id");
                    $query->bindParam(':id', $ep);
                    $query->execute();

                    $res = $query->fetch();
                    $serie = $res['serie_id'];

                    $qry = $db->prepare("select titre from serie where id = :id");
                    $qry->bindParam(':id', $serie);
                    $qry->execute();

                    $data = $qry->fetch();

                    return "<a href='?action=displayEpisode&id=$ep' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retour</a> <br> <br>
                            <h3>Commenter la série : {$data['titre']}</h3>
                            <form method='post' action='?action=comment&serie=$serie'>
                                <input type='number' name='note' placeholder='note (entre 1 et 5)' required class='text-black border-2 rounded-md border-yellow-500 mb-4'><br>
                                <textarea name='commentaire' placeholder='commentaire (256 charactères max)' required class='text-black border-2 rounded-md border-yellow-500 mb-4'></textarea>
                                <br><button type='submit' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Poster</button>
                            </form><br>";
                }
            }
            return "<a href='?action=displayCatalogue' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retour au catalogue</a><br><br><h3>Cet épisode n'existe pas</h3>";
        } else {
            $serie = $_GET['serie'] ?? 0;
            if ($serie != 0){
                $user = unserialize($_SESSION['user']);
                $user_id = $user->id;
                if (($db = ConnectionFactory::makeConnection()) != null){
                    $query = $db->prepare("select note from commentaire where idUser = :id and idSerie = :serie");
                    $query->bindParam(':id', $user_id);
                    $query->bindParam(':serie', $serie);
                    $query->execute();

                    if (!$query->fetch()){
                        $note = filter_var($_POST['note'], FILTER_SANITIZE_NUMBER_INT);
                        if ($note < 1) $note = 1;
                        if ($note > 5) $note = 5;
                        $commentaire = filter_var($_POST['commentaire'], FILTER_SANITIZE_SPECIAL_CHARS);

                        $insert = $db->prepare("insert into commentaire(idUser, idSerie, note, commentaire) values (:user, :serie, :note, :commentaire)");
                        $insert->bindParam(':serie', $serie);
                        $insert->bindParam(':user', $user_id);
                        $insert->bindParam(':note', $note);
                        $insert->bindParam(':commentaire', $commentaire);

                        if($insert->execute()) return "<a href='?action=displayCatalogue' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retour au catalogue</a><br><br><h3>Commentaire ajouté</h3>";
                        else return "<a href='?action=comment&serie=$serie' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Réessayer</a><br><br><h3>Commentaire non ajouté</h3>";
                    } else return "<a href='?action=displayCatalogue' class='border-2 rounded-md bg-yellow-500 border-yellow-500 hover:bg-yellow-600'>Retour au catalogue</a><br><br><h3>Vous avez déjà commenté cette série</h3>";
                }
            }
            return "<h3>Cet épisode n'existe pas</h3><br><a href='?action=displayCatalogue'>Retour au catalogue</a>";
        }
    }
}