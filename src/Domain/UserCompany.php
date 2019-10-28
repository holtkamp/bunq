<?php declare(strict_types = 1);

namespace Link0\Bunq\Domain;

final class UserCompany extends User
{
    /**
     * @param array $userCompany
     */
    public static function fromArray(array $userCompany) : self
    {
        return new self($userCompany);
    }
}
