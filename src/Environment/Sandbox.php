<?php declare(strict_types = 1);

namespace Link0\Bunq\Environment;

use Link0\Bunq\Environment;

final class Sandbox implements Environment
{
    const SERVICE_URL = 'https://public-api.sandbox.bunq.com';
    const VERSION = 'v1';

    /**
     * @var bool $inDebugMode
     */
    private $inDebugMode;

    public function __construct(bool $inDebugMode = false)
    {
        $this->inDebugMode = $inDebugMode;
    }

    public function serviceUrl(): string
    {
        return self::SERVICE_URL;
    }

    public function version(): string
    {
        return self::VERSION;
    }

    public function endpoint(): string
    {
        return $this->serviceUrl() . '/' . $this->version() . '/';
    }

    public function inDebugMode(): bool
    {
        return $this->inDebugMode;
    }
}
