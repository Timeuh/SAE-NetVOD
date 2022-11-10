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

            }
        }


    }

}