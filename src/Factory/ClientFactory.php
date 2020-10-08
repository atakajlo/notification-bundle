<?php

declare(strict_types=1);

namespace Atakajlo\NotificationBundle\Factory;

use Nyholm\Dsn\DsnParser;
use phpcent\Client;

class ClientFactory
{
    private string $dsn;

    public function __construct(string $dsn)
    {
        $this->dsn = $dsn;
    }

    public function create()
    {
        $dsn = DsnParser::parse($this->dsn);

        return new Client(
            $dsn->getHost(),
            $dsn->getUser(),
            $dsn->getPassword()
        );
    }
}