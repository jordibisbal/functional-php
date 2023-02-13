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
Selects the best according to *$criteria* (<=> like).

```PHP
function best(iterable $collection, Closure $criteria, mixed $default = null): mixed
```
* $criteria: Closure(mixed $first, mixed $second): int
```PHP
> best([1, 3, 2], fn ($x, $y) => $x <=> $y);

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

### crossCompareSet
Returns an array of **Pair**s for every unique combination of elements in `$collection`, if `$collection` has fewer than
two elements, an empty array is returned, i.e. the triangular half of the matrix resultant of the cartesian product of 
`$collection` with itself, excluding the diagonal.

Useful to check, for instance, all the elements of `$collection` with each other to select the best one.

```PHP
function crossCompareSet(iterable $collection): array
```

Search for the nearest two integers in an array.

```PHP
> best(
      crossCompareSet([1, 5, 7, 15]), 
      fn (Pair $a, Pair $b) => ($a->first() - $a->second()) <=> ($b->first() - $b->second())
  )

Pair::__set_state(['first' => 7, 'second' => 5,])
```
---
### Object operations
Operations on objects

---
#### cloneWith
Clones the given object (no shallow copy), executes the given closure on after binding it
so even the object private properties can be mutated.

```PHP
cloneWith(object $object, Closure $closure): object
```
```PHP
> readonly class foo { private string $property; }

> $object = cloneWith(new foo(), fn (foo $self) => $self->property = 'baz');

\foo::__set_state([ 'property' => 'baz' ])
```

Note it cannot mutate readonly properties if already defined (e.g. initialized in the constructor).