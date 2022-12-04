<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Either\Reason;

final class BecauseNull implements Reason
{
    private function __construct(public readonly string $reason)
    {
    }

    public static function create(): self
    {
        return new self('From None optional');
    }

    public function reason(): string
    {
        return $this->reason;
    }
}
