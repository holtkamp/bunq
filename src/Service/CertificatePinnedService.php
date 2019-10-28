<?php declare(strict_types = 1);

namespace Link0\Bunq\Service;

use Link0\Bunq\Client;
use Link0\Bunq\Domain\Certificate;
use Link0\Bunq\Domain\Id;

final class CertificatePinnedService
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Id
     */
    private $userId;

    public function __construct(Client $client, Id $userId)
    {
        $this->client = $client;
        $this->userId = $userId;
    }

    /**
     * @return Certificate[]
     */
    public function all(): array
    {
        return $this->client->get('user/' . $this->userId . '/certificate-pinned');
    }

    public function add(Certificate $certificate): Id
    {
        return $this->client->post(
            'user/' . $this->userId . '/certificate-pinned',
            [
                'certificate_chain' => [[
                    'certificate' => (string) $certificate,
                ]],
            ]
        )[0];
    }

    public function get(Id $certificateId): Certificate
    {
        return $this->client->get(
            'user/' . $this->userId . '/certificate-pinned/' . $certificateId
        )[0];
    }

    public function remove(Id $certificateId) : void
    {
        $this->client->delete('user/' . $this->userId . '/certificate-pinned/' . $certificateId);
    }
}
