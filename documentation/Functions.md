# j45l/functional-php

- [Functional primitives for PHP](#functional-primitives-for-php)
    * [Collection filtering and selection](#collection-filtering-and-selection)
        + [best](#best)
        + [butLast](#butlast)
        + [first](#first)
        + [head](#head)
        + [last](#last)
        + [pluck](#pluck)
        + [reject](#reject)
        + [select](#select)
        + [tail](#tail)
        + [take](#take)
        + [traverse](#traverse)
    * [Collection transformation functions](#collection-transformation-functions)
        + [cartesianProduct](#cartesianproduct)
        + [crossCompareSet](#crosscompareset)
        + [fold](#fold)
        + [foldRight](#foldright)
        + [map](#map)
        + [mapFirst](#mapfirst)
        + [merge](#merge)
        + [mergeGenerator](#mergegenerator)
        + [reduce](#reduce)
        + [reduceRight](#reduceright)
        + [recurseTimes](#recursetimes)
        + [sum](#sum)
        + [toArray](#toarray)
        + [toGenerator](#togenerator)
        + [toIterable](#toiterable)
    * [Function composition, partial application and curling.](#function-composition--partial-application-and-curling)
        + [compose](#compose)
        + [partial](#partial)
        + [partialRight](#partialright)
        + [pipe](#pipe)
    * [Object & type functions](#object---type-functions)
        + [cloneWith](#clonewith)
        + [isAOr](#isaor)
        + [isClosureOr](#isclosureor)
    * [Value functions](#value-functions)
        + [falseFn](#falsefn)
        + [identity](#identity)
        + [nop](#nop)
        + [trueFn](#truefn)
    * [Logic functions](#logic-functions)
        + [every](#every)
        + [none](#none)
        + [not](#not)
        + [some](#some)
    * [Loop functions](#loop-functions)
        + [doUntil](#dountil)
        + [doWhile](#dowhile)
    * [Effect functions](#effect-functions)
        + [also](#also)
        + [delay](#delay)
    * [Optimization functions](#optimization-functions)
        + [tailRecursion](#tailrecursion)
    
## Functional primitives for PHP

https://github.com/jordibisbal/functional-php
composer require j45l/functional-php

Most functions return an array instead of the iterable type used as input.

Some function fully consume generators, be aware of infinity cases.

In general just \Closures are accepted as functions/callable as `callable` can lead to bad practices (opinionated), if 
you need to use one, just wrap it in an arrow function, and you are good to go.

Check function's unit test for further insight.

---
### Collection filtering and selection
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
Returns the first element of the collection that `$predicate` if true for, or `$default` if collection is empty or 
`$predicate` is not true for any. If predicate is not given, just the first one is returned.

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
#### pluck
Return the `$propertyName` element from each element from the `$collection`, 
`$defaultValue` if the property is not found for the element.

If an array is given as `$propertyName` then they are pluck one over the other, so 
`pluck($collection, ['a', 'b'])` is the same as `pluck(pluck($collection, 'A'), 'B')`.

Pluck retrieves the property value using the first of the following (uses take internally, so same rules apply):
* The element is an object and a `$propertyName` is a method, then the method is invoked with no parameters.
* The element is an object and has a public `$propertyName` property, then the property value.
* The element is an array, then the value at index `$propertyName`
```PHP
function pluck(iterable $collection, string|array $propertyName, mixed $defaultValue = null): array
```

```PHP
> pluck(
      [ 123 => ['name' => 'alice', 'email' => 'alice@mail.com'], 456 => ['name' => 'bob', 'email' => 'bob@mail.com'] ],
      'email'
  )

[123 => 'alice@gmail.com', 456 => 'bob@gmail.com']
```

see also: [take](#take)

---

#### reject
Return the elements of the `$collection` for which the `$predicate` is false, if no `$predicate` is provided, return the
falsy ones. Keys are preserved.

```PHP
function reject(iterable $collection, Closure $predicate = null): array

$predicate signature: Closure(mixed $element, mixed $index, iterable $collection): bool
```

```PHP
> reject(
      ['reject', 'value', 'rejectKey' => 'value'];, 
      static fn($value, $key, $collection) => $value === 'reject' || $key === 'rejectKey'
  )

[1 => 'value']
```

see also: [select](#select)

#### select
Return the elements of the `$collection` for which the `$predicate` is true, if no `$predicate` is provided, return the
truly ones. Keys are preserved.

```PHP
function select(iterable $collection, Closure $predicate = null): array

$predicate signature: Closure(mixed $element, mixed $index, iterable $collection): bool
```

```PHP
> reject(
      ['select', 'value', 'selectKey' => 'value'];, 
      static fn($value, $key, $collection) => $value === 'select' || $key === 'selectKey'
  )

[0 => 'select', 'selectKey' => 'value']
```

see also: [reject](#reject)

#### tail
Returns `$collection` without the first element. Be aware the `$collection` is first converted to array, so ***Generators***
and other alike types are fully consumed. If `$collection` is empty or just have one element, an empty array is returned.
If ` $predicate` is given, be aware the collection is filtered (**select**ed) **before**.

```PHP
function tail(iterable $collection, Closure $predicate = null): array

$predicate signature: Closure(T, string|int): bool
```
```PHP
> tail([1, 2, 3])

[2, 3]

> tail([1, 2, 3, 4], fn (x) => x > 2)

[4]
```
see also: [head](#head), [select](#select)

---
#### take
Return the `$propertyName` element from each element from `$target`,
`$defaultValue` if the property is not found for the element.

If an array is given as `$propertyName` then they are token one over the other, so
`take($target, ['a', 'b'])` is the same as `take(take($target, 'A'), 'B')`.

take retrieves the property value using the first of the following:
* `$target` is an object and a `$propertyName` is a method, then the method is invoked with no parameters.
* `$target` is an object and has a public `$propertyName` property, then the property value.
* `$target` is an array, then the value at index `$propertyName`
```PHP
function take(mixed $target, array|int|string $propertyName, mixed $defaultValue = null): mixed
```

```PHP
> take(
      ['name' => 'alice', 'email' => 'alice@mail.com'],
      'email'
  )

'alice@gmail.com'
```

see also: [pluck](#pluck)

---
#### traverse
Map data selectively from complex collections by matching against a series of `$mapSelect`, one for every depth, just 
terminal nodes (mapped) are returned.
This allows to traverse a data tree (acyclic graph) matching complex criteria while mapping each node if needed (e.g. 
selecting data partially).

```PHP
function traverse(iterable $collection, array $mapSelect): array

$mapSelect signature: 
    array<array{
      0?:(Closure(mixed $current, mixed $key, iterable<mixed> $collection):bool),
      1?:(Closure(mixed $current, array<string|int> $path,iterable<mixed> $collection):mixed)
    }>
```

`$mapSelect` matches and map every node, where: 
   * index 0, if present: the predicate (a Closure) used to select the collection items, the value (current node), key 
and the original collection is passed to the predicate. If not present every node is selected. 
   * index 1, the mapper: maps the current node, the value (current node), the path (an array with every key, in order,
traversed until current node) and the original collection is passed to the mapper. If not present the node is traversed
as is.

Be aware that mapping intermediate nodes, by removing nesting levels could disallow you to access some nodes
from the original collection by using `$path` as `$path` is built while traversing the mapped nodes.
```PHP
> $whiskeys = [
      'Single Malt' => [
          'Glenmorangie' => [
              'region' => 'Highland, Scotland',
              'whiskeys' => [
                  [ 'name' => 'Signet', 'price' => '236.00' ],
              ],
          ],
          'Macallan' => [
              'region' => 'Highland, Scotland',
              'whiskeys' => [
                  [ 'name' => '12 Year Double Cask', 'price' => '79.00' ],
              ],
          ],
          'Yamazaki' => [
              'region' => 'Japan',
              'whiskeys' => [
                  [ 'name' => '12 Year Old', 'price' => '180.00' ],
              ],
          ],
      ],
      'Blended' => [
          'Buchanan' => [
              'region' => 'Scotland',
              'whiskeys' => [
                  [ 'name' => '12 Year Scotch', 'price' => '32.00' ]
              ],
          ]
      ]
  ]; 
  
> traverse(
      $whiskeys,
      [
          [ fn ($_, $type) => $type === 'Single Malt' ],
          [ fn ($distillery) => $distillery['region'] !== 'Japan', fn ($distillery) => $distillery['whiskeys'] ],
          [
              fn ($whiskey) => (float) $whiskey['price'] < 200,
              fn ($whiskey, $path) =>
                  ['distillery' => $path[1], 'name' => $whiskey['name'], 'price' => $whiskey['price']]
          ],
      ]
  )
  
[
     [ 'distillery' => 'Macallan', 'name' => '12 Year Double Cask', 'price' => '79.00', ],
],
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
> fold(['A', 'B', 'C'], static fn($initial, $value): string => $initial . $value)

'ABC' 
```

see also: [foldRight](#foldRight), [reduce](#reduce), [reduceRight](#reduceRight), [recurseTimes](#recurseTimes)

---

#### foldRight

Folds from the right all elements of the collection returning a single scalar value, if the collection is empty, `$default`
is returned instead.

```PHP
function foldRight(iterable $collection, Closure $callback, mixed $default = null): mixed
```

```PHP
> foldRight(['A', 'B', 'C'], static fn($initial, $value): string => $initial . $value)

'CBA' 
```
see also: [fold](#fold), [reduce](#reduce), [reduceRight](#reduceRight), [recurseTimes](#recurseTimes)

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
#### merge

Merges some collections (arrays), alias to `array_merge`.

When merging, numeric keys are not preserved and all elements are present on the output array, non-numeric keys are preserved,
if repeated, the rightmost one overrides the others.

merge is not recursive.

```PHP
function merge(array ...$arrays): array
```

```PHP
> merge(['A' => 'a', 'B' => 'b', 2 => 'C'], ['B' => 'br', 3 => 'Cr'])

['A' => 'a', 'B' => 'br', 0 => 'C', 1 => 'Cr']

> merge(['A' => ['B', 'C']], ['A' => ['Br']])

['A' => ['Br']]
```
---

#### mergeGenerator

Merges iterables (generators and/or arrays) and produces a generator that yields all key/values.
We aware the keys can be repeated.

```PHP
function mergeGenerator(Generator|array ...$collections): Generator
```

```PHP
> mergeGenerator(['A' => 'a', 'B' => 'b'], ['B' => 'br'])

yieldIterable(['A', 'B', 'B'], ['a', 'b', 'br'])
// The following is generated: 'A' => 'a', 'B' => 'b' and 'B' => 'br' 
```

#### reduce

Reduce from the left all elements of the collection returning a single scalar value. If `$collection` is empty, `$initial` 
is returned.

```PHP
function reduce(iterable $collection, Closure $fn, mixed $initial = null): mixed

$fn signature: Closure(mixed $initial, mixed $current, mixed $index, mixed $collection): mixed
```

```PHP
> reduce(['A', 'B', 'C'], static fn($initial, $value): string => $initial . $value, '')

'ABC' 
```

see also: [fold](#fold), [foldRight](#foldRight), [reduceRight](#reduceRight), [recurseTimes](#recurseTimes)

---

#### reduceRight

Reduce from the right all elements of the collection returning a single scalar value. If `$collection` is empty, `$initial`
is returned.

```PHP
function reduceRight(iterable $collection, Closure $fn, mixed $initial = null): mixed

$fn signature: Closure(mixed $initial, mixed $current, mixed $index, mixed $collection): mixed
```

```PHP
> reduce(['A', 'B', 'C'], static fn($initial, $value): string => $initial . $value, '')

'CBA' 
```

see also: [fold](#fold), [foldRight](#foldRight), [reduce](#reduce), [recurseTimes](#recurseTimes)

---

#### recurseTimes

Returns a function that recurses `$times` times the mapping function upon the result of itself.

```PHP
function recurseTimes(Closure $map): Closure

returned signature: Closure($times): Closure
    returned signature: Closure(mixed): mixed
```

```PHP
> $fn = recurseTimes(fn ($x) => $x * 2)(8)
> $fn(1);


256
```
#### reindex

Maps (transform) through `$function` every key of the `$collection`, returning an array, if some key is repeated in
`$collection` (e.g. in generators), the last produced result is used.

```PHP
function reindex(iterable $collection, Closure $function): array
```

```PHP
> reindex([1, 2, 3], fn ($x): int => $x * 4)

[1, 4 => 2, 8 => 3]
```
---
#### sum

Returns the sum of all the `$collection` elements. $collection elements should be preferment  either ***float*** or 
***int***, the sum if done by means on ***+*** so if $collection elements are mixed take in account possible casting 
(e.g. ***float*** to ***int***, ***string*** to ***float*** or ***int***...).  

```PHP
function sum(iterable $collection): mixed
```

```PHP
> sum([39.1, 2, 0.9]))

42.0

> sum([1, 2, 39])

42

> sum([1, 2, '39'])

42
```

---

#### toArray

Returns `$item` as an array, if `$item` is already an array, returns it as is, if is a ***Traversable*** 
(e.g. a ***Generator) consumes it and returns an array with the returned elements (we aware of duplicated keys), 
otherwise returns a single item array with `$item` as unique content.

```PHP
function toArray(mixed $item): array
```

```PHP
> toArray(1)

[1]

> toArray(yieldIterable([1, 2, 3])))

[1, 2, 3]
```

see also: [toGenerator](#toGenerator), [toIterable](#toIterable), [yieldIterable](#yieldIterable)

---

#### toGenerator

Returns a ***Generator*** that yields every item of `$iterable`, it does not consume `$iterable` beforehand but as needed 
(i.e. if iterable is not an array), it supports duplicated keys om `$iterable`.

```PHP
function toGenerator(iterable $iterable): Generator
```

```PHP
> toGenerator([1, 2, 3])->next()->current

2
```

see also: [toArray](#toArray), [toIterable](#toIterable), [yieldIterable](#yieldIterable)

---

#### toIterable

Returns an iterable from  ***$item***, if `$item` is already one, it returns it as is, if not returns and array with 
`$item` as its sole element.

```PHP
function toIterable(mixed $item): iterable
```

```PHP
> toIterable(1)

[1]
```

#### unindex

Alias to array_values, returns the collection without indices.

```PHP
function unindex(array $collection): array
```

```PHP
> unindex([1, 'a' => 2, '1' => 3])

[1, 2, 3]
```

see also: [toArray](#toArray), [toGenerator](#toGenerator), [yieldIterable](#yieldIterable)

#### unzip

Given a collection of two dimensional arrays, return an array with the array with the first elements and a second one with
the second.

```PHP
function unzip(array $collection, mixed $defaultLeft = null, mixed $defaultRight = null): array
```

```PHP
> unzip([[1, 'a'], [2, 'b'],  [3, 'c']])
[[1, 2, 3], ['a', 'b', 'c']]
```

see also: [zip](#zip)

#### zip

Given a collection of two dimensional arrays, return an array with the array with the first elements and a second one with
the second.

```PHP
function unzip(array $collection, mixed $defaultLeft = null, mixed $defaultRight = null): array
```

```PHP
> unzip([[1, 'a'], [2, 'b'],  [3, 'c']])
[[1, 2, 3], ['a', 'b', 'c']]
```

see also: [zip](#zip)


---

### Function composition, partial application and curling.

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

see also: [pipe](#pipe)

---

#### partial
Return a new function with a partial left application of the given function, it returns a new
function that call the given one with the first parameters set to `$arguments`.
```PHP
function partial(Closure $fn, ...$arguments): Closure
```

```PHP
> partial(static fn (...$values) => concat($values), 'a', 'b')('c', 'd')

abcd
```

---

#### partialRight
Return a new function with a partial right application of the given function, it returns a new
function that call the given one with the last parameters set to `$arguments`.
```PHP
function partialRight(Closure $fn, ...$arguments): Closure
```

```PHP
> partialRight(static fn (...$values) => concat($values), 'c', 'd')('a', 'b')

abcd
```

---

#### pipe
Returns the result of the composition of the given `$functions` with null as the (first) parameter. 
Alias to `compose(...$functions)(null)`
```PHP
function pipe(Closure ...$functions): mixed
```

```PHP
> pipe(
      fn () => 4,
      fn ($x) => $x * 10,
      fn ($x) => $x + 2,
  )

42
```

see also: [compose](#compose)

---
### Object & type functions
Functions to check/enforce type and object manipulation

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
### Value functions

Functions aimed to provide values and default values and behaviours.

---
#### falseFn

Return a function than returns `false`.

```PHP
function falseFn(): bool
```

```PHP
> falseFn()()

false
```
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
#### nop

Return a function than returns `null`, works as 'no operation'.

```PHP
function nop(): bool
```

```PHP
> nopFn()()

false
```
---
#### trueFn

Return a function than returns `true`.

```PHP
function trueFn(): bool
```

```PHP
> trueFn()()

false
```
---
### Logic functions

#### every

Returns `true` if every of the elements of `$collection` passes the `$predicate` (`$predicate` is true for).

If not `$predicate` is given it is checked for truly.

```PHP
function every(iterable $collection, Closure $predicate): Closure
```

```PHP
> some([1, 2] fn ($item) => $item === 1)

false
```

```PHP
> some([1, 2] fn ($item) => $item !== 3)

true
```
---
#### none

Returns `true` if none of the elements of `$collection` passes the `$predicate` (`$predicate` is true for).

If not `$predicate` is given it is checked for truly.

```PHP
function none(iterable $collection, Closure $predicate): Closure
```

```PHP
> none([1, 2] fn ($item) => $item === 1)

false
```

```PHP
> none([1, 2] fn ($item) => $item === 3)

true
```
---
#### not

Negates the value of the given closure as boolean.

```PHP
function not(Closure $fn): Closure
```

```PHP
> not(fn () => true)

false
```
---
#### some

Returns `true` if some of the elements of `$collection` passes the `$predicate` (`$predicate` is true for).

If not `$predicate` is given it is checked for truly.

```PHP
function some(iterable $collection, Closure $predicate): Closure
```

```PHP
> some([1, 2] fn ($item) => $item === 1)

true
```

```PHP
> some([1, 2] fn ($item) => $item === 3)

false
```
---
### Loop functions

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
```

---
### Effect functions

Function to produce effects or that rely on them.

---

#### also

Executes a given function with while returns the passed value.

```PHP
function also(Closure $function): Closure
```

```PHP
> $effect = 20;
> also( function ($x) use (&$effect) { $effect = $effect + $x; } )(22)

22

> $effect

42
```
---
#### delay
Waits for `$seconds` seconds then executes the function and returns its return value, if a `delayFn` is given, executes
it instead of `usleep($seconds * 1E6)` to wait.

```PHP
function delay(float $seconds, Closure $callable, Closure $delayFn = null): mixed
```

```PHP
> delay(1, fn () => 42)

(after 1 second)
42
```

---
#### tryOrThrow
Executes the `$function` closure, if a throwable is raised, then $throwable is raised instead.

```PHP
function tryOrThrow(Closure $function, Throwable $throwable): mixed
```

```PHP
> tryOrThrow(fn () => throw new RuntimeError(), new LogicException());


PHP Fatal error:  Uncaught LogicException in /tmp/_.php:_
Stack trace:
#0 {main}
  thrown in /tmp/_.php on line _
```

### Optimization functions

---
#### tailRecursion

Return a new function that decorates `$recursiveFn` with tail recursion using trampoline, be aware the format of 
`$recursiveFn` is really tricky, so use the examples below as guideline, do not inline any variable reference without
fully understanding its consequences, and test it really thoroughly. Take a look to 
***\j45l\functional\Test\Unit\Functions\TailRecursionTest***.

```PHP
function tailRecursion(Closure $recursiveFn): Closure
```

```PHP
> $tailRecursion = static function ($x) use (&$tailRecursion) {
      /** @phpstan-var Closure $tailRecursion */
      return match (true) {
          $x === 1000 => $x,
          default => $tailRecursion($x + 1),
      };
  };

>  $tailRecursion = tailRecursion($tailRecursion);
>  $tailRecursion(1);

1000

> class Foo {
      public function invoke() {
          $tailRecursion = tailRecursion($this->depthRecursive(1000, $tailRecursion));
                    
          return $tailRecursion(1);
      }
    
      private function depthRecursive(int $times, mixed &$recurse): Closure
      {
          return static function ($x) use ($times, &$recurse) {
              return match (true) {
                  $x === $times => $x,
                  default => $recurse($x + 1),
              };
          };
      }
  }
  
> (new Foo())->invoke();

1000
```

<small><i><a href='http://ecotrust-canada.github.io/markdown-toc/'>Table of contents generated with markdown-toc</a></i></small>