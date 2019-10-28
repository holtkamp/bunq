<?php declare(strict_types = 1);

namespace Link0\Bunq\Service;

use Link0\Bunq\Client;
use Link0\Bunq\Domain\DeviceServer;
use Link0\Bunq\Domain\Id;
use Link0\Bunq\Domain\Installation;
use Link0\Bunq\Domain\Keypair;
use Link0\Bunq\Domain\Token;

final class InstallationService
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Keypair $keypair
     * @return array
     *
     * Array(
     *   'Id' => ...
     *   'Token' => ...
     *   'ServerPublicKey' ...
     * )
     */
    public function createInstallation(Keypair $keypair): array
    {
        // TODO: This doesn't need the signature middleware
        return $this->client->post('installation', [
            'client_public_key' => (string) $keypair->publicKey(),
        ]);
    }

    public function createDeviceServer($token, string $apiKey, string $description, array $permittedIps = []): Id
    {
        $body = [
            'description' => $description,
            'secret' => $apiKey,
            'permitted_ips' => $permittedIps,
        ];

        return $this->client->post('device-server', $body, [
            'X-Bunq-Client-Authentication' => (string) $token,
        ])[0];
    }

    /**
     * @return array
     *
     * Array(
     *   'Id' => ...
     *   'Token' => ...
     *   'UserCompany' => ...
     * )
     */
    public function createSessionServer(string $token, string $apiKey): array
    {
        $body = ['secret' => $apiKey];

        return $this->client->post('session-server', $body, [
            'X-Bunq-Client-Authentication' => $token,
        ]);
    }

    /**
     * @return DeviceServer[]
     */
    public function listDeviceServers(Installation $installation): array
    {
        return $this->client->get('device-server', [
            'X-Bunq-Client-Authentication' => $installation->token(),
        ]);
    }

    /**
     * @return array
     */
    public function listInstallations()
    {
        return $this->client->get('installation');
    }

    /**
     * @return Installation[]
     */
    public function installationById(Id $installationId)
    {
        return $this->client->get('installation/' . $installationId);
    }

    /**
     * @return array
     */
    public function serverPublicKey(Installation $installation)
    {
        return $this->client->get('installation/' . $installation->id() . '/server-public-key');
    }
}
