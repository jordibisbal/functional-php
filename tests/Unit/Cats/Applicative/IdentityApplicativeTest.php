<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Cats\Applicative;

use j45l\functional\Cats\Functors\IdentityApplicative;
use function j45l\functional\identity;

/**
 * @extends ApplicativeTestCase<mixed>
 */
final class IdentityApplicativeTest extends ApplicativeTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->set(IdentityApplicative::pure(identity(...)));
    }

    public function testIdentity(): void
    {
        $this->assertIdentity(IdentityApplicative::pure(0));
        $this->assertIdentity(IdentityApplicative::pure(42));
    }

    public function testAdder(): void
    {
        $add = static function ($x) {
            return static function ($y) use ($x) {
                return $x + $y;
            };
        };

        $five = IdentityApplicative::pure(5);
        $ten = IdentityApplicative::pure(10);
        $applicative = IdentityApplicative::pure($add);

        self::assertEquals(15, $applicative->apply($five)->apply($ten)->get());
        self::assertEquals(15, $five->map($add)->apply($ten)->get());
    }

    public function testAdderSubtract(): void
    {
        $addSub = static function ($x) {
            return static function ($y) use ($x) {
                return static function ($z) use ($x, $y) {
                    return $x + $y - $z;
                };
            };
        };

        $five = IdentityApplicative::pure(5);
        $ten = IdentityApplicative::pure(10);
        $fifteen = IdentityApplicative::pure(15);
        $applicative = IdentityApplicative::pure($addSub);

        self::assertEquals(0, $applicative->apply($five)->apply($ten)->apply($fifteen)->get());
        self::assertEquals(0, $five->map($addSub)->apply($ten)->apply($fifteen)->get());
    }
}
