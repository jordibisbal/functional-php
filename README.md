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

```composer require jordibisbal/functional-php```

## Usage

### Failsafe

#### doOr()

Return a function than invokes `$fn` a throwable is  thrown, `$failFn` is invoked, prefixing the throwable to the function parameters.

``Closure JBFunctional\doOr(callable $fn, callable $failFn)``

##### Example

```php
use function JBFunctional\doOr;


$fn = static function ($param) {
    throw new Exception('exception');
};

$failFn = static function (Throwable $throwable, ...$params) {
    return sprintf("%s with parameters %s", $throwable->getMessage(), print_r($params));
};

doOr($fn, $failFn); 
```

#### mapOr()

Applies ```$fn``` to each element in the collection and collects the return value, if a throwable is thrown, ```$failFn``` is applied instead

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
        function (Throwable $throwable, User $user) {
            $logger->log($throwable->getMessage());
            
            return null;
        }
    )
);
```