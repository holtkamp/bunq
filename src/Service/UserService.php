<?php declare(strict_types = 1);

namespace Link0\Bunq\Service;

use Link0\Bunq\Client;
use Link0\Bunq\Domain\Id;
use Link0\Bunq\Domain\User;

final class UserService
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return User[]
     */
    public function listUsers(): array
    {
        return $this->client->get('user');
    }

    public function userById(Id $userId): User
    {
        return $this->client->get('user/' . $userId)[0];
    }
}
