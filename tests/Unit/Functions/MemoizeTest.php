<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use j45l\functional\Optimization\MemoizeTrait;
use PHPUnit\Framework\TestCase;

use function j45l\functional\first;
use function j45l\functional\identity;

interface MemoizingSubject
{
    public function memoize(int ...$arguments): int;
    public function calls(): int;
}

/** @covers \j45l\functional\Optimization\MemoizeTrait */
class MemoizeTest extends TestCase // phpcs:ignore
{
    /** @use MemoizeTrait<int> */
    use MemoizeTrait;

    public function testMemoizeReturnsValueOnceMemoized(): void
    {
        self::memoize(identity(...), 42);
        self::assertEquals(42, self::memoize(identity(...), 42));
    }

    public function testMemoizeReturnsDifferentValuesByArguments(): void
    {
        self::memoize(identity(...), 42);
        self::memoize(identity(...), 43);
        self::memoize(identity(...), 44, 45);

        self::assertEquals(42, self::memoize(identity(...), 42));
        self::assertEquals(43, self::memoize(identity(...), 43));
        self::assertEquals(44, self::memoize(identity(...), 44, 45));
    }

    public function testMemoizeEvaluatesCallbackJustOnceByArguments(): void
    {
        $calls = 0;

        $callback = static function () use (&$calls) {
            $calls++;

            return 42;
        };

        self::memoize($callback, 42, 1);

        self::assertEquals(42, self::memoize($callback, 42, 1));
        self::assertEquals(42, self::memoize($callback, 42, 1));
        self::assertEquals(1, $calls);

        self::assertEquals(42, self::memoize($callback, 42, 777));
        self::assertEquals(42, self::memoize($callback, 42, 1));
        self::assertEquals(2, $calls);
    }

    public function testMemoizeKeyCanBeChanged(): void
    {
        $subject = $this->buildTestMemoizingSubject();

        self::assertEquals(42, $subject->memoize(39, 1, 2));
        self::assertEquals(42, $subject->memoize(39, 1, 777));
        self::assertEquals(1, $subject->calls());
    }

    private function buildTestMemoizingSubject(): MemoizingSubject
    {
        return new class () implements MemoizingSubject {
            private int $calls = 0;

            /** @use MemoizeTrait<int> */
            use MemoizeTrait {
                memoize as parentMemoize;
            }

            /**
             * @noinspection PhpUnusedPrivateMethodInspection
             * @phpstan-ignore-next-line
             */
            private static function memoizeTraitKey(int ...$arguments): string
            {
                return (string) first($arguments);
            }

            public function memoize(int ...$arguments): int
            {
                return self::parentMemoize(
                    function () use ($arguments) {
                        $this->calls++;
                        return array_sum($arguments);
                    },
                    ...$arguments
                );
            }

            public function calls(): int
            {
                return $this->calls;
            }
        };
    }

    protected function setUp(): void
    {
        parent::setUp();
        self::memoize();
    }
}
