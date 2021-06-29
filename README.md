# Functional-php

Some functional oriented add-ons/ideas, favouring the use of high order functions

On https://github.com/lstrojny/functional-php (uses and copied code from)

## Install

add to composer.json

    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/jordibisbal/functional-php"
        }
    ],

`composer require jordibisbal/functional-php:@dev`

## Usage

### Assertions

#### AssertIsAOr()

Return a function that asserts the type of the parameter is the given one or otherwise the alternate function ``$fn`` is called, the function does return nothing. 

`assertIsAOr(string $className, Callable $failFn): Closure` <br/> → `($item): void` 

##### Example

```php
use function JBFunctional\assertIsAOr;

...

$object = new Aclass();

assertIsAOr(
    AClass::class, 
    function static (): void 
    { 
        throw new TypeError();
    }
)($object);
```

### Failsafe

#### doOr()

Return a function than invokes `$fn`, if a throwable is  thrown, `$failFn` is invoked, prefixing the throwable to the function parameters.

`Closure JBFunctional\doOr(callable $fn, callable $failFn)` <br/> → `(mixed ...$params): mixed`

##### Example

```php
use function JBFunctional\doOr;

$fn = static function ($param): void {
    throw new Exception('exception');
};

$failFn = static function (Throwable $throwable, ...$params): string {
    return sprintf("%s with parameters %s", $throwable->getMessage(), print_r($params));
};

doOr($fn, $failFn)($params); 
```

#### mapOr()

Returns a function that applies `$fn` to each element in the given collection and collects the return value, if a throwable is thrown, `$failFn` is applied instead.

Keys are maintained.

`array Functional\map(callable $fn, callable $failFn)` <br/> → `(iterable $collection $collection): iterable`

##### Example

```php
use function Functional\filter;
use function JBFunctional\mapOr;

...

$emails = filter(
    mapOr(         
        fn (User $user): Email => $users->getEmail(), 
        function (Throwable $throwable, User $user): ?Email use ($logger) {
            $logger->log($throwable->getMessage());
            
            return null;
        }
    )($users)
);
```
