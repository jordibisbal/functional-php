<?php

declare(strict_types=1);

namespace j45l\functional\Cats\DoTry\Reason;

final class Because implements Reason
{
    private function __construct(public readonly string $reason)
    {
    }

    public static function of(string $reason): self
    {
        return new self($reason);
    }

    public function reason(): string
    {
        return $this->reason;
    }
}
