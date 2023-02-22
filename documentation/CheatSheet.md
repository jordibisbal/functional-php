# j45l/functional-php

- [j45l/functional-php](#j45lfunctional-php)
    * [Functional primitives for PHP](#functional-primitives-for-php)
        + [Collection filtering](#collection-filtering)
            - [best](#best)
            - [butLast](#butlast)
            - [first](#first)
            - [head](#head)
            - [last](#last)
        + [Collection transformation functions](#collection-transformation-functions)
            - [cartesianProduct](#cartesianproduct)
            - [crossCompareSet](#crosscompareset)
            - [fold](#fold)
            - [foldRight](#foldright)
            - [map](#map)
            - [mapFirst](#mapfirst)
        + [Function composition, partial application and curling](#function-composition-partial-application-and-curling)
            - [compose](#compose)
        + [Transform functions](#transform-functions)
            - [cloneWith](#clonewith)
            - [identity](#identity)
            - [isAOr](#isaor)
            - [isClosureOr](#isclosureor)
        + [Environment](#environment)
            - [delay](#delay)
        + [Logic functions](#logic-functions)
            - [falseFn](#falsefn)
        + [Repeat functions](#repeat-functions)
            - [doUntil](#dountil)
            - [doWhile](#dowhile)


## Functional primitives for PHP

https://github.com/jordibisbal/functional-php
composer require j45l/functional-php

Most functions return an array instead of the iterable type used as input.

Some function fully consume generators, be aware of infinity cases.

In general just \Closures are accepted as functions/callable as `callable` can lead to bad practices (opinionated), if 
you need to use one, just wrap it in an arrow function, and you are good to go.

Check function's unit test for further insight.

---
### Collection filtering
Functions intended to filter, select and reject elements on collections.

---
#### best
Selects the best according to *$criteria* (true if the first is better than the second).

```PHP
function best(iterable $collection, Closure $criteria, mixed $default = null): mixed
```
* $criteria: Closure(mixed $first, mixed $second): bool
```PHP
> best([1, 3, 2], fn ($x, $y) => $x > $y);

3
```

---
#### butLast

Returns the collection excluding the last element

```PHP
function butLast(iterable $collection): array
```
```PHP
> butLast([1, 2, 3])

[1, 2]
```

---
#### first
Returns the first element of the collection that `$predicate` if true for or `$default` if collection is empty, or `$predicate` 
is not true for any. If predicate is not given, just the first one is returned.

```PHP
function first(iterable $collection, Closure $predicate = null, mixed $default = null): mixed
```
```PHP
> first([1, 2, 3])

1
```
---
#### head
Returns the first element of the collection that `$predicate` if true for, or `$default` if collection is empty or `$predicate`
is not true for any. If predicate is not given, just the first one is returned.

Alias function of [first](#first)

---
#### last
Returns the last element of the collection that `$predicate` if true for, or `$default` if collection is empty or `$predicate`
is not true for any. If predicate is not given, just the first one is returned.

```PHP
function last(iterable $collection, Closure $predicate = null, mixed $default = null): mixed
```
```PHP
> last([1, 2, 3])

3
```

---
### Collection transformation functions
Functions transforming collections.

---
#### cartesianProduct
Returns the cartesian product of a collection of collections.
```PHP
cartesianProduct(array $collections, Closure $productFunction = null): array
```
```PHP
> cartesianProduct([[1, 2], [3, 5]], fn ($a, $b) => $a * $b);

[3, 5, 6, 10]
```

#### crossCompareSet
Returns an array of **Pair**s for every unique combination of elements in `$collection`, if `$collection` has fewer than
two elements, an empty array is returned, i.e. the triangular half of the matrix resultant of the cartesian product of 
`$collection` with itself, excluding the diagonal.

Useful to compare, for instance, all the elements of `$collection` with each other to select the best pair.

```PHP
function crossCompareSet(iterable $collection): array
```

Search for the nearest two integers in an array.

```PHP
> best(
      crossCompareSet([1, 5, 10, 7]), 
      fn (Pair $a, Pair $b) => abs(($a->first() - $a->second())) < abs(($b->first() - $b->second()))
  )

Pair::__set_state(['first' => 5, 'second' => 7,])
```
---
#### fold

Folds from the left all elements of the collection returning a single scalar value, if the collection is empty, `$default`
is returned instead.

```PHP
function fold(iterable $collection, Closure $callback, mixed $default = null): mixed
```

```PHP
> fold(['A', 'B', 'C'], static fn($value, $initial): string => $initial . $value)

'ABC' 
```
---
#### foldRight

Folds from the right all elements of the collection returning a single scalar value, if the collection is empty, `$default`
is returned instead.

```PHP
function foldRight(iterable $collection, Closure $callback, mixed $default = null): mixed
```

```PHP
> foldRight(['A', 'B', 'C'], static fn($value, $initial): string => $initial . $value)

'CBA' 
```
---
#### map

Maps (transform) through `$function` every member of the `$collection`, returning an array, if some key is repeated in
`$collection` (e.g. in generators), the last produced result is used.

Retains `$collection` keys.

```PHP
function map(iterable $collection, Closure $function): array
```

```PHP
> map([1, 2, 3], fn ($x): int => $x * 4)

[4, 8, 12]
```
---
---
#### mapFirst

Maps (transform) through `$function` the first element of `$collection` where `$predicate` is true (every element if
`$predicate not given`), if no such element is found, returns `$default`.

```PHP
function mapFirst(iterable $collection, Closure $map, Closure $predicate = null, mixed $default = null): mixed
```

```PHP
> mapFirst([1, 2, 3], fn ($x): int => $x * 4)

4
```
---
### Function composition, partial application and curling

---
#### compose
Return a new function that is the composition of the given ones. So `compose(f,g)(x)` becomes `g(f(x))` (right composition).
```PHP
function compose(Closure ...$functions): Closure
```

```PHP
> compose(
      fn ($x) => $x * 10,
      fn ($x) => $x + 2,
  )(4)

42
```
---
### Transform functions
Functions transforming values

---
#### cloneWith
Clones the given object (no shallow copy), executes the given closure on after binding it
so even the object private properties can be mutated once cloned.

```PHP
cloneWith(object $object, Closure $closure): object
```
```PHP
> readonly class foo { private string $property; }

> $object = cloneWith(new foo(), fn (foo $self) => $self->property = 'baz');

\foo::__set_state([ 'property' => 'baz' ])
```

Note it cannot mutate readonly properties if already defined (e.g. initialized in the constructor).

---
#### identity
Return the passed value.

```PHP
function identity(mixed $x = null): mixed
```

```PHP
> identity(42);

42
```
---
#### isAOr
Return the `$value` if is an object of the given `$class`, elsewhere returns `$default`. If `$default` if a closure
then `$default($value)` is returned instead.

```PHP
function isAOr(mixed $value, string $className, mixed $default = null): mixed
```

```PHP
> isAOr(1, Value::class, new Value(1))

Value::__set_state(['value' => 1])
```

used to wrap a value if is not already wrapped:

```PHP
> isAOr(42, Value::class, fn ($x): Value => new Value($x))

Value::__set_state(['value' => 42])
```
---
#### isClosureOr
Returns the passed `$value` if it is a `\Closure`, elsewhere return `$default` closure or `nop(..)` (i.e. a closure 
returning null).

```PHP
function isClosureOr(mixed $value, Closure $default = null): Closure
```

```PHP
> isClosureOr(42, falseFn(...))()

false
```

---
### Environment

---
#### delay
Waits for `$seconds` seconds then executes the function and returns its return value, if a `delayFn` is given, executes 
it instead of usleep to wait.

```PHP
function delay(float $seconds, Closure $callable, Closure $delayFn = null): mixed
```

```PHP
> delay(1, fn () => 42)

(after 1 second)
42
```
---
### Logic functions

---
#### falseFn

Return a function than returns 'false'.

```PHP
function falseFn(): bool
```

```PHP
> falseFn()()

false
```
---
### Repeat functions

---
#### doUntil

Repeats `$fn` until $predicate is `true`, then returns the result of evaluating `$return` or null if not given.
Equivalent to a `do { ... } while ()` loop.

```PHP
function doUntil(Closure $predicate, Closure $fn, Closure $return = null): mixed
```

```PHP
> doUntil(
      fn (): bool => $this->endOfFile($handle), 
      fn () => $this->process($this->readLine($handle)), 
      fn (): int => $this->processedLinesCount 
  )

123
```

Be aware:

* `$fn` is executed at least one. So in the previous example, it could file when reading empty file by reading past the end of the file.
* Arrow functions can not modify, nor access to mutated values, so use classic lambdas with by reference uses if needed.

```PHP
doUntil(
    trueFn(...),
    function () use (&$effect) {
        $effect = 42;
    }
)
```
---
#### doWhile

Repeats `$fn` while $predicate is `true`, then returns the result of evaluating `$return` or null if not given.
Equivalent to a `while() { ... }` loop.

```PHP
function doWhile(Closure $predicate, Closure $fn, Closure $return = null): mixed
```

```PHP
> doWhile(
      fn (): bool => !$this->endOfFile($handle), 
      fn () => $this->process($this->readLine($handle)), 
      fn (): int => $this->processedLinesCount 
  )

123
```

Be aware that arrow functions can not modify, nor access to mutated values, so use classic lambdas with by reference 
uses if needed.

```PHP
doUntil(
    trueFn(...),
    function () use (&$effect) {
        $effect = 42;
    }
)
`