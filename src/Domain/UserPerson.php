<?php declare(strict_types = 1);

namespace Link0\Bunq\Domain;

final class UserPerson extends User
{
    /**
     * @param array $userPerson
     */
    public static function fromArray(array $userPerson) : self
    {
        return new self($userPerson);
    }
}
