<?php

declare(strict_types=1);

namespace j45l\functional\Optimization;

use Closure;

use function j45l\functional\identity;
use function j45l\functional\pipe;
use function j45l\functional\with;

/** @template T */
trait MemoizeTrait
{
    /** @var array<T> */
    private static array $memoizeTraitCache = [];

    private static function memoizeTraitKey(mixed ...$arguments): string
    {
        return serialize($arguments);
    }

    private static function memoizeTraitForget(): void
    {
        self::$memoizeTraitCache = [];
    }

    /**
     * @param ((Closure(mixed...):T)|null)|null $callback
     * @return Closure(mixed...):?T
     */
    private static function memoize(Closure $callback = null): Closure
    {
        $callback ??= identity(...);

        return static fn (mixed ...$arguments) =>
            with(self::memoizeTraitKey(...$arguments))(
                static fn (string $key) => self::$memoizeTraitCache[
                    match (true) {
                        array_key_exists($key, self::$memoizeTraitCache) => $key,
                        default => pipe(
                            fn () => self::$memoizeTraitCache[$key] = $callback(...$arguments),
                            fn () => $key
                        )
                    }
                ]
            );
    }
}
