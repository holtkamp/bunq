<?php declare(strict_types = 1);

namespace Link0\Bunq\Domain;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;

final class Token
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
    private $token;

    /**
     * @param array $token
     * @return Token
     */
    public static function fromArray(array $token)
    {
        $timezone = new DateTimeZone('UTC');
        $t = new Token();
        $t->id = Id::fromInteger(intval($token['id']));
        $t->created = new DateTimeImmutable($token['created'], $timezone);
        $t->updated = new DateTimeImmutable($token['updated'], $timezone);
        $t->token = $token['token'];
        return $t;
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

    public function token(): string
    {
        return $this->token;
    }

    public function __toString()
    {
        return $this->token();
    }
}
