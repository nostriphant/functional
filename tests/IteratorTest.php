<?php

namespace nostriphant\FunctionalTests;

it('can iterate and map over iterator', function () {
    $iterator = new \ArrayIterator(['a', 'b', 'c']);
    $iterated = iterator_to_array(\nostriphant\Functional\Iterator::map($iterator, fn(string $value) => ++$value));
    
    expect($iterated[0])->toBe('b');
    expect($iterated[1])->toBe('c');
    expect($iterated[2])->toBe('d');
});


it('can walk over iterator and apply a function to each element', function () {
    $elements = ['a', 'b', 'c'];
    $iterator = new \ArrayIterator($elements);
    
    \nostriphant\Functional\Iterator::walk($iterator, fn(string $element, int $index) => expect($element)->toBe($elements[$index]));
    
    \nostriphant\Functional\Iterator::walk($iterator, fn(string $element, int $index, string $prefix) => expect($prefix . $element)->toBe('prefix_' . $elements[$index]), 'prefix_');
});


it('can merge two or more iterators', function () {
    $iterator1 = new \ArrayIterator(['a', 'b', 'c']);
    $iterator2 = new \ArrayIterator(['d', 'e', 'f']);
    $merged = iterator_to_array(\nostriphant\Functional\Iterator::merge($iterator1, $iterator2));
    
    expect($merged[0])->toBe('a');
    expect($merged[1])->toBe('b');
    expect($merged[2])->toBe('c');
    expect($merged[3])->toBe('d');
    expect($merged[4])->toBe('e');
    expect($merged[5])->toBe('f');
});