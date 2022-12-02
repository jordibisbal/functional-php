<?php

declare(strict_types=1);

namespace j45l\functional\Cats\DoTry;

use j45l\functional\Cats\Maybe\Maybe;

/**
 * @template T
 * @extends DoTry<T>
 */
final class Success extends DoTry
{
    /** @param T $value */
    private function __construct(private readonly mixed $value)
    {
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @phpstan-return $this
     */
    public function andThen(callable $fn): DoTry
    {
        return self::pure($fn($this->get()));
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
     * @return T
     */
    public function get(): mixed
    {
        return $this->value;
    }

    /**
     * @template R
     * @param R $value
     * @return T
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getOrElse(mixed $value): mixed
    {
        return $this->get();
    }

    /**
     * @return T
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getOrFail(string $message = null): mixed
    {
        return $this->value;
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @phpstan-return DoTry<R>
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function map(callable $fn): DoTry
    {
        return DoTry::try(fn () => $fn($this->value)); /** @phpstan-ignore-line  */
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

    public function toMaybe(): Maybe
    {
        return Maybe::of($this->getOrElse(null));
    }

}
