<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Either;

use j45l\functional\Cats\Maybe\Maybe;
use function j45l\functional\with;

/**
 * @template Right
 * @extends Either<Right>
 */
final class Success extends Either
{
    /** @param Right $value */
    private function __construct(private readonly mixed $value)
    {
    }

    /**
     * @template Result
     * @param callable(Right):Result $fn
     * @return self<Result>
     */
    public function andThen(callable $fn): Either
    {
        return with(self::try(fn() => $fn($this->get())))(static fn (mixed $response) => match (true) {
            isSuccess($response) && isEither($response->get()) => $response->get(),
            default => $response,
        });
    }

    /**
     * @template Value
     * @param Value $value
     * @phpstan-return self<Value>
     */
    public static function pure(mixed $value): self
    {
        return new self($value);
    }

    /**
     * @return Right
     */
    public function get(): mixed
    {
        return $this->value;
    }

    /**
     * @template Result
     * @param Result $value
     * @return Result|Right
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getOrElse(mixed $value = null): mixed
    {
        return $this->get();
    }

    /**
     * @return Right
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getOrFail(string $message = null): mixed
    {
        return $this->value;
    }

    /**
     * @template Result
     * @param callable(Right):Result $fn
     * @phpstan-return Either<Result>
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function map(callable $fn): Either
    {
        return Either::try(fn () => $fn($this->value)); /** @phpstan-ignore-line  */
    }

    /**
     * @template Result
     * @param callable(Right):Result $fn
     * @phpstan-return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function orElse(callable $fn): self
    {
        return $this;
    }

    public function toMaybe(): Maybe
    {
        return Maybe::of($this->getOrElse());
    }
}
