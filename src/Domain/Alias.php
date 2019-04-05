<?php declare(strict_types=1);

namespace Link0\Bunq\Domain;

use InvalidArgumentException;

final class Alias
{
    const TYPE_EMAIL = 'EMAIL';
    const TYPE_IBAN = 'IBAN';
    const TYPE_PHONE_NUMBER = 'PHONE_NUMBER';
    const TYPE_URL = 'URL';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $name;

    public function __construct(string $type, string $value, string $name)
    {
        $this->guardValidType($type);

        $this->type  = $type;
        $this->value = $value;
        $this->name  = $name;
    }

    public static function fromArray(array $alias): ?self
    {
        try {
            return new self(
                $alias['type'],
                $alias['value'],
                $alias['name']
            );
        } catch (\Exception $exception) {
            \error_log('caught exception while trying to assemble Alias: ' . $exception->getMessage());
        }


        return null;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type(),
            'value' => $this->value(),
            'name' => $this->name(),
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    private function guardValidType(string $type): void
    {
        $reflectionClass = new \ReflectionClass(__CLASS__);
        if (!array_key_exists('TYPE_' . $type, $reflectionClass->getConstants())) {
            throw new \InvalidArgumentException(sprintf('Invalid Alias type "%s"', $type));
        }
    }

    public function type(): string
    {
        return $this->type;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function name(): string
    {
        return $this->name;
    }
}
