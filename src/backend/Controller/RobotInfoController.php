<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\Driver\Connection;

use App\VueRenderer;

class RobotInfoController extends PageController
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

        // Fetch operating time data
        $this->vars['fullOperatingTime'] = json_decode(file_get_contents('http://d1-hakemisto/time-h.json'));

        // Fetch function usage data
        $this->vars['fullFunctionUsage'] = $this->connection
            ->createQueryBuilder()
            ->select('toiminto.nimi', 'loki.kayttoaika AS aika', 'loki.paivays')
            ->from('lokikirjaus', 'loki')
            ->leftJoin('loki', 'toiminnot', 'toiminto', 'loki.toiminto = toiminto.id')
            ->execute()
            ->fetchAll();

        // Fetch battery data
        $battery_data = file_get_contents('http://d1-hakemisto/battery.txt');
        preg_match_all('/Data:\[([^\]]+)\]/', $battery_data, $matches);
        $this->vars['fullBatteryCharge'] = array_map('json_decode', $matches[1]);

        return parent::show($request, $renderer);
    }
}