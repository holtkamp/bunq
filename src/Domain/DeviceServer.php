<?php declare(strict_types = 1);

namespace Link0\Bunq\Domain;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

final class DeviceServer
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

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $status;

    /**
     * @param array $structure
     */
    public static function fromArray(array $structure) : self
    {
        $timezone = new DateTimeZone('UTC');

        $deviceServer = new static();
        $deviceServer->id = $structure['id'];
        $deviceServer->created = new DateTimeImmutable($structure['created'], $timezone);
        $deviceServer->updated = new DateTimeImmutable($structure['updated'], $timezone);
        $deviceServer->ip = $structure['ip'];
        $deviceServer->description = $structure['description'];
        $deviceServer->status = $structure['status'];

        return $deviceServer;
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
