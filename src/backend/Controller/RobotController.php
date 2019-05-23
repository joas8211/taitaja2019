<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Driver\Connection;

use App\VueRenderer;

class RobotController extends PageController
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function show(Request $request, VueRenderer $renderer)
    {
        // Check authentication
        if (!($_SESSION['user'] ?? false))
        {
            return new Response('', 403);
        }

        // Fetch functions
        $stmt = $this->connection
            ->createQueryBuilder()
            ->select('*')
            ->from('functions')
            ->execute();
        $this->vars['functions'] = $stmt->fetchAll();

        return parent::show($request, $renderer);
    }

    public function addFunction()
    {
        // Check authentication
        if (!($_SESSION['user'] ?? false))
        {
            return new Response('', 403);
        }

        $stmt = $this->connection
            ->createQueryBuilder()
            ->insert('functions')
            ->setValue('title', '?')
            ->setParameter(0, trim($_POST['function']))
            ->execute();
        
        return new Response($this->connection->lastInsertId());
    }

    public function removeFunction()
    {
        // Check authentication
        if (!($_SESSION['user'] ?? false))
        {
            return new Response('', 403);
        }

        $stmt = $this->connection
            ->createQueryBuilder()
            ->delete('functions')
            ->where('id = ?')
            ->setParameter(0, trim($_POST['function']))
            ->execute();

        return new Response();
    }

    public function execute()
    {
        // Check authentication
        if (!($_SESSION['user'] ?? false))
        {
            return new Response('', 403);
        }

        $stmt = $this->connection
            ->createQueryBuilder()
            ->insert('log')
            ->setValue('user', '?')
            ->setValue('function', '?')
            ->setValue('operating_time', '?')
            ->setParameter(0, $_SESSION['user'])
            ->setParameter(1, $_POST['function'])
            ->setParameter(2, 0)
            ->execute();

        return new Response();
    }
}