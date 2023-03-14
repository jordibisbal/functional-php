<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Maybe;

use j45l\functional\Cats\Either\Reason\BecauseNull;
use j45l\functional\Cats\Either\Either;
use j45l\functional\Cats\Either\Failure;
use RuntimeException;

/**
 * @template T
 * @extends Maybe<T>
 */
final class None extends Maybe
{
    private function __construct()
    {
    }

    /** @return self<T> */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @template R
     * @param callable(T|null):R $fn
     * @phpstan-return Either<R>
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function orElseTry(callable $fn): Either
    {
        return Either::try(static fn () => $fn(null));
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @return Failure<T>
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function andThenTry(callable $fn): Failure
    {
        return Failure::because(BecauseNull::create());
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @return Maybe<R>
     */
    public function orElse(callable $fn): Maybe
    {
        /** @phpstan-ignore-next-line */
        return self::ofNullable($fn($this));
    }

    /**
     * @template R
     * @param R $value
     * @phpstan-return R
     */
    public function getOrElse(mixed $value): mixed
    {
        return $value;
    }

    /**
     * @return None<T>
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function map(callable $fn): None
    {
        return $this;
    }

    /**
     * @return None<T>
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function andThen(callable $fn): None
    {
        return $this;
    }

    public function getOrFail(string $message = null): mixed
    {
        throw new RuntimeException(
            $message ?? sprintf('getOrFail() called upon a Left object (%s).', __CLASS__)
        );
    }

    /** @return null */
    public function getOrNull(): mixed
    {
        return null;
    }
}
