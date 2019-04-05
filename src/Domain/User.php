<?php declare(strict_types=1);

namespace Link0\Bunq\Domain;

use DateTimeInterface;
use DateTimeZone;

abstract class User
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_SIGNUP = 'SIGNUP';
    const STATUS_RECOVERY = 'RECOVERY';

    const SUBSTATUS_NONE = 'NONE';
    const SUBSTATUS_FACE_RESET = 'FACE_RESET';
    const SUBSTATUS_APPROVAL = 'APPROVAL';
    const SUBSTATUS_APPROVAL_DIRECTOR = 'APPROVAL_DIRECTOR';
    const SUBSTATUS_APPROVAL_PARENT = 'APPROVAL_PARENT';
    const SUBSTATUS_APPROVAL_SUPPORT = 'APPROVAL_SUPPORT';
    const SUBSTATUS_COUNTER_IBAN = 'COUNTER_IBAN';
    const SUBSTATUS_IDEAL = 'IDEAL';
    const SUBSTATUS_SUBMIT = 'SUBMIT';

    /**
     * @var Id
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $subStatus;

    /**
     * @var DateTimeInterface
     */
    private $created;

    /**
     * @var DateTimeInterface
     */
    private $updated;

    /**
     * @var Alias[]
     */
    private $alias;

    /**
     * @var string
     */
    private $publicUuid;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $region;

    /**
     * @var int
     */
    private $sessionTimeout;

    /**
     * @var Address
     */
    private $mainAddress;

    /**
     * @var Address
     */
    private $postalAddress;

    /**
     * @var NotificationFilter[]
     */
    private $notificationFilters;

    protected function __construct(array $user)
    {
        $this->id        = Id::fromInteger((int)$user['id']);
        $this->status    = $user['status'];
        $this->subStatus = $user['sub_status'];

        $timezone      = new DateTimeZone('UTC');
        $this->created = new \DateTimeImmutable($user['created'], $timezone);
        $this->updated = new \DateTimeImmutable($user['updated'], $timezone);

        $this->alias = array_filter(
            array_map(
                function ($alias): ?Alias {
                    return Alias::fromArray($alias);
                },
                $user['alias']
            )
        );

        $this->publicUuid     = $user['public_uuid'];
        $this->nickname       = $user['public_nick_name'];
        $this->displayName    = $user['display_name'];
        $this->language       = $user['language'];
        $this->region         = $user['region'];
        $this->sessionTimeout = (int)$user['session_timeout'];

        $this->mainAddress   = Address::fromArray($user['address_main']);
        $this->postalAddress = Address::fromArray($user['address_postal']);

        $this->notificationFilters = array_filter(
            array_map(
                function ($notificationFilter): ?NotificationFilter {
                    return NotificationFilter::fromArray($notificationFilter);
                },
                $user['notification_filters']
            )
        );
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function subStatus(): string
    {
        return $this->subStatus;
    }

    public function created(): DateTimeInterface
    {
        return $this->created;
    }

    public function updated(): DateTimeInterface
    {
        return $this->updated;
    }

    /**
     * @return Alias[]
     */
    public function alias(): array
    {
        return $this->alias;
    }

    public function publicUuid(): string
    {
        return $this->publicUuid;
    }

    public function nickname(): string
    {
        return $this->nickname;
    }

    public function displayName(): string
    {
        return $this->displayName;
    }

    public function language(): string
    {
        return $this->language;
    }

    public function region(): string
    {
        return $this->region;
    }

    public function sessionTimeout(): int
    {
        return $this->sessionTimeout;
    }

    /**
     * @return NotificationFilter[]
     */
    public function notificationFilters(): array
    {
        return $this->notificationFilters;
    }
}
