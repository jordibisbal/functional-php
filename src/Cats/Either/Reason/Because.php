<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Either\Reason;

use function j45l\functional\cloneWith;

final class Because implements Reason
{
    private mixed $subject = null;

    private function __construct(public readonly string $reason)
    {
    }

    public static function of(string $reason): self
    {
        return new self($reason);
    }

    /** @SuppressWarnings(PHPMD.ShortMethodName) */
    public function on(mixed $subject): self
    {
        return cloneWith($this, fn (self $self) => $self->subject = $subject);
    }

    public function subject(): mixed
    {
        return $this->subject;
    }

    public function reason(): string
    {
        return $this->reason;
    }
}
