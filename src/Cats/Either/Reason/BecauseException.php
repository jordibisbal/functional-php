<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Either\Reason;

use Exception;

final class BecauseException implements Reason
{
    private function __construct(public readonly Exception $exception)
    {
    }

    public static function of(Exception $exception): self
    {
        return new self($exception);
    }

    public function reason(): string
    {
        return $this->exception->getMessage();
    }
}
