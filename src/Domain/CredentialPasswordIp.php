<?php declare(strict_types=1);

namespace Link0\Bunq\Domain;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

final class CredentialPasswordIp
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DateTimeInterface
     */
    private $created;

    /**
     * @var DateTimeInterface
     */
    private $updated;

    private $expiryTime;

    private $tokenValue;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $status;

    public static function fromArray(array $structure): CredentialPasswordIp
    {
        $timezone = new DateTimeZone('UTC');

        $credentialPasswordIp = new static();
        $credentialPasswordIp->id = $structure['id'];
        $credentialPasswordIp->created = new DateTimeImmutable($structure['created'], $timezone);
        $credentialPasswordIp->updated = new DateTimeImmutable($structure['updated'], $timezone);
        $credentialPasswordIp->status = $structure['status'];
        $credentialPasswordIp->expiryTime = $structure['expiry_time'];
        $credentialPasswordIp->tokenValue = $structure['token_value'];
        $credentialPasswordIp->description = $structure['permitted_device']['description'];
        $credentialPasswordIp->ip = $structure['permitted_device']['ip'];

        return $credentialPasswordIp;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function created(): DateTimeInterface
    {
        return $this->created;
    }

    public function updated(): DateTimeInterface
    {
        return $this->updated;
    }

    public function ip(): string
    {
        return $this->ip;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function status(): string
    {
        return $this->status;
    }
}
