<?php

namespace nostriphant\FunctionalTests;

use nostriphant\Functional\Alternate;

Pest::extend('expect');

it('usage works', function () {
    $when = new \nostriphant\Functional\When(fn(bool $val) => $val === true, fn() => true, fn() => false);
    
    expect($when(true))->toBeTrue();
    expect($when(false))->toBeFalse();
});

it('advanced usage works', function () {
    $when = new \nostriphant\Functional\When(fn(string $val) => $val === 'Hello World', fn(string $val) => 'yes: '. $val, fn(string $val) => 'no: '. $val);
    
    expect($when('Hello World'))->toBe('yes: Hello World');
    expect($when('Hello sdsdsWorld'))->toBe('no: Hello sdsdsWorld');
});