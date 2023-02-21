# j45l/functional-php

## Functional primitives for PHP

https://github.com/jordibisbal/functional-php
composer require j45l/functional-php

Most functions return an array instead of the iterable type used in parameters.
Most function also fully consume generators, be aware of infinity ones.

---
### Collection filters
Functions intended to filter, select and reject collection

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

Returns the first element of the collection or `$default` if collection is empty.

```PHP
function first(iterable $collection, Closure $predicate = null, mixed $default = null): mixed
```
```PHP
> first([1, 2, 3])

1
```
---
### Collection operations
Operations between collections

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
### Composition

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
### Object operations
Operations on objects

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

Be aware:

* Arrow functions can not modify, nor access to mutated values, so use classic lambdas with by reference uses if needed.

```PHP
doUntil(
    trueFn(...),
    function () use (&$effect) {
        $effect = 42;
    }
)
`