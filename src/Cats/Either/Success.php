<?php

declare(strict_types=1);

namespace j45l\functional\Either;

use j45l\functional\Maybe\Some;

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
        return self::pure($fn($this->value));
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
    public function orElse(callable $fn): self {
        return $this;
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
     * @return T
     */
    public function getOrFail(string $message = null): mixed
    {
        return $this->value;
    }

    public function getOrElse(mixed $value): mixed
    {
        return $this->get();
    }

    public function andThenOption(callable $fn): mixed
    {
        return Some::pure($this->value);
    }
}
