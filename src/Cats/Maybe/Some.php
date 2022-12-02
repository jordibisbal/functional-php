<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Maybe;

use j45l\functional\Cats\DoTry\DoTry;
use j45l\functional\Cats\DoTry\Success;

/**
 * @template T
 * @extends Maybe<T>
 */
final class Some extends Maybe
{
    /** @param T $value */
    private function __construct(private readonly mixed $value)
    {
    }

    /**
     * @param T $value
     * @phpstan-return self<T>
     */
    public static function pure(mixed $value): self
    {
        return new self($value);
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @return Maybe<R>
     */
    public function andThen(callable $fn): Maybe
    {
        /** @phpstan-ignore-next-line */
        return Maybe::of($fn($this->get()));
    }

    /**
     * @param mixed $value
     * @return T
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getOrElse(mixed $value): mixed
    {
        return $this->value;
    }

    /**
     * @return T
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getOrFail(string $message = null): mixed
    {
        return $this->get();
    }

    /**
     * @return T
     */
    public function get(): mixed
    {
        return $this->value;
    }

    /**
     * @template T2
     * @param callable(T):T2 $fn
     * @phpstan-return self<T2>
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function map(callable $fn): self
    {
        return new self($fn($this->value));
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @phpstan-return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function orElse(callable $fn): self
    {
        return $this;
    }
}
