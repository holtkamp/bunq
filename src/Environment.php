<?php

namespace Link0\Bunq;

interface Environment
{
    public function endpoint(): string;

    public function inDebugMode(): bool;
}
