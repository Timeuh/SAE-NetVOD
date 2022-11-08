<?php

namespace iutnc\netvod\action;

class LogoutAction extends Action
{

    public function execute(): string
    {
        session_destroy();

        return "<a href='?action='>Deconnection</a>";

    }
}