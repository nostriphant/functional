<?php

namespace nostriphant\FunctionalTests;

use nostriphant\Functional\Index;

Pest::extend('expect');

it('store and call that item', function () {
    $index = new Index();
    $index2 = new Index();
    
    $index('foo', fn() => 'bar');
    $index2('foo', fn() => 'bur');
    
    expect($index('foo')())->toBe('bar');
    expect($index2('foo')())->toBe('bur');
    expect($index)->toHaveCount(1);
});


it('is accessable as an array', function () {
    $index = new Index();
    
    $index['foo'] = fn() => 'bar';
    $index['fie'] = fn() => 'bir';
    
    expect($index('foo')())->toBe('bar');
    expect($index)->toHaveCount(2);
});