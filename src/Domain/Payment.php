<?php declare(strict_types = 1);

namespace Link0\Bunq\Domain;

use DateTimeInterface;
use DateTimeZone;
use Money\Currency;
use Money\Money;

final class Payment
{
    const TYPE_IDEAL = 'IDEAL';
    const TYPE_BUNQ = 'BUNQ';
    const TYPE_EBA_SCT = 'EBA_SCT';

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
     * @var Money
     */
    private $amount;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $type;

    /**
     * @var LabelMonetaryAccount
     */
    private $alias;

    /**
     * @var LabelMonetaryAccount
     */
    private $counterpartyAlias;

    public static function fromArray($value)
    {
        $timezone = new DateTimeZone('UTC');

        $payment = new Payment();
        $payment->id = Id::fromInteger(intval($value['id']));
        $payment->created = new \DateTimeImmutable($value['created'], $timezone);
        $payment->updated = new \DateTimeImmutable($value['updated'], $timezone);
        $payment->amount = new Money(
            $value['amount']['value'] * 100, // cents
            new Currency($value['amount']['currency'])
        );
        $payment->description = $value['description'];
        $payment->type = $value['type'];

        $payment->alias = LabelMonetaryAccount::fromArray($value['alias']);
        $payment->counterpartyAlias = LabelMonetaryAccount::fromArray($value['counterparty_alias']);

        return $payment;
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

    public function amount(): Money
    {
        return $this->amount;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function alias(): LabelMonetaryAccount
    {
        return $this->alias;
    }

    public function counterpartyAlias(): LabelMonetaryAccount
    {
        return $this->counterpartyAlias;
    }
}
