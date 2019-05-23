<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Driver\Connection;

use App\VueRenderer;

class LoginController extends PageController
{
    public function show(Request $request, VueRenderer $renderer)
    {
        return parent::show($request, $renderer);
    }

    public function login(Request $request, VueRenderer $renderer, Connection $connection)
    {
        $stmt = $connection
            ->createQueryBuilder()
            ->select('*')
            ->from('users')
            ->where('username = ?')
            ->setParameter(0, trim($_POST['username']))
            ->execute();
        $user_row = $stmt->fetch();
        if ($user_row && password_verify($_POST['password'], $user_row['password']))
        {
            $_SESSION['user'] = $user_row['id'];
        }
        else
        {
            $this->vars['error'] = true;
        }

        return $this->show($request, $renderer);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        return $this->redirectToRoute('login_view');
    }
}