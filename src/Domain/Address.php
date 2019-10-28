<?php declare(strict_types = 1);

namespace Link0\Bunq\Domain;

final class Address
{
    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $houseNumber;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $province;

    public function __construct(
        string $street,
        string $houseNumber,
        string $postalCode,
        string $city,
        string $country,
        string $province
    ) {
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->country = $country;
        $this->province = $province;
    }

    /**
     * @param array $address
     */
    public static function fromArray(array $address): self
    {
        return new self(
            $address['street'],
            $address['house_number'],
            $address['postal_code'],
            $address['city'],
            $address['country'],
            $address['province'] === null ? '' : $address['province']
        );
    }

    public function toArray() : array
    {
        return [
            'street' => $this->street(),
            'house_number' => $this->houseNumber(),
            'postal_code' => $this->postalCode(),
            'city' => $this->city(),
            'country' => $this->country(),
            'province' => $this->province(),
        ];
    }

    public function street(): string
    {
        return $this->street;
    }

    public function houseNumber(): string
    {
        return $this->houseNumber;
    }

    public function postalCode(): string
    {
        return $this->postalCode;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function country(): string
    {
        return $this->country;
    }

    public function province(): string
    {
        return $this->province;
    }
}
