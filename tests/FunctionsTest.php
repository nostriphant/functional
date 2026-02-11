<?php

namespace nostriphant\FunctionalTests;


it('finds items in range', function (string|int|float $value, string|int|float $start, string|int|float $end, int|float $step = 1) {
    expect(\nostriphant\Functional\Functions::in_range($value, $start, $end, $step))->toBeTrue();
})->with([
    [4, 1, 5],
    ["b", "a", "c"],
    [0.5, 0.0, 1.0, 0.1],
    [1.5, 1.0, 2.0, 0.5]
]);

it('can iterate and map over iterator', function () {
    $iterator = new \ArrayIterator(['a', 'b', 'c']);
    $iterated = iterator_to_array(\nostriphant\Functional\Functions::iterator_map($iterator, fn(string $value) => ++$value));
    
    expect($iterated[0])->toBe('b');
    expect($iterated[1])->toBe('c');
    expect($iterated[2])->toBe('d');
});


it('can walk over iterator and apply a function to each element', function () {
    $elements = ['a', 'b', 'c'];
    $iterator = new \ArrayIterator($elements);
    
    \nostriphant\Functional\Functions::iterator_walk($iterator, fn(string $element, int $index) => expect($element)->toBe($elements[$index]));
    
    \nostriphant\Functional\Functions::iterator_walk($iterator, fn(string $element, int $index, string $prefix) => expect($prefix . $element)->toBe('prefix_' . $elements[$index]), 'prefix_');
});


it('can merge two or more iterators', function () {
    $iterator1 = new \ArrayIterator(['a', 'b', 'c']);
    $iterator2 = new \ArrayIterator(['d', 'e', 'f']);
    $merged = iterator_to_array(\nostriphant\Functional\Functions::iterator_merge($iterator1, $iterator2));
    
    expect($merged[0])->toBe('a');
    expect($merged[1])->toBe('b');
    expect($merged[2])->toBe('c');
    expect($merged[3])->toBe('d');
    expect($merged[4])->toBe('e');
    expect($merged[5])->toBe('f');
});