<?php

namespace iutnc\netvod\action;

class LogoutAction extends Action
{

    public function execute(): string
    {
        session_destroy();

        return '<script>document.location.href="?action="</script>';

    }
}