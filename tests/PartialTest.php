<?php

namespace nostriphant\FunctionalTests;


it('partially applies arguments left', function () {
    $f = fn(int $a, int $b) => $a - $b;
    $f_applied = \nostriphant\Functional\Partial::left($f, 1);
    expect($f_applied(2))->toBe(-1);
});

it('partially applies arguments left on regular functions', function () {
    $f_applied = \nostriphant\Functional\Partial::left('substr', 'Hello World');
    expect($f_applied(2))->toBe('llo World');
});

it('partially applies arguments right', function () {
    $f = fn(int $a, int $b) => $a - $b;
    
    $f_applied = \nostriphant\Functional\Partial::right($f, 1);
    expect($f_applied(4))->toBe(3);
});

it('partially applies arguments right on regular functions', function () {
    $f_applied = \nostriphant\Functional\Partial::right('str_contains', 'Hello');
    expect($f_applied('Hello World'))->toBe(true);
    expect($f_applied('Bye World'))->toBe(false);
});


class SubstractMultiple {
    public function __construct(private int $a) {
    }
    
    public function __invoke(int $a, int $b, int $c, int $d): mixed {
        return $this->a - $a - $b - $c - $d;
    }
}


it('partially applies arguments on X position', function () {
    $f = fn(int $a, int $b, int $c) => $a - $b - $c;
    $f_applied = \nostriphant\Functional\Partial::at1($f, 1);
    expect($f_applied(4, -3))->toBe(6);
});

it('partially applies multiple arguments on X position', function () {
    $f = fn(int $a, int $b, int $c, int $d) => $a - $b - $c - $d;
    $f_applied = \nostriphant\Functional\Partial::at1($f, 1, 2);
    expect($f_applied(4, -3))->toBe(4);
});

it('partially applies multiple arguments on X position (type hinting safe)', function () {
    $f = new SubstractMultiple(10);
    $f_applied = \nostriphant\Functional\Partial::at1($f, 1, 2);
    expect($f_applied(4, -3))->toBe(6);
    expect($f_applied->a)->toBe(10);
});

interface Substrator {
    function __invoke(int $a, int $b): int;
}

class Substract implements Substrator {
    public function __construct(private int $a) {
    }
    
    public function __invoke(int $a, int $b): int {
        return $this->a - $a - $b;
    }
}

it('partially applies arguments left (type hinting safe)', function () {
    $f = new Substract(10);
    
    $f_applied = \nostriphant\Functional\Partial::left($f, 1);
    expect($f_applied(2))->toBe(7);
    expect($f_applied)->toBeInstanceOf($f::class);
    expect($f_applied->a)->toBe(10);
});
it('partially applies arguments right (type hinting safe)', function () {
    $f = new Substract(10);
    
    $f_applied = \nostriphant\Functional\Partial::right($f, 1);
    expect($f_applied(4))->toBe(5);
    expect($f_applied)->toBeInstanceOf($f::class);
    expect($f_applied->a)->toBe(10);
});

readonly class SubstractRO {
    public function __construct(private int $a) {
    }
    
    public function __invoke(int $a, int $b): mixed {
        return $this->a - $a - $b;
    }
}

it('partially applies arguments left (readonly, type hinting safe)', function () {
    $f = new SubstractRO(10);
    
    $f_applied = \nostriphant\Functional\Partial::left($f, 1);
    expect($f_applied(2))->toBe(7);
    expect($f_applied)->toBeInstanceOf($f::class);
    expect($f_applied->a)->toBe(10);
});
it('partially applies arguments right (readonly, type hinting safe)', function () {
    $f = new SubstractRO(10);
    
    $f_applied = \nostriphant\Functional\Partial::right($f, 1);
    expect($f_applied(4))->toBe(5);
    expect($f_applied)->toBeInstanceOf($f::class);
    expect($f_applied->a)->toBe(10);
});