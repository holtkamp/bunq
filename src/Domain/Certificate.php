<?php declare(strict_types = 1);

namespace Link0\Bunq\Domain;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

final class Certificate
{
    /**
     * @var Id
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
    private $certificate;

    /**
     * @string
     */
    private function __construct(string $certificate)
    {
        $this->certificate = $certificate;
    }

    public static function fromString(string $certificate) : self
    {
        return new self($certificate);
    }

    /**
     * @param array $value
     */
    public static function fromArray($value) : self
    {
        $timezone = new DateTimeZone('UTC');
        $cert = new self($value['certificate_chain']);
        $cert->id = Id::fromInteger(intval($value['id']));
        $cert->created = new DateTimeImmutable($value['created'], $timezone);
        $cert->updated = new DateTimeImmutable($value['updated'], $timezone);
        return $cert;
    }

    public function id(): Id
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

    public function certificate(): string
    {
        return $this->certificate;
    }

    public function __toString()
    {
        return $this->certificate;
    }
}
