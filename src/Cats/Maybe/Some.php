<?php

declare(strict_types=1);

namespace j45l\functional\Maybe;

use j45l\functional\Either\DoTry;
use j45l\functional\Either\Success;

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
     * @return T
     */
    public function get(): mixed
    {
        return $this->value;
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

    /**
     * @return T
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getOrFail(string $message = null): mixed
    {
        return $this->get();
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

#region Try

    /**
     * @template R
     * @param callable(T):R $fn
     * @return Success<T>
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function orElseTry(callable $fn): Success
    {
        return Success::pure($this->get());
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @return DoTry<R>
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function andThenTry(callable $fn): DoTry
    {
        return DoTry::try(fn () => $fn($this->get()));
    }
#endregion
}
