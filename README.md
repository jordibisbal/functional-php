# Functional-php

Some functional oriented add-ons/ideas

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

`assertIsAOr(string $className, Callable $failFn): Closure` → `($item): void` 

### Failsafe

#### doOr()

Return a function than invokes `$fn`, if a throwable is  thrown, `$failFn` is invoked, prefixing the throwable to the function parameters.

`Closure JBFunctional\doOr(callable $fn, callable $failFn)`  → `(mixed ...$params): mixed`

##### Example

```php
use function JBFunctional\doOr;

$fn = static function ($param) {
    throw new Exception('exception');
};

$failFn = static function (Throwable $throwable, ...$params) {
    return sprintf("%s with parameters %s", $throwable->getMessage(), print_r($params));
};

doOr($fn, $failFn)($params); 
```

#### mapOr()

Applies `$fn` to each element in the collection and collects the return value, if a throwable is thrown, `$failFn` is applied instead

`array Functional\map(array|Traversable $collection, callable $fn, callable $failFn)`

##### Example

```php
use function Functional\filter;
use function JBFunctional\mapOr;

...

$emails = filter(
    mapOr(
        $users, 
        fn (User $user) => $users->getEmail(), 
        function (Throwable $throwable, User $user) use ($logger) {
            $logger->log($throwable->getMessage());
            
            return null;
        }
    )
);
```
