<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Cats\Applicative;

use j45l\functional\Cats\Functors\Applicative;
use PHPUnit\Framework\TestCase;

/**
 * @template A
 */
abstract class ApplicativeTestCase extends TestCase
{

    /** @var Applicative<A> */
    private Applicative $applicative;

    /**
     * @param Applicative<A> $applicative
     * @return $this
     */
    public function set(Applicative $applicative): self
    {
        $this->applicative = $applicative;

        return  $this;
    }

    /**
     * @param A $x
     */
    public function assertIdentity(mixed $x): void
    {
        self::assertEquals($x, $this->applicative->apply($x), 'Identity');
    }

    abstract public function testIdentity(): void;
}
