<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Functors;

/**
 * @template A
 * @extends Applicative<A>
 */
final class IdentityApplicative extends Applicative
{
    private function __construct(private readonly mixed $value)
    {
    }

    /**
     * @param A $value
     * @return self<A>
     */
    public static function pure(mixed $value): self
    {
        return new self($value);
    }

    /**
     * @param Applicative<A> $applicative
     * @return Applicative<A>
     */
    public function apply(Applicative $applicative): Applicative
    {
        return self::pure($this->get()($applicative->get()));
    }

    /**
     * @return A
     */
    public function get(): mixed
    {
        return $this->value;
    }
}
